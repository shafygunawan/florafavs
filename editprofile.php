<?php

error_reporting(E_ALL);
session_start();

// cek apakah cust sudah login
if (!isset($_SESSION['customer_id'])) {
  header("Location: ./login.php");
  exit();
}

require_once('config/database.php');
require_once('libs/validation.php');
require_once('data/customer.php');

// AMBIL DATA CUST
$customer = find_customer_with_id($_SESSION['customer_id']);
$errors = [];

// JIKA TOMBOL UBAH DATA (UBAH) DIKLIK
if (isset($_POST['ubah'])) {
  // DIVALIDASI
  validate_email_customer($errors, $_POST, 'email');
  validate_phone($errors, $_POST, 'telephone');
  validate_name($errors, $_POST, 'nama');

  // JIKA TIDAK TERDAPAT ERROR / KESALAHAN VALIDASI 
  if (!$errors) {
    try {
      // UPDATE DATA DIRI CUST
      $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      $ubahdata = $db->prepare("UPDATE customers SET customer_name = :custname, customer_phone = :custphone, customer_email = :custemail WHERE customer_id = :custid ");
      $ubahdata->bindValue(":custname", htmlspecialchars(trim($_POST['nama'])));
      $ubahdata->bindValue(":custphone", htmlentities(trim($_POST['telephone'])));
      $ubahdata->bindValue(":custemail", htmlspecialchars(trim($_POST['email'])));
      $ubahdata->bindValue(":custid", $_SESSION['customer_id']);

      $ubahdata->execute();

      header("Location: ./profile.php");
      exit();
    } catch (PDOException $error) {
      throw new Exception($error->getMessage());
    }
  }
}

// HEADER
$title = 'Ubah Profil';
require('layouts/header.php');

?>

<!-- css customs -->
<link rel="stylesheet" href="./assets/css/profile.css">

<!-- content -->
<main>
  <!-- profile -->
  <div class="profile container">
    <div class="profile__header">
      <h1>Ubah Profil</h1>
    </div>
    <div class="profile__body">
      <form action='./editprofile.php' method='POST' class="profile__right">
        <div class="profile__form">
          <div>
            <!-- INPUT NAMA  -->
            <label class="input-label" for='nama'>Nama <span class="text-danger">*</span></label>
            <input type='text' name='nama' id='nama' class="input" value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : $customer['customer_name']; ?>">
            <div class="input-error"><?php if (isset($errors['nama'])) echo $errors['nama'] ?></div>
          </div>
          <div>
            <!-- INPUT EMAIL -->
            <label class="input-label" for='email'>Email <span class="text-danger">*</span></label>
            <input type='text' name='email' id='email' class="input" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : $customer['customer_email']; ?>">
            <div class="input-error"><?php if (isset($errors['email'])) echo $errors['email'] ?></div>
          </div>
          <div>
            <!-- INPUT NO TELP -->
            <label class="input-label" for='telephone'>Telephone <span class="text-danger">*</span></label>
            <input type='text' name='telephone' id='telephone' class="input" value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : $customer['customer_phone']; ?>">
            <div class="input-error"><?php if (isset($errors['telephone'])) echo $errors['telephone'] ?></div>
          </div>
          <div>
            <!-- TOMBOL UBAH -->
            <button type="submit" name="ubah" class="profile__button">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end profile -->
</main>
<!-- end content -->

<?php

// FOOTER
require('layouts/footer.php');

?>