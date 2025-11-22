<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Hanya Project Manager yang dapat membuat tugas.";
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $project_id = $_POST['project_id'];
    $assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : NULL;
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : NULL;

    $default_status = 'belum';

    $manager_id_session = $_SESSION['user_id'];
    $sql_check = "SELECT manager_id FROM projects WHERE id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $project_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $project_data = mysqli_fetch_assoc($result_check);
    mysqli_stmt_close($stmt_check);

    if (!$project_data || $project_data['manager_id'] != $manager_id_session) {
        $_SESSION['error'] = "Anda tidak memiliki izin untuk menambah tugas ke proyek ini.";
        header("Location: kelola_tugas.php");
        exit();
    }

    $sql = "INSERT INTO tasks (project_id, assigned_to, nama_tugas, deskripsi, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iissi", $project_id, $assigned_to, $nama_tugas, $deskripsi, $default_status);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Tugas baru berhasil dibuat dan ditugaskan.";
    } else {
        $_SESSION['error'] = "Gagal membuat tugas: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
}

header("Location: kelola_tugas.php");
exit();
