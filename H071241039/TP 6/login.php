<?php
session_start();

$message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 flex items-center justify-center min-h-screen font-[Poppins]">

    <div class="bg-white/80 backdrop-blur-sm p-8 sm:p-10 rounded-2xl shadow-xl w-full max-w-sm border border-purple-100">
        <h2 class="text-2xl sm:text-3xl font-bold text-purple-600 mb-4 text-center">
            Masuk ke Sistem
        </h2>

        <?php if (!empty($message)) : ?>
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded mb-4 text-center font-medium shadow-sm">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="proses_login.php" class="space-y-6">
            <input
                type="text"
                name="username"
                placeholder="Username"
                required
                class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:outline-none
                       focus:ring-2 focus:ring-purple-300 text-gray-700 text-base sm:text-lg bg-white/70"
            >

            <div class="relative">
                <input
                    id="passwordInput"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-purple-300 text-gray-700 text-base sm:text-lg pr-12 bg-white/70"
                >
                <button
                    id="togglePassword"
                    type="button"
                    aria-pressed="false"
                    class="absolute inset-y-0 right-2 flex items-center px-2 text-purple-500 hover:text-purple-700 focus:outline-none"
                >
                    <span id="toggleEmoji">👁️</span>
                </button>
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-pink-300 via-purple-300 to-blue-300 hover:from-pink-400 hover:via-purple-400 hover:to-blue-400 text-white font-semibold px-4 py-3
                       rounded-lg text-base sm:text-lg transition transform hover:scale-105 shadow-md"
            >
                Masuk
            </button>
        </form>
    </div>

    <script>
        (function(){
            const pwdInput = document.getElementById('passwordInput');
            const toggleBtn = document.getElementById('togglePassword');
            const toggleEmoji = document.getElementById('toggleEmoji');

            toggleBtn.addEventListener('click', () => {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                toggleEmoji.textContent = isPassword ? '🙈' : '👁️';
                toggleBtn.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            });
        })();
    </script>

</body>
</html>
