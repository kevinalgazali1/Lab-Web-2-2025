<?php
$page_title = "Edit User - Super Admin";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header("Location: index.php");
    exit();
}

$user_id_to_edit = 0;
$user_data = null;
$managers = [];

if (isset($_GET['id'])) {
    $user_id_to_edit = $_GET['id'];

    if ($user_id_to_edit == $_SESSION['user_id']) {
        $_SESSION['error'] = "Anda tidak dapat mengedit akun Anda sendiri dari halaman ini.";
        header("Location: kelola_users.php");
        exit();
    }

    $sql_user = "SELECT username, role, project_manager_id FROM users WHERE id = ?";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "i", $user_id_to_edit);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    if (mysqli_num_rows($result_user) == 1) {
        $user_data = mysqli_fetch_assoc($result_user);
    } else {
        $_SESSION['error'] = "User tidak ditemukan.";
        header("Location: kelola_users.php");
        exit();
    }
    mysqli_stmt_close($stmt_user);

    $sql_managers = "SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username";
    $result_managers = mysqli_query($conn, $sql_managers);

    if (mysqli_num_rows($result_managers) > 0) {
        while ($row_manager = mysqli_fetch_assoc($result_managers)) {
            $managers[] = $row_manager;
        }
    }
} else {
    $_SESSION['error'] = "ID user tidak disediakan.";
    header("Location: kelola_users.php");
    exit();
}
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

            <a href="kelola_users.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-dark-accent text-brand-white transition-colors">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="font-semibold">Kelola Users</span>
            </a>

            <a href="kelola_proyek.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-accent hover:text-brand-white transition-colors">
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
            <h2 class="text-4xl font-semibold text-brand-white">Edit User</h2>
            <p class="text-lg text-gray-400 mt-2">Mengubah data untuk user: <span class="font-semibold text-brand-orange"><?php echo htmlspecialchars($user_data['username']); ?></span></p>
        </header>

        <div class="bg-dark-content p-8 rounded-xl shadow-lg">
            <form action="proses_edit_user.php" method="POST" class="space-y-6">

                <input type="hidden" name="user_id" value="<?php echo $user_id_to_edit; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                        <small class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                        <select id="role" name="role" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="Project Manager" <?php echo ($user_data['role'] == 'Project Manager') ? 'selected' : ''; ?>>
                                Project Manager
                            </option>
                            <option value="Team Member" <?php echo ($user_data['role'] == 'Team Member') ? 'selected' : ''; ?>>
                                Team Member
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="project_manager_id" class="block text-sm font-medium text-gray-300 mb-2">Project Manager (jika Team Member)</label>
                        <select id="project_manager_id" name="project_manager_id"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="">Tidak ada</option>
                            <?php foreach ($managers as $manager): ?>
                                <option value="<?php echo $manager['id']; ?>" <?php echo ($user_data['project_manager_id'] == $manager['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($manager['username']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand-orange text-dark-bg font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Update User
                    </button>
                </div>
            </form>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>