<?php
use Core\App;
use Core\Database;
use Core\Validator;
use Models\Item;

$db = App::resolve(Database::class);
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST["id"];
  $currentItem = $db->query("SELECT * FROM items WHERE id = :id", ['id' => $id])->findOrFail();
  
  $name = $_POST["name"] ?? '';
  $categoryId = $_POST["category_id"] ?? 0;

  // Validasi
  if (!Validator::string($name, 1, 100)) {
    $errors["name"] = "Name must be between 1 and 100 characters.";
  }
  if (!Validator::greaterThan($categoryId, 0)) {
    $errors["category_id"] = "Category is required and must be valid.";
  }
  if (!empty($errors)) {
    $item = $db->query("SELECT * FROM items WHERE id = :id", ['id' => $id])->find();
    $categories = $db->query("SELECT * FROM item_categories")->get();
    return view("items/edit.view.php", [
      "errors" => $errors,
      "item" => $item,
      "categories" => $categories,
    ]);
  }

  // Update DB
  $db->query("
    UPDATE items 
    SET 
      name = :name, category_id = :category_id, updated_at = :updated_at
    WHERE id = :id
  ", [
    "id" => $id,
    "name" => $name,
    "category_id" => $categoryId,
    "updated_at" => DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d H:i:s.u'),
  ]);

  // Redirect
  header("Location: /items");
  exit;
} else {
  header("Location: /items");
  exit;
}
