<?php 

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

$routes = [
  "/" => "controllers/index.php",
  "/categories" => "controllers/categories.php",
  "/category" => "controllers/category.php",
  "/items" => "controllers/item.php",
  "/inbounds" => "controllers/inbounds.php",
  "/outbounds" => "controllers/outbounds.php"
];

function abort($code = Response::INTERNAL_SERVER_ERROR) {
  http_response_code($code);
  require "views/errors/{$code}.view.php";
  die();
}
 
function routeToController($uri, $routes) {
  if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
  } else {
    abort(Response::NOT_FOUND);
  }
}

routeToController($uri,$routes);