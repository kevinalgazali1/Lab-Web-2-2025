<?php
session_start();
require 'koneksi.php';

// Cek apakah user sudah login dan role team_member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'team_member') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Update status tugas
if (isset($_POST['update_status'])) {
    $tugas_id = $_POST['tugas_id'];
    $status = $_POST['status'];
    
    $sql = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $status, $tugas_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Ambil proyek yang melibatkan team member ini
$projects_result = mysqli_query($conn, "SELECT DISTINCT p.* FROM projects p 
                                      JOIN tasks t ON p.id = t.project_id 
                                      WHERE t.assigned_to = $user_id");

// Ambil tugas yang ditugaskan ke team member ini
$tasks_result = mysqli_query($conn, "SELECT t.*, p.nama_proyek FROM tasks t 
                                   JOIN projects p ON t.project_id = p.id 
                                   WHERE t.assigned_to = $user_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Team Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Manajemen Proyek</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Halo, <?php echo $_SESSION['username']; ?> (Team Member)</span>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Dashboard Team Member</h2>
        
        <!-- Daftar Proyek -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Proyek yang Saya Ikuti</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Proyek</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                            <tr>
                                <td><?php echo $project['id']; ?></td>
                                <td><?php echo $project['nama_proyek']; ?></td>
                                <td><?php echo $project['deskripsi']; ?></td>
                                <td><?php echo $project['tanggal_mulai']; ?></td>
                                <td><?php echo $project['tanggal_selesai']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Tugas -->
        <div class="card">
            <div class="card-header">
                <h5>Tugas Saya</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Tugas</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Proyek</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($task = mysqli_fetch_assoc($tasks_result)): ?>
                            <tr>
                                <td><?php echo $task['id']; ?></td>
                                <td><?php echo $task['nama_tugas']; ?></td>
                                <td><?php echo $task['deskripsi']; ?></td>
                                <td><?php echo $task['status']; ?></td>
                                <td><?php echo $task['nama_proyek']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $task['id']; ?>">
                                        Ubah Status
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal Ubah Status -->
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
                                                    <label class="form-label">Status Saat Ini: <?php echo $task['status']; ?></label>
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>