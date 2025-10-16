<?php
session_start();
require 'data.php'; // Memuat data pengguna

// Menerima data dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userFound = null;

    // 1. Cari pengguna berdasarkan username
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $userFound = $user;
            break;
        }
    }

    // 2. Jika username ditemukan, verifikasi password
    if ($userFound) {
        if (password_verify($password, $userFound['password'])) {
            // Jika berhasil, simpan data ke session dan arahkan ke dashboard
            $_SESSION['user'] = $userFound;
            header('Location: dashboard.php');
            exit();
        }
    }

    // Jika gagal, buat session error dan kembalikan ke login
    $_SESSION['error'] = "Username atau password salah!";
    header('Location: login.php');
    exit();
} else {
    // Jika file diakses langsung, kembalikan ke login
    header('Location: login.php');
    exit();
}
?>