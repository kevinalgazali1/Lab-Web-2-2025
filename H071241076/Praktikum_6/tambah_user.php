<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $project_manager_id = NULL;

    if ($role == 'Team Member' && !empty($_POST['project_manager_id'])) {
        $project_manager_id = $_POST['project_manager_id'];
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    if ($project_manager_id === NULL) {

        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $password_hash, $role);
    } else {
        $sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $username, $password_hash, $role, $project_manager_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "User baru berhasil ditambahkan.";
    } else {
        $_SESSION['error'] = "Gagal menambahkan user: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);

    header("Location: kelola_users.php");
    exit();
} else {
    header("Location: kelola_users.php");
    exit();
}
