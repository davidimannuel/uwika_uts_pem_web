<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>
<?php use Models\Item; ?>

<div class="container mt-4">
  <h1>Items Management</h1>
  <a href="/items/create" class="btn btn-success mb-3">Create Item</a>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Unit</th>
        <th>PCS Stock</th>
        <th>PACK Stock</th>
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
          <?= ($item['unit'] == Item::UNIT_PACK && $item['pcs_per_pack'] > 0) ? " ({$item['pcs_per_pack']} PCS)" : "" ?>
        </td>
        <td>
          <?= ( ($item['unit'] == Item::UNIT_PACK) && !($item["pcs_per_pack"] > 0) ) ? "-" : htmlspecialchars($item['pcs_stock']) ?>
        </td>
        <td><?= htmlspecialchars($item['pack_stock']) ?></td>
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