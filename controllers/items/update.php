<?php
use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $categoryId = $_POST["category_id"];
  $unit = $_POST["unit"];
  $pcsPerCarton = $_POST["pcs_per_carton"] ?? null;
  if ($pcsPerCarton === "") {
    $pcsPerCarton = null;
  }
  $stock = $_POST["stock"] ?? 0;

  // Validasi input
  if (!Validator::string($name, 1, 100)) {
    $errors["name"] = "Name must be between 1 and 100 characters.";
  }
  if ($categoryId <= 0) {
    $errors["category_id"] = "Category is required.";
  }
  if (!in_array($unit, ["PCS", "CARTON"])) {
    $errors["unit"] = "Unit must be 'PCS' or 'CARTON'.";
  }

  if (!empty($errors)) {
    return view("items/edit.view.php", [
      "errors" => $errors,
    ]);
  }

  $db->query("
    UPDATE items 
    SET name = :name, category_id = :category_id, unit = :unit, pcs_per_carton = :pcs_per_carton, updated_at = CURRENT_TIMESTAMP 
    WHERE id = :id
  ", [
    "id" => $id,
    "name" => $name,
    "category_id" => $categoryId,
    "unit" => $unit,
    "pcs_per_carton" => $pcsPerCarton,
  ]);

  header("Location: /items");
  exit;
}