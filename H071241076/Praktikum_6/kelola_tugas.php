<?php
$page_title = "Kelola Tugas - Project Manager";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    header("Location: index.php");
    exit();
}

$manager_id = $_SESSION['user_id'];

$sql_tasks = "SELECT 
                t.id AS task_id, t.nama_tugas, t.deskripsi, t.status, 
                p.nama_proyek, 
                u.username AS assigned_member 
              FROM tasks t
              JOIN projects p ON t.project_id = p.id
              LEFT JOIN users u ON t.assigned_to = u.id
              WHERE p.manager_id = ?
              ORDER BY p.nama_proyek, t.status, t.id DESC";

$stmt_tasks = mysqli_prepare($conn, $sql_tasks);
mysqli_stmt_bind_param($stmt_tasks, "i", $manager_id);
mysqli_stmt_execute($stmt_tasks);
$result_tasks = mysqli_stmt_get_result($stmt_tasks);

$sql_projects = "SELECT id, nama_proyek FROM projects WHERE manager_id = ?";
$stmt_projects = mysqli_prepare($conn, $sql_projects);
mysqli_stmt_bind_param($stmt_projects, "i", $manager_id);
mysqli_stmt_execute($stmt_projects);
$result_projects = mysqli_stmt_get_result($stmt_projects);

$manager_projects = [];
while ($row = mysqli_fetch_assoc($result_projects)) {
    $manager_projects[] = $row;
}

$sql_members = "SELECT id, username FROM users WHERE project_manager_id = ? AND role = 'Team Member'";
$stmt_members = mysqli_prepare($conn, $sql_members);
mysqli_stmt_bind_param($stmt_members, "i", $manager_id);
mysqli_stmt_execute($stmt_members);
$result_members = mysqli_stmt_get_result($stmt_members);

$team_members = [];
while ($row = mysqli_fetch_assoc($result_members)) {
    $team_members[] = $row;
}

mysqli_stmt_close($stmt_tasks);
mysqli_stmt_close($stmt_projects);
mysqli_stmt_close($stmt_members);
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

            <a href="proyek_saya.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                <span class="font-semibold">Proyek Saya</span>
            </a>

            <a href="kelola_tugas.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
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
            <h2 class="text-4xl font-semibold text-brand-white">Kelola Tugas Proyek</h2>
            <p class="text-lg text-gray-400 mt-2">Buat dan tugaskan tugas untuk semua proyek Anda.</p>
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
            <h3 class="text-2xl font-semibold text-brand-white mb-6">Tambah Tugas Baru</h3>
            <form action="tambah_tugas.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-300 mb-2">Pilih Proyek</label>
                        <select id="project_id" name="project_id" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="">Pilih Proyek...</option>
                            <?php foreach ($manager_projects as $project): ?>
                                <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['nama_proyek']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-300 mb-2">Tugaskan Kepada</label>
                        <select id="assigned_to" name="assigned_to"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="">Belum Ditugaskan</option>
                            <?php foreach ($team_members as $member): ?>
                                <option value="<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['username']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="nama_tugas" class="block text-sm font-medium text-gray-300 mb-2">Nama Tugas</label>
                    <input type="text" id="nama_tugas" name="nama_tugas" required
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand-orange text-dark-bg font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Tambah Tugas
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-dark-content rounded-xl shadow-lg overflow-hidden">
            <h3 class="text-2xl font-semibold text-brand-white p-6">Daftar Semua Tugas</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[1000px]">
                    <thead class="bg-dark-accent uppercase text-sm text-gray-300">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Tugas</th>
                            <th class="p-4">Proyek</th>
                            <th class="p-4">Ditugaskan Kepada</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-accent">
                        <?php if (mysqli_num_rows($result_tasks) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_tasks)): ?>
                                <tr class="hover:bg-dark-accent transition-colors">
                                    <td class="p-4 text-gray-300"><?php echo $row['task_id']; ?></td>
                                    <td class="p-4 font-semibold text-brand-white"><?php echo htmlspecialchars($row['nama_tugas']); ?></td>
                                    <td class="p-4 text-brand-orange"><?php echo htmlspecialchars($row['nama_proyek']); ?></td>
                                    <td class="p-4 text-gray-300"><?php echo $row['assigned_member'] ?: 'Belum Ditugaskan'; ?></td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php
                                            if ($row['status'] == 'selesai') echo 'bg-green-500 text-white';
                                            elseif ($row['status'] == 'proses') echo 'bg-yellow-500 text-dark-bg';
                                            else echo 'bg-red-500 text-white';
                                            ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex space-x-3">
                                            <a href="edit_tugas.php?id=<?php echo $row['task_id']; ?>" class="text-blue-400 hover:text-blue-300" title="Edit Tugas">
                                                Edit </a>
                                            <a href="hapus_tugas.php?id=<?php echo $row['task_id']; ?>" class="text-red-500 hover:text-red-400" title="Hapus Tugas" onclick="return confirm('Anda yakin ingin menghapus tugas ini?');">
                                                Hapus </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-400">Anda belum memiliki tugas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>