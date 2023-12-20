<?php

// fungsi upload file
function upload_file($field_list, $field_name, $folder_name)
{
  // ambil data file
  $filename = $field_list[$field_name]['name'];
  $tmp_filename = $field_list[$field_name]['tmp_name'];
  $error = $field_list[$field_name]['error'];

  if ($error == 4) {
    return false;
  }

  // tentukan lokasi file akan dipindahkan
  $destination = __DIR__ . '/../assets/img/' . $folder_name . '/';
  $extension = explode('.', $filename);
  $extension = strtolower(end($extension));
  $new_filename = uniqid() . '.' . $extension;

  // Pindahkan file jika tipe dan ukuran sesuai
  if (!move_uploaded_file($tmp_filename, $destination . $new_filename)) {
    return false;
  }

  return $new_filename;
}

// fungsi hapus file
function delete_file($filename, $folder_name)
{
  $file_path = __DIR__ . '/../assets/img/' . $folder_name . '/' . $filename;
  if (file_exists($file_path)) {
    unlink($file_path);
  }
}
