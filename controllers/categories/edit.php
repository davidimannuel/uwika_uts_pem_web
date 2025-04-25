<?php

use Core\App;
use Core\Database;

$config = require basePath("config.php");

$db = App::resolve(Database::class);

$categoryId = $_GET['id'] ?? null;
if (!$categoryId) {
    abort();
}

$category = $db->query("SELECT * FROM categories where id = :id",[':id' => $categoryId])->findOrFail();

view("categories/edit.view.php", [
    "category" => $category
]);