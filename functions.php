<?php 

function urlIs($path) {
  return $_SERVER['REQUEST_URI'] === $path ? true : false;
}

// var dump and die
function dd($data) {
  echo "<pre>";
  var_dump($data);
  echo "</pre>";
  die();
}

function basePath($path) {
  return BASE_PATH . $path;
}

function view($path, $attributes = []) {
  
  extract($attributes);
  
  require basePath('views/'.$path);
}
