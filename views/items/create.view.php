<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>

<div class="container mt-4">
  <h1>Create Item</h1>
  <a href="/items" class="btn btn-success">Back to Items</a>
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
        <option value="PCS">PCS</option>
        <option value="CARTON">CARTON</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="pcs_per_carton" class="form-label">Pcs per Carton (Optional)</label>
      <input type="number" class="form-control" id="pcs_per_carton" name="pcs_per_carton">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const unitSelect = document.getElementById('unit');
    const pcsPerCartonInput = document.getElementById('pcs_per_carton');

    // Show pcs_per_carton input only if unit is CARTON
    unitSelect.addEventListener('change', function() {
      if (this.value === 'CARTON') {
        pcsPerCartonInput.parentElement.style.display = 'block';
      } else {
        pcsPerCartonInput.parentElement.style.display = 'none';
      }
    });

    // Trigger change event on page load to set initial state
    unitSelect.dispatchEvent(new Event('change'));
  });
</script>
<?php require basePath("views/partials/foot.php"); ?>