<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user']['username'])) {
    header('Location: login.php');
    exit();
}

$logged_in_user = $_SESSION['user']['username'];
$logged_in_role = $_SESSION['user']['role'];
$logged_in_id = $_SESSION['user']['id'];

require 'dashboard_logic.php';

$pm_list = [];
$my_projects = [];
$my_team = [];
$projects_member = []; 
$tasks_member = [];  

if ($logged_in_role === 'super admin') {
    $sql_pm_list = "SELECT id, username FROM users WHERE role = 'project manager'";
    $result_pm_list = mysqli_query($conn, $sql_pm_list);
    $pm_list = mysqli_fetch_all($result_pm_list, MYSQLI_ASSOC);
}

if ($logged_in_role === 'project manager') {
    $sql_projects = "SELECT * FROM projects WHERE manager_id = ?";
    $stmt_projects = mysqli_prepare($conn, $sql_projects);
    mysqli_stmt_bind_param($stmt_projects, "i", $logged_in_id);
    mysqli_stmt_execute($stmt_projects);
    $result_projects = mysqli_stmt_get_result($stmt_projects);
    $my_projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);

    $sql_members = "SELECT id, username FROM users WHERE project_manager_id = ?";
    $stmt_members = mysqli_prepare($conn, $sql_members);
    mysqli_stmt_bind_param($stmt_members, "i", $logged_in_id);
    mysqli_stmt_execute($stmt_members);
    $result_members = mysqli_stmt_get_result($stmt_members);
    $my_team = mysqli_fetch_all($result_members, MYSQLI_ASSOC);
} elseif ($logged_in_role === 'member') {
    $sql_tasks = "SELECT * FROM tasks WHERE assigned_to = ?";
    $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
    mysqli_stmt_bind_param($stmt_tasks, "i", $logged_in_id);
    mysqli_stmt_execute($stmt_tasks);
    $result_tasks = mysqli_stmt_get_result($stmt_tasks);
    $tasks_member = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    if (!empty($tasks_member)) {
        $project_ids = [];
        foreach ($tasks_member as $task) {
            $project_ids[] = $task['project_id'];
        }
        $unique_project_ids = array_unique($project_ids);
        if (!empty($unique_project_ids)) {
            $in_clause = implode(',', $unique_project_ids);

            $sql_projects = "SELECT * FROM projects WHERE id IN ($in_clause)";
            $result_projects = mysqli_query($conn, $sql_projects);
            $projects_member = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Dashboard</h1>
                <div class="user-info">
                    <?= htmlspecialchars($logged_in_user); ?> (<?= htmlspecialchars($logged_in_role); ?>)
                </div>
            </div>
            <a href="logout.php">Logout</a>
        </div>

        <?php if ($logged_in_role === 'super admin') : ?>

            <div class="card welcome-card">
                <div class="welcome-header">
                    <h2>👋 Selamat Datang, <?= htmlspecialchars($logged_in_user); ?>!</h2>
                    <p class="welcome-subtitle">    </p>
                </div>
            </div>

            <div class="card" id="form-tambah-pengguna">
                <h2>Tambah Pengguna</h2>
                <form action="dashboard.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="super admin">Admin</option>
                            <option value="project manager">Project Manager</option>
                            <option value="member">Member</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pm_id">Project Manager</label>
                        <select id="pm_id" name="pm_id">
                            <option value="">-- Pilih PM (untuk member) --</option>
                            <?php foreach ($pm_list as $pm) : ?>
                                <option value="<?= $pm['id']; ?>">
                                    <?= htmlspecialchars($pm['username']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" name="tambah">Tambah Pengguna</button>
                </form>

                <?php
                    if (isset($_SESSION['error tambah user'])) {
                        echo '<p class="error-message">' . $_SESSION['error tambah user'] . '</p>';
                        unset($_SESSION['error tambah user']);
                    }
                    if (isset($_SESSION['error_hapus_user'])) {
                        echo '<p class="error-message">' . $_SESSION['error_hapus_user'] . '</p>';
                        unset($_SESSION['error_hapus_user']);
                    }
                ?>
            </div>

            <div class="card" id="tabel-pengguna">
                <h2>Data Semua Pengguna</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>PM ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM users";
                            $result = mysqli_query($conn, $sql);
                            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            foreach ($users as $user) :
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']); ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><?= htmlspecialchars($user['role']); ?></td>
                                <td><?= htmlspecialchars($user['project_manager_id']); ?></td>
                                <td>
                                    <form action="dashboard.php" method="POST" onsubmit="return confirm('Yakin hapus pengguna ini?');" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($user['id']); ?>">
                                        <button type="submit" name="delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php
            $project_to_edit = null;
            if (isset($_GET['edit_project_id']) && $logged_in_role === 'super admin') {
                $edit_project_id = intval($_GET['edit_project_id']);
                $sql_edit_proj = "SELECT * FROM projects WHERE id = ?";
                $stmt_edit_proj = mysqli_prepare($conn, $sql_edit_proj);
                mysqli_stmt_bind_param($stmt_edit_proj, "i", $edit_project_id);
                mysqli_stmt_execute($stmt_edit_proj);
                $result_edit_proj = mysqli_stmt_get_result($stmt_edit_proj);
                if (mysqli_num_rows($result_edit_proj) > 0) {
                    $project_to_edit = mysqli_fetch_assoc($result_edit_proj);
                }
            }

            if ($project_to_edit) :
            ?>
                <div class="card" id="form-edit-proyek">
                    <div class="edit-form">
                        <h2>Edit Proyek (ID: <?= $project_to_edit['id'] ?>)</h2>
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="project_id" value="<?= $project_to_edit['id'] ?>">
                            
                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="text" name="nama_proyek" value="<?= htmlspecialchars($project_to_edit['nama_proyek']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($project_to_edit['tanggal_mulai']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($project_to_edit['tanggal_selesai']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Project Manager</label>
                                <select name="pm_id" required>
                                    <?php foreach ($pm_list as $pm) : ?>
                                        <option value="<?= $pm['id']; ?>" <?= ($pm['id'] == $project_to_edit['manager_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($pm['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" required><?= htmlspecialchars($project_to_edit['deskripsi']) ?></textarea>
                            </div>

                            <button type="submit" name="update-proyek">Update Proyek</button>
                            <a href="dashboard.php#tabel-proyek">Batal</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card" id="tabel-proyek">
                <h2>Data Proyek</h2>
                <?php
                    if (isset($_SESSION['error_hapus_proyek'])) {
                        echo '<p class="error-message">' . $_SESSION['error_hapus_proyek'] . '</p>';
                        unset($_SESSION['error_hapus_proyek']);
                    }
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Proyek</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>ID Manager</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM projects";
                            $result = mysqli_query($conn, $sql);
                            $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            foreach ($projects as $project) :
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($project['id']); ?></td>
                                <td><?= htmlspecialchars($project['nama_proyek']); ?></td>
                                <td><?= htmlspecialchars($project['deskripsi']); ?></td>
                                <td><?= htmlspecialchars($project['tanggal_mulai']); ?></td>
                                <td><?= htmlspecialchars($project['tanggal_selesai']); ?></td>
                                <td><?= htmlspecialchars($project['manager_id']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="dashboard.php" method="POST" onsubmit="return confirm('Yakin hapus proyek ini?');" style="display:inline;">
                                            <input type="hidden" name="delete_project_id" value="<?= htmlspecialchars($project['id']); ?>">
                                            <button type="submit" name="hapus-proyek">Hapus</button>
                                        </form>
                                        <a href="dashboard.php?edit_project_id=<?= $project['id'] ?>#form-edit-proyek">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($logged_in_role === 'project manager') :?>
            
        <div class="card welcome-card">
            <div class="welcome-header">
                <h2>👋 Selamat Datang, <?= htmlspecialchars($logged_in_user); ?>!</h2>
                <p class="welcome-subtitle">Berikut adalah proyek dan tugas yang telah anda buat.</p>
            </div>
        </div>

            <?php
            $project_to_edit_pm = null;
            if (isset($_GET['edit_project_id'])) {
                $edit_project_id_pm = intval($_GET['edit_project_id']);
                $sql_edit_proj_pm = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";
                $stmt_edit_proj_pm = mysqli_prepare($conn, $sql_edit_proj_pm);
                mysqli_stmt_bind_param($stmt_edit_proj_pm, "ii", $edit_project_id_pm, $logged_in_id);
                mysqli_stmt_execute($stmt_edit_proj_pm);
                $result_edit_proj_pm = mysqli_stmt_get_result($stmt_edit_proj_pm);
                if (mysqli_num_rows($result_edit_proj_pm) > 0) {
                    $project_to_edit_pm = mysqli_fetch_assoc($result_edit_proj_pm);
                }
            }

            if ($project_to_edit_pm) :
            ?>
            
                <div class="card" id="form-edit-proyek">
                    <div class="edit-form">
                        <h2>Edit Proyek (ID: <?= $project_to_edit_pm['id'] ?>)</h2>
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="project_id" value="<?= $project_to_edit_pm['id'] ?>">
                            <input type="hidden" name="pm_id" value="<?= $logged_in_id ?>">
                            
                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="text" name="nama_proyek" value="<?= htmlspecialchars($project_to_edit_pm['nama_proyek']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($project_to_edit_pm['tanggal_mulai']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($project_to_edit_pm['tanggal_selesai']) ?>" required>
                            </div>

                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" required><?= htmlspecialchars($project_to_edit_pm['deskripsi']) ?></textarea>
                            </div>

                            <button type="submit" name="update-proyek">Update Proyek</button>
                            <a href="dashboard.php#tabel-proyek">Batal</a>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card" id="form-tambah-proyek">
                    <h2>Tambah Proyek</h2>
                    <form action="dashboard.php" method="POST">
                        <div class="form-group">
                            <label for="nama_proyek">Nama Proyek</label>
                            <input type="text" id="nama_proyek" name="nama_proyek" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi proyek..." required></textarea>
                        </div>

                        <input type="hidden" name="pm_id" value="<?= htmlspecialchars($logged_in_id); ?>">
                        <button type="submit" name="tambah-proyek">Tambah Proyek</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="card" id="tabel-proyek">
                <h2>Data Proyek Anda</h2>
                <?php
                    if (isset($_SESSION['error_hapus_proyek'])) {
                        echo '<p class="error-message">' . $_SESSION['error_hapus_proyek'] . '</p>';
                        unset($_SESSION['error_hapus_proyek']);
                    }
                ?>
                <table>
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
                            foreach ($my_projects as $project) :
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($project['id']); ?></td>
                                <td><?= htmlspecialchars($project['nama_proyek']); ?></td>
                                <td><?= htmlspecialchars($project['deskripsi']); ?></td>
                                <td><?= htmlspecialchars($project['tanggal_mulai']); ?></td>
                                <td><?= htmlspecialchars($project['tanggal_selesai']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="dashboard.php?edit_project_id=<?= $project['id'] ?>#form-edit-proyek">Edit</a>
                                        <form action="dashboard.php" method="POST" onsubmit="return confirm('Yakin hapus proyek ini?');" style="display:inline;">
                                            <input type="hidden" name="delete_project_id" value="<?= htmlspecialchars($project['id']); ?>">
                                            <button type="submit" name="hapus-proyek">Hapus</button>
                                        </form>
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php
            $task_to_edit = null;
            if (isset($_GET['edit_task_id'])) {
                $edit_task_id = intval($_GET['edit_task_id']);
                $sql_edit_task = "SELECT tasks.* FROM tasks 
                                JOIN projects ON tasks.project_id = projects.id 
                                WHERE tasks.id = ? AND projects.manager_id = ?";
                $stmt_edit_task = mysqli_prepare($conn, $sql_edit_task);
                mysqli_stmt_bind_param($stmt_edit_task, "ii", $edit_task_id, $logged_in_id);
                mysqli_stmt_execute($stmt_edit_task);
                $result_edit_task = mysqli_stmt_get_result($stmt_edit_task);
                if (mysqli_num_rows($result_edit_task) > 0) {
                    $task_to_edit = mysqli_fetch_assoc($result_edit_task);
                }
            }

            if ($task_to_edit) :
            ?>
                <div class="card" id="form-edit-tugas">
                    <div class="edit-form">
                        <h2>Edit Tugas (ID: <?= $task_to_edit['id'] ?>)</h2>
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="task_id" value="<?= $task_to_edit['id'] ?>">
                            
                            <div class="form-group">
                                <label>Nama Tugas</label>
                                <input type="text" name="nama_tugas" value="<?= htmlspecialchars($task_to_edit['nama_tugas']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" required>
                                    <option value="Belum" <?= ($task_to_edit['status'] == 'Belum') ? 'selected' : '' ?>>Belum</option>
                                    <option value="Proses" <?= ($task_to_edit['status'] == 'Proses') ? 'selected' : '' ?>>Proses</option>
                                    <option value="Selesai" <?= ($task_to_edit['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Project</label>
                                <select name="project_id" required>
                                    <?php foreach ($my_projects as $project) : ?>
                                        <option value="<?= $project['id']; ?>" <?= ($project['id'] == $task_to_edit['project_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($project['nama_proyek']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ditugaskan Ke</label>
                                <select name="assigned_to" required>
                                    <?php foreach ($my_team as $member) : ?>
                                        <option value="<?= $member['id']; ?>" <?= ($member['id'] == $task_to_edit['assigned_to']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($member['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" name="update-tugas">Update Tugas</button>
                            <a href="dashboard.php#tabel-tugas">Batal</a>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card" id="form-tambah-tugas">
                    <h2>Tambah Tugas</h2>
                    <form action="dashboard.php" method="POST">
                        <div class="form-group">
                            <label for="nama_tugas">Nama Tugas</label>
                            <input type="text" id="nama_tugas" name="nama_tugas" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="Belum">Belum</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <select id="project_id" name="project_id" required>
                                <option value="">-- Pilih Proyek --</option>
                                <?php foreach ($my_projects as $project) : ?>
                                    <option value="<?= $project['id']; ?>">
                                        <?= htmlspecialchars($project['nama_proyek']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="assigned_to">Ditugaskan Ke</label>
                            <select id="assigned_to" name="assigned_to" required>
                                <option value="">-- Pilih Anggota Tim --</option>
                                <?php foreach ($my_team as $member) : ?>
                                    <option value="<?= $member['id']; ?>">
                                        <?= htmlspecialchars($member['username']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" name="tambah-tugas">Tambah Tugas</button>
                    </form>

                    <?php
                        if (isset($_SESSION['error tambah tugas'])) {
                            echo '<p class="error-message">' . $_SESSION['error tambah tugas'] . '</p>';
                            unset($_SESSION['error tambah tugas']);
                        }
                        if (isset($_SESSION['error_update_tugas'])) {
                            echo '<p class="error-message">' . $_SESSION['error_update_tugas'] . '</p>';
                            unset($_SESSION['error_update_tugas']);
                        }
                    ?>
                </div>
            <?php endif; ?>

            <div class="card" id="tabel-tugas">
                <h2>Data Tugas Proyek</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Tugas</th>
                            <th>Status</th>
                            <th>Project ID</th>
                            <th>Ditugaskan Ke</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE manager_id = $logged_in_id)";
                            $result = mysqli_query($conn, $sql);
                            $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            foreach ($tasks as $task) :
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($task['id']); ?></td>
                                <td><?= htmlspecialchars($task['nama_tugas']); ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($task['status']); ?>">
                                        <?= htmlspecialchars($task['status']); ?>
                                    </span>
                                    <form action="dashboard.php" method="POST" style="display: inline; margin-left: 10px;">
                                        <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                                        <?php if ($task['status'] == 'Belum') : ?>
                                            <input type="hidden" name="new_status" value="Proses">
                                            <button type="submit" name="update_status" style="padding: 5px 10px; font-size: 12px;">Mulai</button>
                                        <?php elseif ($task['status'] == 'Proses') : ?>
                                            <input type="hidden" name="new_status" value="Selesai">
                                            <button type="submit" name="update_status" style="padding: 5px 10px; font-size: 12px;">Selesaikan</button>
                                        <?php else : ?>
                                            <input type="hidden" name="new_status" value="Belum">
                                            <button type="submit" name="update_status" style="padding: 5px 10px; font-size: 12px;">Reset</button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td><?= htmlspecialchars($task['project_id']); ?></td>
                                <td><?= htmlspecialchars($task['assigned_to']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="dashboard.php?edit_task_id=<?= $task['id'] ?>#form-edit-tugas">Edit</a>
                                        <form action="dashboard.php" method="POST" onsubmit="return confirm('Yakin hapus tugas ini?');" style="display:inline;">
                                            <input type="hidden" name="task_id_to_delete" value="<?= $task['id'] ?>">
                                            <button type="submit" name="hapus-tugas">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else : ?>
        <div class="card welcome-card">
            <div class="welcome-header">
                <h2>👋 Selamat Datang, <?= htmlspecialchars($logged_in_user); ?>!</h2>
                <p class="welcome-subtitle">Berikut adalah proyek dan tugas yang telah ditugaskan kepada Anda</p>
            </div>
        </div>

        <?php if (empty($projects_member)): ?>
            <div class="card empty-state">
                <div class="empty-state-content">
                    <div class="empty-icon">📋</div>
                    <h3>Belum Ada Tugas</h3>
                    <p>Anda belum ditugaskan pada proyek apapun saat ini.</p>
                    <p class="empty-hint">Hubungi Project Manager Anda untuk mendapatkan penugasan tugas.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="card info-card">
                <div class="info-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?= count($projects_member); ?></div>
                        <div class="stat-label">Proyek Aktif</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= count($tasks_member); ?></div>
                        <div class="stat-label">Total Tugas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                                $completed = 0;
                                foreach ($tasks_member as $t) {
                                    if ($t['status'] == 'Selesai') $completed++;
                                }
                                echo $completed;
                            ?>
                        </div>
                        <div class="stat-label">Tugas Selesai</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php 
                                $progress = count($tasks_member) > 0 ? round(($completed / count($tasks_member)) * 100) : 0;
                                echo $progress . '%';
                            ?>
                        </div>
                        <div class="stat-label">Progress</div>
                    </div>
                </div>
            </div>

        <div class="projects-section">
            <h2>📁 Daftar Proyek & Tugas Anda</h2>
            <p class="section-description">Kelola dan update status tugas Anda di setiap proyek</p>
        </div>

        <?php foreach ($projects_member as $project) : ?>
            <div class="card project-card">
                <div class="project-header">
                    <div>
                        <h3>🎯 <?= htmlspecialchars($project['nama_proyek']); ?></h3>
                        <p class="project-id">ID Proyek: <?= $project['id']; ?></p>
                    </div>
                    <div class="project-dates">
                        <span class="date-badge">📅 <?= date('d M Y', strtotime($project['tanggal_mulai'])); ?></span>
                        <span class="date-badge">🏁 <?= date('d M Y', strtotime($project['tanggal_selesai'])); ?></span>
                    </div>
                </div>
                
                <div class="project-description">
                    <strong>Deskripsi Proyek:</strong>
                    <p><?= htmlspecialchars($project['deskripsi']); ?></p>
                </div>

                <div class="tasks-section">
                    <h4>✅ Tugas Anda di Proyek Ini</h4>
                    
                    <?php
                    $project_tasks = array_filter($tasks_member, function($task) use ($project) {
                        return $task['project_id'] == $project['id'];
                    });
                    
                    if (empty($project_tasks)): ?>
                        <div class="no-tasks-message">
                            <p>💡 Tidak ada tugas untuk Anda di proyek ini saat ini.</p>
                        </div>
                    <?php else: ?>
                        <table class="tasks-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Tugas</th>
                                    <th>Status & Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($project_tasks as $task) : ?>
                                    <tr id="task-<?= $task['id']; ?>">
                                        <td>
                                            <span class="task-id">#<?= htmlspecialchars($task['id']); ?></span>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($task['nama_tugas']); ?></strong>
                                        </td>
                                        <td>
                                            <div class="status-action-wrapper">
                                                <span class="status-badge status-<?= strtolower(htmlspecialchars($task['status'])); ?>">
                                                    <?php 
                                                        $status_icon = '';
                                                        switch($task['status']) {
                                                            case 'Belum': $status_icon = '⏳'; break;
                                                            case 'Proses': $status_icon = '🔄'; break;
                                                            case 'Selesai': $status_icon = '✔️'; break;
                                                        }
                                                        echo $status_icon . ' ' . htmlspecialchars($task['status']);
                                                    ?>
                                                </span>
                                                <form action="dashboard.php#task-<?= $task['id']; ?>" method="POST" class="status-form">
                                                    <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                                                    <?php if ($task['status'] == 'Belum') : ?>
                                                        <input type="hidden" name="new_status" value="Proses">
                                                        <button type="submit" name="update_status" class="btn-start">
                                                            ▶️ Mulai Tugas
                                                        </button>
                                                    <?php elseif ($task['status'] == 'Proses') : ?>
                                                        <input type="hidden" name="new_status" value="Selesai">
                                                        <button type="submit" name="update_status" class="btn-complete">
                                                            ✅ Selesaikan
                                                        </button>
                                                    <?php else : ?>
                                                        <input type="hidden" name="new_status" value="Belum">
                                                        <button type="submit" name="update_status" class="btn-reset">
                                                            🔄 Reset
                                                        </button>
                                                    <?php endif; ?>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <div class="task-summary">
                            <?php
                                $belum = $proses = $selesai = 0;
                                foreach ($project_tasks as $t) {
                                    if ($t['status'] == 'Belum') $belum++;
                                    elseif ($t['status'] == 'Proses') $proses++;
                                    elseif ($t['status'] == 'Selesai') $selesai++;
                                }
                            ?>
                            <span class="summary-item">⏳ Belum: <strong><?= $belum ?></strong></span>
                            <span class="summary-item">🔄 Proses: <strong><?= $proses ?></strong></span>
                            <span class="summary-item">✔️ Selesai: <strong><?= $selesai ?></strong></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php endif; ?>
    </div>
</body>
</html>