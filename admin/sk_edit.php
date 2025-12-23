<?php
include 'protect.php';       // Hanya admin2
include '../koneksi.php';    // Memakai $koneksi
include 'sidebar.php';       // Sidebar admin2

$msg = "";

// Ambil ID SK
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID SK tidak valid!'); location='sk_list.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data SK dari database
$stmt = $koneksi->prepare("SELECT * FROM sk_kipk WHERE id_sk_kipk=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    echo "<script>alert('Data SK tidak ditemukan!'); location='sk_list.php';</script>";
    exit;
}

// PROSES UPDATE
if (isset($_POST['update'])) {

    $nama_sk   = trim($_POST['nama_sk']);
    $tahun     = trim($_POST['tahun']);
    $nomor_sk  = trim($_POST['nomor_sk']);
    $file      = $_FILES['file_sk'];

    if ($nama_sk == "" || $tahun == "" || $nomor_sk == "") {
        $msg = "<div class='alert alert-warning'>⚠ Semua field wajib diisi!</div>";
    } else {

        // Data file lama
        $filePath = $data['file_path'];
        $fileUrl  = $data['file_url'];

        // Upload file baru jika ada
        if (isset($file['name']) && $file['name'] != "") {

            $uploadDir = '../uploads/sk/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $cleanName = preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $file['name']);
            $fileName  = time() . '_' . $cleanName;
            $newPath   = $uploadDir . $fileName;
            $newUrl    = '/KIPWEB/uploads/sk/' . $fileName;

            if (move_uploaded_file($file['tmp_name'], $newPath)) {

                // Hapus file lama jika ada
                if (!empty($filePath) && file_exists($filePath)) {
                    unlink($filePath);
                }

                $filePath = $newPath;
                $fileUrl  = $newUrl;

            } else {
                $msg = "<div class='alert alert-danger'>❌ Upload file gagal!</div>";
            }
        }

        // Update data SK (status kembali pending)
        $stmt = $koneksi->prepare("
            UPDATE sk_kipk 
            SET nama_sk=?, tahun=?, nomor_sk=?, file_path=?, file_url=?, status='pending', id_admin=? 
            WHERE id_sk_kipk=?
        ");
        $stmt->bind_param(
            "ssssssi",
            $nama_sk,
            $tahun,
            $nomor_sk,
            $filePath,
            $fileUrl,
            $_SESSION['id_admin'],  // Admin 2
            $id
        );

        if ($stmt->execute()) {
            // Alert sukses seperti upload SK
            echo "<script>
                    alert('✅ Data SK berhasil diperbarui masih pending. Menunggu verifikasi Admin 3.');
                    window.location='sk_list.php';
                  </script>";
            exit;
        } else {
            $msg = "<div class='alert alert-danger'>❌ Gagal menyimpan data!</div>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit SK KIP-K</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== BG LEMBUT UNGU ===== */
body {
    background: #f4edff;
    height: 100vh;
    margin: 0;
}

/* ===== AREA UTAMA CENTER ===== */
.content {
    margin-left: 230px;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

/* ===== CARD FORM ===== */
.box {
    width: 100%;
    max-width: 700px;
    background: white;
    padding: 35px;
    border-radius: 18px;
    border-top: 7px solid #7a33c9;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    animation: fadeIn .4s ease-out;
}

/* Animasi smooth */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== JUDUL ===== */
h2 {
    text-align: center;
    color: #7a33c9;
    font-weight: 700;
    margin-bottom: 25px;
    font-size: 27px;
}

/* ===== LABEL ===== */
.form-label {
    font-weight: 600;
    color: #4b2a79;
}

/* ===== INPUT ===== */
.form-control {
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #c7b3ec;
    background: #faf7ff;
}

.form-control:focus {
    border-color: #7a33c9;
    background: white;
    box-shadow: 0 0 6px rgba(122,51,201,0.35);
}

/* ===== TOMBOL ===== */
.btn-purple {
    background: #7a33c9;
    color: white;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px;
    border: none;
}

.btn-purple:hover {
    background: #6a2db2;
}

.btn-secondary {
    border-radius: 12px;
    padding: 12px;
}

.btn-file {
    background: #6431ac;
    border: none;
}

.btn-file:hover {
    background: #54299a;
}
</style>
</head>

<body>

<div class="content">
    <div class="box">

        <h2>✏ Edit SK KIP-K</h2>

        <?= $msg; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Nama SK</label>
                <input type="text" name="nama_sk" class="form-control"
                       value="<?= htmlspecialchars($data['nama_sk']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun" class="form-control"
                       value="<?= htmlspecialchars($data['tahun']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control"
                       value="<?= htmlspecialchars($data['nomor_sk']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">File SK Saat Ini</label><br>
                <?php if (!empty($data['file_url'])): ?>
                    <a href="<?= $data['file_url']; ?>" target="_blank" class="btn btn-file btn-sm text-white">
                        📄 Lihat File
                    </a>
                <?php else: ?>
                    <span class="text-muted">Tidak ada file</span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File Baru (Opsional)</label>
                <input type="file" name="file_sk" class="form-control" accept=".pdf,.xlsx,.xls">
            </div>

            <button name="update" class="btn btn-purple w-100">Simpan Perubahan</button>
        </form>

        <a href="sk_list.php" class="btn btn-secondary w-100 mt-3">← Kembali ke Daftar SK</a>

    </div>
</div>

</body>
</html>
