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

$category = find_category($_GET['category_id']);

// cek apakah kategori tidak ada
if (!$category) {
  header("Location: ./categories.php");
  exit();
}

delete_category($_GET['category_id']);

header('Location: ./categories.php');
exit();
