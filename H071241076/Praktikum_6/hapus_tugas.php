<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] != 'Project Manager') {
    $_SESSION['error'] = "Hanya Project Manager yang dapat menghapus tugas.";
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {

    $task_id_to_delete = $_GET['id'];
    $manager_id_session = $_SESSION['user_id'];

    $sql_check = "SELECT p.manager_id 
                  FROM tasks t 
                  JOIN projects p ON t.project_id = p.id 
                  WHERE t.id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $task_id_to_delete);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $task_project_info = mysqli_fetch_assoc($result_check);
    mysqli_stmt_close($stmt_check);

    if (!$task_project_info || $task_project_info['manager_id'] != $manager_id_session) {
        $_SESSION['error'] = "Anda tidak memiliki izin untuk menghapus tugas ini.";
        header("Location: kelola_tugas.php");
        exit();
    }

    $sql_delete = "DELETE FROM tasks WHERE id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    mysqli_stmt_bind_param($stmt_delete, "i", $task_id_to_delete);

    if (mysqli_stmt_execute($stmt_delete)) {
        $_SESSION['message'] = "Tugas berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus tugas: " . mysqli_stmt_error($stmt_delete);
    }

    mysqli_stmt_close($stmt_delete);
} else {
    $_SESSION['error'] = "ID tugas tidak disediakan.";
}

header("Location: kelola_tugas.php");
exit();
