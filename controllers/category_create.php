<?php
$config = require("config.php");
require "Validator.php";

$db = new Database($config['database']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $errors = [];
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

require "views/category_create.view.php";