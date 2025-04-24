<?php require "views/partials/head.php"; ?>
  
<?php require "views/partials/nav.php"; ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Category Management</h1>
  <p>Category : <?= htmlspecialchars($category["name"])?></p>
</div>
  
<?php require "views/partials/foot.php"; ?>