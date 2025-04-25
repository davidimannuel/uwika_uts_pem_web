<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>

<div class="container mt-4">
  <h1>Create Outbound</h1>
  <a href="/outbounds" class="btn btn-secondary mb-3">Back to Outbounds</a>
  <form action="/outbounds/store" method="POST">
    <div class="mb-3">
      <label for="item_id" class="form-label">Item</label>
      <select class="form-control" id="item_id" name="item_id" required>
        <?php foreach ($items as $item): ?>
          <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></option>
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
      <label for="pcs_per_carton" class="form-label">Pcs per Carton (Optional)</label>
      <input type="number" class="form-control" id="pcs_per_carton" name="pcs_per_carton">
    </div>
    <div class="mb-3">
      <label for="note" class="form-label">Note</label>
      <textarea class="form-control" id="note" name="note" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<?php require basePath("views/partials/foot.php"); ?>