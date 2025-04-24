<?php 


const BASE_PATH = __DIR__ . "/../";

require BASE_PATH . "Core/functions.php";


// autoload classes
spl_autoload_register(function ($class) {
  $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
  
  require basePath("{$class}.php");
});

require basePath("bootstrap.php");

require basePath("Core/router.php");
