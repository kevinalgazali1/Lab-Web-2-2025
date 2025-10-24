<?php
$page_title = "Dashboard Super Admin";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Super Admin') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";
    header("Location: index.php");
    exit();
}

// --- PHP: Ambil Data Statistik Real-time ---
// 1. Total Users
$sql_users = "SELECT COUNT(id) AS total_users FROM users";
$result_users = mysqli_query($conn, $sql_users);
$total_users = mysqli_fetch_assoc($result_users)['total_users'];


// 2. Total Projects
$sql_projects = "SELECT COUNT(id) AS total_projects FROM projects";
$result_projects = mysqli_query($conn, $sql_projects);
$total_projects = mysqli_fetch_assoc($result_projects)['total_projects'];


// 3. Total Tasks
$sql_tasks = "SELECT COUNT(id) AS total_tasks FROM tasks";
$result_tasks = mysqli_query($conn, $sql_tasks);
$total_tasks = mysqli_fetch_assoc($result_tasks)['total_tasks'];
// ------------------------------------------
?>

<?php require 'header.php'; ?>

<div class="flex min-h-screen">

    <aside class="w-64 bg-dark-content p-6 shadow-lg">
        <h1 class="text-2xl font-semibold text-brand-white mb-8">Admin Panel</h1>

        <nav class="space-y-4">
            <a href="dashboard_admin.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="kelola_users.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="font-semibold">Kelola Users</span>
            </a>

            <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-400 hover:bg-red-500 hover:text-brand-white transition-colors">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="font-semibold">Logout</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <header class="mb-10">
            <h2 class="text-4xl font-semibold text-brand-white">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="text-lg text-gray-400 mt-2">Anda login sebagai: <span class="font-semibold text-brand-orange"><?php echo htmlspecialchars($_SESSION['role']); ?></span></p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="users" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total Users</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_users; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="briefcase" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total Projects</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_projects; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="clipboard-check" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total Tasks</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_tasks; ?></p>
                    </div>
                </div>
            </div>

        </div>

    </main>

</div>

<?php require 'footer.php'; ?>