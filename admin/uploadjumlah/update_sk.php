<?php
include '../sidebar.php';
include '../../koneksi.php';

$msg = '';

// Ambil ID dari query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data SK lama
$result = $koneksi->query("SELECT * FROM sk_kipk WHERE id=$id");
if($result->num_rows == 0){
    echo "<script>alert('Data SK tidak ditemukan!'); window.location='lihat_data_sk.php';</script>";
    exit;
}
$sk = $result->fetch_assoc();

// Proses Update
if(isset($_POST['submit'])){
    $nama_sk = trim($_POST['nama_sk']);
    $tahun = trim($_POST['tahun']);
    $nomor_sk = trim($_POST['nomor_sk']);
    $file = $_FILES['file_sk'];

    // Validasi
    if($nama_sk=='' || $tahun=='' || $nomor_sk==''){
        $msg = "⚠️ Nama, Tahun, dan Nomor SK wajib diisi!";
    } else {
        $filePath = $sk['file_path'];
        $fileUrl = $sk['file_url'];

        // Jika ada file baru
        if($file['name']){
            $uploadDir = '../../uploads/sk/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = time().'_'.$file['name'];
            $filePath = $uploadDir.$fileName;
            $fileUrl = '/KIPWEB/uploads/sk/'.$fileName;

            if(!move_uploaded_file($file['tmp_name'], $filePath)){
                $msg = "❌ Upload file baru gagal!";
            } else {
                // Hapus file lama jika ada
                if(file_exists($sk['file_path'])) unlink($sk['file_path']);
            }
        }

        if($msg==''){
            // Update database
            $stmt = $koneksi->prepare("UPDATE sk_kipk SET nama_sk=?, tahun=?, nomor_sk=?, file_path=?, file_url=? WHERE id=?");
            $stmt->bind_param("sssssi", $nama_sk, $tahun, $nomor_sk, $filePath, $fileUrl, $id);

            if($stmt->execute()){
                // Redirect ke halaman lihat_data_sk.php setelah update berhasil
                header("Location: lihat_data_sk.php");
                exit;
            } else {
                $msg = "❌ Gagal memperbarui data SK!";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Update File SK</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f4f6fa; font-family:Arial, sans-serif; }
.content{ margin-left:220px; padding:35px; }
.container-box{ background:white; padding:25px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); max-width:600px; margin:auto; }
h2{ text-align:center; margin-bottom:20px; color:#1f4aa8; }
</style>
</head>
<body>

<div class="content">
    <div class="container-box">
        <h2>✏️ Update File SK</h2>

        <?php if($msg!='') echo "<div class='alert alert-info'>$msg</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama SK</label>
                <input type="text" name="nama_sk" class="form-control" value="<?= htmlspecialchars($sk['nama_sk']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($sk['tahun']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control" value="<?= htmlspecialchars($sk['nomor_sk']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">File SK (.xlsx / .pdf)</label>
                <input type="file" name="file_sk" class="form-control" accept=".xlsx,.xls,.pdf">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file</small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Update</button>
        </form>

        <a href="lihat_data_sk.php" class="btn btn-secondary w-100 mt-3">← Kembali ke Daftar SK</a>
    </div>
</div>

</body>
</html>
