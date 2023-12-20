<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mencari staff
function find_staff($email)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM staffs WHERE staff_email = :email");
    $statement->bindValue(":email", htmlspecialchars(trim($email)));
    $statement->execute();

    $staff = $statement->fetch(PDO::FETCH_ASSOC);

    return $staff;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mencari staff yang dijoinkan dengan peran
function find_staff_with_role($email)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM staffs INNER JOIN roles ON roles.role_id = staffs.role_id WHERE staff_email = :email");
    $statement->bindValue(":email", htmlspecialchars(trim($email)));
    $statement->execute();

    $staff = $statement->fetch(PDO::FETCH_ASSOC);

    return $staff;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk mendapatkan seluruh staff
function get_staffs()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM staffs ORDER BY staff_id DESC");
    $statement->execute();

    $staffs = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $staffs;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

// fungsi untuk menyimpan staff
function save_staff($staff, $role_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("INSERT INTO staffs (role_id, staff_name, staff_phone, staff_email, staff_password) VALUES (:role_id, :name, :phone, :email, :password)");
    $statement->bindValue(":role_id", $role_id);
    $statement->bindValue(":name", htmlspecialchars(trim($staff['name'])));
    $statement->bindValue(":phone", htmlspecialchars(trim($staff['phone'])));
    $statement->bindValue(":email", htmlspecialchars(trim($staff['email'])));
    $statement->bindValue(":password", password_hash(trim($staff['password']), PASSWORD_DEFAULT));
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
