    <?php
    error_reporting(E_ALL);
ini_set('display_errors', 1);
    include 'connect.php';

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if ($result){
        $user_found = mysqli_fetch_assoc($result);

            if ($user_found && password_verify($password, $user_found['password'])) {
                $_SESSION['user'] = $user_found;

                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "login gagal, periksa username dan password anda";

                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Terjadi kesalahan pada server.";
            header("Location: login.php");
            exit();
        }

        $conn->close();
    }
