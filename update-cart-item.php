<?php

session_start();

// cek apakah cust sudah login
if (!isset($_SESSION['customer_id'])) {
  header("Location: ./login.php");
  exit();
}

// JIKA TIDAK ADA PRODUK YANG DIPILIH
if (!isset($_POST['plant_id'])) {
  header("Location: ./products.php");
  exit();
}

require_once('data/cart-item.php');

// INSTANCE CUST_ID,PRODUK_ID
$customer_id = $_SESSION['customer_id'];
$plant_id = $_POST['plant_id'];

// AMBIL DATA DETAIL KERANJANG 
$cart_item = find_cart_item($customer_id, $plant_id);

// JIKA TOMBOL TAMBAH, KURANG (REDUCE) DIKLIK
// KURANGI QTY
if (isset($_POST['reduce'])) {
  // JIKA JUM QTY PRODUK DI KERANJANG -1 = 0
  if ($cart_item['cart_item_qty'] - 1 == 0) {
    delete_cart_item($customer_id, $plant_id);
  } else {
    // JIKA DI -1 != 0
    update_cart_item($customer_id, $plant_id, $cart_item['cart_item_qty'] - 1);
  }
} else {
  // TAMBAH QTY
  update_cart_item($customer_id, $plant_id, $cart_item['cart_item_qty'] + 1);
}

$previous_page = $_SERVER['HTTP_REFERER'];
header("Location: $previous_page");
exit();
