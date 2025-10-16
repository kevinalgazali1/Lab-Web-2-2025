<?php
session_start();
require 'data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $found = false;

    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $found = true;
            break;
        }
    }

    if ($found) {
        header("Location: dashboard.php");
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: login.php");
    }
}
