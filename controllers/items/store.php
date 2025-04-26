<?php
use Core\App;
use Core\Database;
use Core\Validator;
use Models\Item;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $newItem = new Item($_POST);

  // Validasi input
  if (!Validator::string($newItem->name, 1, 100)) {
    $errors["name"] = "Name must be between 1 and 100 characters.";
  }
  if (!Validator::greaterThan($newItem->categoryId,0)) {
    $errors["category_id"] = "Category is required and must be valid.";
  }
  if (!Item::isValidUnit($newItem->unit)) {
    $errors["unit"] = "Unit must be 'PCS' or 'PACK'.";
  }
  if ($newItem->unit === Item::UNIT_PACK && (!Validator::greaterThan($newItem->pcsPerPack ?? 0,0))) {
    $errors["pcs_per_pack"] = "Pcs per pack is required and must be a greater than 0 when unit is 'PACK'.";
  }

  // Jika ada error, kembalikan ke form dengan pesan error
  if (!empty($errors)) {
    return view("items/create.view.php", [
      "errors" => $errors,
      "categories" => $db->query("SELECT * FROM categories")->get(),
    ]);
  }
  
  // Simpan data ke database
  $db->query("
    INSERT INTO items (name, category_id, unit, pcs_per_pack, pcs_stock, pack_stock) 
    VALUES (:name, :category_id, :unit, :pcs_per_pack, :pcs_stock, :pack_stock)
  ", [
    "name" => $newItem->name,
    "category_id" => $newItem->categoryId,
    "unit" => $newItem->unit,
    "pcs_per_pack" => $newItem->pcsPerPack,
    "pcs_stock" => 0, // Set default pcs_stock to 0
    "pack_stock" => 0, // Set default pcs_stock to 0
  ]);
    

  // Redirect ke halaman items
  header("Location: /items");
  exit;
} else {
  header("Location: /items");
  exit;
}