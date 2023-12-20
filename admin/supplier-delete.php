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

// cek apakah id pemasok tidak ada
if (!isset($_GET['supplier_id'])) {
  header("Location: ./suppliers.php");
  exit();
}

require_once('../data/supplier.php');

$supplier = find_supplier($_GET['supplier_id']);

// cek apakah pemasok tidak ditemukan
if (!$supplier) {
  header("Location: ./suppliers.php");
  exit();
}

delete_supplier($_GET['supplier_id']);

header('Location: ./suppliers.php');
exit();
