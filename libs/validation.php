<?php

require_once(__DIR__ . '/../config/staff.php');
require_once(__DIR__ . '/../data/customer.php');
require_once(__DIR__ . '/../data/staff.php');

// fungsi untuk mengecek apakah suatu nilai ada isinya
function is_filled($value)
{
  $value = trim($value);
  return !empty($value);
}

// fungsi validasi token staff
function validate_token(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  if ($field_list[$field_name] == STAFF_ADMINISTRATOR_TOKEN) {
    return 1;
  }

  if ($field_list[$field_name] == STAFF_MANAGER_TOKEN) {
    return 2;
  }

  $errors[$field_name] = 'Token tidak valid!';
  return false;
}

// fungsi validasi nama
function validate_name(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar a-z A-Z - ' dan spasi
  $pattern = "/^[a-zA-Z-' ]{1,}+$/";
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan harus berupa huruf saja!';
    return false;
  }

  return true;
}

// fungsi validasi nomor telepon
function validate_phone(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar angka dan panjang digit bukan 10-13 digit
  $pattern =  "/^[\d]{10,13}$/"; // angka
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan harus berupa angka dengan 10-13 digit!';
    return false;
  }

  return true;
}

// fungsi validasi karakter alfabet dan numerik
function validate_alphanum(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar alfabet & numerik
  $pattern = "/^[a-zA-Z]+[0-9]+$/";
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = "Masukan harus berupa huruf dan angka!";
    return false;
  }

  return true;
}

// fungsi validasi email
function validate_email(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter spasi
  if (preg_match('/\s/', $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan tidak boleh mengandung spasi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar pola yang telah ditentukan
  $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Format email salah!';
    return false;
  }

  return true;
}

// fungsi validasi email customer
function validate_email_customer(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  $customers = get_customers();

  // cek apakah customer sudah login
  if (isset($_SESSION['customer_id'])) {
    $emailcust = get_email_customer($_SESSION['customer_id']);

    // cek apakah email baru tidak sama dengan email saat ini
    if ($field_list[$field_name] != $emailcust['customer_email']) {
      foreach ($customers as $customer) {
        // cek apakah email baru telah terdaftar
        if ($customer['customer_email'] == $field_list[$field_name]) {
          $errors[$field_name] = 'Email telah terdaftar, gunakan email lain!';
          return false;
        }
      }
    }
  } else {
    foreach ($customers as $customer) {
      // cek apakah email baru telah terdaftar
      if ($customer['customer_email'] == $field_list[$field_name]) {
        $errors[$field_name] = 'Email telah terdaftar, gunakan email lain!';
        return false;
      }
    }
  }

  // cek apakah kolom mengandung karakter spasi
  if (preg_match('/\s/', $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan tidak boleh mengandung spasi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar pola yang telah ditentukan
  $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Format email salah!';
    return false;
  }

  return true;
}

// fungsi validasi email staff
function validate_email_staff(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  $staffs = get_staffs();

  foreach ($staffs as $staff) {
    // cek apakah email baru telah terdaftar
    if ($staff['staff_email'] == $field_list[$field_name]) {
      $errors[$field_name] = 'Email telah terdaftar, gunakan email lain!';
      return false;
    }
  }

  // cek apakah kolom mengandung karakter spasi
  if (preg_match('/\s/', $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan tidak boleh mengandung spasi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar pola yang telah ditentukan
  $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Format email salah!';
    return false;
  }

  return true;
}

// fungsi validasi password
function validate_password(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah panjang karakter diluar 8-16 karakter
  if (strlen($field_list[$field_name]) < 8 || strlen($field_list[$field_name]) > 16) {
    $errors[$field_name] = 'Panjang password 8 hingga 16 karakter!';
    return false;
  }

  // cek apakah kolom tidak mengandung huruf besar
  if (!preg_match('/[A-Z]/', $field_list[$field_name])) {
    $errors[$field_name] = 'Harus terdapat minimal 1 huruf besar!';
    return false;
  }

  // cek apakah kolom tidak mengandung huruf kecil
  if (!preg_match('/[a-z]/', $field_list[$field_name])) {
    $errors[$field_name] = 'Harus terdapat minimal 1 huruf kecil!';
    return false;
  }

  // cek apakah kolom tidak mengandung karakter spesial
  if (!preg_match('/\W/', $field_list[$field_name])) {
    $errors[$field_name] = 'Harus terdapat minimal 1 karakter spesial!';
    return false;
  }

  // cek apakah kolom mengandung karakter spasi
  if (preg_match('/\s/', $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan tidak boleh mengandung spasi!';
    return false;
  }

  return true;
}

// fungsi validasi numerik
function validate_num(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar angka
  $pattern =  "/^[\d]{1,}$/";
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan harus berupa angka!';
    return false;
  }

  return true;
}

// fungsi validasi alamat
function validate_address(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  return true;
}
