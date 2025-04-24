<?php

use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);

$categoryId = $_GET['id'] ?? null;
if (!$categoryId) {
    abort();
}

$category = $db->query("SELECT * FROM item_categories where id = :id",[':id' => $categoryId])->findOrFail();
// dd($category);

view("item_categories/show.view.php", [
    "category" => $category
]);