<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$items = $db->query("SELECT id, name, unit, pcs_per_pack FROM items")->get();

view("stock_transactions/create.view.php", [
    "items" => $items,
    "type" => $_GET['type'] ?? 'INBOUND', // Default ke INBOUND
]);