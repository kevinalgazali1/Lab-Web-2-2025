<?php  
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Team Member') {
    die("Akses ditolak");
}

$id_member = $_SESSION['user']['id'];

// === AMBIL DAFTAR PROYEK YANG TERKAIT DENGAN TEAM MEMBER + NAMA MANAGER ===
$sql_proyek = "SELECT DISTINCT 
                    p.id, 
                    p.nama_proyek, 
                    p.deskripsi, 
                    p.tanggal_mulai, 
                    p.tanggal_selesai,
                    u.username AS nama_manager
               FROM projects p
               JOIN users u ON p.manager_id = u.id
               JOIN tasks t ON t.project_id = p.id
               WHERE t.assigned_to = ?";
$stmt_proyek = mysqli_prepare($conn, $sql_proyek);
mysqli_stmt_bind_param($stmt_proyek, "i", $id_member);
mysqli_stmt_execute($stmt_proyek);
$result_proyek = mysqli_stmt_get_result($stmt_proyek);

$projects = [];
while ($row = mysqli_fetch_assoc($result_proyek)) {
    $projects[] = $row;
}

// === AMBIL DAFTAR TUGAS ===
$sql_tugas = "SELECT 
                    t.id, 
                    t.nama_tugas, 
                    t.status, 
                    p.nama_proyek 
              FROM tasks t
              JOIN projects p ON t.project_id = p.id
              WHERE t.assigned_to = ?";
$stmt_tugas = mysqli_prepare($conn, $sql_tugas);
mysqli_stmt_bind_param($stmt_tugas, "i", $id_member);
mysqli_stmt_execute($stmt_tugas);
$result_tugas = mysqli_stmt_get_result($stmt_tugas);

$tasks = [];
while ($row = mysqli_fetch_assoc($result_tugas)) {
    $tasks[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Team Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 font-[Poppins] min-h-screen">

    <!-- HEADER -->
    <header class="w-full bg-gradient-to-r from-indigo-400 to-blue-300 text-white p-4 sm:p-6 
                   flex justify-between items-center shadow-md rounded-b-2xl">
        <h1 class="text-2xl sm:text-3xl font-bold">Dashboard Team Member</h1>
        <a href="logout.php" 
           class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-md shadow-sm text-base sm:text-lg transition">
            Logout
        </a>
    </header>

    <main class="w-full p-4 sm:p-6 space-y-10 max-w-6xl mx-auto">

        <!-- === DAFTAR PROYEK === -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-indigo-300 pb-2">
                Daftar Proyek Kamu
            </h2>

            <?php if (empty($projects)) : ?>
                <p class="text-gray-600 text-center text-lg sm:text-xl italic">
                    Kamu belum tergabung dalam proyek manapun.
                </p>
            <?php else : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($projects as $proyek) : ?>
                        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-md p-5 border border-indigo-100 hover:shadow-xl transition">
                            <h3 class="text-lg sm:text-xl font-semibold text-indigo-600 mb-2">
                                <?= htmlspecialchars($proyek['nama_proyek']) ?>
                            </h3>

                            <p class="text-sm text-gray-600 mb-2">
                                <?= htmlspecialchars($proyek['deskripsi']) ?: 'Tidak ada deskripsi.' ?>
                            </p>

                            <p class="text-sm text-gray-700 mb-1">
                                <strong>Manager:</strong> <?= htmlspecialchars($proyek['nama_manager']) ?>
                            </p>

                            <p class="text-xs text-gray-500">
                                <strong>Mulai:</strong> <?= htmlspecialchars($proyek['tanggal_mulai']) ?><br>
                                <strong>Selesai:</strong> <?= htmlspecialchars($proyek['tanggal_selesai']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- === DAFTAR TUGAS === -->
        <section class="space-y-4">
            <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-indigo-300 pb-2">
                Daftar Tugas Kamu
            </h2>

            <?php if (empty($tasks)) : ?>
                <p class="text-gray-600 text-center text-lg sm:text-xl italic">
                    Belum ada tugas yang ditugaskan.
                </p>
            <?php else : ?>
                <?php foreach ($tasks as $tugas) : ?>
                    <div class="bg-white/80 backdrop-blur-md rounded-xl shadow p-5 flex justify-between items-center 
                                hover:shadow-lg transition border border-gray-100">
                        
                        <div>
                            <p class="font-semibold text-gray-800 text-lg sm:text-xl">
                                <?= htmlspecialchars($tugas['nama_tugas']) ?>
                            </p>
                            <p class="text-sm sm:text-base text-gray-500 italic">
                                <?= htmlspecialchars($tugas['nama_proyek']) ?>
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <?php
                                $warna = '';
                                if ($tugas['status'] === 'belum') {
                                    $warna = 'bg-pink-200 text-pink-800';
                                } elseif ($tugas['status'] === 'proses') {
                                    $warna = 'bg-yellow-200 text-yellow-800';
                                } elseif ($tugas['status'] === 'selesai') {
                                    $warna = 'bg-green-200 text-green-800';
                                }
                            ?>
                            <span class="px-3 py-1 text-sm sm:text-base rounded-full font-medium <?= $warna ?>">
                                <?= ucfirst($tugas['status']) ?>
                            </span>

                            <a href="ubah_status.php?id=<?= $tugas['id'] ?>" 
                               class="bg-blue-300 hover:bg-blue-400 text-white px-4 py-2 rounded-md text-base sm:text-lg transition shadow-sm">
                                Ubah Status
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

    </main>
</body>
</html>