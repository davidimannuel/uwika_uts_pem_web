<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$categories = $db->query("SELECT * FROM item_categories ORDER BY updated_at DESC")->get();
// dd($categories);


view("item_categories/index.view.php", [
    "categories" => $categories
]);