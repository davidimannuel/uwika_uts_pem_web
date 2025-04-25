<?php
use Core\App;
use Core\Database;
use Core\Validator;

require basePath("controllers/items/constants.php");

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
  if (!in_array($unit, VALID_UNITS)) {
    $errors["unit"] = "Unit must be 'PCS' or 'CARTON'.";
  }

  if (!empty($errors)) {
    return view("items/create.view.php", [
      "errors" => $errors,
    ]);
  }

  $db->query("
    INSERT INTO items (name, category_id, unit, pcs_per_carton, stock) 
    VALUES (:name, :category_id, :unit, :pcs_per_carton, :stock)
  ", [
    "name" => $name,
    "category_id" => $categoryId,
    "unit" => $unit,
    "pcs_per_carton" => $pcsPerCarton,
    "stock" => 0,
  ]);

  header("Location: /items");
  exit;
} else {
  header("Location: /items");
}