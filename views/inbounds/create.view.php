<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>

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
      <select class="form-control <?= isset($errors['item_id']) ? 'is-invalid' : '' ?>" id="item_id" name="item_id" required>
        <?php foreach ($items as $item): ?>
          <option value="<?= $item['id'] ?>" <?= (isset($_POST['item_id']) && $_POST['item_id'] == $item['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($item['name']) ?>
            <?= ($item['pcs_per_pack'] > 0) ? " / {$item['pcs_per_pack']} PCS" : "" ?>
            <?= " / " . $item['unit'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="pack_quantity" class="form-label">Pack Quantity</label>
      <input type="number" class="form-control <?= isset($errors['pack_quantity']) ? 'is-invalid' : '' ?>" id="pack_quantity" name="pack_quantity" value="<?= htmlspecialchars($_POST['pack_quantity'] ?? '') ?>" min="0">
    </div>
    <div class="mb-3">
      <label for="pcs_quantity" class="form-label">PCS Quantity</label>
      <input type="number" class="form-control <?= isset($errors['pcs_quantity']) ? 'is-invalid' : '' ?>" id="pcs_quantity" name="pcs_quantity" value="<?= htmlspecialchars($_POST['pcs_quantity'] ?? '') ?>" min="0">
    </div>
    <div class="mb-3">
      <label for="note" class="form-label">Note</label>
      <textarea class="form-control <?= isset($errors['note']) ? 'is-invalid' : '' ?>" id="note" name="note" rows="3"><?= htmlspecialchars($_POST['note'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<?php require basePath("views/partials/foot.php"); ?>