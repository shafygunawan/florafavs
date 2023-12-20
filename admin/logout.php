<?php

session_start();

// menghapus semua session
unset($_SESSION['role_name']);
unset($_SESSION['staff_id']);
unset($_SESSION['staff_name']);

// redirect ke halaman login
header('Location: ./login.php');
exit();
