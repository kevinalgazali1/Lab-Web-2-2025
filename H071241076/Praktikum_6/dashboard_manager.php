<?php
$page_title = "Dashboard Project Manager";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";
    
    if ($_SESSION['role'] == 'Super Admin') {
        header("Location: dashboard_admin.php");
    } elseif ($_SESSION['role'] == 'Team Member') {
        header("Location: dashboard_member.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$manager_id = $_SESSION['user_id'];

$sql_proyek = "SELECT COUNT(id) AS total_proyek FROM projects WHERE manager_id = ?";
$stmt_proyek = mysqli_prepare($conn, $sql_proyek);
mysqli_stmt_bind_param($stmt_proyek, "i", $manager_id);
mysqli_stmt_execute($stmt_proyek);
$result_proyek = mysqli_stmt_get_result($stmt_proyek);
$total_proyek = mysqli_fetch_assoc($result_proyek)['total_proyek'];
mysqli_stmt_close($stmt_proyek);


$sql_tugas = "SELECT COUNT(t.id) AS total_tugas_aktif 
              FROM tasks t
              JOIN projects p ON t.project_id = p.id
              WHERE p.manager_id = ? AND t.status != 'selesai'";
$stmt_tugas = mysqli_prepare($conn, $sql_tugas);
mysqli_stmt_bind_param($stmt_tugas, "i", $manager_id);
mysqli_stmt_execute($stmt_tugas);
$result_tugas = mysqli_stmt_get_result($stmt_tugas);
$total_tugas_aktif = mysqli_fetch_assoc($result_tugas)['total_tugas_aktif'];
mysqli_stmt_close($stmt_tugas);


$role_tm = 'Team Member';
$sql_anggota = "SELECT COUNT(id) AS total_anggota FROM users WHERE project_manager_id = ? AND role = ?";
$stmt_anggota = mysqli_prepare($conn, $sql_anggota);
mysqli_stmt_bind_param($stmt_anggota, "is", $manager_id, $role_tm);
mysqli_stmt_execute($stmt_anggota);
$result_anggota = mysqli_stmt_get_result($stmt_anggota);
$total_anggota = mysqli_fetch_assoc($result_anggota)['total_anggota'];
mysqli_stmt_close($stmt_anggota);

?>

<?php require 'header.php'; ?>

<div class="flex min-h-screen">
    
    <aside class="w-64 bg-dark-content p-6 shadow-lg">
        <h1 class="text-2xl font-semibold text-brand-white mb-8">Manager Panel</h1>
        
        <nav class="space-y-4">
            <a href="dashboard_manager.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>
            
            <a href="proyek_saya.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                <span class="font-semibold">Proyek Saya</span>
            </a>

            <a href="kelola_tugas.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span class="font-semibold">Kelola Tugas</span>
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
                        <i data-lucide="briefcase" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total Proyek Saya</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_proyek; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="clipboard-list" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total Tugas Aktif</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_tugas_aktif; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-content p-6 rounded-xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-dark-accent rounded-full">
                        <i data-lucide="users" class="w-6 h-6 text-brand-orange"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Anggota Tim</p>
                        <p class="text-2xl font-semibold text-brand-white"><?php echo $total_anggota; ?></p>
                    </div>
                </div>
            </div>
            
        </div>
        
    </main>
    
</div>

<?php require 'footer.php'; ?>