<?php
session_start();
require 'koneksi.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$current_role = $_SESSION['role'];
$is_admin = ($current_role == 'Super Admin');
$is_manager = ($current_role == 'Project Manager');

if (!$is_admin && !$is_manager) {
    $_SESSION['error'] = "Anda tidak memiliki izin untuk menghapus proyek.";
    header("Location: index.php");
    exit();
}


if (isset($_GET['id'])) {

    $project_id_to_delete = $_GET['id'];
    $current_user_id = $_SESSION['user_id'];

    if ($is_manager) {
        $sql_check = "SELECT manager_id FROM projects WHERE id = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $project_id_to_delete);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        $project_info = mysqli_fetch_assoc($result_check);
        mysqli_stmt_close($stmt_check);

        if (!$project_info || $project_info['manager_id'] != $current_user_id) {
            $_SESSION['error'] = "Anda hanya dapat menghapus proyek Anda sendiri.";
            header("Location: proyek_saya.php");
            exit();
        }
    }

    $sql_delete = "DELETE FROM projects WHERE id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    mysqli_stmt_bind_param($stmt_delete, "i", $project_id_to_delete);

    if (mysqli_stmt_execute($stmt_delete)) {
        $_SESSION['message'] = "Proyek berhasil dihapus (bersama semua tugas di dalamnya).";
    } else {
        $_SESSION['error'] = "Gagal menghapus proyek: " . mysqli_stmt_error($stmt_delete);
    }

    mysqli_stmt_close($stmt_delete);
} else {
    $_SESSION['error'] = "ID proyek tidak disediakan.";
}

$redirect_page = ($is_manager) ? 'proyek_saya.php' : 'kelola_proyek.php';

header("Location: " . $redirect_page);
exit();
