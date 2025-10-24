<?php
$page_title = "Dashboard Team Member";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Team Member') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";

    if ($_SESSION['role'] == 'Super Admin') {
        header("Location: dashboard_admin.php");
    } elseif ($_SESSION['role'] == 'Project Manager') {
        header("Location: dashboard_manager.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$member_id = $_SESSION['user_id'];

// --- PHP: Ambil Data Statistik Real-time ---
// 1. Tugas Belum Selesai (Status 'belum' atau 'proses')
$sql_tugas_belum = "SELECT COUNT(id) AS total_tugas_belum 
                   FROM tasks 
                   WHERE assigned_to = ? AND status IN ('belum', 'proses')";
$stmt_tugas_belum = mysqli_prepare($conn, $sql_tugas_belum);
mysqli_stmt_bind_param($stmt_tugas_belum, "i", $member_id);
mysqli_stmt_execute($stmt_tugas_belum);
$result_tugas_belum = mysqli_stmt_get_result($stmt_tugas_belum);
$total_tugas_belum = mysqli_fetch_assoc($result_tugas_belum)['total_tugas_belum'];
mysqli_stmt_close($stmt_tugas_belum);


// 2. Proyek Aktif (Proyek yang memiliki tugas yang di-assign ke member ini)
$sql_proyek_aktif = "SELECT COUNT(DISTINCT project_id) AS total_proyek_aktif
                     FROM tasks
                     WHERE assigned_to = ?";
$stmt_proyek_aktif = mysqli_prepare($conn, $sql_proyek_aktif);
mysqli_stmt_bind_param($stmt_proyek_aktif, "i", $member_id);
mysqli_stmt_execute($stmt_proyek_aktif);
$result_proyek_aktif = mysqli_stmt_get_result($stmt_proyek_aktif);
$total_proyek_aktif = mysqli_fetch_assoc($result_proyek_aktif)['total_proyek_aktif'];
mysqli_stmt_close($stmt_proyek_aktif);
// ----------------------------------------
?>

<?php require 'header.php'; ?>

<div class="flex min-h-screen">

    <aside class="w-64 bg-dark-content p-6 shadow-lg">
        <h1 class="text-2xl font-semibold text-brand-white mb-8">Member Panel</h1>

        <nav class="space-y-4">
            <a href="dashboard_member.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="tugas_saya.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                <span class="font-semibold">Tugas Saya</span>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="clipboard-list" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Tugas Belum Selesai</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_tugas_belum; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="briefcase" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Proyek Aktif</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_proyek_aktif; ?></p>
                    </div>
                </div>
            </div>

        </div>

    </main>

</div>

<?php require 'footer.php'; ?>