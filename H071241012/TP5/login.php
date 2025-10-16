<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background: #f3f3f3; }
        .login-box {
            background: white; padding: 30px; margin: 100px auto;
            width: 300px; border-radius: 10px; box-shadow: 0 0 10px #ccc;
        }
        input { width: 100%; padding: 8px; margin: 10px 0; }
        button { width: 100%; padding: 8px; background: #007BFF; color: white; border: none; border-radius: 5px; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Login</h2>
    <form action="proses_login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Masuk</button>
    </form>
    <?php 
    if($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
</div>
</body>
</html>
