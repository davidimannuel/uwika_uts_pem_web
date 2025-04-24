<?php
use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // dd($_POST);  
  $name = $_POST["name"];
  
  if (!Validator::string($name, 1, 255)) {
    $errors["name"] = "Name must be between 1 and 255 characters.";
  }
  // dd($errors);
  if (empty($errors)) {
    $db->query("INSERT INTO item_categories (name) VALUES (:name)", [
      "name" => $name
    ]);
    
    // Redirect to the categories page
    header("Location: /item-categories");
    exit;
  }
}

view("item_categories/create.view.php",[
  "errors" => $errors,
]);