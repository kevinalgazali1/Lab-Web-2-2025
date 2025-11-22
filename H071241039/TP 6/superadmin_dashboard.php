<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Super Admin') {
    die("Akses ditolak");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold drop-shadow">Super Admin Dashboard</h1>
            <div class="space-x-2">
                <a href="tambah_user.php" 
                   class="bg-white/90 text-blue-700 px-4 py-2 rounded-lg font-semibold shadow hover:bg-white transition">
                    Tambah User
                </a>
                <a href="logout.php" 
                   class="bg-rose-400 hover:bg-rose-500 text-white px-4 py-2 rounded-lg font-semibold shadow transition">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- KONTEN -->
    <div class="max-w-7xl mx-auto p-6 space-y-10">

        <!-- ==================== DAFTAR USER ==================== -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-blue-300 pb-1">
                Daftar Semua User
            </h2>
            <div class="overflow-x-auto bg-white/80 rounded-2xl shadow-md backdrop-blur-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-100 to-purple-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $user_result = mysqli_query($conn, "SELECT id, username, role FROM users");
                        while ($user = mysqli_fetch_assoc($user_result)) {
                            if ($user['id'] == $_SESSION['user']['id']) continue;

                            $role_color = match($user['role']) {
                                'Project Manager' => 'bg-green-100 text-green-800',
                                'Team Member' => 'bg-yellow-100 text-yellow-800',
                            };
                        ?>
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-sm <?= $role_color ?>">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="hapus_user.php?id=<?= $user['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus user ini?')"
                                   class="bg-rose-400 hover:bg-rose-500 text-white px-3 py-1 rounded-lg text-sm font-medium shadow transition">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ==================== DAFTAR PROYEK ==================== -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-purple-300 pb-1">
                Daftar Semua Proyek
            </h2>
            <div class="overflow-x-auto bg-white/80 rounded-2xl shadow-md backdrop-blur-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-pink-100 to-blue-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama Proyek</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal Mulai</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal Selesai</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Manager</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $project_result = mysqli_query($conn, "
                            SELECT p.*, u.username AS manager 
                            FROM projects p 
                            LEFT JOIN users u ON p.manager_id = u.id
                        ");
                        
                        while ($row = mysqli_fetch_assoc($project_result)) {
                            $members = [];
                            $member_result = mysqli_query($conn, "
                                SELECT username 
                                FROM users 
                                WHERE project_manager_id={$row['manager_id']} 
                                AND role='Team Member'
                            ");
                            while ($m = mysqli_fetch_assoc($member_result)) {
                                $members[] = $m['username'];
                            }
                            $members_str = implode(', ', $members);
                        ?>
                        <tr class="hover:bg-pink-50/50 transition">
                            <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['manager']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($members_str) ?></td>
                            <td class="px-4 py-3">
                                <a href="hapus_proyek.php?id=<?= $row['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                   class="bg-rose-400 hover:bg-rose-500 text-white px-3 py-1 rounded-lg text-sm font-medium shadow transition">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>