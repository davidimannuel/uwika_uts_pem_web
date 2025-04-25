<?php require basePath("views/partials/head.php"); ?>
  
<?php require basePath("views/partials/nav.php"); ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Create Item Category</h1>
  <a href="/categories" class="btn btn-success">Back to Categories</a>
  <div class="row">
    <div class="col-md-6">
      <form action="/categories/store" method="POST">
        <label for="name" class="form-label">Name</label>
        <input type="text" 
          name="name"
          placeholder="Name" 
          value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" 
          class="form-control">
        
        <?php if (isset($errors["name"])): ?>
          <div class="alert alert-danger mt-2">
            <?= htmlspecialchars($errors["name"]) ?>
          </div>
        <?php endif; ?>

        <input 
          type="submit" 
          value="Create" 
          class="btn btn-primary mt-2">
      </form>
  </div>
</div>
  
<?php require basePath("views/partials/foot.php"); ?>