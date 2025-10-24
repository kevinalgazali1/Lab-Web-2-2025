<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password_input = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    mysqli_stmt_close($stmt); 

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);
        $password_hash_db = $user['password'];

        if (password_verify($password_input, $password_hash_db)) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'Super Admin') {
                header("Location: dashboard_admin.php");
            } elseif ($user['role'] == 'Project Manager') {
                header("Location: dashboard_manager.php");
            } elseif ($user['role'] == 'Team Member') {
                header("Location: dashboard_member.php");
            } else {
                $_SESSION['error'] = "Role tidak dikenal.";
                header("Location: index.php");
            }
            exit();

        } else {
            $_SESSION['error'] = "Password yang Anda masukkan salah.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan.";
        header("Location: index.php");
        exit();
    }
    
} else {
    header("Location: index.php");
    exit();
}
?>