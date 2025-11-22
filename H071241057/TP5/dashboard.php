<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}


$logged_in_user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <div class="header">
        <a href="logout.php">Logout</a>
    </div>

    <?php if ($logged_in_user['username'] === 'adminxxx') : ?>
        <h2>Data Semua Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else : ?>
        <h2>Data Anda</h2>
        <table>
            <?php foreach ($logged_in_user as $key => $value) : ?>
                <?php if ($key !== 'password') :?>
                    <tr>
                        <td><strong><?= htmlspecialchars(ucfirst($key)); ?></strong></td>
                        <td><?= htmlspecialchars($value); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>