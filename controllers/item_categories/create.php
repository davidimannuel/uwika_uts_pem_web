<?php

$config = require basePath("config.php");

require basePath("Validator.php");

$db = new Database($config['database']);

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
    header("Location: /categories");
    exit;
  }
}

view("item_categories/create.view.php",[
  "errors" => $errors,
]);