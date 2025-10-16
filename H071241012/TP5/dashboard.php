<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding: 40px;
        }
        .container {
            width: 80%;
            max-width: 700px;
            background: #fff;
            border: 1px solid #ccc;
            padding: 30px 40px;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
        }
        a.logout {
            color: #d00;
            text-decoration: none;
        }
        a.logout:hover {
            text-decoration: underline;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
<div class="container">
    <?php 
    if ($user['username'] === 'adminxxx'): ?>
        <h2>Selamat Datang, Admin!</h2>
        <a href="logout.php" class="logout">Logout</a>
        <hr>
        <h3>Data Semua Pengguna</h3>
        <table>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php 
    else: ?>
        <h2>Selamat Datang, <?= htmlspecialchars($user['name']) ?>!</h2>
        <a href="logout.php" class="logout">Logout</a>
        <hr>
        <h3>Data Profil Anda</h3>
        <table>
            <tr><th>Nama</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
            <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><th>Fakultas</th><td><?= htmlspecialchars($user['faculty'] ?? '-') ?></td></tr>
            <tr><th>Angkatan</th><td><?= htmlspecialchars($user['batch'] ?? '-') ?></td></tr>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
