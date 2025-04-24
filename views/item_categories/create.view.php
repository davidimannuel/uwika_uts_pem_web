<?php require basePath("views/partials/head.php"); ?>
  
<?php require basePath("views/partials/nav.php"); ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Create Category</h1>
  <form action="" method="POST">
    <label for="name">Category Name</label>
    <input type="text" 
      name="name" a
      placeholder="Category Name" 
      value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" class="form-control">
    <input type="submit" value="Create" class="btn btn-primary">
  </form>
  <?php if (isset($errors["name"])): ?>
    <div class="alert alert-danger">
      <?= $errors["name"] ?>
    </div>
  <?php endif; ?>
</div>
  
<?php require basePath("views/partials/foot.php"); ?>