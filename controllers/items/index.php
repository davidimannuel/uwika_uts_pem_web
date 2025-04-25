<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$items = $db->query("
  SELECT items.*, categories.name AS category_name 
  FROM items 
  JOIN categories ON items.category_id = categories.id
  ORDER BY items.updated_at DESC
")->get();

view("items/index.view.php", [
    "items" => $items
]);