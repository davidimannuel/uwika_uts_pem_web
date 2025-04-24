<?php require basePath("views/partials/head.php"); ?>
  
<?php require basePath("views/partials/nav.php"); ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Category Management</h1>
  <a href="/item-categories/create">Create Category</a>
  <ul>
    <?php foreach ($categories as $category): ?>
      <li>
        <a href="/item-category?id=<?= $category['id'] ?>">
          <?= htmlspecialchars($category['name']) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
  
<?php require basePath("views/partials/foot.php"); ?>