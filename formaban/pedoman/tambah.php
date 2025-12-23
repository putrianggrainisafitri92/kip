<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
include __DIR__ . '/../sidebar.php';

// Load koneksi ($koneksi)
require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();
?>

<?php
// ===============================
// PROSES UPLOAD
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pedoman'])) {

    if ($_FILES['pedoman']['error'] !== 0) {
        die("Gagal upload: Tidak ada file atau file rusak.");
    }

    $nama_file = $_FILES['pedoman']['name'];
    $tmp = $_FILES['pedoman']['tmp_name'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if ($ext !== 'pdf') {
        die("File harus dalam format PDF.");
    }

    $folder = "uploads/pedoman/";
    $absolutePath = __DIR__ . "/../../" . $folder;

    if (!is_dir($absolutePath)) {
        mkdir($absolutePath, 0777, true);
    }

    $new_name = uniqid() . "_" . $nama_file;
    $path = $folder . $new_name;

    if (!move_uploaded_file($tmp, $absolutePath . $new_name)) {
        die("Gagal memindahkan file.");
    }

    $stmt = $koneksi->prepare("
        INSERT INTO pedoman (nama_file, file_path, status, id_admin, tanggal_upload, created_at)
        VALUES (?, ?, 'pending', ?, NOW(), NOW())
    ");

    $stmt->bind_param("ssi", $nama_file, $path, $admin['id_admin']);
    $stmt->execute();
    $stmt->close();

    header("Location: list.php?msg=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload Pedoman</title>

<style>
/* BASE LAYOUT */
body {
    margin: 0;
    padding-left: 240px;   /* ruang untuk sidebar */
    background: #eef2f7;
    font-family: "Segoe UI", Arial;
}

/* CENTER WRAPPER */
.wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

/* CARD */
.card {
    background: #fff;
    padding: 35px 40px;
    width: 450px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    animation: fadeIn 0.4s ease;
}

.card h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 22px;
    text-align: center;
    color: #333;
}

/* INPUT */
input[type="file"] {
    padding: 10px;
    background: #f8f9fb;
    border: 2px dashed #cdd5e0;
    border-radius: 8px;
    width: 100%;
    cursor: pointer;
}

input[type="file"]:hover {
    border-color: #6c8ff5;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    background: #0d6efd;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    margin-top: 15px;
    transition: 0.2s;
}

button:hover {
    background: #0b5ed7;
}

/* ANIMATION */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>

<body>

<div class="wrapper">
    <div class="card">
        <h2>Upload Pedoman (PDF)</h2>

        <form method="POST" enctype="multipart/form-data">
            <label><strong>Pilih File PDF</strong></label><br><br>
            <input type="file" name="pedoman" accept="application/pdf" required><br>

            <button type="submit">Upload</button>
        </form>
    </div>
</div>

</body>
</html>
