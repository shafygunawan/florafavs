<?php

session_start();

// cek apakah cust sudah login
if (!isset($_SESSION['customer_id'])) {
  header("Location: ./login.php");
  exit();
}

require_once('data/customer.php');

// AMBIL DATA CUST
$customer = find_customer_with_id($_SESSION['customer_id']);

$title = 'Profil Saya';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="./assets/css/profile.css">

<!-- content -->
<main>
  <!-- profile -->
  <div class="profile container">
    <div class="profile__header">
      <h1>Profil Saya</h1>
    </div>
    <div class="profile__body">
      <div class="profile__left">
        <!-- FOTO CUST -->
        <img src="./assets/img/default-profile.jpg" alt="<?= $customer['customer_name'] ?>" />
      </div>
      <div class="profile__right">
        <div class="profile__form">
          <div>
            <!-- NAMA  -->
            <div class="input-label">Nama:</div>
            <div class="input-label"><?= $customer['customer_name'] ?></div>
          </div>
          <div>
            <!-- EMAIL -->
            <div class="input-label">Email:</div>
            <div class="input-label"><?= $customer['customer_email'] ?></div>
          </div>
          <div>
            <!-- NO TELEPHONE -->
            <div class="input-label">Telepon:</div>
            <div class="input-label"><?= $customer['customer_phone'] ?></div>
          </div>
          <!-- TOMBOL UBAH DATA (ubahprofil) -->
          <form action="./editprofile.php" method="get">
            <button type="submit" class="profile__button">Ubah Data</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- end profile -->
</main>
<!-- end content -->

<?php

// FOOTER
require('layouts/footer.php');

?>