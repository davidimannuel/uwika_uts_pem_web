<?php
use Core\App;
use Core\Database;
use Core\Sanitizer;
use Models\Item;
use Models\StockTransaction;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST["type"] ?? null; // 'inbound' or 'outbound'
    $itemId = $_POST["item_id"] ?? null;
    $packQuantity = Sanitizer::emptyToDefault($_POST["pack_quantity"] ?? null, 0); // sanitizer for prevent empty string"" that make < 0
    $pcsQuantity = Sanitizer::emptyToDefault($_POST["pcs_quantity"] ?? null, 0); // sanitizer for prevent empty string"" that make < 0
    $note = Sanitizer::emptyToDefault($_POST["note"] ?? null, null);

    // Ambil data item dari database
    $currentItemDb = $db->query("SELECT * FROM items WHERE id = :id", ['id' => $itemId])->findOrFail();
    $currentItem = new Item($currentItemDb);

    // Validasi input
    if (!$type || !in_array($type, StockTransaction::VALID_TYPES)) {
        $errors["type"] = "Transaction type is invalid.";
    }
    if (!$itemId || $itemId <= 0) {
        $errors["item_id"] = "Item is required.";
    }
    
    if ($packQuantity < 0 || $pcsQuantity < 0) {
        $errors["quantity"] = "Quantities must be non-negative numbers.";
    }

    // Validasi berdasarkan unit item
    if ($currentItem->unit == Item::UNIT_PCS) {
        // Untuk item dengan unit PCS, wajib input pcs_quantity
        if ($pcsQuantity <= 0) {
            $errors["pcs_quantity"] = "PCS quantity is required for items with unit PCS.";
        }
        if ($packQuantity > 0) {
            $errors["pack_quantity"] = "Item with unit PCS cannot have pack quantity.";
        }
    } elseif ($currentItem->unit == Item::UNIT_PACK) {
        // Untuk item dengan unit PACK
        if ($currentItem->pcsPerPack <= 0) {
            // Jika tidak ada pcs_per_pack, wajib input pack_quantity
            if ($packQuantity <= 0) {
                $errors["pack_quantity"] = "Pack quantity is required for items without PCS per Pack.";
            }
            if ($pcsQuantity > 0) {
                $errors["pcs_quantity"] = "Item does not support PCS quantity.";
            }
        } else {
            // Jika ada pcs_per_pack, wajib input salah satu pack_quantity atau pcs_quantity
            // dd([
            //     "packQuantity" => $packQuantity,
            //     "pcsQuantity" => $pcsQuantity,
            //     "check" => $packQuantity <= 0 && $pcsQuantity <= 0,
            // ]);
            if ($packQuantity <= 0 && $pcsQuantity <= 0) {
                $errors["quantity"] = "At least one of Pack Quantity or PCS Quantity is required.";
            }
        }
    }
    // Tentukan apakah stok akan ditambah (inbound) atau dikurangi (outbound)
    $isIncrease = $type === StockTransaction::TYPE_INBOUND;
    // dd([
    //     "type" => $type,
    //     "inbound" => StockTransaction::TYPE_INBOUND,
    //     "isIncrease" => $isIncrease,
    // ]);
    // Adjust stock
    if ($currentItem->unit == Item::UNIT_PCS) {
        $success = $currentItem->adjustPcsStock($pcsQuantity, $isIncrease);
        if (!$success) {
            $errors["pcs_quantity"] = $isIncrease ? "Failed to adjust PCS stock." : "Not enough PCS stock.";
        }
    } elseif ($currentItem->unit == Item::UNIT_PACK) {
        // Adjust PCS stock terlebih dahulu jika ada
        if ($currentItem->pcsPerPack > 0 && $pcsQuantity > 0) {
            $success = $currentItem->adjustPcsStock($pcsQuantity, $isIncrease);
            if (!$success) {
                $errors["pcs_quantity"] = $isIncrease ? "Failed to adjust PCS stock." : "Not enough PCS stock.";
            }
            // dd([
            //     "currentItem" => $currentItem,
            //     "isIncrease" => $isIncrease,
            //     "packQuantity" => $packQuantity,
            //     "pcsQuantity" => $pcsQuantity,
            // ]);
        }
        // Adjust PACK stock

        if ($packQuantity > 0) {
            $success = $currentItem->adjustPackStock($packQuantity, $isIncrease);
            if (!$success) {
                $errors["pack_quantity"] = $isIncrease ? "Failed to adjust PACK stock." : "Not enough PACK stock.";
            }
        }
    }
    // dd([
    //     "currentItem" => $currentItem,
    //     "isIncrease" => $isIncrease,
    //     "packQuantity" => $packQuantity,
    //     "pcsQuantity" => $pcsQuantity,
    // ]);
    // Jika ada error, kembalikan ke halaman index dengan pesan error
    if (!empty($errors)) {
        return view("stock_transactions/index.view.php", [
            "errors" => $errors,
            "transactions" => $db->query("SELECT * FROM stock_transactions WHERE item_id = :item_id ORDER BY stock_transactions.created_at DESC", ['item_id' => $itemId])->get(),
            "items" => $db->query("SELECT id, name, unit, pcs_per_pack FROM items")->get(),
            "itemId" => $itemId,
            "type" => $type,
            "currentItem" => $db->query("
                SELECT name, pcs_stock, pack_stock, pcs_per_pack, unit 
                FROM items 
                WHERE id = :id
            ", ['id' => $itemId])->findOrFail(),
        ]);
    }

    // Proses transaksi menggunakan metode transaction
    try {
        $db->transaction(function ($db) use ($currentItem, $type, $packQuantity, $pcsQuantity, $note) {
            // Insert ke tabel stock_transactions
            $db->query("
                INSERT INTO stock_transactions (item_id, type, pack_quantity, pcs_quantity, note) 
                VALUES (:item_id, :type, :pack_quantity, :pcs_quantity, :note)
            ", [
                "item_id" => $currentItem->id,
                "type" => $type,
                "pack_quantity" => $packQuantity,
                "pcs_quantity" => $pcsQuantity,
                "note" => $note,
            ]);

            // Update stok di tabel items
            $db->query("
                UPDATE items
                SET
                  pcs_stock = :pcs_stock,
                  pack_stock = :pack_stock,
                  updated_at = NOW()
                WHERE id = :id
            ", [
                "id" => $currentItem->id,
                "pcs_stock" => $currentItem->pcsStock,
                "pack_stock" => $currentItem->packStock,
            ]);
        });

        // Redirect jika berhasil
        header("Location: /stock-transactions?item_id=" . $itemId);
        exit;
    } catch (Exception $e) {
        // Tambahkan pesan error jika terjadi kesalahan
        $errors["general"] = "An error occurred while processing the transaction: " . $e->getMessage();

        return view("stock_transactions/index.view.php", [
            "errors" => $errors,
            "transactions" => $db->query("SELECT * FROM stock_transactions WHERE item_id = :item_id ORDER BY stock_transactions.created_at DESC", ['item_id' => $itemId])->get(),
            "items" => $db->query("SELECT id, name, unit, pcs_per_pack FROM items")->get(),
            "itemId" => $itemId,
            "type" => $type,
            "currentItem" => $db->query("
                SELECT name, pcs_stock, pack_stock, pcs_per_pack, unit 
                FROM items 
                WHERE id = :id
            ", ['id' => $itemId])->findOrFail(),
        ]);
    }
} else {
    header("Location: /stock-transactions");
    exit;
}