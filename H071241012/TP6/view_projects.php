<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Query berbeda berdasarkan role
if ($role == 'super_admin') {
    $sql = "SELECT p.*, u.username as manager_name FROM projects p JOIN users u ON p.manager_id = u.id";
} elseif ($role == 'project_manager') {
    $sql = "SELECT * FROM projects WHERE manager_id = $user_id";
} elseif ($role == 'team_member') {
    $sql = "SELECT DISTINCT p.* FROM projects p JOIN tasks t ON p.id = t.project_id WHERE t.assigned_to = $user_id";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Proyek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Daftar Proyek</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Proyek</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <?php if ($role == 'super_admin'): ?>
                        <th>Manager</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($project = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $project['id']; ?></td>
                        <td><?php echo $project['nama_proyek']; ?></td>
                        <td><?php echo $project['deskripsi']; ?></td>
                        <td><?php echo $project['tanggal_mulai']; ?></td>
                        <td><?php echo $project['tanggal_selesai']; ?></td>
                        <?php if ($role == 'super_admin'): ?>
                            <td><?php echo $project['manager_name']; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>