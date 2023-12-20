<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/cart-item.php');
require_once(__DIR__ . '/order-detail.php');

// fungsi untuk mendapatkan seluruh pesanan
function get_orders($customer_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM orders WHERE customer_id = :customer_id ORDER BY order_id DESC");
    $statement->bindValue(":customer_id", $customer_id);
    $statement->execute();

    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $orders;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mencari pesanan
function find_order($customer_id, $id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM orders WHERE order_id = :id AND customer_id = :customer_id");
    $statement->bindValue(":id", $id);
    $statement->bindValue(":customer_id", $customer_id);
    $statement->execute();

    $order = $statement->fetch(PDO::FETCH_ASSOC);

    return $order;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mencari pesanan yang dijoinkan dengan metode pembayaran
function find_order_with_payment_method($customer_id, $id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM orders INNER JOIN payment_methods ON payment_methods.payment_method_id = orders.payment_method_id WHERE order_id = :id AND customer_id = :customer_id");
    $statement->bindValue(":id", $id);
    $statement->bindValue(":customer_id", $customer_id);
    $statement->execute();

    $order = $statement->fetch(PDO::FETCH_ASSOC);

    return $order;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menyimpan pesanan
function save_order($customer_id, $payment_method_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $cart_items = get_cart_items_with_plant($customer_id);
    $total_price = 0;
    foreach ($cart_items as $cart_item) {
      $total_price += $cart_item['plant_price'] * $cart_item['cart_item_qty'];
    }

    $statement = $db->prepare("INSERT INTO orders (customer_id, payment_method_id, order_date, order_status, order_total_price) VALUES (:customer_id, :payment_method_id, :date, :status, :total_price)");
    $statement->bindValue(":customer_id", $customer_id);
    $statement->bindValue(":payment_method_id", $payment_method_id);
    $statement->bindValue(":date", date('Y-m-d'));
    $statement->bindValue(":status", 'unpaid');
    $statement->bindValue(":total_price", $total_price);
    $statement->execute();

    foreach ($cart_items as $cart_item) {
      $order_detail = ['qty' => $cart_item['cart_item_qty'], 'unit_price' => $cart_item['plant_price']];
      save_order_detail($db->lastInsertId(), $cart_item['plant_id'], $order_detail);
    }

    delete_all_cart_items($customer_id);
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk memperbarui pesanan
function update_order($customer_id, $id, $payment_method_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE orders SET payment_method_id = :payment_method_id WHERE order_id = :id AND customer_id = :customer_id");
    $statement->bindValue(":payment_method_id", $payment_method_id);
    $statement->bindValue(":id", $id);
    $statement->bindValue(":customer_id", $customer_id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
