<?php

/*
routing convention
- /{plural} => index -> main page / list all
- /{plural}/create => create -> create new
- /{plural}/store => store -> store logic (using post method)
- /{singular} => show -> show one
- /{singular}/edit => edit -> edit one (using query string for id)
- /{singular}/update => update -> update logic (using post method)
- /{singular}/destroy => delete -> delete one (using query string for id)
*/

return [
  "/" => "controllers/index.php",
  
  // item categories
  "/categories" => "controllers/categories/index.php",
  "/category" => "controllers/categories/show.php",
  "/categories/create" => "controllers/categories/create.php",
  "/categories/store" => "controllers/categories/store.php",
  "/category/edit" => "controllers/categories/edit.php",
  "/category/update" => "controllers/categories/update.php",
  "/category/delete" => "controllers/categories/destroy.php",
  
  // Items
  "/items" => "controllers/items/index.php",
  "/items/create" => "controllers/items/create.php",
  "/items/store" => "controllers/items/store.php",
  "/item/edit" => "controllers/items/edit.php",
  "/item/update" => "controllers/items/update.php",
  "/item/delete" => "controllers/items/destroy.php",

  // Inbounds
  "/inbounds" => "controllers/inbounds/index.php",
  "/inbounds/create" => "controllers/inbounds/create.php",
  "/inbounds/store" => "controllers/inbounds/store.php",

  // Outbounds
  "/outbounds" => "controllers/outbounds/index.php",
  "/outbounds/create" => "controllers/outbounds/create.php",
  "/outbounds/store" => "controllers/outbounds/store.php",
];