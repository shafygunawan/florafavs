<?php

session_start();

require('layouts/header.php');

?>

<!-- content -->
<main>
  <!-- hero -->
  <div class="hero container">
    <div class="hero__left">
      <h1 class="hero__title">Selamat datang di FloraFavs: taman Anda yang hidup!</h1>
      <p class="hero__subtitle">
        Temukan keindahan alam di dalam rumah Anda dengan koleksi tanaman eksotis dan unik kami. Mulai petualangan hijau Anda sekarang!
      </p>
      <a href="./products.php" class="hero__button">Mulai sekarang</a>
    </div>
    <div class="hero__right">
      <div class="hero__img-group">
        <img src="./assets/img/heros/hero-1.jpg" alt="Field" />
        <img src="./assets/img/heros/hero-2.jpg" alt="Field" />
      </div>
      <div class="hero__img-group">
        <img src="./assets/img/heros/hero-3.jpg" alt="Field" />
        <img src="./assets/img/heros/hero-4.jpg" alt="Field" />
      </div>
    </div>
  </div>
  <!-- end hero -->
  <!-- promotion -->
  <div class="promotion">
    <div class="promotion__container container">
      <div class="promotion__left">
        <img src="./assets/img/promotions/promotion-1.jpg" alt="Promotion" class="promotion__img" />
        <img src="./assets/img/promotions/promotion-2.jpg" alt="Promotion" class="promotion__img" />
      </div>
      <div class="promotion__right">
        <h2 class="promotion__title">
          Menghadirkan Kesejukan Alam ke Dalam Rumah Anda
        </h2>
        <p class="promotion__description">
          Kami adalah tim tanaman penuh dedikasi yang percaya bahwa keindahan alam dapat dihadirkan ke dalam setiap rumah. Dengan cinta dan perhatian, kami menawarkan koleksi tanaman berkualitas tinggi untuk meningkatkan kehidupan Anda dengan sentuhan hijau yang menyegarkan.
        </p>
      </div>
    </div>
  </div>
  <!-- end promotion -->
  <!-- how -->
  <div class="how container">
    <h2 class="how__header">3 Langkah Mudah Beli Tanaman</h2>
    <div class="how__body">
      <div class="how__list">
        <div class="how__item">
          <img src="./assets/img/how/how-1.jpeg" alt="Step 1" class="how__img" />
          <h3 class="how__title">1. Pilih tanaman favorit anda</h3>
          <p class="how__description">
            Temukan keindahan tanaman dengan menjelajahi koleksi kami yang beragam, lengkap dengan gambar untuk memudahkan pemilihan.
          </p>
        </div>
        <div class="how__item">
          <img src="./assets/img/how/how-2.jpeg" alt="Step 1" class="how__img" />
          <h3 class="how__title">
            2. Tambahkan ke keranjang belanja
          </h3>
          <p class="how__description">
            klik "+ Keranjang" untuk menyimpannya, dan pantau dengan mudah jumlah barang Anda di keranjang belanja.
          </p>
        </div>
        <div class="how__item">
          <img src="./assets/img/how/how-3.jpeg" alt="Step 1" class="how__img" />
          <h3 class="how__title">
            3. Selesaikan pembelian
          </h3>
          <p class="how__description">
            Selesaikan pembelian Anda dengan mudah menggunakan formulir pembayaran sederhana.
          </p>
        </div>
      </div>
      <a href="./products.php" class="how__button">Jelajahi tanaman</a>
    </div>
  </div>
  <!-- end how -->
  <!-- join -->
  <div class="join container">
    <div class="join__card join__card_admin">
      <h2 class="join__title">Kelola sekarang</h2>
      <p class="join__description">
        Kelola sekarang dan jadilah penggerak dalam menyebarkan kebaikan tanaman!
      </p>
      <a href="./admin/login.php" class="join__button">Mulai sebagai staff</a>
    </div>
    <div class="join__card">
      <h2 class="join__title">Beli tanaman sekarang</h2>
      <p class="join__description">
        Mulai petualangan hijau Anda sekarang - pilih, tambahkan ke keranjang, dan bawa keindahan tanaman!
      </p>
      <a href="./login.php" class="join__button join__button_primary">Mulai sebagai pelanggan</a>
    </div>
  </div>
  <!-- end join -->
</main>
<!-- end content -->

<?php

require('layouts/footer.php');

?>