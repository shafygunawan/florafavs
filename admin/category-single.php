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

// cek apakah id kategori tidak ada
if (!isset($_GET['category_id'])) {
  header("Location: ./categories.php");
  exit();
}

require_once('../data/category.php');
require_once('../libs/validation.php');

$category = find_category($_GET['category_id']);

// cek apakah kategori tidak ada
if (!$category) {
  header("Location: ./categories.php");
  exit();
}

// inisialisasi variabel untuk menyimpan error dan inputan user
$errors = [];
$old_inputs = [
  'name' => $category['category_name'],
];

// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
  validate_name($errors, $_POST, 'name');

  // cek apakah tidak ada error
  if (!$errors) {
    update_category($category['category_id'], $_POST);
    header('Location: ./categories.php');
    exit();
  }

  $old_inputs['name'] = htmlspecialchars($_POST['name']);
}

// inisialisasi variabel untuk halaman dan komponen header
$page = 'categories';
$title = 'Detail Kategori';
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
    <h1 class="admin__title">Detail kategori</h1>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <form action="./category-single.php?category_id=<?= $category['category_id'] ?>" method="post" class="page-single">
        <div>
          <label for="name" class="input-label">Nama <span class="text-danger">*</span></label>
          <input type="text" id="name" name="name" class="input" value="<?= $old_inputs['name'] ?>" />
          <?php if (isset($errors['name'])) : ?>
            <div class="input-error">
              <?= $errors['name'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="page-single__actions-container">
          <a href="./category-delete.php?category_id=<?= $category['category_id'] ?>" class="page-single__button">Hapus</a>
          <div class="page-single__actions">
            <a href="./categories.php" class="page-single__button">Batal</a>
            <button type="submit" name="submit" class="page-single__button page-single__button_primary">
              Simpan
            </button>
          </div>
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