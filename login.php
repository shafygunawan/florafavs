<?php

session_start();

// cek apakah cust sudah login
if (isset($_SESSION['customer_id'])) {
  header("Location: ./products.php");
  exit();
}

require_once('data/customer.php');
require_once('libs/validation.php');

// INSTANCE BOOLEAN UNTUK ERROR
$login_error = null;
// LIST TEMP ERROR MSG
$errors = [];
// LIST TEMP INPUTAN USER
$old_inputs = [
  'email' => '',
];

// JIKA TOMBOL MASUK (LOGIN) DIKLIK
if (isset($_POST['submit'])) {
  // DI VALIDASI
  validate_email($errors, $_POST, 'email');
  validate_password($errors, $_POST, 'password');

  // JIKA TIDAK TERDAPAT ERROR VALIDASI 
  if (!$errors) {
    // MENCARI DATA CUST 
    $customer = find_customer($_POST['email']);

    // JIKA DITEMUKAN
    if ($customer) {
      // CHECK PASSWORD CUST
      if (password_verify($_POST['password'], $customer['customer_password'])) {
        // INSTANCE CUST_ID,CUST_EMAIL
        $_SESSION['customer_id'] = $customer['customer_id'];
        $_SESSION['customer_email'] = $customer['customer_email'];
        header("Location: ./products.php");
        exit();
      }
    }

    // JIKA TIDAK DITEMUKAN
    $login_error = 'Email atau password salah!';
  }

  // SIMPAN INPUTAN USER
  $old_inputs['email'] = htmlspecialchars($_POST['email']);
}

// HEADER
$title = 'Login';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="./assets/css/login.css">

<!-- content -->
<main>
  <!-- login -->
  <div class="login container">
    <form action="./login.php" method="post" class="login__left">
      <h1>Login</h1>
      <!-- ERROR MSG JIKA LOGIN GAGAL -->
      <?php if ($login_error != null) : ?>
        <div class="alert alert_danger">
          <?= $login_error; ?>
        </div>
      <?php endif; ?>
      <!-- SUCCES MSG JIKA LOGIN BERHASIL -->
      <?php if (isset($_GET['success_message'])) : ?>
        <div class="alert alert_success">
          <?= $_GET['success_message']; ?>
        </div>
      <?php endif; ?>
      <!-- INPUT EMAIL -->
      <div>
        <label for="email" class="input-label">Email <span class="text-danger">*</span></label>
        <input type="text" name="email" id="email" class="input" value="<?= $old_inputs['email'] ?>" />
        <!-- ERR MSG EMAIL -->
        <?php if (isset($errors['email'])) : ?>
          <div class="input-error"><?= $errors['email'] ?></div>
        <?php endif; ?>
      </div>
      <!-- INPUT PASSWORD -->
      <div>
        <label for="password" class="input-label">Password <span class="text-danger">*</span></label>
        <input type="password" name="password" id="password" class="input" />
        <div class="input-help">Harus berisi 8-16 karakter dengan minimal 1 huruf besar, 1 huruf kecil, 1 karakter spesial, dan tidak boleh mengandung spasi.</div>
        <!-- ERR MSG PASSWORD -->
        <?php if (isset($errors['password'])) : ?>
          <div class="input-error"><?= $errors['password'] ?></div>
        <?php endif; ?>
      </div>
      <!-- TOMBOL MASUK -->
      <button type="submit" name="submit" class="login__button">Masuk</button>
      <!-- LINK REGISTER CUST -->
      <p>Belum punya akun? <a href="./register.php">Daftar</a></p>
      <!-- LINK LOGIN STAFF -->
      <p>
        <a href="./admin/login.php">Login Staff</a>
      </p>
    </form>
    <div class="login__right">
      <img src="./assets/img/plant-illustration.jpeg" alt="" />
    </div>
  </div>
  <!-- end login -->
</main>
<!-- end content -->

<?php

// FOOTER
require('layouts/footer.php');

?>