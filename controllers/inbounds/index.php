<?php
use Core\Database;

$config = require basePath("config.php");

$db = new Database($config['database']);
$inbounds = $db->query("
  SELECT 
    inbounds.*, 
    items.name AS item_name, items.unit AS item_unit,
    items.pcs_per_pack AS item_pcs_per_pack 
  FROM inbounds 
  JOIN items ON inbounds.item_id = items.id
  ORDER BY inbounds.created_at DESC
")->get();

view("inbounds/index.view.php", [
    "inbounds" => $inbounds
]);