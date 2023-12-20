<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mendapatkan seluruh metode pembayaran yang dijoinkan dengan pesanan yang belum lunas
function get_data_order()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM payment_methods JOIN orders ON orders.payment_method_id = payment_methods.payment_method_id WHERE order_status = :unpaid");
    $statement->bindValue(":unpaid", "unpaid");
    $statement->execute();

    $order_info = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $order_info;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan total kuantitas dari detail pesanan
function get_order_sum($data)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT SUM(order_detail_qty) AS total_sum FROM order_details WHERE order_id = :order_id");
    $statement->bindParam(':order_id', $data, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {
      return $result['total_sum'];
    } else {
      return 0;
    }
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk memperbarui status pesanan menjadi 'paid'
function approve_order($data)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE orders SET order_status='paid' WHERE order_id = :order_id");
    $statement->bindParam(':order_id', $data, PDO::PARAM_INT);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan seluruh detail pesanan berdasarkan id pesanan
function find_order_admin($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM order_details WHERE order_id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $find_order = $statement->fetch(PDO::FETCH_ASSOC);

    return $find_order;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan detail pesanan yang dijoinkan dengan tanaman
function get_order_details_admin($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM order_details JOIN plants ON order_details.plant_id = plants.plant_id WHERE order_id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $order_info = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $order_info;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan pesanan belum lunas yang dijoinkan dengan metode pembayaran
function get_date_bank($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM orders JOIN payment_methods ON orders.payment_method_id = payment_methods.payment_method_id
        WHERE order_id= :id AND order_status = :unpaid");
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(":unpaid", "unpaid");
    $statement->execute();

    $date_bank = $statement->fetch(PDO::FETCH_ASSOC);

    return $date_bank;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
