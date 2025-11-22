<?php
$page_title = "Login - Manajemen Proyek";
session_start();

require 'header.php';
?>

<div class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">

        <div class="bg-dark-content shadow-lg rounded-xl p-8 md:p-12">

            <h1 class="text-3xl font-semibold mb-2 text-brand-white text-center">Selamat Datang!</h1>
            <p class="text-gray-300 mb-8 text-center">Silakan login untuk melanjutkan.</p>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="bg-red-500 text-white p-3 rounded-lg mb-6 text-sm">';
                echo htmlspecialchars($_SESSION['error']);
                echo '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form action="proses_login.php" method="POST" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                        </span>
                        <input type="text" id="username" name="username"
                            class="w-full pl-10 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent"
                            placeholder="Masukkan username Anda" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                        </span>
                        <input type="password" id="password" name="password"
                            class="w-full pl-10 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent"
                            placeholder="Masukkan password Anda" required>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <a href="#" class="text-sm text-gray-400 hover:text-brand-orange transition-colors">Lupa password?</a>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-brand-orange text-dark-bg font-semibold py-3 px-4 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Login
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php
require 'footer.php';
?>