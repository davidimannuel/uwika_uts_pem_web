<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>
<?php use Models\Item; ?>

<div class="container mt-4">
  <h1>Create Item</h1>
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
  <form action="/items/store" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select class="form-control" id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
          <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="unit" class="form-label">Unit</label>
      <select class="form-control" id="unit" name="unit" required>
        <?php foreach (Item::VALID_UNITS as $unit): ?>
          <option value="<?= $unit ?>"><?= htmlspecialchars($unit) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3" id="pcs_per_pack_group" style="display: none;">
      <label for="pcs_per_pack" class="form-label">Pcs per Pack (Optional)</label>
      <input type="number" class="form-control" id="pcs_per_pack" name="pcs_per_pack" min="1">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const unitSelect = document.getElementById('unit');
    const pcsPerPackGroup = document.getElementById('pcs_per_pack_group');

    // Show pcs_per_pack input only if unit is PACK
    unitSelect.addEventListener('change', function() {
      if (this.value === '<?= Item::UNIT_PACK ?>') {
        pcsPerPackGroup.style.display = 'block';
      } else {
        pcsPerPackGroup.style.display = 'none';
      }
    });

    // Trigger change event on page load to set initial state
    unitSelect.dispatchEvent(new Event('change'));
  });
</script>

<?php require basePath("views/partials/foot.php"); ?>