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
  "/item-categories" => "controllers/item_categories/index.php",
  "/item-category" => "controllers/item_categories/show.php",
  "/item-categories/create" => "controllers/item_categories/create.php",
  "/item-categories/store" => "controllers/item_categories/store.php",
  "/item-category/edit" => "controllers/item_categories/edit.php",
  "/item-category/update" => "controllers/item_categories/update.php",
  "/item-category/delete" => "controllers/item_categories/destroy.php",
  
  // "/items" => "controllers/item.php",
  // "/inbounds" => "controllers/inbounds.php",
  // "/outbounds" => "controllers/outbounds.php"
];