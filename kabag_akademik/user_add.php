<?php
session_start();

// Proteksi halaman
if (!isset($_SESSION['level']) || $_SESSION['level'] != 13) {
    die("Akses ditolak! Hanya admin level 13 yang bisa menambah user.");
}

// include koneksi
$tryK = [
    __DIR__ . "/koneksi.php",
    __DIR__ . "/../koneksi.php",
    __DIR__ . "/../../koneksi.php"
];
$found = false;
foreach ($tryK as $k) {
    if (file_exists($k)) {
        include $k;
        $found = true;
        break;
    }
}
if (!$found) die("ERROR: koneksi.php tidak ditemukan!");

// Gunakan variabel koneksi
if (isset($koneksi)) $db = $koneksi;
elseif (isset($conn)) $db = $conn;
else die("ERROR: Variabel koneksi tidak ditemukan!");

// PROSES SIMPAN USER
$msg = "";
if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password']; // TANPA HASH
    $level    = $_POST['level'];

    if ($nama == "" || $username == "" || $password == "" || $level == "") {
        $msg = "Semua field wajib diisi!";
    } else {

        // CEK USERNAME SUDAH ADA
        $cek = $db->prepare("SELECT id_admin FROM admin WHERE username=? LIMIT 1");
        $cek->bind_param("s", $username);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $msg = "Username sudah digunakan!";
            $cek->close();
        } else {
            $cek->close();

            // INSERT TANPA HASH PASSWORD
            $ins = $db->prepare("INSERT INTO admin (nama_lengkap, username, password, level) VALUES (?,?,?,?)");
            $ins->bind_param("sssi", $nama, $username, $password, $level);

            if ($ins->execute()) {
                echo "<script>alert('User berhasil ditambahkan');window.location='crud_user.php';</script>";
                exit;
            } else {
                $msg = "Gagal menambah user: " . $ins->error;
            }
            $ins->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background:#f3e8ff;
    font-family:'Poppins',sans-serif;
}

/* FIX: supaya tidak ketiban navbar/ sidebar */
.main-wrapper {
    margin-left: 260px;
    padding: 40px;
    margin-top: 20px;
}

.card-custom {
    max-width: 780px;
    margin:auto;
    background:#fff;
    padding:26px;
    border-left:6px solid #6a00ff;
    border-radius:12px;
    box-shadow:0 8px 26px rgba(0,0,0,0.1);
}

label { 
    color:#5a0ccf; 
    font-weight:600; 
}
.form-control { 
    border-radius:10px; 
    padding:10px; 
    background:#faf7ff; 
    border:1px solid #d8c7f9; 
}
.btn-primary { 
    background:#6a00ff; 
    border:none; 
    border-radius:10px; 
    padding:10px 20px; 
}
.msg { 
    padding:10px; 
    border-radius:8px; 
    margin-bottom:12px; 
}
.msg.error { 
    background:#ffe3e6; 
    border-left:6px solid #d40023; 
    color:#7a0010; 
}
</style>
</head>
<body>

<!-- FIX: sidebar admin level 13 -->
<?php include __DIR__ . "/sidebar.php"; ?>

<div class="main-wrapper">
    <div class="card-custom">
        <h2 style="color:#5a0ccf; margin-bottom:12px;">Tambah User Baru</h2>

        <?php if ($msg != "") { ?>
            <div class="msg error"><?= $msg ?></div>
        <?php } ?>

        <form method="post">

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Level</label>
                <select name="level" class="form-control" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="11">Admin1</option>
                    <option value="12">Admin2</option>
                    <option value="13">Admin3</option>
                </select>
            </div>

            <button type="submit" name="simpan" class="btn btn-primary">Tambah User</button>
            <a href="crud_user.php" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>

</body>
</html>
