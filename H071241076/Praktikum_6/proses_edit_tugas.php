<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Hanya Project Manager yang dapat mengedit tugas.";

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

    $task_id = $_POST['task_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : NULL;
    $assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : NULL;
    $manager_id_session = $_SESSION['user_id'];

    $sql_check = "SELECT p.manager_id FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $task_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $task_to_edit = mysqli_fetch_assoc($result_check);
    mysqli_stmt_close($stmt_check);

    if (!$task_to_edit || $task_to_edit['manager_id'] != $manager_id_session) {
        $_SESSION['error'] = "Anda tidak memiliki izin untuk mengedit tugas ini.";
        header("Location: kelola_tugas.php");
        exit();
    }

    $sql_update = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, assigned_to = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param($stmt_update, "ssii", $nama_tugas, $deskripsi, $assigned_to, $task_id);

    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['message'] = "Tugas berhasil di-update.";
    } else {
        $_SESSION['error'] = "Gagal meng-update tugas: " . mysqli_stmt_error($stmt_update);
    }

    mysqli_stmt_close($stmt_update);
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
}

header("Location: kelola_tugas.php");
exit();
