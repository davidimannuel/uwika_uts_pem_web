<?php 

$routes = require basePath("routes.php");

use Core\Response;

function abort($code = Response::INTERNAL_SERVER_ERROR) {
  http_response_code($code);
  require basePath("views/errors/{$code}.view.php");
  die();
}
 
function routeToController($uri, $routes) {
  if (array_key_exists($uri, $routes)) {
    require basePath($routes[$uri]);
  } else {
    abort(Response::NOT_FOUND);
  }
}

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];
routeToController($uri,$routes);