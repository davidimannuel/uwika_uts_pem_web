<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>

<div class="container mt-4">
  <h1>Inbound Management</h1>
  <a href="/inbounds/create" class="btn btn-success mb-3">Create Inbound</a>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Unit</th>
        <th>Pack Quantity</th>
        <th>PCS Quantity</th>
        <th>Note</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php $rowNumber = 1; ?>
      <?php foreach ($inbounds as $inbound): ?>
      <tr>
        <td><?= $rowNumber++ ?></td>
        <td><?= htmlspecialchars($inbound['item_name']) ?></td>
        <td><?= htmlspecialchars($inbound['item_unit']) ?></td>
        <td>
          <?= htmlspecialchars($inbound['pack_quantity']) ?>
          <?= ($inbound['item_pcs_per_pack'] > 0) ? " ({$inbound['item_pcs_per_pack']} PCS per PACK)" : "" ?>
        </td>
        <td><?= htmlspecialchars($inbound['pcs_quantity']) ?></td>
        <td><?= htmlspecialchars($inbound['note']) ?></td>
        <td><?= htmlspecialchars($inbound['created_at']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require basePath("views/partials/foot.php"); ?>