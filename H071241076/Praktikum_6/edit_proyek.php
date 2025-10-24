<?php
$page_title = "Edit Proyek - Project Manager";
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

$project_id_to_edit = 0;
$project_data = null;
$manager_id_session = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $project_id_to_edit = $_GET['id'];

    $sql_project = "SELECT nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id FROM projects WHERE id = ?";
    $stmt_project = mysqli_prepare($conn, $sql_project);
    mysqli_stmt_bind_param($stmt_project, "i", $project_id_to_edit);
    mysqli_stmt_execute($stmt_project);
    $result_project = mysqli_stmt_get_result($stmt_project);

    if (mysqli_num_rows($result_project) == 1) {
        $project_data = mysqli_fetch_assoc($result_project);

        if ($project_data['manager_id'] != $manager_id_session) {
            $_SESSION['error'] = "Anda hanya dapat mengedit proyek Anda sendiri.";
            header("Location: proyek_saya.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Proyek tidak ditemukan.";
        header("Location: proyek_saya.php");
        exit();
    }
    mysqli_stmt_close($stmt_project);
} else {
    $_SESSION['error'] = "ID proyek tidak disediakan.";
    header("Location: proyek_saya.php");
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

            <a href="proyek_saya.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                <span class="font-semibold">Proyek Saya</span>
            </a>

            <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-400 hover:bg-red-500 hover:text-brand-white transition-colors">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="font-semibold">Logout</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">

        <header class="mb-10">
            <h2 class="text-4xl font-semibold text-brand-white">Edit Proyek</h2>
            <p class="text-lg text-gray-400 mt-2">Mengubah detail untuk proyek: <span class="font-semibold text-brand-orange"><?php echo htmlspecialchars($project_data['nama_proyek']); ?></span></p>
        </header>

        <div class="bg-dark-content p-8 rounded-xl shadow-lg">
            <form action="proses_edit_proyek.php" method="POST" class="space-y-6">

                <input type="hidden" name="project_id" value="<?php echo $project_id_to_edit; ?>">

                <div>
                    <label for="nama_proyek" class="block text-sm font-medium text-gray-300 mb-2">Nama Proyek</label>
                    <input type="text" id="nama_proyek" name="nama_proyek" value="<?php echo htmlspecialchars($project_data['nama_proyek']); ?>" required
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent"><?php echo htmlspecialchars($project_data['deskripsi']); ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $project_data['tanggal_mulai']; ?>" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-300 mb-2">Tanggal Selesai (Opsional)</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $project_data['tanggal_selesai']; ?>"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand-orange text-dark-bg font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Update Proyek
                    </button>
                </div>
            </form>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>