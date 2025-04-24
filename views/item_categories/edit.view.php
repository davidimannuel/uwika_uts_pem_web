<?php require basePath("views/partials/head.php"); ?>
  
<?php require basePath("views/partials/nav.php"); ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Edit Item Category</h1>
  <a href="/item-categories" class="btn btn-success">Back to Categories</a>
  <div class="row">
    <div class="col-md-6">
      <form action="/item-category/update" method="POST">
        <input type="hidden" name="id" value="<?= $category['id'] ?>">
        <label for="name" class="form-label">Name</label>
        <input type="text" 
          name="name"
          placeholder="Name" 
          value="<?= htmlspecialchars($category['name']) ?>" 
          class="form-control">
        
        <?php if (isset($errors["name"])): ?>
          <div class="alert alert-danger mt-2">
            <?= htmlspecialchars($errors["name"]) ?>
          </div>
        <?php endif; ?>

        <input 
          type="submit" 
          value="Edit" 
          class="btn btn-primary mt-2">
      </form>
  </div>
</div>
  
<?php require basePath("views/partials/foot.php"); ?>