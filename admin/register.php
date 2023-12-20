<?php

session_start();

// cek apakah user sudah login
if (isset($_SESSION['staff_id'])) {
  header("Location: ./index.php");
  exit();
}

require_once('../data/staff.php');
require_once('../libs/validation.php');

// inisialisasi variabel untuk menyimpan error dan inputan user
$errors = [];
$old_inputs = [
  'name' => '',
  'phone' => '',
  'email' => '',
  'token' => '',
];

// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
  validate_name($errors, $_POST, 'name');
  validate_phone($errors, $_POST, 'phone');
  validate_email_staff($errors, $_POST, 'email');
  validate_password($errors, $_POST, 'password');
  $role_id = validate_token($errors, $_POST, 'token');

  // cek apakah tidak ada error dan token role valid
  if (!$errors && $role_id) {
    save_staff($_POST, $role_id);
    header('Location: ./login.php?success_message=Akun+berhasil+dibuat,+silahkan+login!');
    exit();
  }

  $old_inputs['name'] = htmlspecialchars($_POST['name']);
  $old_inputs['phone'] = htmlspecialchars($_POST['phone']);
  $old_inputs['email'] = htmlspecialchars($_POST['email']);
  $old_inputs['token'] = htmlspecialchars($_POST['token']);
}

// inisialisasi variabel untuk halaman dan komponen header
$title = 'Registrasi Staff';
require('layouts/header-two.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="../assets/css/register.css">

<!-- content -->
<main>
  <!-- register -->
  <div class="register container">
    <form action="./register.php" method="post" class="register__form">
      <h1>Registrasi Staff</h1>
      <div>
        <label for="name" class="input-label">Nama <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="input" value="<?= $old_inputs['name'] ?>" />
        <?php if (isset($errors['name'])) : ?>
          <div class="input-error"><?= $errors['name'] ?></div>
        <?php endif ?>
      </div>
      <div>
        <label for="email" class="input-label">Email <span class="text-danger">*</span></label>
        <input type="text" name="email" id="email" class="input" value="<?= $old_inputs['email'] ?>" />
        <?php if (isset($errors['email'])) : ?>
          <div class="input-error"><?= $errors['email'] ?></div>
        <?php endif ?>
      </div>
      <div>
        <label for="phone" class="input-label">Telepon <span class="text-danger">*</span></label>
        <input type="text" name="phone" id="phone" class="input" value="<?= $old_inputs['phone'] ?>" />
        <?php if (isset($errors['phone'])) : ?>
          <div class="input-error"><?= $errors['phone'] ?></div>
        <?php endif ?>
      </div>
      <div>
        <label for="password" class="input-label">Password <span class="text-danger">*</span></label>
        <input type="password" name="password" id="password" class="input" />
        <div class="input-help">Harus berisi 8-16 karakter dengan minimal 1 huruf besar, 1 huruf kecil, 1 karakter spesial, dan tidak boleh mengandung spasi.</div>
        <?php if (isset($errors['password'])) : ?>
          <div class="input-error"><?= $errors['password'] ?></div>
        <?php endif ?>
      </div>
      <div>
        <label for="token" class="input-label">Token <span class="text-danger">*</span></label>
        <input type="text" name="token" id="token" class="input" value="<?= $old_inputs['token'] ?>" />
        <?php if (isset($errors['token'])) : ?>
          <div class="input-error"><?= $errors['token'] ?></div>
        <?php endif ?>
      </div>
      <button type="submit" name="submit" class="register__button">Daftar</button>
      <p>
        Sudah punya akun? <a href="./login.php">Masuk</a>
      </p>
      <p>
        <a href="../login.php">Login Customer</a>
      </p>
    </form>
  </div>
  <!-- end register -->
</main>
<!-- end content -->

<?php

// komponen footer
require('layouts/footer-two.php');

?>