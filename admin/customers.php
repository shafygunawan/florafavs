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

require_once('../data/customer.php');

$customers = get_customers();

// inisialisasi variabel untuk halaman dan komponen header
$page = 'customers';
$title = 'Pelanggan';
require('layouts/header.php');

?>

<!-- your content in here -->
<div class="admin">
  <div class="admin__header">
    <h1 class="admin__title">Pelanggan</h1>
  </div>
  <div class="admin__body">
    <div class="admin__card">
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($customers as $i => $customer) : ?>
            <tr>
              <td><?= $i + 1 ?>.</td>
              <td>
                <a href="./customer-single.php?customer_email=<?= $customer['customer_email'] ?>"><?= $customer['customer_name'] ?></a>
              </td>
              <td><?= $customer['customer_phone'] ?></td>
              <td><?= $customer['customer_email'] ?></td>
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