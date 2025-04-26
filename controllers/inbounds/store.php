<?php
use Core\App;
use Core\Database;
use Core\Sanitizer;
use Core\Validator;
use Models\Item;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $itemId = $_POST["item_id"] ?? null;
    $packQuantity = $_POST["pack_quantity"] ?? 0;
    $pcsQuantity = $_POST["pcs_quantity"] ?? 0;
    $note = Sanitizer::emptyToDefault($_POST["note"] ?? null, null);

    // Ambil data item dari database
    $currentItemDb = $db->query("SELECT * FROM items WHERE id = :id", ['id' => $itemId])->findOrFail();

    $currentItem = new Item($currentItemDb);

    // Validasi input
    if (!$itemId || $itemId <= 0) {
        $errors["item_id"] = "Item is required.";
    }
    if ($packQuantity <= 0 || $pcsQuantity <= 0) {
        $errors["quantity"] = "Quantity must be a positive number.";
    }
    if ($currentItem->unit == Item::UNIT_PCS && $packQuantity > 0) {
        $errors["pack_quantity"] = "Item with unit PCS cannot have pack quantity.";
    }
    if ($currentItem->unit == Item::UNIT_PACK && !($currentItem->pcsPerPack > 0) && $pcsQuantity > 0) {
        $errors["pcs_quantity"] = "Item with doesn't have pcs_per_pack";
    }
    
    // adjust stock
    if ($currentItem->unit == Item::UNIT_PCS) {
      $currentItem->adjustPcsStock($pcsQuantity);
    } elseif ($currentItem->unit == Item::UNIT_PACK) {
      // adjust pcs stock first
      if ($currentItem->pcsPerPack > 0 && $pcsQuantity > 0) {
        // dd([
        //   "packQuantity" => $packQuantity,
        //   "pcsQuantity" => $pcsQuantity,
        // ]);
        $success = $currentItem->adjustPcsStock($pcsQuantity);
        if (!$success) {
          $errors["pcs_quantity"] = "stock not sufficient";
        }
      }
      // dd($currentItem);
      // adjust pack stock
      $success = $currentItem->adjustPackStock($packQuantity);
      if (!$success) {
        $errors["pack_quantity"] = "stock not sufficient";
      }
    }
    
    
    if (!empty($errors)) {
        return view("inbounds/create.view.php", [
            "errors" => $errors,
            "items" => $db->query("SELECT id, name, unit, pcs_per_pack FROM items")->get(),
        ]);
    }

    // Proses transaksi menggunakan metode transaction
    try {
        $db->transaction(function ($db) use ($currentItem, $packQuantity, $pcsQuantity, $note) {
            // Insert ke tabel inbounds
            $db->query("
                INSERT INTO inbounds (item_id, pack_quantity, pcs_quantity, note) 
                VALUES (:item_id, :pack_quantity, :pcs_quantity, :note)
            ", [
                "item_id" => $currentItem->id,
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
        header("Location: /inbounds");
        exit;
    } catch (Exception $e) {
        // Tambahkan pesan error jika terjadi kesalahan
        $errors["general"] = "An error occurred while processing the transaction: " . $e->getMessage();

        return view("inbounds/create.view.php", [
            "errors" => $errors,
            "items" => $db->query("SELECT id, name, unit, pcs_per_pack FROM items")->get(),
        ]);
    }
} else {
    header("Location: /inbounds");
    exit;
}