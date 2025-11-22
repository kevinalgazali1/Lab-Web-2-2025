<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {

    $user_id_to_delete = $_GET['id'];

    if ($user_id_to_delete == $_SESSION['user_id']) {
        $_SESSION['error'] = "Anda tidak dapat menghapus akun Anda sendiri!";
        header("Location: kelola_users.php");
        exit();
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $user_id_to_delete);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "User berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus user: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "ID user tidak ditemukan atau tidak valid.";
}

header("Location: kelola_users.php");
exit();
?>