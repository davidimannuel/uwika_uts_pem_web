<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$categories = $db->query("SELECT id, name FROM categories")->get();

view("items/create.view.php", [
    "categories" => $categories
]);