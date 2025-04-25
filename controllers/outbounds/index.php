<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$outbounds = $db->query("
  SELECT outbounds.*, items.name AS item_name 
  FROM outbounds 
  JOIN items ON outbounds.item_id = items.id
  ORDER BY outbounds.created_at DESC
")->get();

view("outbounds/index.view.php", [
    "outbounds" => $outbounds
]);