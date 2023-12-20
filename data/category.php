<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mencari kategori
function find_category($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM categories WHERE category_id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $category = $statement->fetch(PDO::FETCH_ASSOC);

    return $category;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan seluruh kategori
function get_categories()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM categories ORDER BY category_id DESC");
    $statement->execute();

    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menyimpan kategori
function save_category($category)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("INSERT INTO categories (category_name) VALUES (:name)");
    $statement->bindValue(":name", htmlspecialchars(trim($category['name'])));
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk memperbarui kategori
function update_category($id, $category)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE categories SET category_name = :name WHERE category_id = :id");
    $statement->bindValue(":name", htmlspecialchars(trim($category['name'])));
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menghapus kategori
function delete_category($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("DELETE FROM categories WHERE category_id = :id");
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
