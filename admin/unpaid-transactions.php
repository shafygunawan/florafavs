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

require_once('../data/transaction.php');

$order_info = get_data_order();

// inisialisasi variabel untuk halaman dan komponen header
$page = 'unpaid-transactions';
$title = 'Transaksi Belum Lunas';
require('layouts/header.php');

?>

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <h1 class="admin__title">Transaksi belum lunas</h1>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <table>
        <thead>
          <tr>
            <th>No. Transaksi</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal</th>
            <th>Total Tanaman</th>
            <th>Total Harga</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order_info as $order) : ?>
            <tr>
              <td>
                <a href="./unpaid-transaction-single.php?order_id=<?= $order["order_id"] ?>">#FF<?= $order["order_id"] ?></a>
              </td>
              <td>Bank <?= $order["payment_method_bank"] ?></td>
              <td><?= date('d M Y', strtotime($order["order_date"])) ?></td>
              <td><?= get_order_sum($order["order_id"]) ?></td>
              <td>Rp<?= number_format($order["order_total_price"]) ?></td>
              <td>
                <a href="./unpaid-transaction-approved.php?order_id=<?= $order["order_id"] ?>" class="button">Tandai sebagai terbayar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- end your content in here -->

<?php

// komponen footer
require('layouts/footer.php');

?>