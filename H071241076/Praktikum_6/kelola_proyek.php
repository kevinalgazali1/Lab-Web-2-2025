<?php
$page_title = "Kelola Proyek - Super Admin";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header("Location: index.php");
    exit();
}

$sql = "SELECT 
            p.id, 
            p.nama_proyek, 
            p.deskripsi, 
            p.tanggal_mulai, 
            p.tanggal_selesai, 
            u.username AS manager_name 
        FROM 
            projects p
        JOIN
            users u ON p.manager_id = u.id
        ORDER BY 
            p.tanggal_mulai DESC";

$result_projects = mysqli_query($conn, $sql);
?>

<?php require 'header.php'; ?>

<div class="flex min-h-screen">

    <aside class="w-64 bg-dark-content p-6 shadow-lg">
        <h1 class="text-2xl font-semibold text-brand-white mb-8">Admin Panel</h1>

        <nav class="space-y-4">
            <a href="dashboard_admin.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="kelola_users.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="font-semibold">Kelola Users</span>
            </a>

            <a href="kelola_proyek.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                <span class="font-semibold">Kelola Proyek</span>
            </a>

            <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-400 hover:bg-red-500 hover:text-brand-white transition-colors">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="font-semibold">Logout</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <header class="mb-10">
            <h2 class="text-4xl font-semibold text-brand-white">Kelola Semua Proyek</h2>
            <p class="text-lg text-gray-400 mt-2">Melihat dan menghapus proyek dari semua Project Manager.</p>
        </header>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="bg-green-500 text-white p-4 rounded-lg mb-6 text-sm font-semibold">';
            echo htmlspecialchars($_SESSION['message']);
            echo '</div>';
            unset($_SESSION['message']);
        }

        if (isset($_SESSION['error'])) {
            echo '<div class="bg-red-500 text-white p-4 rounded-lg mb-6 text-sm font-semibold">';
            echo htmlspecialchars($_SESSION['error']);
            echo '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <div class="bg-dark-content rounded-xl shadow-lg overflow-hidden">
            <h3 class="text-2xl font-semibold text-brand-white p-6">Daftar Semua Proyek</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[1000px]">
                    <thead class="bg-dark-accent uppercase text-sm text-gray-300">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Nama Proyek</th>
                            <th class="p-4">Deskripsi</th>
                            <th class="p-4">Tgl Mulai</th>
                            <th class="p-4">Tgl Selesai</th>
                            <th class="p-4">Project Manager</th>
                            <th class="p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-accent">
                        <?php if (mysqli_num_rows($result_projects) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_projects)): ?>
                                <tr class="hover:bg-dark-accent transition-colors">
                                    <td class="p-4 text-gray-300"><?php echo $row['id']; ?></td>
                                    <td class="p-4 font-semibold text-brand-white"><?php echo htmlspecialchars($row['nama_proyek']); ?></td>
                                    <td class="p-4 text-gray-300 text-sm max-w-xs truncate"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                                    <td class="p-4 text-gray-300"><?php echo date('d M Y', strtotime($row['tanggal_mulai'])); ?></td>
                                    <td class="p-4 text-gray-300"><?php echo $row['tanggal_selesai'] ? date('d M Y', strtotime($row['tanggal_selesai'])) : 'N/A'; ?></td>
                                    <td class="p-4 text-brand-orange"><?php echo htmlspecialchars($row['manager_name']); ?></td>
                                    <td class="p-4">
                                        <div class="flex space-x-3">
                                            <a href="hapus_proyek.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:text-red-400" title="Hapus Proyek" onclick="return confirm('Anda yakin ingin menghapus proyek ini? Ini akan menghapus semua tugas di dalamnya.');">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-400">Belum ada proyek yang dibuat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>