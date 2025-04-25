<?php
use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  $itemId = $_POST["item_id"];
  
  $currentItem = $db->query("SELECT * FROM items WHERE id = :id", ['id' => $itemId])->findOrFail();
  
  $quantity = $_POST["quantity"];
  $unit = $_POST["unit"];
  $pcsPerCarton = $currentItem["pcs_per_carton"];
  $note = $_POST["note"] ?? null;

  // Validasi input
  if ($unit === "PCS" && $currentItem["unit"] === "CARTON" && !($pcsPerCarton > 0)) {
    $errors["unit"] = "PCS per carton must be set";
  }

  if ($itemId <= 0) {
    $errors["item_id"] = "Item is required.";
  }
  if ($quantity <= 0) {
    $errors["quantity"] = "Quantity must be a positive number.";
  }
  if (!in_array($unit, ["PCS", "CARTON"])) {
    $errors["unit"] = "Unit must be 'PCS' or 'CARTON'.";
  }

  if (!empty($errors)) {
    return view("inbounds/create.view.php", [
      "errors" => $errors,
    ]);
  }
  // convert pcs to carton
  
  // https://www.php.net/manual/en/pdo.transactions.php
  try {
    // TODO tidy up transactional database
    // Mulai transaksi
    $dbConn = $db->connection;
    $dbConn->beginTransaction();
    // insert into inbounds table
    $createStatement = $dbConn->prepare("
      INSERT INTO inbounds (item_id, quantity, unit, pcs_per_carton, note) 
      VALUES (:item_id, :quantity, :unit, :pcs_per_carton, :note)
    ");
    $createStatement->execute([
      "item_id" => $itemId,
      "quantity" => $quantity,
      "unit" => $unit,
      "pcs_per_carton" => $pcsPerCarton,
      "note" => $note,
    ]);

    // update stock in items table
    $updateStatement = $dbConn->prepare("
      UPDATE items 
      SET stock = stock + :quantity
      WHERE id = :id
    ");
    $updateStatement->execute([
      "id" => $itemId,
      "quantity" => $quantity,
    ]);

    // Commit transaksi jika semua berhasil
    $dbConn->commit();

    header("Location: /inbounds");
    exit;
  } catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $dbConn->rollBack();

    // Tambahkan pesan error
    $errors["general"] = "An error occurred while processing the transaction: " . $e->getMessage();

    return view("inbounds/create.view.php", [
      "errors" => $errors,
    ]);
  }

  header("Location: /inbounds");
  exit;
} else {
  header("Location: /inbounds");
  exit;
}