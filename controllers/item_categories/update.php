<?php
use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  
  // Validasi panjang string
  if (!Validator::string($name, 1, 255)) {
    $errors["name"] = "Name must be between 1 and 255 characters.";
  }

  // Jika ada error validasi, kembalikan ke form
  if (!empty($errors)) {
    return view("item_categories/create.view.php", [
      "errors" => $errors,
    ]);
  }

  // Tangani error duplikasi dengan try-catch
  try {
    $now = DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d H:i:s.u');
    
    $db->query("UPDATE item_categories SET name = :name, updated_at = :updated_at WHERE id = :id", [
      "name" => $name,
      "updated_at" => $now,
      "id" => $_POST["id"]
    ]);
    
    // Redirect ke halaman kategori jika berhasil
    header("Location: /item-categories");
    return ;
  } catch (PDOException $e) {
    // Tangkap error duplikasi
    if ($e->getCode() === '23505') { // PostgreSQL unique violation error code
      $errors["name"] = "The category name already exists.";
    } else {
      // Tangani error lain jika diperlukan
      $errors["general"] = "An unexpected error occurred.";
    }
    // Kembalikan ke form dengan pesan error
    return view("item_categories/create.view.php", [
      "errors" => $errors,
    ]);
  }
} 

header('location: /item-categories');
die();