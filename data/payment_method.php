<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mendapatkan seluruh metode pembayaran
function get_payment_methods()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM payment_methods ORDER BY payment_method_id DESC");
    $statement->execute();

    $payment_methods = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $payment_methods;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
