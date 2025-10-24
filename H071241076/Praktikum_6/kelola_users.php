<?php
$page_title = "Kelola Users - Super Admin";
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
if ($_SESSION['role'] != 'Super Admin') {
    header("Location: dashboard_admin.php");
    exit();
}

$sql = "SELECT 
            u.id, 
            u.username, 
            u.role, 
            pm.username AS manager_name 
        FROM 
            users u
        LEFT JOIN 
            users pm ON u.project_manager_id = pm.id
        ORDER BY 
            u.role, u.username";
$result_users = mysqli_query($conn, $sql);

$sql_managers = "SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username";
$result_managers = mysqli_query($conn, $sql_managers);

$managers = [];
if (mysqli_num_rows($result_managers) > 0) {
    while ($row_manager = mysqli_fetch_assoc($result_managers)) {
        $managers[] = $row_manager;
    }
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
            <h2 class="text-4xl font-semibold text-brand-white">Kelola Users</h2>
            <p class="text-lg text-gray-400 mt-2">Tambah, edit, atau hapus Project Manager dan Team Member.</p>
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
            <h3 class="text-2xl font-semibold text-brand-white mb-6">Tambah User Baru</h3>
            <form action="tambah_user.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                        <select id="role" name="role" required
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="">Pilih Role...</option>
                            <option value="Project Manager">Project Manager</option>
                            <option value="Team Member">Team Member</option>
                        </select>
                    </div>
                    <div>
                        <label for="project_manager_id" class="block text-sm font-medium text-gray-300 mb-2">Project Manager (jika Team Member)</label>
                        <select id="project_manager_id" name="project_manager_id"
                            class="w-full pl-4 pr-4 py-3 bg-dark-bg border border-dark-accent rounded-lg text-brand-white focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                            <option value="">Tidak ada</option>
                            <?php foreach ($managers as $manager): ?>
                                <option value="<?php echo $manager['id']; ?>">
                                    <?php echo htmlspecialchars($manager['username']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-brand-orange text-dark-bg font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 focus:ring-offset-dark-content transition-all">
                        Tambah User
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-dark-content rounded-xl shadow-lg overflow-hidden">
            <h3 class="text-2xl font-semibold text-brand-white p-6">Daftar User</h3>
            <table class="w-full text-left">
                <thead class="bg-dark-accent uppercase text-sm text-gray-300">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Username</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Manajer</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-accent">
                    <?php if (mysqli_num_rows($result_users) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result_users)): ?>
                            <tr class="hover:bg-dark-accent transition-colors">
                                <td class="p-4 text-gray-300"><?php echo $row['id']; ?></td>
                                <td class="p-4 font-semibold text-brand-white"><?php echo htmlspecialchars($row['username']); ?></td>
                                <td class="p-4 text-gray-300"><?php echo htmlspecialchars($row['role']); ?></td>
                                <td class_name="p-4 text-gray-300"><?php echo $row['manager_name'] ? htmlspecialchars($row['manager_name']) : 'N/A'; ?></td>
                                <td class="p-4">
                                    <div class="flex space-x-3">
                                        <?php if ($row['id'] != $_SESSION['user_id']): ?>
                                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="text-blue-400 hover:text-blue-300" title="Edit">
                                                <i data-lucide="edit-2" class="w-5 h-5"></i>
                                            </a>
                                            <a href="hapus_user.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:text-red-400" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus user ini?');">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-500 text-sm">(Akun Anda)</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">Belum ada user terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

</div>

<?php require 'footer.php'; ?>