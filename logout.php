<?php

session_start();

// UNSET SELURUH SESI
unset($_SESSION['customer_id']);
unset($_SESSION['customer_email']);

// ARAHKAN KE HAL. LOGIN
header('Location: ./login.php');
exit();
