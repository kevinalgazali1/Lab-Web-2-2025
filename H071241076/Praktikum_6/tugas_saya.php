<?php
$page_title = "Tugas Saya - Team Member";
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

$sql = "SELECT 
            t.id AS task_id, 
            t.nama_tugas, 
            t.deskripsi AS task_description, 
            t.status, 
            p.nama_proyek, 
            p.id AS project_id
        FROM 
            tasks t
        JOIN 
            projects p ON t.project_id = p.id
        WHERE 
            t.assigned_to = ? 
        ORDER BY 
            FIELD(t.status, 'belum', 'proses', 'selesai'), p.nama_proyek, t.nama_tugas";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $member_id);
mysqli_stmt_execute($stmt);
$result_tasks = mysqli_stmt_get_result($stmt);

$possible_statuses = ['belum', 'proses', 'selesai'];

?>

<?php require 'header.php'; ?>

<div class="flex min-h-screen">

    <aside class="w-64 bg-dark-content p-6 shadow-lg">
        <h1 class="text-2xl font-semibold text-brand-white mb-8">Member Panel</h1>

        <nav class="space-y-4">
            <a href="dashboard_member.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="tugas_saya.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
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
            <h2 class="text-4xl font-semibold text-brand-white">Tugas Saya</h2>
            <p class="text-lg text-gray-400 mt-2">Lihat dan perbarui status tugas yang ditugaskan kepada Anda.</p>
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
            <h3 class="text-2xl font-semibold text-brand-white p-6">Daftar Tugas</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px]">
                    <thead class="bg-dark-accent uppercase text-sm text-gray-300">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Tugas</th>
                            <th class="p-4">Proyek</th>
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
                                    <td class="p-4 text-gray-300"><?php echo htmlspecialchars($row['nama_proyek']); ?></td>
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
                                        <form action="update_status_tugas.php" method="POST" class="inline-flex items-center space-x-2">
                                            <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                                            <select name="status" class="bg-dark-bg border border-dark-accent rounded-md py-1 px-2 text-sm text-brand-white focus:outline-none focus:ring-1 focus:ring-brand-orange">
                                                <?php foreach ($possible_statuses as $status): ?>
                                                    <option value="<?php echo $status; ?>" <?php echo ($row['status'] == $status) ? 'selected' : ''; ?>>
                                                        <?php echo ucfirst($status); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="bg-brand-orange text-dark-bg text-xs font-semibold py-1 px-3 rounded-md hover:bg-opacity-90 transition-colors">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-400">Anda belum memiliki tugas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>