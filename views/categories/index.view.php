<?php require basePath("views/partials/head.php"); ?>
  
<?php require basePath("views/partials/nav.php"); ?>
  
<div class="container mt-4">
  <!-- Your content goes here -->
  <h1>Category Management</h1>
  <a href="/categories/create" class="btn btn-success">Create Category</a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Action</th>
        <th scope="col">Created At</th>
        <th scope="col">Updated At</th>
      </tr>
    </thead>
    <tbody>
      <?php $rowNumber = 1; // Inisialisasi nomor baris ?>
      <?php foreach ($categories as $category): ?>
      <tr>
        <th scope="row"><?= $rowNumber++ ?></th>
        <td><?= htmlspecialchars($category['name']) ?></td>
        <td>
          <div class="btn-group" role="group" aria-label="Action Buttons">
            <a href="/category/edit?id=<?= $category['id'] ?>" class="btn btn-primary">Edit</a>
            <form action="/category/delete" method="post" style="display: inline;">
              <input type="hidden" name="id" value="<?= $category['id'] ?>">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
        </td>
        <td><?= $category['created_at'] ?></td>
        <td><?= $category['updated_at'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
  
<?php require basePath("views/partials/foot.php"); ?>