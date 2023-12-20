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

require_once('../data/category.php');
require_once('../data/plant.php');

// mengambil seluruh kategori
$categories = get_categories();

// inisialisasi variabel untuk halaman dan komponen header
$page = 'categories';
$title = 'Kategori';
require('layouts/header.php');

?>

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <h1 class="admin__title">Kategori</h1>
    <div class="admin__actions">
      <a href="./category-add.php" class="admin__button">Tambah Kategori</a>
    </div>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Produk Terkait</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $i => $category) : ?>
            <tr>
              <td><?= $i + 1 ?>.</td>
              <td>
                <a href="./category-single.php?category_id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?></a>
              </td>
              <td><?= count_related_plants_based_on_category($category['category_id'])['count_related_plants'] ?></td>
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