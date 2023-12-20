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

require_once('../data/plant.php');

$plants = get_plants_with_category();

// inisialisasi variabel untuk halaman dan komponen header
$page = 'products';
$title = 'Tanaman';
require('layouts/header.php');

?>

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <h1 class="admin__title"><?= $title ?></h1>
    <div class="admin__actions">
      <a href="./product-add.php" class="admin__button">Tambah Tanaman</a>
    </div>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($plants as $i => $plant) : ?>
            <tr>
              <td><?= $i + 1 ?>.</td>
              <td><a href="./product-single.php?plant_id=<?= $plant['plant_id'] ?>"><?= $plant['plant_name'] ?></a></td>
              <td>Rp<?= number_format($plant['plant_price']) ?></td>
              <td><?= $plant['plant_stock'] ?></td>
              <td><?= $plant['category_name'] ?></td>
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