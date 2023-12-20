<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mencari tanaman
function find_plant($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM plants WHERE plant_id = :id");
    $statement->bindValue(":id", $id);
    $statement->execute();

    $plant = $statement->fetch(PDO::FETCH_ASSOC);

    return $plant;
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

// fungsi untuk mencari seluruh tanaman yang dijoinkan dengan kategori
function search_plants_with_category($keyword = '', $category_id = '', $only_available = false)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $query = "SELECT * FROM plants INNER JOIN categories ON categories.category_id = plants.category_id WHERE plant_name LIKE :keyword";
    if ($category_id != '') {
      $query .= " AND plants.category_id = :category_id";
    }
    if ($only_available) {
      $query .= " AND plant_stock > 0";
    }
    $query .= ' ORDER BY plant_id DESC';

    $statement = $db->prepare($query);
    $statement->bindValue(':keyword', "%$keyword%");
    if ($category_id != '') {
      $statement->bindValue(':category_id', $category_id);
    }
    $statement->execute();

    $plants = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $plants;
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

// fungsi untuk mendapatkan seluruh tanaman yang dijoinkan dengan kategori
function get_plants_with_category()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM plants INNER JOIN categories ON categories.category_id = plants.category_id ORDER BY plant_id DESC");
    $statement->execute();

    $plants = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $plants;
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

// fungsi untuk menyimpan tanaman
function save_plant($plant)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("INSERT INTO plants (supplier_id, category_id, plant_name, plant_price, plant_stock, plant_photo) VALUES (:supplier_id, :category_id, :name, :price, :stock, :photo)");
    $statement->bindValue(":supplier_id", trim($plant['supplier_id']));
    $statement->bindValue(":category_id", trim($plant['category_id']));
    $statement->bindValue(":name", htmlspecialchars(trim($plant['name'])));
    $statement->bindValue(":price", trim($plant['price']));
    $statement->bindValue(":stock", trim($plant['stock']));
    $statement->bindValue(":photo", trim($plant['photo']));
    $statement->execute();
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

// fungsi untuk memperbarui tanaman
function update_plant($id, $plant)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE plants SET supplier_id = :supplier_id, category_id = :category_id, plant_name = :name, plant_price = :price, plant_stock = :stock, plant_photo = :photo WHERE plant_id = :id");
    $statement->bindValue(":id", $id);
    $statement->bindValue(":supplier_id", trim($plant['supplier_id']));
    $statement->bindValue(":category_id", trim($plant['category_id']));
    $statement->bindValue(":name", htmlspecialchars(trim($plant['name'])));
    $statement->bindValue(":price", trim($plant['price']));
    $statement->bindValue(":stock", trim($plant['stock']));
    $statement->bindValue(":photo", trim($plant['photo']));
    $statement->execute();
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

// fungsi untuk menghapus tanaman
function delete_plant($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("DELETE FROM plants WHERE plant_id = :id");
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

// fungsi untuk mendapatkan total tanaman berdasarkan kategori
function count_related_plants_based_on_category($category_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT COUNT(*) AS count_related_plants FROM plants WHERE category_id = :category_id");
    $statement->bindValue(":category_id", $category_id);
    $statement->execute();

    $plant = $statement->fetch(PDO::FETCH_ASSOC);

    return $plant;
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}
