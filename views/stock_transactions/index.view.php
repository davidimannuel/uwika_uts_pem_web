<?php require basePath("views/partials/head.php"); ?>
<?php require basePath("views/partials/nav.php"); ?>
<?php use Models\StockTransaction; ?>

<div class="container mt-4">
  <h1>Stock Transactions</h1>

  <!-- Dropdown untuk memilih item -->
  <form method="GET" class="mb-3">
    <div class="row">
      <div class="col-md-6">
        <select name="item_id" class="form-control" onchange="this.form.submit()">
          <option value="">Select an Item</option>
          <?php foreach ($items as $item): ?>
            <option value="<?= $item['id'] ?>" <?= $itemId == $item['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($item['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </form>

  <?php if (!$itemId): ?>
    <div class="alert alert-info col-md-6">Please select an item to view and create transactions.</div>
  <?php else: ?>
    <!-- Informasi stok terkini -->
    <div class="mb-4">
      <h2>Item Information</h2>
      <div class="row">
        <!-- Kolom kiri -->
        <div class="col-md-6">
          <p><strong>Item Name:</strong> <?= htmlspecialchars($currentItem['name']) ?></p>
          <p><strong>Unit:</strong> <?= htmlspecialchars($currentItem['unit']) ?></p>
          <?php if ($currentItem['pcs_per_pack']): ?>
            <p><strong>PCS per Pack:</strong> <?= htmlspecialchars($currentItem['pcs_per_pack']) ?></p>
          <?php endif; ?>
        </div>
        <!-- Kolom kanan -->
        <div class="col-md-6">
          <p><strong>PCS Stock:</strong> <?= htmlspecialchars($currentItem['pcs_stock']) ?></p>
          <p><strong>Pack Stock:</strong> <?= htmlspecialchars($currentItem['pack_stock']) ?></p>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Kolom untuk daftar transaksi -->
      <div class="col-md-8">
        <h2>Transactions for <?= htmlspecialchars($currentItem['name']) ?></h2>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Type</th>
              <th>Pack Quantity</th>
              <th>PCS Quantity</th>
              <th>Note</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($transactions)): ?>
              <tr>
                <td colspan="6" class="text-center">No transactions found for this item.</td>
              </tr>
            <?php else: ?>
              <?php $rowNumber = 1; ?>
              <?php foreach ($transactions as $transaction): ?>
              <tr>
                <td><?= $rowNumber++ ?></td>
                <td><?= htmlspecialchars($transaction['type']) ?></td>
                <td><?= htmlspecialchars($transaction['pack_quantity']) ?></td>
                <td><?= htmlspecialchars($transaction['pcs_quantity']) ?></td>
                <td><?= htmlspecialchars($transaction['note'] ?? '') ?></td>
                <td><?= htmlspecialchars($transaction['created_at']) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Kolom untuk form create transaction -->
      <div class="col-md-4">
        <h2>Create Transaction</h2>

        <!-- Tampilkan error jika ada -->
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="/stock-transactions/store" method="POST">
          <input type="hidden" name="item_id" value="<?= htmlspecialchars($itemId) ?>">
          <div class="mb-3">
            <label for="type" class="form-label">Transaction Type</label>
            <select class="form-control" id="type" name="type" required>
              <?php foreach (StockTransaction::VALID_TYPES as $validType): ?>
                <option value="<?= $validType ?>" <?= $type === $validType ? 'selected' : '' ?>>
                  <?= htmlspecialchars($validType) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="pack_quantity" class="form-label">Pack Quantity</label>
            <input type="number" class="form-control" id="pack_quantity" name="pack_quantity" min="0">
          </div>
          <div class="mb-3">
            <label for="pcs_quantity" class="form-label">PCS Quantity</label>
            <input type="number" class="form-control" id="pcs_quantity" name="pcs_quantity" min="0">
          </div>
          <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php require basePath("views/partials/foot.php"); ?>