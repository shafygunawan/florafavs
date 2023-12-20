<?php

error_reporting(E_ALL);
session_start();

// cek apakah user belum login
if (!isset($_SESSION['staff_id'])) {
  header("Location: ./login.php");
  exit();
}

// cek apakah peran user bukan manager
if ($_SESSION['role_name'] != 'manager') {
  header("Location: ./index.php");
  exit();
}

require_once('../config/database.php');

try {
  $pdo = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}

// inisialisasi variabel untuk halaman dan komponen header
$page = 'unpaid-transactions';
$title = 'Transaksi Belum Lunas';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="../assets/css/admin/graph.css">

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <h1 class="admin__title">Transaksi belum lunas</h1>
  </div>
  <div class="admin__body">

    <?php
    // Prepare statements untuk
    $tanggalpenjualan = $pdo->prepare("SELECT order_date FROM orders WHERE order_status = 'unpaid' AND order_date BETWEEN :datestart AND :dateend GROUP BY order_date");
    $penjualan = $pdo->prepare("SELECT SUM(order_total_price) AS sold FROM orders WHERE order_status = 'unpaid' AND order_date BETWEEN :datestart AND :dateend GROUP BY order_date");
    $paymentmethod = $pdo->prepare("SELECT payment_method_bank FROM payment_methods paymet, orders ord WHERE paymet.payment_method_id = ord.payment_method_id AND order_status = 'unpaid' AND order_date BETWEEN :datestart AND :dateend ORDER BY order_date");
    $orderdate = $pdo->prepare("SELECT order_date FROM orders WHERE order_status = 'unpaid' AND order_date BETWEEN :datestart AND :dateend ORDER BY order_date");
    $plantquantity = $pdo->prepare("SELECT SUM(ordet.order_detail_qty) AS quantity FROM order_details ordet, orders ord WHERE ord.order_id = ordet.order_id AND ord.order_status = 'unpaid' AND order_date BETWEEN :datestart AND :dateend GROUP BY ord.order_id ORDER BY ord.order_date");
    $orderprice = $pdo->prepare("SELECT order_total_price FROM orders WHERE order_status = 'unpaid' AND order_date BETWEEN :datestart AND :dateend ORDER BY order_date");
    $linkid = $pdo->prepare("SELECT order_id FROM orders WHERE order_status = 'unpaid' AND order_date BETWEEN '1023-01-01' AND '5023-12-12' ORDER BY order_date");

    // Bind parameter
    $datestart = isset($_GET['datestart']) ? $_GET['datestart'] : '1900-01-01';
    $dateend = isset($_GET['dateend']) ? $_GET['dateend'] : date('Y-m-d');

    $tanggalpenjualan->bindParam(':datestart', $datestart);
    $tanggalpenjualan->bindParam(':dateend', $dateend);
    $penjualan->bindParam(':datestart', $datestart);
    $penjualan->bindParam(':dateend', $dateend);
    $paymentmethod->bindParam(':datestart', $datestart);
    $paymentmethod->bindParam(':dateend', $dateend);
    $orderdate->bindParam(':datestart', $datestart);
    $orderdate->bindParam(':dateend', $dateend);
    $plantquantity->bindParam(':datestart', $datestart);
    $plantquantity->bindParam(':dateend', $dateend);
    $orderprice->bindParam(':datestart', $datestart);
    $orderprice->bindParam(':dateend', $dateend);

    // Execute query
    $tanggalpenjualan->execute();
    $penjualan->execute();
    $paymentmethod->execute();
    $orderdate->execute();
    $plantquantity->execute();
    $orderprice->execute();
    $linkid->execute();

    // Fetch data
    $paymentmethodarray = $paymentmethod->fetchAll(PDO::FETCH_ASSOC);
    $orderdatearray = $orderdate->fetchAll(PDO::FETCH_ASSOC);
    $plantquantityarray = $plantquantity->fetchAll(PDO::FETCH_ASSOC);
    $orderpricearray = $orderprice->fetchAll(PDO::FETCH_ASSOC);
    $linkidarray = $linkid->fetchAll(PDO::FETCH_ASSOC);

    $len = count($orderdatearray);
    $drop = $len + 1; //tinggi tabel sesuai banyak data + 1
    $totalquantity = 0;
    $totalprice = 0;
    ?>

    <!-- filter tanggal -->
    <form action="./manager-unpaid-transactions.php" method="get" class="admin__filters">
      <input type="date" class="input" name="datestart" value="<?= $datestart ?>">
      <span>sampai</span>
      <input type="date" class="input" name="dateend" value="<?= $dateend ?>">
      <button class="admin__button">Filter</button>
      <a href="./manager-unpaid-transactions.php" class="admin__button">Reset</a>
    </form>
    <div class="admin__card">
      <h2 class="admin__card-title">Grafik</h2>
      <hr />
      <!-- grafik chart -->
      <canvas id="graph" class="graph"></canvas>
    </div>
    <div class="admin__card">
      <!-- tabel laporan -->
      <table>
        <?php
        for ($rait = 0; $rait <= $drop; $rait++) { //$don = kolom tabel, $rait = baris tabel
          for ($don = 0; $don <= 5; $don++) {
            if ($rait == 0) { //header tabel
              if ($don == 0) {
                echo "<thead><tr><th>No. Transaksi</th>";
              } else if ($don == 1) {
                echo '<th>Metode Pembayaran</th>';
              } else if ($don == 2) {
                echo '<th>Tanggal</th>';
              } else if ($don == 3) {
                echo '<th>Total Tanaman</th>';
              } else if ($don == 4) {
                echo '<th>Total Harga</th>';
              } else {
                echo '<th> </th></tr></thead>';
              }
            } else if ($rait == $drop) {
              if ($don == 0) { //baris paling bawah
                echo '<tfoot><tr><td>Total</td>';
              } else if ($don == 3) { //kolom 3 untuk total quantitas produk
                echo "<td>$totalquantity</td>";
              } else if ($don == 4) { //kolom 4 untuk total harga produk
                echo "<td>Rp" . number_format($totalprice) . "</td>";
              } else if ($don == 5) { //kolom 5 untuk total transaksi
                echo "<td>" . $drop - 1 . " Transaksi</td>";
              } else { //kosong, untuk tabel tanpa jumlah total
                echo '<td> </td>';
              }
            } else if ($don == 0 && $rait != 0) {
              if ($rait != $drop) { // isian nomor urut transaksi
                if ($rait == 1) {
                  echo '<tbody><tr><td>#FF' . $rait . '</td>';
                } else {
                  echo '<tr><td>#FF' . $rait . '</td>';
                }
              }
            } else if ($don == 1 && $rait != 0 && $rait != $drop) { // kolom 1 untuk metode pembayaran
              echo '<td>Bank ' . $paymentmethodarray[$rait - 1]['payment_method_bank'] . '</td>';
            } else if ($don == 2 && $rait != 0 && $rait != $drop) { // kolom 2 untuk tanggal
              echo '<td>' . date('d M Y', strtotime($orderdatearray[$rait - 1]['order_date'])) . '</td>';
            } else if ($don == 3 && $rait != 0 && $rait != $drop) { // kolom 3 untuk kuantitas produk
              echo '<td>' . $plantquantityarray[$rait - 1]['quantity'] . '</td>';
              $totalquantity += $plantquantityarray[$rait - 1]['quantity'];
            } else if ($don == 5) {
              if ($rait == $len) { // kolom untuk info lebih lanjut
                echo '<td><a href="./manager-unpaid-transaction-single.php?transid=' . $linkidarray[$rait - 1]['order_id'] . '">Detail</a></td></tbody>';
              } else {
                echo '<td><a href="./manager-unpaid-transaction-single.php?transid=' . $linkidarray[$rait - 1]['order_id'] . '">Detail</a></td>';
              }
            } else {
              if ($rait != $drop) { // kolom 4 untuk harga 
                echo '<td>Rp' . number_format($orderpricearray[$rait - 1]['order_total_price']) . '</td>';
                $totalprice += $orderpricearray[$rait - 1]['order_total_price'];
              } else {
                echo '<td> </td>';
              }
            }
          }
        }
        ?>
      </table>

    </div>
  </div>
</div>
<!-- end your content in here -->

<!-- js libs -->
<script src="../vendor/Chart.js-4.4.0/chart.umd.js"></script>

<!-- custom js -->
<script>
  const ctx = document.getElementById('graph');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php while ($row = $tanggalpenjualan->fetch(PDO::FETCH_ASSOC)) {
          echo '"' . $row['order_date'] . '",';
        } ?>
      ], // Nama data yang dihitung
      datasets: [{
        label: 'Transaksi',
        data: [
          <?php while ($row = $penjualan->fetch(PDO::FETCH_ASSOC)) {
            echo '"' . $row['sold'] . '",';
          } ?>
        ], // Banyak data
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php

// komponen footer
require('layouts/footer.php');

?>