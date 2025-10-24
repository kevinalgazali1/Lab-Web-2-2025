<?php
$page_title = "Proyek Saya - Project Manager";
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

$sql = "SELECT id, nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai 
        FROM projects 
        WHERE manager_id = ? 
        ORDER BY tanggal_mulai DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result_projects = mysqli_stmt_get_result($stmt);

?>

<?php require 'header.php'; ?>

<div class="flex min-h-screen">

    <aside class="w-64 bg-dark-content p-6 shadow-lg">
        <h1 class="text-2xl font-semibold text-brand-white mb-8">Manager Panel</h1>

        <nav class="space-y-4">
            <a href="dashboard_manager.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="proyek_saya.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
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
            <h2 class="text-4xl font-semibold text-brand-white">Proyek Saya</h2>
            <p class="text-lg text-gray-400 mt-2">Buat, edit, atau hapus proyek yang Anda kelola.</p>
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

        <div class="bg-dark-content p-8 rounded-xl shadow-lg mb-10">
            <h3 class="text-2xl font-semibold text-brand-white mb-6">Buat Proyek Baru</h3>
            <form action="tambah_proyek.php" method="POST" class="space-y-6">
                <div>
                    <label for="nama_proyek" class="block text-sm font-medium text-gray-300 mb-2">Nama Proyek</label>
                    <input type="text" id="nama_proyek" name="nama_proyek" required
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Selesai (Opsional)</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand-orange text-dark-bg font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Buat Proyek
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-dark-content rounded-xl shadow-lg overflow-hidden">
            <h3 class="text-2xl font-semibold text-brand-white p-6">Daftar Proyek Saya</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[1000px]">
                    <thead class="bg-dark-accent uppercase text-sm text-gray-300">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Nama Proyek</th>
                            <th class="p-4">Deskripsi</th>
                            <th class="p-4">Tgl Mulai</th>
                            <th class="p-4">Tgl Selesai</th>
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
                                    <td class="p-4">
                                        <div class="flex space-x-3">
                                            <a href="edit_proyek.php?id=<?php echo $row['id']; ?>" class="text-blue-400 hover:text-blue-300" title="Edit Proyek">
                                                Edit
                                            </a>
                                            <a href="hapus_proyek.php?id=<?php echo $row['id']; ?>&from=manager" class="text-red-500 hover:text-red-400" title="Hapus Proyek" onclick="return confirm('Anda yakin ingin menghapus proyek ini? Ini akan menghapus semua tugas di dalamnya.');">
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-400">Anda belum memiliki proyek.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>