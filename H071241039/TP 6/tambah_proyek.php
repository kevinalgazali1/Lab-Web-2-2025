<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama      = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai     = $_POST['tanggal_mulai'];
    $selesai   = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $message = "<p class='text-red-500 font-medium text-center'>Semua field wajib diisi!</p>";
    } 
    elseif (strtotime($selesai) < strtotime($mulai)) {
        $message = "<p class='text-red-500 font-medium text-center'>Tanggal selesai tidak boleh lebih kecil dari tanggal mulai!</p>";
    } 
    else {
        $cek_sql  = "SELECT id FROM projects WHERE nama_proyek = ? AND manager_id = ?";
        $cek_stmt = mysqli_prepare($conn, $cek_sql);
        mysqli_stmt_bind_param($cek_stmt, "si", $nama, $manager_id);
        mysqli_stmt_execute($cek_stmt);
        $cek_result = mysqli_stmt_get_result($cek_stmt);

        if (mysqli_num_rows($cek_result) > 0) {
            $message = "<p class='text-red-500 font-medium text-center'>Nama proyek ini sudah ada!</p>";
        } else {
            $sql  = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $deskripsi, $mulai, $selesai, $manager_id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: manager_dashboard.php");
                exit();
            } else {
                $message = "<p class='text-red-500 font-medium text-center'>Terjadi kesalahan: ".mysqli_error($conn)."</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg p-8 w-full max-w-lg border border-purple-100">
        <h2 class="text-3xl font-bold text-purple-700 mb-6 text-center">Tambah Proyek</h2>
        <a href="manager_dashboard.php" class="inline-block text-purple-500 hover:text-purple-700 font-medium mb-4 transition">
            &larr; Kembali ke Dashboard
        </a>
        <?php 
        if (!empty($message)) echo $message; 
        ?>
        <form method="POST" class="space-y-4 mt-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Proyek:</label>
                <input type="text" name="nama_proyek" required
                       class="w-full px-4 py-2 border border-purple-200 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-300 bg-purple-50/40">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Deskripsi:</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-2 border border-purple-200 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-300 bg-purple-50/40"></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai" required
                           class="w-full px-4 py-2 border border-purple-200 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-300 bg-purple-50/40"
                           onchange="document.getElementById('tanggal_selesai').min=this.value;">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai:</label>
                    <input id="tanggal_selesai" type="date" name="tanggal_selesai" required
                           class="w-full px-4 py-2 border border-purple-200 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-300 bg-purple-50/40">
                </div>
            </div>
            <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-400 to-purple-400 hover:from-pink-500 hover:to-purple-500 text-white font-semibold px-4 py-2 rounded-md shadow-md transition duration-200">
                Simpan Proyek
            </button>
        </form>
    </div>
</body>
</html>