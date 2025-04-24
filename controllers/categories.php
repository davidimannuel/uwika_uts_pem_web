<?php

$config = require("config.php");

$db = new Database($config['database']);
$categories = $db->query("SELECT * FROM item_categories")->get();
// dd($categories);

require "views/categories.view.php";