<?php
include 'protect.php';
include '../koneksi.php';
include 'sidebar.php';

$msg = "";

if (isset($_POST['submit'])) {

    $nama_sk   = trim($_POST['nama_sk']);
    $tahun     = trim($_POST['tahun']);
    $nomor_sk  = trim($_POST['nomor_sk']);
    $file      = $_FILES['file_sk'];

    if ($nama_sk == "" || $tahun == "" || $nomor_sk == "" || !$file['name']) {
        $msg = "<div class='alert alert-warning'>⚠️ Semua field wajib diisi.</div>";
    } else {

        $cek = $koneksi->prepare("SELECT id_sk_kipk FROM sk_kipk WHERE nama_sk=? AND tahun=? AND nomor_sk=?");
        $cek->bind_param("sss", $nama_sk, $tahun, $nomor_sk);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>⚠️ Data SK sudah ada!</div>";
        } else {

            $uploadDir = '../uploads/sk/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $allowed = ['pdf','xlsx','xls'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $msg = "<div class='alert alert-danger'>❌ Format file tidak diizinkan!</div>";
            } else {

                $cleanName = preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $file['name']);
                $fileName = time() . '_' . $cleanName;
                $filePath = $uploadDir . $fileName;
                $fileUrl  = '../uploads/sk/' . $fileName;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {

                    $stmt = $koneksi->prepare("
                        INSERT INTO sk_kipk 
                        (nama_sk, tahun, nomor_sk, file_path, file_url, id_admin, status)
                        VALUES (?, ?, ?, ?, ?, ?, 'pending')
                    ");

                    $stmt->bind_param(
                        "sssssi",
                        $nama_sk,
                        $tahun,
                        $nomor_sk,
                        $filePath,
                        $fileUrl,
                        $_SESSION['id_admin']
                    );

                    $stmt->execute();

                    echo "<script>
                            alert('✅ Berhasil! SK masuk ke Pending. Menunggu verifikasi Admin 3.');
                            window.location='sk_list.php';
                          </script>";
                    exit;

                } else {
                    $msg = "<div class='alert alert-danger'>❌ Upload gagal!</div>";
                }
            }
        }
        $cek->close();
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload SK KIP-K</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { 
    background:#f3eaff; 
    height:100vh;
    margin:0;
}

.content { 
    margin-left:230px;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

.box {
    background:white;
    padding:35px;
    border-radius:15px;
    width:100%;
    max-width:650px;
    border-top:7px solid #7a33c9;
    box-shadow:0 4px 15px rgba(0,0,0,0.12);
}

h2 { 
    text-align:center; 
    color:#7a33c9; 
    font-weight:700;
    margin-bottom:25px;
}

.form-label {
    font-weight:600;
    color:#4b2a79;
}

.form-control {
    padding:12px;
    border-radius:10px;
    border:1px solid #bca7e6;
}

.form-control:focus {
    border-color:#7a33c9;
    box-shadow:0 0 5px rgba(122,51,201,0.4);
}

.btn-purple {
    background:#7a33c9;
    color:white;
    font-weight:600;
    padding:12px;
    border-radius:10px;
}

.btn-purple:hover {
    background:#6a2db2;
}

.btn-secondary {
    padding:12px;
    border-radius:10px;
}
</style>

</head>

<body>

<div class="content">
    <div class="box">

        <h2>📄 Upload SK KIP-K</h2>

        <?= $msg; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Nama SK</label>
                <input type="text" name="nama_sk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">File SK (.pdf / .xlsx / .xls)</label>
                <input type="file" name="file_sk" class="form-control" accept=".pdf,.xlsx,.xls" required>
            </div>

            <button name="submit" class="btn btn-purple w-100">UPLOAD SK</button>
        </form>

        <a href="sk_list.php" class="btn btn-secondary w-100 mt-3">← Kembali ke Daftar SK</a>

    </div>
</div>

</body>
</html>
