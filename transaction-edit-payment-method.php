<?php

session_start();

// cek apakah cust sudah login
if (!isset($_SESSION['customer_id'])) {
  header("Location: ./login.php");
  exit();
}

// JIKA TIDAK ADA ORDER YANG DIUBAH PEMBAYARANNYA ARAHKAN KE HAL ORDER
if (!isset($_GET['order_id'])) {
  header("Location: ./transactions.php");
  exit();
}

require_once('data/order.php');
require_once('data/payment_method.php');

// LIST TEMP ERROR 
$errors = [];
// AMBIL SELURUH ORDERAN CUST X 
$order = find_order($_SESSION['customer_id'], $_GET['order_id']);
// AMBIL SELURUH METHODE PEMBAYARAN
$payment_methods = get_payment_methods();

// JIKA TIDAK ADA ORDERAN
if (!$order) {
  header("Location: ./transactions.php");
  exit();
}

// JIKA STATUS ORDERAN TELAH TERBAYAR
if ($order['order_status'] == 'paid') {
  header("Location: ./transaction-single.php?order_id=" . $_GET['order_id']);
  exit();
}

// JIKA TOMBOL SIMPAN (SUBMIT) DIKLIK
if (isset($_POST['submit'])) {
  // JIKA METHODE PEMBAYARAN DIPILIH
  if (isset($_POST['payment_method_id'])) {
    // UPDATE METHODE PEMBAYARAN
    update_order($_SESSION['customer_id'], $_GET['order_id'], $_POST['payment_method_id']);
    header("Location: ./transaction-single.php?order_id=" . $_GET['order_id']);
    exit();
  }

  // ISI ERROR MSG
  $errors['payment_method_id'] = 'Pilih satu metode pembayaran.';
}

// HEADER
$title = 'Ubah Metode Pembayaran Transaksi';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="./assets/css/transaction-edit-payment-method.css">

<!-- content -->
<main>
  <!-- transaction edit payment method -->
  <div class="transaction-edit-method">
    <div class="transaction-edit-method__header">
      <p>
        <!-- LINK KEMBALI -->
        <i class="ph-bold ph-arrow-left"></i>
        <a href="./transaction-single.php?order_id=<?= $_GET['order_id'] ?>">Kembali</a>
      </p>
      <h1>Ubah Metode Pembayaran #FF<?= $order['order_id'] ?></h1>
    </div>
    <form action="./transaction-edit-payment-method.php?order_id=<?= $_GET['order_id'] ?>" method="post" class="transaction-edit-method__body">
      <div class="transaction-edit-method__method">
        <div class="transaction-edit-method__method-group">
          <h2 class="transaction-edit-method__method-title">
            Metode Pembayaran <span class="text-danger">*</span>
          </h2>
          <div class="transaction-edit-method__method-list">
            <!-- TAMPILKAN SEMUA METHODE PEMBAYARAN -->
            <?php foreach ($payment_methods as $payment_method) : ?>
              <label>
                <input type="radio" name="payment_method_id" value="<?= $payment_method['payment_method_id'] ?>" <?= $payment_method['payment_method_id'] == $order['payment_method_id'] ? 'checked' : '' ?> />
                <span></span>
                <i class="ph-fill ph-check-circle"></i>
                <img src="./assets/img/banks/<?= $payment_method['payment_method_logo'] ?>" alt="<?= $payment_method['payment_method_bank'] ?>" />
              </label>
            <?php endforeach; ?>
          </div>
          <!-- JIKA TERDAPAT ERROR -->
          <?php if (isset($errors['payment_method_id'])) : ?>
            <div class="input-error"><?= $errors['payment_method_id'] ?></div>
          <?php endif; ?>
        </div>
      </div>
      <!-- TOMBOL SIMPAN(SUBMIT) -->
      <button type="submit" name="submit" class="transaction-edit-method__button">
        Simpan
      </button>
    </form>
  </div>
  <!-- end transaction edit payment method -->
</main>
<!-- end content -->

<?php

require('layouts/footer.php');

?>