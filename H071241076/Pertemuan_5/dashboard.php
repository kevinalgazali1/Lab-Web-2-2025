<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_data = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 800px;
        }
        h1 {
            margin-top: 0;
        }
        h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        .logout {
            color: #e74c3c;
            text-decoration: none;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-table th, .admin-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .admin-table th {
            background-color: #f2f2f2;
        }
        .user-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        .user-table td:first-child {
            font-weight: bold;
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($user_data['name']); ?>!</h1>
        <a href="logout.php" class="logout">Logout</a>

        <?php
        if ($user_data['username'] === 'adminxxx') :
            require_once 'data.php';
        ?>
            <h2>Data Semua Pengguna</h2>
            <table class="admin-table">
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else : ?>
            <h2>Data Anda</h2>
            <table class="user-table">
                <tr>
                    <td>Nama</td>
                    <td><?php echo htmlspecialchars($user_data['name']); ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($user_data['username']); ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo htmlspecialchars($user_data['email']); ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?php echo htmlspecialchars($user_data['gender']); ?></td>
                </tr>
                 <tr>
                    <td>Fakultas</td>
                    <td><?php echo htmlspecialchars($user_data['faculty']); ?></td>
                </tr>
                 <tr>
                    <td>Angkatan</td>
                    <td><?php echo htmlspecialchars($user_data['batch']); ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>