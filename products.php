<?php

session_start();

// cek apakah cust sudah login
if (!isset($_SESSION['customer_id'])) {
  header("Location: ./login.php");
  exit();
}

require_once('data/plant.php');
require_once('data/category.php');

// KATA KUNCI
$keyword = htmlspecialchars(isset($_GET['keyword']) ? $_GET['keyword'] : '');
// KATEGORI
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

// AMBIL KATEGORI
$categories = get_categories();
// SEARCH ENGINE DENGAN KATAKUNCI & KATEGORI
$plants = search_plants_with_category($keyword, $category_id, true);

$title = 'Produk';
require('layouts/header.php');

?>

<!-- content -->
<main>
  <!-- filter -->
  <form action="./products.php" method="get" class="filter container">
    <div class="filter__list">
      <div class="filter__item">
        <label for="category_id">
          <i class="ph ph-tag"></i>
        </label>
        <!-- KATEGORI -->
        <select name="category_id" id="category_id">
          <option value="" selected>Semua</option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $category_id ? 'selected' : '' ?>><?= $category['category_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="filter__search">
      <label for="keyword">
        <i class="ph ph-magnifying-glass"></i>
      </label>
      <!-- INPUT KATA KUNCI -->
      <input type="search" name="keyword" id="keyword" placeholder="Cari tanaman ..." value="<?= $keyword ?>" />
      <button type="submit">Cari</button>
    </div>
  </form>
  <!-- end filter -->
  <!-- products -->
  <div class="products container">
    <div class="products__body">
      <!-- TAMPILKAN HASIL PENCARIAN PRODUK -->
      <?php foreach ($plants as $plant) : ?>
        <div class="products__card">
          <div class="products__card-top">
            <!-- GAMBAR PRODUK -->
            <img src="./assets/img/plants/<?= $plant['plant_photo'] ?>" alt="<?= $plant['plant_name'] ?>" class="products__card-img" />
          </div>
          <div class="products__card-body">
            <!-- HARGA -->
            <p class="products__card-price">Rp<?= number_format($plant['plant_price']) ?></p>
            <!-- NAMA -->
            <h3 class="products__card-name"><?= $plant['plant_name'] ?></h3>
            <!-- KATEGORI, STOCK -->
            <p class="products__card-info">
              <i class="ph ph-tag"></i>
              <?= $plant['category_name'] ?>
              <i class="ph ph-package"></i>
              <?= $plant['plant_stock'] ?> stok
            </p>
            <hr />
            <!-- TOMBOL +KERANJANG & BELI SEKARANG -->
            <form action="./add-to-cart.php" method="post" class="products__card-actions">
              <!-- +KERANJANG -->
              <input type="hidden" name="plant_id" value="<?= $plant['plant_id'] ?>">
              <button type="submit" name="add_to_cart" class="products__card-action-button">
                <i class="ph ph-plus-circle"></i>
                Keranjang
              </button>
              <!-- BELI SEKARANG -->
              <button type="submit" name="buy_now" class="products__card-action-button products__card-action-button_primary">
                <i class="ph ph-shopping-cart-simple"></i>
                Beli Sekarang
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
      <!-- JIKA HASIL PENCARIAN KOSONG -->
      <?php if (empty($plants)) : ?>
        <div class="products__empty">
          Produk kosong!
        </div>
      <?php endif; ?>
    </div>
  </div>
  <!-- end products -->
</main>
<!-- end content -->

<?php

require('layouts/footer.php');

?>