<?php
session_start();
require_once 'data.php';

$username_input = $_POST['username'];
$password_input = $_POST['password'];

$user_found = null;

foreach ($users as $user) {
    if ($user['username'] === $username_input) {
        $user_found = $user;
        break;
    }
}

if ($user_found && password_verify($password_input, $user_found['password'])) {
    $_SESSION['user'] = $user_found;
    header('Location: dashboard.php');
    exit;
} else {
    $_SESSION['error_message'] = 'Username atau password salah';
    header('Location: login.php');
    exit;
}

?>