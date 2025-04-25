<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$items = $db->query("SELECT id, name FROM items")->get();

view("outbounds/create.view.php", [
    "items" => $items
]);