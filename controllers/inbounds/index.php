<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$inbounds = $db->query("
  SELECT inbounds.*, items.name AS item_name 
  FROM inbounds 
  JOIN items ON inbounds.item_id = items.id
  ORDER BY inbounds.created_at DESC
")->get();

view("inbounds/index.view.php", [
    "inbounds" => $inbounds
]);