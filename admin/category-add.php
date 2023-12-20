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
require_once('../libs/validation.php');

// inisialisasi variabel untuk menyimpan error dan inputan user
$errors = [];
$old_inputs = [
  'name' => '',
];

// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
  validate_name($errors, $_POST, 'name');

  // cek apakah tidak ada error
  if (!$errors) {
    save_category($_POST);
    header('Location: ./categories.php');
    exit();
  }

  $old_inputs['name'] = htmlspecialchars($_POST['name']);
}

// inisialisasi variabel untuk halaman dan komponen header
$page = 'categories';
$title = 'Tambah Kategori';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="../assets/css/admin/page-single.css">

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <div class="admin__back">
      <i class="ph-bold ph-arrow-left"></i>
      <a href="./categories.php">Kembali</a>
    </div>
    <h1 class="admin__title">Tambah kategori</h1>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <form action="./category-add.php" method="post" class="page-single">
        <div>
          <label for="name" class="input-label">Nama <span class="text-danger">*</span></label>
          <input type="text" id="name" name="name" class="input" value="<?= $old_inputs['name'] ?>" />
          <?php if (isset($errors['name'])) : ?>
            <div class="input-error">
              <?= $errors['name'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="page-single__actions">
          <a href="./categories.php" class="page-single__button">Batal</a>
          <button type="submit" name="submit" class="page-single__button page-single__button_primary">
            Tambah
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end your content in here -->

<?php

// komponen footer
require('layouts/footer.php');

?>