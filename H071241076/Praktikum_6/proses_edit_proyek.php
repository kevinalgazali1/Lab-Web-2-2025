<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Hanya Project Manager yang dapat mengedit proyek.";

    if ($_SESSION['role'] == 'Super Admin') {
        header("Location: dashboard_admin.php");
    } elseif ($_SESSION['role'] == 'Team Member') {
        header("Location: dashboard_member.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $project_id = $_POST['project_id'];
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : NULL;
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;
    $manager_id = $_SESSION['user_id'];

    $sql_check = "SELECT manager_id FROM projects WHERE id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $project_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $project_to_edit = mysqli_fetch_assoc($result_check);
    mysqli_stmt_close($stmt_check);

    if (!$project_to_edit || $project_to_edit['manager_id'] != $manager_id) {
        $_SESSION['error'] = "Anda tidak memiliki izin untuk mengedit proyek ini atau proyek tidak ditemukan.";
        header("Location: proyek_saya.php");
        exit();
    }

    $sql_update = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param($stmt_update, "ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $manager_id);

    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['message'] = "Proyek berhasil di-update.";
    } else {
        $_SESSION['error'] = "Gagal meng-update proyek: " . mysqli_stmt_error($stmt_update);
    }

    mysqli_stmt_close($stmt_update);
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
}

header("Location: proyek_saya.php");
exit();
