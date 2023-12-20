<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/cart-item.php');

// fungsi untuk mendapatkan seluruh detail pesanan yang dijoinkan dengan tanaman dan kategori
function get_order_details_with_plant_with_category($order_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM order_details INNER JOIN plants ON plants.plant_id = order_details.plant_id INNER JOIN categories ON categories.category_id = plants.category_id WHERE order_id = :order_id ORDER BY order_detail_id DESC");
    $statement->bindValue(":order_id", $order_id);
    $statement->execute();

    $order_details = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $order_details;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menyimpan detail pesanan
function save_order_detail($order_id, $plant_id, $order_detail)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("INSERT INTO order_details (order_id, plant_id, order_detail_qty, order_detail_unit_price) VALUES (:order_id, :plant_id, :qty, :unit_price)");
    $statement->bindValue(":order_id", $order_id);
    $statement->bindValue(":plant_id", $plant_id);
    $statement->bindValue(":qty", $order_detail['qty']);
    $statement->bindValue(":unit_price", $order_detail['unit_price']);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
