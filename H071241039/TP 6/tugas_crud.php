<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id  = $_SESSION['user']['id'];
$project_id  = $_GET['project_id'] ?? 0;
$pemberitahuan = "";

// =======================
// Tambah Tugas
// =======================
if (isset($_POST['tambah'])) {

    $nama_tugas   = trim($_POST['nama_tugas']);
    $assigned_to  = $_POST['assigned_to'];
    $project_id   = $_POST['project_id'];

    if (!empty($nama_tugas) && !empty($assigned_to) && !empty($project_id)) {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE nama_tugas=? AND project_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama_tugas, $project_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Tugas dengan nama '$nama_tugas' sudah ada dalam proyek ini.";
        } else {
            $sql = "INSERT INTO tasks (nama_tugas, project_id, assigned_to) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sii", $nama_tugas, $project_id, $assigned_to);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $pemberitahuan = "Tugas '$nama_tugas' berhasil ditambahkan.";
        }

    }

}

// =======================
// Hapus Tugas
// =======================
if (isset($_GET['hapus_id'])) {

    $hapus_id = $_GET['hapus_id'];
    $sql = "DELETE t FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $manager_id);
    mysqli_stmt_execute($stmt);

    header("Location: tugas_crud.php?project_id=" . $project_id);
    exit();
}

// =====================================
// Ambil daftar proyek milik manager ini
// =====================================
$project_list = [];
$sql = "SELECT id, nama_proyek FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
$stmt->execute();
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $project_list[] = $row;
}

if ($project_id == 0 && count($project_list) > 0) {
    $project_id = $project_list[0]['id'];
}

// =======================
// Daftar team member
// =======================
$team_members = [];
$sql = "SELECT id, username FROM users WHERE role='Team Member' AND project_manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
$stmt->execute();
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $team_members[] = $row;
}

// =======================
// Daftar tugas di proyek
// =======================
$tasks = [];
$sql = "SELECT t.id, t.nama_tugas, t.status, u.username AS member
        FROM tasks t
        JOIN users u ON t.assigned_to = u.id
        WHERE t.project_id=? 
        ORDER BY t.id ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $project_id);
$stmt->execute();
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Tugas Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 min-h-screen">

    <header class="w-full bg-gradient-to-r from-pink-400 to-purple-400 text-white p-4 sm:p-6 flex justify-between items-center shadow-md">
        <h1 class="text-2xl sm:text-3xl font-bold drop-shadow">Daftar Tugas</h1>
        <a href="manager_dashboard.php" 
           class="bg-white/30 hover:bg-white/50 px-4 py-2 rounded-md text-white text-base sm:text-lg transition backdrop-blur-md shadow">
           ⬅ Kembali
        </a>
    </header>

    <main class="w-full p-4 sm:p-8 space-y-6">

        <?php if (!empty($pemberitahuan)): ?>
            <div class="p-3 bg-pink-100 border border-pink-300 text-pink-700 rounded-md shadow-sm">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="font-medium text-gray-700">Pilih Proyek:</label>
                <select name="project_id" onchange="this.form.submit()" 
                        class="px-3 py-2 border border-purple-200 rounded-md bg-white/70 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <?php foreach ($project_list as $proj): ?>
                        <option value="<?= $proj['id'] ?>" <?= $proj['id']==$project_id?'selected':'' ?>>
                            <?= htmlspecialchars($proj['nama_proyek']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <section>
            <h2 class="text-xl font-semibold text-purple-700 mb-3">📋 Daftar Tugas</h2>

            <?php if (empty($tasks)): ?>
                <p class="text-gray-600 italic">Belum ada tugas untuk proyek ini.</p>
            <?php else: ?>
                <div class="overflow-x-auto bg-white/90 backdrop-blur-md rounded-2xl shadow border border-purple-100">
                    <table class="min-w-full divide-y divide-purple-200">
                        <thead class="bg-purple-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tugas</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Assigned To</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($tasks as $tugas): ?>
                                <tr class="hover:bg-purple-50/50 transition">
                                    <td class="px-4 py-2 text-gray-800"><?= htmlspecialchars($tugas['nama_tugas']) ?></td>
                                    <td class="px-4 py-2 text-gray-700"><?= htmlspecialchars($tugas['member']) ?></td>
                                    <td class="px-4 py-2 text-gray-700 capitalize"><?= $tugas['status'] ?></td>
                                    <td class="px-4 py-2 flex flex-wrap gap-2">
                                        <a href="ubah_status.php?id=<?= $tugas['id'] ?>&project_id=<?= $project_id ?>" 
                                           class="bg-gradient-to-r from-yellow-300 to-yellow-400 hover:from-yellow-400 hover:to-yellow-500 text-gray-800 px-3 py-1 rounded-md text-sm font-medium shadow transition">
                                           ✏️ Ubah
                                        </a>
                                        <a href="tugas_crud.php?project_id=<?= $project_id ?>&hapus_id=<?= $tugas['id'] ?>" 
                                           onclick="return confirm('Yakin ingin menghapus?')" 
                                           class="bg-gradient-to-r from-pink-400 to-red-400 hover:from-pink-500 hover:to-red-500 text-white px-3 py-1 rounded-md text-sm font-medium shadow transition">
                                           🗑️ Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-purple-700 mb-3">✨ Tambah Tugas Baru</h2>

            <form method="POST" class="space-y-4 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow border border-purple-100">
                <input type="hidden" name="project_id" value="<?= $project_id ?>">

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Tugas:</label>
                    <input type="text" name="nama_tugas" required 
                           class="w-full px-4 py-2 border border-purple-200 rounded-md bg-purple-50/40 focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Assign ke Team Member:</label>
                    <select name="assigned_to" required 
                            class="w-full px-4 py-2 border border-purple-200 rounded-md bg-purple-50/40 focus:outline-none focus:ring-2 focus:ring-purple-300">
                        <?php foreach ($team_members as $tm): ?>
                            <option value="<?= $tm['id'] ?>"><?= htmlspecialchars($tm['username']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" name="tambah" 
                        class="w-full bg-gradient-to-r from-pink-400 to-purple-400 hover:from-pink-500 hover:to-purple-500 text-white font-semibold px-4 py-2 rounded-md shadow-md transition">
                    ➕ Tambah Tugas
                </button>
            </form>

        </section>

    </main>

</body>
</html>