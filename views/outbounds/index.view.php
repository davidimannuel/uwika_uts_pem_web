<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>

<div class="container mt-4">
  <h1>Outbound Management</h1>
  <a href="/outbounds/create" class="btn btn-success">Create Outbound</a>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Note</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php $rowNumber = 1; ?>
      <?php foreach ($outbounds as $outbound): ?>
      <tr>
        <td><?= $rowNumber++ ?></td>
        <td><?= htmlspecialchars($outbound['item_name']) ?></td>
        <td><?= htmlspecialchars($outbound['quantity']) ?></td>
        <td><?= htmlspecialchars($outbound['unit']) ?></td>
        <td><?= htmlspecialchars($outbound['note']) ?></td>
        <td><?= htmlspecialchars($outbound['created_at']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require basePath("views/partials/foot.php"); ?>