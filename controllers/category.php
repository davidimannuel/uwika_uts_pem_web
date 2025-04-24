<?php

$config = require("config.php");

$db = new Database($config['database']);

$categoryId = $_GET['id'] ?? null;
if (!$categoryId) {
    abort();
}

$category = $db->query("SELECT * FROM item_categories where id = :id",[':id' => $categoryId])->findOrFail();
// dd($category);

require "views/category.view.php";