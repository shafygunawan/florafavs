<?php

session_start();

// cek apakah user belum login
if (!isset($_SESSION['staff_id'])) {
  header("Location: ./login.php");
  exit();
}

// cek apakah peran user bukan administrator
if ($_SESSION['role_name'] != 'administrator') {
  header("Location: ./unpaid-transactions.php");
  exit();
}

// cek apakah id pesanan tidak ada
if (!isset($_GET['order_id'])) {
  header("Location: ./unpaid-transactions.php");
  exit();
}

require_once('../data/transaction.php');

$find_order = find_order_admin($_GET['order_id']);

// cek apakah pesanan tidak ditemukan
if (!$find_order) {
  header('Location: ./unpaid-transactions.php');
  exit();
}

approve_order($_GET['order_id']);

header('Location: ./unpaid-transactions.php');
exit();
