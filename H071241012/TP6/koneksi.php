<?php
// koneksi.php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_manajemen_proyek";

// Membuat koneksi
$conn = mysqli_connect($hostname, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>