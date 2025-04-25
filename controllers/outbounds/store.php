<?php
use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $itemId = $_POST["item_id"];
  $quantity = $_POST["quantity"];
  $unit = $_POST["unit"];
  $pcsPerCarton = $_POST["pcs_per_carton"] ?? null;
  $note = $_POST["note"] ?? null;

  // Validasi input
  if ($itemId <= 0) {
    $errors["item_id"] = "Item is required.";
  }
  if ($quantity <= 0 || $quantity <= 0) {
    $errors["quantity"] = "Quantity must be a positive number.";
  }
  if (!in_array($unit, ["PCS", "CARTON"])) {
    $errors["unit"] = "Unit must be 'PCS' or 'CARTON'.";
  }

  if (!empty($errors)) {
    return view("outbounds/create.view.php", [
      "errors" => $errors,
    ]);
  }

  $db->query("
    INSERT INTO outbounds (item_id, quantity, unit, pcs_per_carton, note) 
    VALUES (:item_id, :quantity, :unit, :pcs_per_carton, :note)
  ", [
    "item_id" => $itemId,
    "quantity" => $quantity,
    "unit" => $unit,
    "pcs_per_carton" => $pcsPerCarton,
    "note" => $note,
  ]);

  header("Location: /outbounds");
  exit;
}