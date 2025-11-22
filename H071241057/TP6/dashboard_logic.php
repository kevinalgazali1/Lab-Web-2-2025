<?php
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role'];
    $pm_id_to_bind = null; 
    if ($role === 'member' && !empty($_POST['pm_id'])) {
        $pm_id_to_bind = intval($_POST['pm_id']);
    } else if ($role === 'member' && empty($_POST['pm_id'])) {
        $_SESSION['error tambah user'] = "Project Manager ID harus diisi untuk role member.";
        header("Location: dashboard.php#form-tambah-pengguna");
        exit();
    }

    $sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $password, $role, $pm_id_to_bind);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-pengguna");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete'])) {
    $delete_id = intval($_POST['delete_id']);

    if ($delete_id === $logged_in_id) {
        $_SESSION['error tambah user'] = "Anda tidak dapat menghapus diri sendiri.";
        header("Location: dashboard.php#tabel-pengguna");
        exit();
    }

    $sql_check = "SELECT COUNT(*) AS total_members FROM users WHERE project_manager_id = ?";
    $stmt = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $total_members = $row['total_members'];

    $sql_check_projects = "SELECT COUNT(*) AS total_projects FROM projects WHERE manager_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check_projects);
    mysqli_stmt_bind_param($stmt_check, "i", $delete_id);
    mysqli_stmt_execute($stmt_check);
    $resul_projects = mysqli_stmt_get_result($stmt_check);
    $row_projects = mysqli_fetch_assoc($resul_projects);
    $total_projects = $row_projects['total_projects'];

    if ($total_members > 0 || $total_projects > 0) {
        $error_message = "Tidak dapat menghapus pengguna karena masih memiliki ";
        if ($total_members > 0) {
            $error_message .= "$total_members anggota yang ditugaskan";
        }
        if ($total_projects > 0) {
            if ($total_members > 0) {
                $error_message .= " dan ";
            }
            $error_message .= "$total_projects proyek yang masih ada";
        }
        $_SESSION['error_hapus_user'] = $error_message;
        header("Location: dashboard.php#tabel-pengguna");
        exit();
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-pengguna");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['tambah-proyek'])) {
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $pm_id = $_POST['pm_id'];

    $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $pm_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-proyek");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['update-proyek'])) {
    $project_id = intval($_POST['project_id']);
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $pm_id = intval($_POST['pm_id']);

    if ($logged_in_role === 'project manager') {
        $pm_id = $logged_in_id;
    }

    $sql = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ?, manager_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $pm_id, $project_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-proyek");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['hapus-proyek'])) {
    $delete_project_id = intval($_POST['delete_project_id']);

    $sql_check_tasks = "SELECT COUNT(*) as total FROM tasks WHERE project_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check_tasks);
    mysqli_stmt_bind_param($stmt_check, "i", $delete_project_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $row_tasks = mysqli_fetch_assoc($result_check);
    $total_tasks = $row_tasks['total'];

    if ($total_tasks > 0) {
        $_SESSION['error_hapus_proyek'] = "Tidak dapat menghapus proyek karena masih memiliki $total_tasks tugas.";
        header("Location: dashboard.php#tabel-proyek");
        exit();
    }

    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $delete_project_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-proyek");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['tambah-tugas'])) {
    $nama_tugas = $_POST['nama_tugas'];
    $status = $_POST['status'];
    $project_id = intval($_POST['project_id']);
    $assigned_to = intval($_POST['assigned_to']);

    $sql = "SELECT id FROM projects WHERE id = ? AND manager_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $project_id, $logged_in_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error tambah tugas'] = "Error: Proyek tidak ditemukan atau Anda tidak memiliki izin.";
        header("Location: dashboard.php#form-tambah-tugas");
        exit();
    }

    $sql = "SELECT id FROM users WHERE project_manager_id = ? AND id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $logged_in_id, $assigned_to);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error tambah tugas'] = "Error: Pengguna tidak ditemukan atau bukan anggota tim Anda.";
        header("Location: dashboard.php#form-tambah-tugas");
        exit();
    }

    $sql = "INSERT INTO tasks (nama_tugas, status, project_id, assigned_to) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $nama_tugas, $status, $project_id, $assigned_to);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-tugas");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['update-tugas'])) {
    $task_id = intval($_POST['task_id']);
    $nama_tugas = $_POST['nama_tugas'];
    $status = $_POST['status'];
    $project_id = intval($_POST['project_id']);
    $assigned_to = intval($_POST['assigned_to']);

    $sql_check_proj = "SELECT id FROM projects WHERE id = ? AND manager_id = ?";
    $stmt_check_proj = mysqli_prepare($conn, $sql_check_proj);
    mysqli_stmt_bind_param($stmt_check_proj, "ii", $project_id, $logged_in_id);
    mysqli_stmt_execute($stmt_check_proj);
    if (mysqli_num_rows(mysqli_stmt_get_result($stmt_check_proj)) == 0) {
        $_SESSION['error_update_tugas'] = "Error: Proyek tidak valid atau bukan milik Anda.";
        header("Location: dashboard.php#tabel-tugas");
        exit();
    }

    $sql_check_user = "SELECT id FROM users WHERE project_manager_id = ? AND id = ?";
    $stmt_check_user = mysqli_prepare($conn, $sql_check_user);
    mysqli_stmt_bind_param($stmt_check_user, "ii", $logged_in_id, $assigned_to);
    mysqli_stmt_execute($stmt_check_user);
    if (mysqli_num_rows(mysqli_stmt_get_result($stmt_check_user)) == 0) {
        $_SESSION['error_update_tugas'] = "Error: Pengguna tidak valid atau bukan anggota tim Anda.";
        header("Location: dashboard.php#tabel-tugas");
        exit();
    }

    $sql = "UPDATE tasks SET nama_tugas = ?, status = ?, project_id = ?, assigned_to = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiii", $nama_tugas, $status, $project_id, $assigned_to, $task_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-tugas");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['hapus-tugas'])) {
    $task_id_to_delete = intval($_POST['task_id_to_delete']);

    $sql = "DELETE FROM tasks WHERE id = ? AND project_id IN (SELECT id FROM projects WHERE manager_id = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $task_id_to_delete, $logged_in_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-tugas");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['update_status'])) {
    $task_id = intval($_POST['task_id']);
    $new_status = $_POST['new_status'];

    $sql = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $task_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php#tabel-tugas");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>