<?php require basePath("views/partials/head.php"); ?>
  
<?php require basePath("views/partials/nav.php"); ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Category Management</h1>
  <p>Category : <?= htmlspecialchars($category["name"])?></p>
</div>
  
<?php require basePath("views/partials/foot.php"); ?>