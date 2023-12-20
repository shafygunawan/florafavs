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

// cek apakah id tanaman tidak ada
if (!isset($_GET['plant_id'])) {
  header("Location: ./products.php");
  exit();
}

require_once('../data/plant.php');
require_once('../libs/file.php');

$plant = find_plant($_GET['plant_id']);

// cek apakah tanaman tidak ditemukan
if (!$plant) {
  header("Location: ./products.php");
  exit();
}

delete_plant($_GET['plant_id']);
delete_file($plant['plant_photo'], 'plants');

header('Location: ./products.php');
exit();
