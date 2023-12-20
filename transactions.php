<?php

session_start();

// cek apakah cust sudah login
if (!isset($_SESSION['customer_id'])) {
  header("Location: ./login.php");
  exit();
}

require_once('data/order.php');

// AMBIL SELURUH ORDERAN CUST X
$orders = get_orders($_SESSION['customer_id']);

// HEADER
$title = 'Transaksi';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="./assets/css/transactions.css">

<!-- content -->
<main>
  <!-- transactions -->
  <div class="container transactions">
    <div class="section-header">
      <h2>Transaksi</h2>
    </div>
    <div class="transactions__body">
      <table class="transactions__table">
        <thead>
          <tr>
            <th>No. Transaksi</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <!-- TAMPILKAN ORDERAN CUST X -->
          <?php foreach ($orders as $order) : ?>
            <tr>
              <!-- LIHAT LEBIH DETAIL -->
              <td><a href="./transaction-single.php?order_id=<?= $order['order_id'] ?>">#FF<?= $order['order_id'] ?></a></td>
              <!-- TGL TRX -->
              <td><?= date('d M Y', strtotime($order['order_date'])) ?></td>
              <!-- TOTAL PER ORDER -->
              <td>Rp<?= number_format($order['order_total_price']) ?></td>
              <!-- STATUS ORDER -->
              <td><span class="badge <?= $order['order_status'] == 'paid' ? 'badge_success' : 'badge_danger' ?>"><?= $order['order_status'] ?></span></td>
            </tr>
          <?php endforeach; ?>
          <!-- JIKA ORDERAN MASIH KOSONG -->
          <?php if (empty($orders)) : ?>
            <tr>
              <td colspan="4" class="transactions__empty">Anda belum memiliki transaksi!</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- end transactions -->
</main>
<!-- end content -->

<?php

// FOOTER
require('layouts/footer.php');

?>