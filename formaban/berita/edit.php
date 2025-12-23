<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();

require_once __DIR__ . '/../../koneksi.php';
$admin = getAdmin();

// ambil ID berita
$id = $_GET['id'] ?? 0;

// ambil berita
$stmt = $koneksi->prepare("SELECT * FROM berita WHERE id_berita=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) die("Berita tidak ditemukan!");

// cek hak akses
if ($data['id_admin'] != $admin['id_admin'] && $admin['role'] !== 'superadmin') {
    die("Anda tidak memiliki akses untuk mengedit berita ini.");
}

$msg = "";

// proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $judul = $_POST['judul'];
    $isi   = $_POST['isi'];
    $gambar = $data['gambar'];

    if (!empty($_FILES['gambar']['name'])) {

        $dir = __DIR__ . '/../../uploads/berita/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $namaBaru = time() . "_" . basename($_FILES['gambar']['name']);
        $lokasiBaru = $dir . $namaBaru;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasiBaru)) {

            // hapus gambar lama
            if (!empty($data['gambar'])) {
                $old = __DIR__ . '/../../' . $data['gambar'];
                if (file_exists($old)) unlink($old);
            }

            $gambar = "uploads/berita/" . $namaBaru;
        }
    }

    // update ke database
    $stmt = $koneksi->prepare("
        UPDATE berita 
        SET judul=?, isi=?, gambar=?, updated_at=NOW()
        WHERE id_berita=?
    ");
    $stmt->bind_param("sssi", $judul, $isi, $gambar, $id);
    $stmt->execute();
    $stmt->close();

    $msg = "Berita berhasil diperbarui!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Berita</title>

<style>
    body {
        margin: 0;
        background: #eef1f5;
        font-family: Arial, sans-serif;
    }

    /* wrapper agar konten tidak tertutup sidebar */
    .content-wrapper {
        margin-left: 250px;
        padding: 40px 20px;
    }

    /* card form */
    .form-card {
        width: 60%;
        background: white;
        margin: auto;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 15px;
    }

    .btn {
        background: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        font-size: 15px;
        margin-top: 10px;
    }

    .preview-img {
        display: block;
        margin: auto;
        margin-bottom: 15px;
        border-radius: 8px;
    }

    .success-msg {
        background: #d1e7dd;
        color: #0f5132;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }
</style>

</head>
<body>

<?php include __DIR__ . '/../sidebar.php'; ?>

<div class="content-wrapper">

    <div class="form-card">

        <h2>Edit Berita</h2>

        <?php if ($msg): ?>
            <div class="success-msg"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Judul Berita</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>

            <label>Isi Berita</label>
            <textarea name="isi" rows="7" required><?= htmlspecialchars($data['isi']) ?></textarea>

            <label>Gambar Saat Ini</label>
            <img class="preview-img" src="/KIPWEB/<?= $data['gambar'] ?>" width="260">

            <label>Ganti Gambar (opsional)</label>
            <input type="file" name="gambar">

            <button class="btn" type="submit">Simpan Perubahan</button>
        </form>

    </div>

</div>

</body>
</html>
