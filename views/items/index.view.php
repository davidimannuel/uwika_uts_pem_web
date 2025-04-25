<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>
<?php require basePath("controllers/items/constants.php"); ?>

<div class="container mt-4">
  <h1>Items Management</h1>
  <a href="/items/create" class="btn btn-success">Create Item</a>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Unit</th>
        <th>Stock</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $rowNumber = 1; ?>
      <?php foreach ($items as $item): ?>
      <tr>
        <td><?= $rowNumber++ ?></td>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= htmlspecialchars($item['category_name']) ?></td>
        <td>
          <?= htmlspecialchars($item['unit']) ?>
          <?= ($item['unit'] == UNIT_CARTON && $item['pcs_per_carton'] > 0) ? "({$item['pcs_per_carton']} PCS)": "" ?>
        </td>
        <td><?= htmlspecialchars($item['stock']) ?></td>
        <td>
          <div class="btn-group">
            <a href="/item/edit?id=<?= $item['id'] ?>" class="btn btn-primary">Edit</a>
            <form action="/item/delete" method="post" style="display: inline;">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require basePath("views/partials/foot.php"); ?>