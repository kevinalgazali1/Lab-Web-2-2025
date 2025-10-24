<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Hanya Project Manager yang dapat membuat proyek.";

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

    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : NULL;
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;
    $manager_id = $_SESSION['user_id'];

    $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Proyek baru berhasil dibuat.";
    } else {
        $_SESSION['error'] = "Gagal membuat proyek: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
}

header("Location: proyek_saya.php");
exit();
