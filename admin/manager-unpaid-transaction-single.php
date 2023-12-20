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
  die('Connection failed: ' . $e->getMessage());
}

$transid = isset($_GET['transid']) ? $_GET['transid'] : null;

$dateorderstmt = $pdo->prepare("SELECT order_date FROM order_details ordet, orders ord WHERE ord.order_id = ?");
$dateorderstmt->execute([$transid]);
$dateorder = $dateorderstmt->fetch(PDO::FETCH_ASSOC)['order_date'];

$plantstmt = $pdo->prepare("SELECT plant_name, plant_price, order_detail_qty FROM order_details ordet, plants pl WHERE ordet.plant_id = pl.plant_id AND order_id = ? ORDER BY order_detail_unit_price");
$plantstmt->execute([$transid]);

$plantquantityarray = array();
$planttotalarray = array();
$plantpricearray = array();
$plantnamearray = array();

while ($row = $plantstmt->fetch(PDO::FETCH_ASSOC)) {
  array_push($plantquantityarray, $row['order_detail_qty']);
  array_push($plantpricearray, $row['plant_price']);
  array_push($plantnamearray, $row['plant_name']);
}

$len = count($plantnamearray);
$drop = $len + 1;
$totalprice = 0;
$totalquantity = 0;

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
      <a href="./manager-unpaid-transactions.php">Kembali</a>
    </div>
    <h1 class="admin__title">Detail transaksi belum lunas</h1>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <?php
      echo "<p>Tanggal transaksi: " . date('d M Y', strtotime($dateorder)) . "</p>";
      ?>
    </div>
    <div class="admin__card">
      <table>
        <?php
        for ($rait = 0; $rait <= $drop; $rait++) {
          for ($don = 0; $don <= 4; $don++) {
            if ($rait == 0) {
              if ($don == 0) {
                echo "<thead><tr><th>No.</th>";
              } else if ($don == 1) {
                echo '<th>Tanaman</th>';
              } else if ($don == 2) {
                echo '<th>Harga</th>';
              } else if ($don == 3) {
                echo '<th>Kuantitas</th>';
              } else {
                echo '<th>Subtotal</th>';
              }
            } else if ($rait == $drop) {
              if ($don == 0) {
                echo '<tfoot><tr><td>Total</td>';
              } else if ($don == 3) { // untuk total kuantitas
                echo "<td>$totalquantity</td>";
              } else if ($don == 4) { // untuk total harga
                echo "<td>Rp" . number_format($totalprice) .  "</td></tfoot>";
              } else {
                echo '<td> </td>';
              }
            } else if ($don == 0 && $rait != 0) {
              if ($rait != $drop) {
                if ($rait == 1) {
                  echo '<tbody><tr><td>' . $rait . '</td>';
                } else {
                  echo '<tr><td>' . $rait . '</td>';
                }
              }
            } else if ($don == 1 && $rait != 0 && $rait != $drop) { // kolom 1 untuk nama produk
              echo '<td>' . $plantnamearray[$rait - 1] . '</td>';
            } else if ($don == 2 && $rait != 0 && $rait != $drop) { // kolom 2 untuk harga produk
              echo '<td>Rp' . number_format($plantpricearray[$rait - 1]) . '</td>';
            } else if ($don == 3 && $rait != 0 && $rait != $drop) { // kolom 3 untuk kuantitas produk
              echo '<td>' . $plantquantityarray[$rait - 1] . '</td>';
              $totalquantity += $plantquantityarray[$rait - 1];
            } else {
              if ($rait != $len) { // kolom 4 untuk sub-total
                echo '<td>Rp' . number_format($plantpricearray[$rait - 1] * $plantquantityarray[$rait - 1]) . '</td>';
                $totalprice = $totalprice + $plantpricearray[$rait - 1] * $plantquantityarray[$rait - 1];
              } else if ($rait == $len) {
                echo '<td>Rp' . number_format($plantpricearray[$rait - 1] * $plantquantityarray[$rait - 1]) . '</td><tbody>';
                $totalprice = $totalprice + $plantpricearray[$rait - 1] * $plantquantityarray[$rait - 1];
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

<?php

// komponen footer
require('layouts/footer.php');

?>