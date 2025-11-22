<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Team Member') {
    $_SESSION['error'] = "Hanya Team Member yang dapat mengupdate status tugas.";

    if ($_SESSION['role'] == 'Super Admin') {
        header("Location: dashboard_admin.php");
    } elseif ($_SESSION['role'] == 'Project Manager') {
        header("Location: dashboard_manager.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $task_id = $_POST['task_id'];
    $new_status = $_POST['status'];
    $member_id = $_SESSION['user_id'];

    $possible_statuses = ['belum', 'proses', 'selesai'];
    if (!in_array($new_status, $possible_statuses)) {
        $_SESSION['error'] = "Status tidak valid.";
        header("Location: tugas_saya.php");
        exit();
    }

    $sql_check = "SELECT assigned_to FROM tasks WHERE id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $task_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $task_to_update = mysqli_fetch_assoc($result_check);
    mysqli_stmt_close($stmt_check);

    if (!$task_to_update || $task_to_update['assigned_to'] != $member_id) {
        $_SESSION['error'] = "Anda tidak memiliki izin untuk mengupdate tugas ini atau tugas tidak ditemukan.";
        header("Location: tugas_saya.php");
        exit();
    }

    $sql_update = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param($stmt_update, "sii", $new_status, $task_id, $member_id);

    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['message'] = "Status tugas berhasil di-update.";
    } else {
        $_SESSION['error'] = "Gagal meng-update status tugas: " . mysqli_stmt_error($stmt_update);
    }

    mysqli_stmt_close($stmt_update);
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
}

header("Location: tugas_saya.php");
exit();
