<?php
$page_title = "Edit Tugas - Project Manager";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";
    header("Location: index.php");
    exit();
}

$task_id_to_edit = 0;
$task_data = null;
$manager_id_session = $_SESSION['user_id'];
$team_members = [];

if (isset($_GET['id'])) {
    $task_id_to_edit = $_GET['id'];

    $sql_task = "SELECT t.nama_tugas, t.deskripsi, t.assigned_to, p.manager_id 
                 FROM tasks t
                 JOIN projects p ON t.project_id = p.id
                 WHERE t.id = ?";
    $stmt_task = mysqli_prepare($conn, $sql_task);
    mysqli_stmt_bind_param($stmt_task, "i", $task_id_to_edit);
    mysqli_stmt_execute($stmt_task);
    $result_task = mysqli_stmt_get_result($stmt_task);

    if (mysqli_num_rows($result_task) == 1) {
        $task_data = mysqli_fetch_assoc($result_task);

        if ($task_data['manager_id'] != $manager_id_session) {
            $_SESSION['error'] = "Anda hanya dapat mengedit tugas dari proyek Anda sendiri.";
            header("Location: kelola_tugas.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Tugas tidak ditemukan.";
        header("Location: kelola_tugas.php");
        exit();
    }
    mysqli_stmt_close($stmt_task);

    $sql_members = "SELECT id, username FROM users WHERE project_manager_id = ? AND role = 'Team Member'";
    $stmt_members = mysqli_prepare($conn, $sql_members);
    mysqli_stmt_bind_param($stmt_members, "i", $manager_id_session);
    mysqli_stmt_execute($stmt_members);
    $result_members = mysqli_stmt_get_result($stmt_members);

    while ($row = mysqli_fetch_assoc($result_members)) {
        $team_members[] = $row;
    }
    mysqli_stmt_close($stmt_members);
} else {
    $_SESSION['error'] = "ID tugas tidak disediakan.";
    header("Location: kelola_tugas.php");
    exit();
}
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
            <h2 class="text-4xl font-semibold text-brand-white">Edit Tugas</h2>
            <p class="text-lg text-gray-400 mt-2">Mengubah detail untuk tugas: <span class="font-semibold text-brand-orange"><?php echo htmlspecialchars($task_data['nama_tugas']); ?></span></p>
        </header>

        <div class="bg-dark-content p-8 rounded-xl shadow-lg">
            <form action="proses_edit_tugas.php" method="POST" class="space-y-6">

                <input type="hidden" name="task_id" value="<?php echo $task_id_to_edit; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_tugas" class="block text-sm font-medium text-gray-300 mb-2">Nama Tugas</label>
                        <input type="text" id="nama_tugas" name="nama_tugas" value="<?php echo htmlspecialchars($task_data['nama_tugas']); ?>" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-300 mb-2">Tugaskan Kepada</label>
                        <select id="assigned_to" name="assigned_to"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="">Belum Ditugaskan</option>
                            <?php foreach ($team_members as $member): ?>
                                <option value="<?php echo $member['id']; ?>" <?php echo ($task_data['assigned_to'] == $member['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($member['username']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent"><?php echo htmlspecialchars($task_data['deskripsi']); ?></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand-orange text-dark-bg font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Update Tugas
                    </button>
                </div>
            </form>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>