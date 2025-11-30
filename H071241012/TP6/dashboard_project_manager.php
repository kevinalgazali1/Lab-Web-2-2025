<?php
// Tambahkan ini untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'koneksi.php';

// Cek apakah user sudah login dan role project_manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'project_manager') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// TAMBAH PROYEK
if (isset($_POST['tambah_proyek'])) {
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    
    $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Proyek berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Gagal menambah proyek: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// EDIT PROYEK
if (isset($_POST['edit_proyek'])) {
    $proyek_id = $_POST['proyek_id'];
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    
    $sql = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $proyek_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Proyek berhasil diupdate";
    } else {
        $_SESSION['error'] = "Gagal mengupdate proyek: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// HAPUS PROYEK - FIXED VERSION
if (isset($_GET['hapus_proyek'])) {
    $proyek_id = $_GET['hapus_proyek'];
    
    // 1. Hapus semua tugas yang terkait dengan proyek ini terlebih dahulu
    $sql_delete_tasks = "DELETE FROM tasks WHERE project_id = ?";
    $stmt_tasks = mysqli_prepare($conn, $sql_delete_tasks);
    mysqli_stmt_bind_param($stmt_tasks, "i", $proyek_id);
    mysqli_stmt_execute($stmt_tasks);
    mysqli_stmt_close($stmt_tasks);
    
    // 2. Baru hapus proyeknya
    $sql_delete_project = "DELETE FROM projects WHERE id = ? AND manager_id = ?";
    $stmt_project = mysqli_prepare($conn, $sql_delete_project);
    mysqli_stmt_bind_param($stmt_project, "ii", $proyek_id, $user_id);
    
    if (mysqli_stmt_execute($stmt_project)) {
        $_SESSION['success'] = "Proyek berhasil dihapus";
    } else {
        $_SESSION['error'] = "Gagal menghapus proyek: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt_project);
    header("Location: dashboard_project_manager.php");
    exit();
}

// TAMBAH TUGAS
if (isset($_POST['tambah_tugas'])) {
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];
    
    $sql = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Tugas berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Gagal menambah tugas: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// EDIT TUGAS
if (isset($_POST['edit_tugas'])) {
    $tugas_id = $_POST['tugas_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];
    $status = $_POST['status'];
    
    $sql = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, project_id = ?, assigned_to = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiisi", $nama_tugas, $deskripsi, $project_id, $assigned_to, $status, $tugas_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Tugas berhasil diupdate";
    } else {
        $_SESSION['error'] = "Gagal mengupdate tugas: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// UPDATE STATUS TUGAS
if (isset($_POST['update_status'])) {
    $tugas_id = $_POST['tugas_id'];
    $status = $_POST['status'];
    
    $sql = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $tugas_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Status tugas berhasil diupdate";
    } else {
        $_SESSION['error'] = "Gagal mengupdate status tugas: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// HAPUS TUGAS - FIXED VERSION
if (isset($_GET['hapus_tugas'])) {
    $tugas_id = $_GET['hapus_tugas'];
    
    // Pastikan tugas ini milik proyek yang dimiliki project manager ini
    $sql_check = "SELECT t.id FROM tasks t 
                 JOIN projects p ON t.project_id = p.id 
                 WHERE t.id = ? AND p.manager_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $tugas_id, $user_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($result_check) > 0) {
        // Tugas valid, bisa dihapus
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $tugas_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Tugas berhasil dihapus";
        } else {
            $_SESSION['error'] = "Gagal menghapus tugas: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Tugas tidak ditemukan atau tidak ada akses";
    }
    
    mysqli_stmt_close($stmt_check);
    header("Location: dashboard_project_manager.php");
    exit();
}

// Ambil data untuk ditampilkan
$projects_result = mysqli_query($conn, "SELECT * FROM projects WHERE manager_id = $user_id");
$tasks_result = mysqli_query($conn, "SELECT t.*, p.nama_proyek, u.username as assigned_name FROM tasks t 
                                    JOIN projects p ON t.project_id = p.id 
                                    JOIN users u ON t.assigned_to = u.id 
                                    WHERE p.manager_id = $user_id");
$team_members_result = mysqli_query($conn, "SELECT * FROM users WHERE project_manager_id = $user_id");

// Ambil data untuk form edit (jika ada)
$edit_proyek = null;
if (isset($_GET['edit_proyek'])) {
    $edit_id = $_GET['edit_proyek'];
    $edit_result = mysqli_query($conn, "SELECT * FROM projects WHERE id = $edit_id AND manager_id = $user_id");
    $edit_proyek = mysqli_fetch_assoc($edit_result);
}

$edit_tugas = null;
if (isset($_GET['edit_tugas'])) {
    $edit_id = $_GET['edit_tugas'];
    $edit_result = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $edit_id");
    $edit_tugas = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Project Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .badge {
            font-size: 0.8em;
        }
        .table th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Manajemen Proyek</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Halo, <?php echo $_SESSION['username']; ?> (Project Manager)</span>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Tampilkan pesan sukses/error -->
    <div class="container mt-3">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <div class="container mt-4">
        <h2>Dashboard Project Manager</h2>
        
        <!-- FORM TAMBAH/EDIT PROYEK -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><?php echo $edit_proyek ? 'Edit Proyek' : 'Tambah Proyek'; ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <?php if ($edit_proyek): ?>
                        <input type="hidden" name="proyek_id" value="<?php echo $edit_proyek['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="nama_proyek" class="form-control" placeholder="Nama Proyek" 
                                   value="<?php echo $edit_proyek ? $edit_proyek['nama_proyek'] : ''; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi"
                                   value="<?php echo $edit_proyek ? $edit_proyek['deskripsi'] : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="tanggal_mulai" class="form-control" 
                                   value="<?php echo $edit_proyek ? $edit_proyek['tanggal_mulai'] : ''; ?>" required>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="tanggal_selesai" class="form-control"
                                   value="<?php echo $edit_proyek ? $edit_proyek['tanggal_selesai'] : ''; ?>" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="<?php echo $edit_proyek ? 'edit_proyek' : 'tambah_proyek'; ?>" 
                                    class="btn btn-<?php echo $edit_proyek ? 'warning' : 'primary'; ?> w-100">
                                <?php echo $edit_proyek ? 'Update Proyek' : 'Tambah Proyek'; ?>
                            </button>
                            <?php if ($edit_proyek): ?>
                                <a href="dashboard_project_manager.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- DAFTAR PROYEK -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Daftar Proyek Saya</h5>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($projects_result) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Proyek</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Reset pointer resultset
                            mysqli_data_seek($projects_result, 0);
                            while ($project = mysqli_fetch_assoc($projects_result)): ?>
                                <tr>
                                    <td><?php echo $project['id']; ?></td>
                                    <td><?php echo $project['nama_proyek']; ?></td>
                                    <td><?php echo $project['deskripsi']; ?></td>
                                    <td><?php echo $project['tanggal_mulai']; ?></td>
                                    <td><?php echo $project['tanggal_selesai']; ?></td>
                                    <td>
                                        <a href="?edit_proyek=<?php echo $project['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?hapus_proyek=<?php echo $project['id']; ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin hapus proyek <?php echo $project['nama_proyek']; ?>?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Belum ada proyek. Silakan tambah proyek baru.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- FORM TAMBAH/EDIT TUGAS -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><?php echo $edit_tugas ? 'Edit Tugas' : 'Tambah Tugas'; ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <?php if ($edit_tugas): ?>
                        <input type="hidden" name="tugas_id" value="<?php echo $edit_tugas['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" name="nama_tugas" class="form-control" placeholder="Nama Tugas" 
                                   value="<?php echo $edit_tugas ? $edit_tugas['nama_tugas'] : ''; ?>" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi"
                                   value="<?php echo $edit_tugas ? $edit_tugas['deskripsi'] : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="project_id" class="form-control" required>
                                <option value="">Pilih Proyek</option>
                                <?php 
                                mysqli_data_seek($projects_result, 0);
                                while ($project = mysqli_fetch_assoc($projects_result)): ?>
                                    <option value="<?php echo $project['id']; ?>" 
                                        <?php echo ($edit_tugas && $edit_tugas['project_id'] == $project['id']) ? 'selected' : ''; ?>>
                                        <?php echo $project['nama_proyek']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="assigned_to" class="form-control" required>
                                <option value="">Pilih Team Member</option>
                                <?php 
                                mysqli_data_seek($team_members_result, 0);
                                while ($tm = mysqli_fetch_assoc($team_members_result)): ?>
                                    <option value="<?php echo $tm['id']; ?>"
                                        <?php echo ($edit_tugas && $edit_tugas['assigned_to'] == $tm['id']) ? 'selected' : ''; ?>>
                                        <?php echo $tm['username']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <?php if ($edit_tugas): ?>
                            <div class="col-md-2">
                                <select name="status" class="form-control" required>
                                    <option value="belum" <?php echo ($edit_tugas['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                                    <option value="proses" <?php echo ($edit_tugas['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                    <option value="selesai" <?php echo ($edit_tugas['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-2">
                            <button type="submit" name="<?php echo $edit_tugas ? 'edit_tugas' : 'tambah_tugas'; ?>" 
                                    class="btn btn-<?php echo $edit_tugas ? 'warning' : 'primary'; ?> w-100">
                                <?php echo $edit_tugas ? 'Update Tugas' : 'Tambah Tugas'; ?>
                            </button>
                            <?php if ($edit_tugas): ?>
                                <a href="dashboard_project_manager.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- DAFTAR TUGAS -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Tugas</h5>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($tasks_result) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Tugas</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Proyek</th>
                                <th>Ditugaskan ke</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($tasks_result, 0);
                            while ($task = mysqli_fetch_assoc($tasks_result)): ?>
                                <tr>
                                    <td><?php echo $task['id']; ?></td>
                                    <td><?php echo $task['nama_tugas']; ?></td>
                                    <td><?php echo $task['deskripsi']; ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php 
                                            if ($task['status'] == 'selesai') echo 'bg-success';
                                            elseif ($task['status'] == 'proses') echo 'bg-warning';
                                            else echo 'bg-secondary';
                                            ?>">
                                            <?php echo $task['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $task['nama_proyek']; ?></td>
                                    <td><?php echo $task['assigned_name']; ?></td>
                                    <td>
                                        <a href="?edit_tugas=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?hapus_tugas=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin hapus tugas <?php echo $task['nama_tugas']; ?>?')">Hapus</a>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $task['id']; ?>">
                                            Ubah Status
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- MODAL UBAH STATUS -->
                                <div class="modal fade" id="statusModal<?php echo $task['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ubah Status Tugas</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="tugas_id" value="<?php echo $task['id']; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tugas: <strong><?php echo $task['nama_tugas']; ?></strong></label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="belum" <?php echo $task['status'] == 'belum' ? 'selected' : ''; ?>>Belum</option>
                                                            <option value="proses" <?php echo $task['status'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                                                            <option value="selesai" <?php echo $task['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="update_status" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Belum ada tugas. Silakan tambah tugas baru.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>