<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1920&q=80') center/cover no-repeat;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(26, 11, 46, 0.6) 0%, rgba(74, 26, 107, 0.5) 50%, rgba(123, 45, 143, 0.6) 100%);
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(139, 69, 190, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 50px 45px;
            width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

        h1 {
            color: white;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 40px;
            font-weight: 600;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px 45px 15px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            color: white;
            font-size: 16px;
            outline: none;
            transition: all 0.3s;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 18px;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .forgot {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot:hover {
            color: white;
        }

        button {
            width: 100%;
            padding: 15px;
            background: white;
            color: #6b2d8f;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
        }

        .register {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .register a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .register a:hover {
            opacity: 0.8;
        }

        .error-message {
            background: rgba(255, 100, 100, 0.2);
            border: 1px solid rgba(255, 100, 100, 0.4);
            color: #ffcccc;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        
        <div id="errorMessage">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . htmlspecialchars($_SESSION['error']) . '</p>';

                unset($_SESSION['error']);
            }
            ?>
        </div>

        <form method="post" action="proses_login.php">
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <span class="icon">👤</span>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="icon">🔒</span>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>