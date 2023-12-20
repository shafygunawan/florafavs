<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?= isset($title) ? $title . ' - ' : ''; ?>FloraFavs</title>

  <!-- css templates -->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/admin/admin.css" />

  <!-- css customs -->

  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
</head>

<body class="body_light">

  <?php require('layouts/sidebar.php') ?>

  <!-- page-wrapper -->
  <div class="page-wrapper">

    <?php require('layouts/topbar.php') ?>

    <!-- content -->
    <div class="content">
      <div class="container container_admin content__container">
        <div class="content__main">