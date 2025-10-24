<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$id = $_GET['id'] ?? 0;
$manager_id = $_SESSION['user']['id'];

$query = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $id, $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$proyek = mysqli_fetch_assoc($result);

if (!$proyek) {
    die("Proyek tidak ditemukan atau akses ditolak");
}

$tanggal_selesai_lama = $proyek['tanggal_selesai'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_proyek = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    if (empty($nama_proyek) || empty($tanggal_mulai) || empty($tanggal_selesai)) {
        $message = "<p class='text-red-600 font-medium text-center bg-red-100 py-2 rounded-md'>Semua field wajib diisi!</p>";
    } elseif (strtotime($tanggal_selesai) < strtotime($tanggal_selesai_lama)) {
        $message = "<p class='text-red-600 font-medium text-center bg-red-100 py-2 rounded-md'>
                        Tanggal selesai tidak boleh lebih kecil dari tanggal sebelumnya.
                    </p>";
    } else {
        $update = "UPDATE projects 
                   SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ?
                   WHERE id = ? AND manager_id = ?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, "ssssii",
            $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $id, $manager_id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: manager_dashboard.php");
            exit();
        } else {
            $message = "<p class='text-red-600 font-medium text-center bg-red-100 py-2 rounded-md'>
                            Terjadi kesalahan: " . mysqli_error($conn) . "
                        </p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 via-pink-100 to-purple-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-full max-w-lg">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Proyek</h2>

        <a href="manager_dashboard.php"
           class="inline-block text-blue-600 hover:text-blue-800 transition font-medium mb-4">&larr; Kembali ke Dashboard</a>

        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" class="space-y-5 mt-4">

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nama Proyek:</label>
                <input type="text" name="nama_proyek"
                       value="<?= htmlspecialchars($proyek['nama_proyek']) ?>" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white/60">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Deskripsi:</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white/60"><?= htmlspecialchars($proyek['deskripsi']) ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai"
                           value="<?= $proyek['tanggal_mulai'] ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 bg-white/60">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tanggal Selesai:</label>
                    <input type="date" name="tanggal_selesai"
                           value="<?= $proyek['tanggal_selesai'] ?>" required
                           min="<?= $tanggal_selesai_lama ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 bg-white/60">
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-400 via-purple-400 to-blue-400 hover:opacity-90 text-white font-semibold px-4 py-2 rounded-lg transition transform hover:scale-105">
                Simpan Perubahan
            </button>
        </form>
    </div>

</body>
</html>