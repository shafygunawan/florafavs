<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mencari pemasok
function find_supplier($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM suppliers WHERE supplier_id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $supplier = $statement->fetch(PDO::FETCH_ASSOC);

    return $supplier;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan seluruh pemasok
function get_suppliers()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM suppliers ORDER BY supplier_id DESC");
    $statement->execute();

    $suppliers = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $suppliers;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menyimpan pemasok
function save_supplier($supplier)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("INSERT INTO suppliers (supplier_name, supplier_phone, supplier_address) VALUES (:name, :phone, :address)");
    $statement->bindValue(":name", htmlspecialchars(trim($supplier['name'])));
    $statement->bindValue(":phone", htmlspecialchars(trim($supplier['phone'])));
    $statement->bindValue(":address", htmlspecialchars(trim($supplier['address'])));
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk memperbarui pemasok
function update_supplier($id, $supplier)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE suppliers SET supplier_name = :name, supplier_phone = :phone, supplier_address = :address WHERE supplier_id = :id");
    $statement->bindValue(":name", htmlspecialchars(trim($supplier['name'])));
    $statement->bindValue(":phone", htmlspecialchars(trim($supplier['phone'])));
    $statement->bindValue(":address", htmlspecialchars(trim($supplier['address'])));
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menghapus pemasok
function delete_supplier($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("DELETE FROM suppliers WHERE supplier_id = :id");
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
