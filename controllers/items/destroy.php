<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $db->query("DELETE FROM items WHERE id = :id", [
    "id" => $_POST["id"]
  ]);
}

header("Location: /items");
exit;