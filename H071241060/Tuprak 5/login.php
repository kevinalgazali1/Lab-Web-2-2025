<?php
session_start();

// Jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { 
            background-color: #171615;
            margin: 0;
            padding: 20px;
            justify-items: center;
            color: #d0c5c0;}
        .login-container {
            border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726; 
            padding: 2rem; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            width: 300px; }
        h2 { 
            text-align: center; 
            margin-bottom: 1.5rem; }
        .input-group {
            margin-bottom: 1rem; }
        .input-group label { 
            display: block; 
            margin-bottom: 5px; }
        .input-group input { 
            color: #ddd;
            width: 100%; 
            padding: 8px;   
            box-sizing: border-box; 
            background-color: #171615;
            border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726;}
        .input-group input:focus {
            outline: none;
            border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726;
            background-color: #3d3938;
            color: white;
        }
        .btn { 
            width: 100%; 
            padding: 10px; 
            background-color: #171615; 
            color: white; 
            border: none; 
            cursor: pointer; 
            font-size: 16px;
            border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726; }
        .btn:hover { 
            background: #3d3938 }
        .error { 
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 10px; 
            border: 1px solid #f5c6cb; 
            border-radius: 4px; 
            margin-bottom: 1rem; 
            text-align: center; 
            border-top: 4px solid #646160;
            border-right: 4px solid #646160;
            border-left: 4px solid #292726;
            border-bottom: 4px solid #292726; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Silakan Login</h2>

        <?php
        // Tampilkan pesan error jika ada
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Hapus pesan error setelah ditampilkan
        }
        ?>

        <form action="proses_login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>