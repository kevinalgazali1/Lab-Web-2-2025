<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Super Admin') {
    die("Akses ditolak");
}

$pm_result = mysqli_query($conn, "SELECT id, username FROM users WHERE role='Project Manager'");
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username           = trim($_POST['username']);
    $password           = trim($_POST['password']);
    $role               = $_POST['role'];
    $project_manager_id = isset($_POST['project_manager_id']) ? trim($_POST['project_manager_id']) : NULL;

    if (empty($username) || empty($password) || empty($role)) {
        $message = "<p class='text-rose-500 font-medium text-center bg-rose-50 p-2 rounded-md'>Semua field wajib diisi!</p>";
    } 
    elseif ($role === 'Team Member' && (empty($project_manager_id) || $project_manager_id === '')) {
        $message = "<p class='text-amber-600 font-medium text-center bg-amber-50 p-2 rounded-md'>Team Member wajib memiliki Project Manager!</p>";
    } 
    else {
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        $user_exists = mysqli_stmt_num_rows($stmt_check) > 0;
        mysqli_stmt_close($stmt_check);

        if ($user_exists) {
            $message = "<p class='text-rose-600 font-medium text-center bg-rose-50 p-2 rounded-md'>
                            Username '$username' sudah digunakan. Silakan pilih username lain.
                        </p>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if ($role === 'Project Manager') {
                $project_manager_id = NULL;
            }

            $sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $username, $password_hash, $role, $project_manager_id);

            if (mysqli_stmt_execute($stmt)) {
                $message = "<p class='text-emerald-600 font-medium text-center bg-emerald-50 p-2 rounded-md'>
                                User berhasil ditambahkan!
                            </p>";
            } else {
                $message = "<p class='text-rose-600 font-medium text-center bg-rose-50 p-2 rounded-md'>
                                Terjadi kesalahan: " . mysqli_error($conn) . "
                            </p>";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-rose-50 via-lavender-50 to-amber-50 font-[Poppins] min-h-screen flex items-center justify-center p-6">

    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-violet-100 p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-violet-600 mb-6 text-center">Tambah User</h2>
        <a href="superadmin_dashboard.php" class="inline-block text-violet-500 hover:text-violet-700 mb-4 transition">
            &larr; Kembali ke Dashboard
        </a>

        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" class="space-y-4 mt-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Username:</label>
                <input type="text" name="username" required
                       class="w-full px-4 py-2 border border-violet-100 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-violet-300 transition">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Password:</label>
                <div class="relative">
                    <input id="passwordInput" type="password" name="password" required
                           class="w-full pr-12 px-4 py-2 border border-violet-100 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-violet-300 transition">
                    <button id="togglePassword" type="button"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500 hover:text-gray-800">
                        <span id="toggleEmoji">👁️</span>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Role:</label>
                <select name="role" id="role" onchange="togglePM()" required
                        class="w-full px-4 py-2 border border-violet-100 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-violet-300 transition">
                    <option value="">--Pilih Role--</option>
                    <option value="Project Manager">Project Manager</option>
                    <option value="Team Member">Team Member</option>
                </select>
            </div>

            <div id="pm_select" class="hidden">
                <label class="block text-gray-700 font-medium mb-1">
                    Pilih Project Manager <span class="text-red-500">*</span>
                </label>
                <select name="project_manager_id" id="project_manager_id"
                        class="w-full px-4 py-2 border border-violet-100 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-violet-300 transition">
                    <option value="">-- Pilih Manager --</option>
                    <?php 
                    mysqli_data_seek($pm_result, 0);
                    while($pm = mysqli_fetch_assoc($pm_result)) : ?>
                        <option value="<?= htmlspecialchars($pm['id']) ?>"><?= htmlspecialchars($pm['username']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-rose-300 via-violet-300 to-amber-200 hover:opacity-90 text-gray-800 font-semibold px-4 py-2 rounded-md shadow transition">
                Tambah User
            </button>
        </form>
    </div>

    <script>
        function togglePM() {
            const role = document.getElementById('role').value;
            const pmSelect = document.getElementById('pm_select');
            const pmDropdown = document.getElementById('project_manager_id');

            if (role === 'Team Member') {
                pmSelect.classList.remove('hidden');
                pmDropdown.setAttribute('required', 'required');
            } else {
                pmSelect.classList.add('hidden');
                pmDropdown.removeAttribute('required');
                pmDropdown.value = '';
            }
        }

        const pwdInput = document.getElementById('passwordInput');
        const toggleBtn = document.getElementById('togglePassword');
        const toggleEmoji = document.getElementById('toggleEmoji');

        toggleBtn.addEventListener('click', () => {
            const hidden = pwdInput.type === 'password';
            pwdInput.type = hidden ? 'text' : 'password';
            toggleEmoji.textContent = hidden ? '🙈' : '👁️';
        });
    </script>

</body>
</html>
