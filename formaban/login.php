<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // AMBIL DATA
    $stmt = $koneksi->prepare("SELECT * FROM admin WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($data) {

        $hash = $data['password'];
        $valid = false;

        // HASH BCRYPT
        if (substr($hash, 0, 4) === '$2y$') {
            if (password_verify($password, $hash)) {
                $valid = true;
            }
        } 
        // HASH MD5
        else {
            if (md5($password) === $hash) {
                $valid = true;
            }
        }

        if ($valid) {
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            $_SESSION['role'] = $data['role'];

            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
        }
        .login-box {
            width: 350px;
            background: #fff;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #2b67f6;
            color: #fff;
            border: none;
            margin-top: 15px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2 style="text-align:center;">LOGIN ADMIN</h2>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">LOGIN</button>
    </form>
</div>

</body>
</html>
