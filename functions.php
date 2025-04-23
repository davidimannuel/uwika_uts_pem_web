<?php 

function urlIs($path) {
  return $_SERVER['REQUEST_URI'] === $path ? true : false;
}

function dd($data) {
  echo "<pre>";
  var_dump($data);
  echo "</pre>";
  die();
}