<?php
include '../sidebar.php';
include '../../koneksi.php';

$msg = '';

// Proses Upload
if(isset($_POST['submit'])){
    $nama_sk = trim($_POST['nama_sk']);
    $tahun = trim($_POST['tahun']);
    $nomor_sk = trim($_POST['nomor_sk']);
    
    $file = $_FILES['file_sk'];

    if($nama_sk=='' || $tahun=='' || $nomor_sk=='' || !$file['name']){
        $msg = "⚠️ Semua field wajib diisi!";
    } else {
        // Cek apakah file sudah ada di database
        $cek = $koneksi->prepare("SELECT id FROM sk_kipk WHERE nama_sk=? AND tahun=? AND nomor_sk=?");
        $cek->bind_param("sss", $nama_sk, $tahun, $nomor_sk);
        $cek->execute();
        $cek->store_result();
        if($cek->num_rows > 0){
            $msg = "⚠️ File dengan data yang sama sudah ada di database!";
        } else {
            $uploadDir = '../../uploads/sk/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = time().'_'.$file['name'];
            $filePath = $uploadDir.$fileName;
            $fileUrl = '/KIPWEB/uploads/sk/' . $fileName;

            if(move_uploaded_file($file['tmp_name'], $filePath)){
                // Insert ke database
                $stmt = $koneksi->prepare("INSERT INTO sk_kipk (nama_sk, tahun, nomor_sk, file_path, file_url) VALUES (?,?,?,?,?)");
                $stmt->bind_param("sssss", $nama_sk, $tahun, $nomor_sk, $filePath, $fileUrl);
                $stmt->execute();
                $stmt->close();

                $msg = "✅ File berhasil diupload!";
            } else {
                $msg = "❌ Upload gagal!";
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
<title>Upload File SK</title>
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
        <h2>📄 Upload File SK</h2>

        <?php if($msg!='') echo "<div class='alert alert-info'>$msg</div>"; ?>

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
                <label class="form-label">File SK (.xlsx / .pdf)</label>
                <input type="file" name="file_sk" class="form-control" accept=".xlsx,.xls,.pdf" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success w-100">Upload</button>
        </form>

        <a href="lihat_data_sk.php" class="btn btn-secondary w-100 mt-3">← Kembali ke Daftar SK</a>
    </div>
</div>

</body>
</html>
