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
require_once('../data/supplier.php');
require_once('../libs/validation.php');
require_once('../libs/file.php');

// inisialisasi variabel untuk menyimpan error dan inputan user
$errors = [];
$old_inputs = [
  'supplier_id' => '',
  'category_id' => '',
  'name' => '',
  'price' => '',
  'stock' => '',
];

// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
  validate_num($errors, $_POST, 'supplier_id');
  validate_num($errors, $_POST, 'category_id');
  validate_name($errors, $_POST, 'name');
  validate_num($errors, $_POST, 'price');
  validate_num($errors, $_POST, 'stock');
  $filename = upload_file($_FILES, 'photo', 'plants');

  // cek apakah foto tidak diisi
  if (!$filename) {
    $errors['photo'] = 'Foto tanaman wajib diisi.';
  }

  // cek apakah tidak ada error
  if (!$errors) {
    $_POST['photo'] = $filename;
    save_plant($_POST);
    header('Location: ./products.php');
    exit();
  }

  // cek apakah foto diisi
  if ($filename) {
    delete_file($filename, 'plants');
  }

  $old_inputs['supplier_id'] = htmlspecialchars($_POST['supplier_id']);
  $old_inputs['category_id'] = htmlspecialchars($_POST['category_id']);
  $old_inputs['name'] = htmlspecialchars($_POST['name']);
  $old_inputs['price'] = htmlspecialchars($_POST['price']);
  $old_inputs['stock'] = htmlspecialchars($_POST['stock']);
}

$categories = get_categories();
$suppliers = get_suppliers();

// inisialisasi variabel untuk halaman dan komponen header
$page = 'products';
$title = 'Tambah Tanaman';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="../assets/css/admin/page-single.css">

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <div class="admin__back">
      <i class="ph-bold ph-arrow-left"></i>
      <a href="./products.php">Kembali</a>
    </div>
    <h1 class="admin__title">Tambah tanaman</h1>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <form action="./product-add.php" method="post" class="page-single" enctype="multipart/form-data">
        <div>
          <label for="name" class="input-label">Name <span class="text-danger">*</span></label>
          <input type="text" id="name" name="name" class="input" value="<?= $old_inputs['name'] ?>" />
          <?php if (isset($errors['name'])) : ?>
            <div class="input-error">
              <?= $errors['name'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div>
          <label for="price" class="input-label">Harga <span class="text-danger">*</span></label>
          <input type="text" id="price" name="price" class="input" value="<?= $old_inputs['price'] ?>" />
          <?php if (isset($errors['price'])) : ?>
            <div class="input-error">
              <?= $errors['price'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div>
          <label for="category_id" class="input-label">Kategori <span class="text-danger">*</span></label>
          <select name="category_id" id="category_id" class="input-select">
            <?php foreach ($categories as $category) : ?>
              <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $old_inputs['category_id'] ? 'selected' : '' ?>><?= $category['category_name'] ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($errors['category_id'])) : ?>
            <div class="input-error">
              <?= $errors['category_id'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div>
          <label for="supplier_id" class="input-label">Pemasok <span class="text-danger">*</span></label>
          <select name="supplier_id" id="supplier_id" class="input-select">
            <?php foreach ($suppliers as $supplier) : ?>
              <option value="<?= $supplier['supplier_id'] ?>" <?= $supplier['supplier_id'] == $old_inputs['supplier_id'] ? 'selected' : '' ?>><?= $supplier['supplier_name'] ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($errors['supplier_id'])) : ?>
            <div class="input-error">
              <?= $errors['supplier_id'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div>
          <label for="stock" class="input-label">Stok <span class="text-danger">*</span></label>
          <input type="text" id="stock" name="stock" class="input" value="<?= $old_inputs['stock'] ?>" />
          <?php if (isset($errors['stock'])) : ?>
            <div class="input-error">
              <?= $errors['stock'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div>
          <label for="photo" class="input-label">Foto <span class="text-danger">*</span></label>
          <input type="file" id="photo" name="photo" class="input" />
          <?php if (isset($errors['photo'])) : ?>
            <div class="input-error">
              <?= $errors['photo'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="page-single__actions">
          <a href="./products.php" class="page-single__button">Batal</a>
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