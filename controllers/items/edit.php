<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$itemId = $_GET['id'] ?? null;
if (!$itemId) {
    abort();
}

$item = $db->query("SELECT * FROM items WHERE id = :id", ['id' => $itemId])->findOrFail();
$categories = $db->query("SELECT id, name FROM categories")->get();

view("items/edit.view.php", [
    "item" => $item,
    "categories" => $categories
]);