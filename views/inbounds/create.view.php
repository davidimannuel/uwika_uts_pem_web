<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>
<?php require basePath("controllers/items/constants.php"); ?>

<div class="container mt-4">
  <h1>Create Inbound</h1>
  <a href="/inbounds" class="btn btn-secondary mb-3">Back to Inbounds</a>
  <?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>
  <form action="/inbounds/store" method="POST">
    <div class="mb-3">
      <label for="item_id" class="form-label">Item</label>
      <select class="form-control" id="item_id" name="item_id" required>
        <?php foreach ($items as $item): ?>
          <option value="<?= $item['id'] ?>">
            <?= htmlspecialchars($item['name'] . " / " . $item['unit']) ?>
            <?= ($item['unit'] == "CARTON" && $item['pcs_per_carton'] > 0) ? " / {$item['pcs_per_carton']} PCS" : "" ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity</label>
      <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
    </div>
    <div class="mb-3">
      <label for="unit" class="form-label">Unit</label>
      <select class="form-control" id="unit" name="unit" required>
        <option value="<?= UNIT_PCS ?>">PCS</option>
        <option value="<?= UNIT_CARTON ?>">CARTON</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="note" class="form-label">Note</label>
      <textarea class="form-control" id="note" name="note" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<?php require basePath("views/partials/foot.php"); ?>