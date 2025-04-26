<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);

// Ambil filter dari query string
$itemId = $_GET['item_id'] ?? null; // ID item
$type = $_GET['type'] ?? null; // 'INBOUND' atau 'OUTBOUND'

// Ambil daftar item untuk dropdown
$items = $db->query("SELECT id, name FROM items")->get();

// Jika item belum dipilih, kosongkan transaksi dan stok
$transactions = [];
$currentItem = null;

if ($itemId) {
    // Ambil informasi stok item yang dipilih
    $currentItem = $db->query("
        SELECT name, pcs_stock, pack_stock, pcs_per_pack, unit 
        FROM items 
        WHERE id = :id
    ", ['id' => $itemId])->findOrFail();

    // Query transaksi berdasarkan item_id dan type (jika ada)
    $query = "
      SELECT 
        stock_transactions.*, 
        items.name AS item_name, 
        items.unit AS item_unit, 
        items.pcs_per_pack AS item_pcs_per_pack 
      FROM stock_transactions
      JOIN items ON stock_transactions.item_id = items.id
      WHERE stock_transactions.item_id = :item_id
    ";
    $params = ['item_id' => $itemId];

    // Tambahkan filter berdasarkan type
    if ($type) {
        $query .= " AND stock_transactions.type = :type";
        $params['type'] = $type;
    }

    // Urutkan berdasarkan waktu transaksi
    $query .= " ORDER BY stock_transactions.created_at DESC";

    $transactions = $db->query($query, $params)->get();
}

view("stock_transactions/index.view.php", [
    "transactions" => $transactions,
    "items" => $items,
    "itemId" => $itemId,
    "type" => $type,
    "currentItem" => $currentItem,
]);