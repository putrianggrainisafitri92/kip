<?php
session_start();
include '../koneksi.php';

// === PROSES LOGIN ===
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $password_md5 = md5($password);

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password_md5' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_nama'] = $data['nama_lengkap'];
        $_SESSION['admin_id'] = $data['id'];
        $_SESSION['admin_role'] = $data['role']; // penting

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login Admin - KIP Kuliah</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 flex items-center justify-center">

  <div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-md border border-white/20">
    <div class="text-center mb-6">
      <img src="../assets/logo-polinela.png" alt="Logo Polinela" class="w-14 mr-3 drop-shadow-lg">
      <h1 class="text-3xl font-bold text-white">Login Admin</h1>
      <p class="text-blue-100 text-sm mt-1">Sistem Informasi KIP-KULIAH POLINELA</p>
    </div>

    <?php if (isset($error)): ?>
      <div class="bg-red-500/20 border border-red-400 text-red-200 px-4 py-2 rounded-lg mb-4 text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">
      <div>
        <label class="block text-blue-100 font-medium mb-1">Username</label>
        <input type="text" name="username" required
          class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-blue-200 focus:ring-2 focus:ring-blue-400 focus:outline-none"
          placeholder="Masukkan username">
      </div>

      <div>
        <label class="block text-blue-100 font-medium mb-1">Password</label>
        <input type="password" name="password" required
          class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-blue-200 focus:ring-2 focus:ring-blue-400 focus:outline-none"
          placeholder="Masukkan password">
      </div>

      <button type="submit" name="login"
        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 rounded-lg transition">
        Masuk
      </button>
    </form>

    <p class="text-center text-blue-200 text-sm mt-6">
      &copy; <?= date('Y') ?> KIP-Kuliah Polinela
    </p>
  </div>

</body>
</html>
