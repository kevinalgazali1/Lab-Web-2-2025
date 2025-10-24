<?php
// Tambahkan ini untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'koneksi.php';

// Cek apakah user sudah login dan role super_admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: login.php");
    exit();
}

// Tambah Project Manager
if (isset($_POST['tambah_pm'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'project_manager';
    
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Project Manager berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Gagal menambah Project Manager";
    }
    mysqli_stmt_close($stmt);
}

// Tambah Team Member
if (isset($_POST['tambah_tm'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'team_member';
    $project_manager_id = $_POST['project_manager_id'];
    
    $sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $password, $role, $project_manager_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Team Member berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Gagal menambah Team Member";
    }
    mysqli_stmt_close($stmt);
}

// HAPUS USER - FIXED VERSION
if (isset($_GET['hapus_user'])) {
    $user_id_to_delete = $_GET['hapus_user'];
    
    // Jangan izinkan hapus diri sendiri
    if ($user_id_to_delete == $_SESSION['user_id']) {
        $_SESSION['error'] = "Tidak bisa menghapus akun sendiri!";
        header("Location: dashboard_super_admin.php");
        exit();
    }
    
    // 1. Cek role user yang akan dihapus
    $sql_check = "SELECT role FROM users WHERE id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $user_id_to_delete);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    
    if ($result_check && mysqli_num_rows($result_check) > 0) {
        $user_data = mysqli_fetch_assoc($result_check);
        $role = $user_data['role'];
        
        if ($role == 'project_manager') {
            // Jika Project Manager, handle proyek dan team member terlebih dahulu
            
            // a. Hapus semua tugas di proyek yang dimiliki manager ini
            $sql1 = "DELETE t FROM tasks t 
                    JOIN projects p ON t.project_id = p.id 
                    WHERE p.manager_id = ?";
            $stmt1 = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt1, "i", $user_id_to_delete);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);
            
            // b. Hapus semua proyek yang dimiliki manager ini
            $sql2 = "DELETE FROM projects WHERE manager_id = ?";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "i", $user_id_to_delete);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
            
            // c. Set team member menjadi tanpa manager (NULL)
            $sql3 = "UPDATE users SET project_manager_id = NULL WHERE project_manager_id = ?";
            $stmt3 = mysqli_prepare($conn, $sql3);
            mysqli_stmt_bind_param($stmt3, "i", $user_id_to_delete);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_close($stmt3);
            
        } elseif ($role == 'team_member') {
            // Jika Team Member, handle tugas yang ditugaskan
            $sql1 = "DELETE FROM tasks WHERE assigned_to = ?";
            $stmt1 = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt1, "i", $user_id_to_delete);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);
        }
        
        // 2. Baru hapus user dari tabel users
        $sql_final = "DELETE FROM users WHERE id = ?";
        $stmt_final = mysqli_prepare($conn, $sql_final);
        mysqli_stmt_bind_param($stmt_final, "i", $user_id_to_delete);
        
        if (mysqli_stmt_execute($stmt_final)) {
            $_SESSION['success'] = "User berhasil dihapus";
        } else {
            $_SESSION['error'] = "Gagal menghapus user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_final);
        
    } else {
        $_SESSION['error'] = "User tidak ditemukan";
    }
    
    mysqli_stmt_close($stmt_check);
    header("Location: dashboard_super_admin.php");
    exit();
}

// HAPUS PROYEK (untuk Super Admin) - FIXED VERSION
if (isset($_GET['hapus_proyek'])) {
    $proyek_id = $_GET['hapus_proyek'];
    
    // 1. Hapus tugas terkait
    $sql_tasks = "DELETE FROM tasks WHERE project_id = ?";
    $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
    mysqli_stmt_bind_param($stmt_tasks, "i", $proyek_id);
    mysqli_stmt_execute($stmt_tasks);
    mysqli_stmt_close($stmt_tasks);
    
    // 2. Hapus proyek
    $sql_project = "DELETE FROM projects WHERE id = ?";
    $stmt_project = mysqli_prepare($conn, $sql_project);
    mysqli_stmt_bind_param($stmt_project, "i", $proyek_id);
    
    if (mysqli_stmt_execute($stmt_project)) {
        $_SESSION['success'] = "Proyek berhasil dihapus";
    } else {
        $_SESSION['error'] = "Gagal menghapus proyek: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt_project);
    header("Location: dashboard_super_admin.php");
    exit();
}

// Ambil semua user
$users_result = mysqli_query($conn, "SELECT * FROM users");

// Ambil semua project
$projects_result = mysqli_query($conn, "SELECT p.*, u.username as manager_name FROM projects p JOIN users u ON p.manager_id = u.id");

// Ambil project managers untuk dropdown
$pm_result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'project_manager'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Manajemen Proyek</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Halo, <?php echo $_SESSION['username']; ?> (Super Admin)</span>
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
        <h2>Dashboard Super Admin</h2>
        
        <!-- Tambah Project Manager -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Tambah Project Manager</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="tambah_pm" class="btn btn-primary">Tambah Project Manager</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tambah Team Member -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Tambah Team Member</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="col-md-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col-md-3">
                            <select name="project_manager_id" class="form-control" required>
                                <option value="">Pilih Project Manager</option>
                                <?php while ($pm = mysqli_fetch_assoc($pm_result)): ?>
                                    <option value="<?php echo $pm['id']; ?>"><?php echo $pm['username']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="tambah_tm" class="btn btn-primary">Tambah Team Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar User -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Daftar Semua User</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Project Manager</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td>
                                    <?php 
                                    if ($user['project_manager_id']) {
                                        $pm_id = $user['project_manager_id'];
                                        $pm_query = mysqli_query($conn, "SELECT username FROM users WHERE id = $pm_id");
                                        $pm = mysqli_fetch_assoc($pm_query);
                                        echo $pm['username'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($user['role'] != 'super_admin'): ?>
                                        <a href="?hapus_user=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus user <?php echo $user['username']; ?>?')">Hapus</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Proyek -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Semua Proyek</h5>
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
                            <th>Manager</th>
                            <th>Aksi</th>
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
                                <td><?php echo $project['manager_name']; ?></td>
                                <td>
                                    <a href="?hapus_proyek=<?php echo $project['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus proyek <?php echo $project['nama_proyek']; ?>?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>