<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>
<?php use Models\Item; ?>

<div class="container mt-4">
  <h1>Edit Item</h1>
  <a href="/items" class="btn btn-success">Back to Items</a>
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <form action="/item/update" method="POST">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select class="form-control" id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
          <option value="<?= $category['id'] ?>" <?= $category['id'] == $item['category_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($category['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>

<?php require basePath("views/partials/foot.php"); ?>
