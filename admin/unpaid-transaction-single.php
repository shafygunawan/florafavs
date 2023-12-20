<?php

session_start();

// cek apakah user belum login
if (!isset($_SESSION['staff_id'])) {
  header("Location: ./login.php");
  exit();
}

// cek apakah peran user bukan administrator
if ($_SESSION['role_name'] != 'administrator') {
  header("Location: ./index.php");
  exit();
}

// cek apakah id pesanan tidak ada
if (!isset($_GET['order_id'])) {
  header("Location: ./unpaid-transactions.php");
  exit();
}

require_once('../data/transaction.php');

$order_info = get_order_details_admin($_GET['order_id']);
$date_bank = get_date_bank($_GET["order_id"]);
$result = 0;
$result_qty = 0;

// cek apakah pesanan tidak ditemukan
if (!$date_bank) {
  header("Location: ./unpaid-transactions.php");
  exit();
}

// inisialisasi variabel untuk halaman dan komponen header
$page = 'unpaid-transactions';
$title = 'Detail Transaksi Belum Lunas';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="../assets/css/admin/page-single.css">

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <div class="admin__back">
      <i class="ph-bold ph-arrow-left"></i>
      <a href="./unpaid-transactions.php">Kembali</a>
    </div>
    <h1 class="admin__title">Detail transaksi belum lunas</h1>
    <div class="admin__actions">
      <?php if ($date_bank["order_status"] == "unpaid") : ?>
        <a href="./unpaid-transaction-approved.php?order_id=<?= $date_bank["order_id"] ?>" class="admin__button">Tandai sebagai terbayar</a>
      <?php else : ?>
        <span class="badge <?= $date_bank['order_status'] == 'paid' ? 'badge_success' : 'badge_danger' ?>"><?= $date_bank['order_status'] ?></span>
      <?php endif; ?>
    </div>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <p>Tanggal transaksi: <?= date('d M Y', strtotime($date_bank['order_date'])) ?></p>
      <p>Metode pembayaran: Bank <?= $date_bank["payment_method_bank"] ?></p>
    </div>
    <div class="admin__card">
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanaman</th>
            <th>Harga</th>
            <th>Kuantitas</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order_info as $i => $ord) : ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= $ord["plant_name"] ?></td>
              <td>Rp<?= number_format($ord["plant_price"]) ?></td>
              <td><?= $ord["order_detail_qty"] ?></td>
              <?php $sum_price = $ord["plant_price"] * $ord["order_detail_qty"] ?>
              <td>Rp<?= number_format($sum_price) ?></td>
              <?php $result += $sum_price;
              $result_qty += $ord["order_detail_qty"]; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">Total</td>
            <td><?= $result_qty ?></td>
            <td>Rp<?= number_format($result) ?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
<!-- end your content in here -->

<?php

// komponen footer
require('layouts/footer.php');

?>