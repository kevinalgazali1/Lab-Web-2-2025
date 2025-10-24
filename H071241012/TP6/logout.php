<?php
session_start();

// Simpan pesan logout success
$_SESSION['success'] = "Anda telah berhasil logout";

// Hancurkan session
session_destroy();

// Redirect ke login page
header("Location: login.php");
exit();
?>