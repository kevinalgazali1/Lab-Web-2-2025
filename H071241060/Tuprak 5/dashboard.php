<?php
session_start();
require 'data.php'; // Diperlukan untuk admin agar bisa menampilkan semua data

// Perlindungan Halaman: Jika pengguna belum login, lempar kembali ke login.php
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$loggedInUser = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; background-color: #171615;}
        .logout {color: #ddd; text-decoration: none; border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726;}
        h1, h2 { color: #ddd; margin-top: 1rem; margin-bottom: 1rem; }
        table {width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { color: #ddd; padding: 12px; border: 1px solid #ddd; text-align: left; border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726;}
        .user-data {color: #ddd; border: 1px solid #ddd; padding: 1rem; border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726;}
        .user-data p { margin: 0.5rem 0; }
        .user-data strong { display: inline-block; width: 100px; }
    </style>
</head>
<body>

    <?php if ($loggedInUser['username'] === 'adminxxx'): ?>
        <h1>Selamat Datang, Admin!</h1>
        <a href="logout.php" class="logout">Logout</a>
        
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
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <h1>Selamat Datang, <?php echo htmlspecialchars($loggedInUser['name']); ?>!</h1>
        <a href="logout.php" class="logout">Logout</a>
        
        <h2>Data Anda</h2>
        <div class="user-data">
            <p><strong>Nama</strong>: <?php echo htmlspecialchars($loggedInUser['name']); ?></p>
            <p><strong>Username</strong>: <?php echo htmlspecialchars($loggedInUser['username']); ?></p>
            <p><strong>Email</strong>: <?php echo htmlspecialchars($loggedInUser['email']); ?></p>
            <p><strong>Gender</strong>: <?php echo htmlspecialchars($loggedInUser['gender']); ?></p>
            <p><strong>Fakultas</strong>: <?php echo htmlspecialchars($loggedInUser['faculty']); ?></p>
            <p><strong>Angkatan</strong>: <?php echo htmlspecialchars($loggedInUser['batch']); ?></p>
        </div>
    <?php endif; ?>

</body>
</html>