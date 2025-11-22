<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $project_manager_id = NULL;
    if ($role == 'Team Member' && !empty($_POST['project_manager_id'])) {
        $project_manager_id = $_POST['project_manager_id'];
    }

    if (!empty($password)) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET username = ?, password = ?, role = ?, project_manager_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $username, $password_hash, $role, $project_manager_id, $user_id);
    } else {

        $sql = "UPDATE users SET username = ?, role = ?, project_manager_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $username, $role, $project_manager_id, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "User berhasil di-update.";
    } else {
        $_SESSION['error'] = "Gagal meng-update user: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
}

header("Location: kelola_users.php");
exit();
