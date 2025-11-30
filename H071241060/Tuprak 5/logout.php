<?php
session_start();

// Hancurkan semua data session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login
header('Location: login.php');
exit();
?>