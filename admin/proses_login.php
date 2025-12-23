<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
session_start();
include '../koneksi.php';

// Batasi percobaan login sederhana
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if ($_SESSION['login_attempts'] >= 5) {
    $_SESSION['error'] = "Terlalu banyak percobaan login. Coba lagi nanti.";
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepared statement, ambil dari tabel "login" (sesuai insert yang kamu lakukan)
    $stmt = mysqli_prepare($koneksi, "SELECT id, nama, username, password FROM login WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // sukses login
            session_regenerate_id(true);
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_nama'] = $row['nama'];
            $_SESSION['last_activity'] = time();
            // reset attempts
            $_SESSION['login_attempts'] = 0;

            header("Location: index.php");
            exit;
        }
    }

    // gagal login
    $_SESSION['login_attempts'] += 1;
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
    exit;
}
?>
