<?php require "views/partials/head.php"; ?>
  
<?php require "views/partials/nav.php"; ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Category Management</h1>
  <ul>
    <?php foreach ($categories as $category): ?>
      <li>
        <a href="/category?id=<?= $category['id'] ?>">
          <?= htmlspecialchars($category['name']) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
  
<?php require "views/partials/foot.php"; ?>