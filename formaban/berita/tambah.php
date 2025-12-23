<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
include __DIR__ . '/../sidebar.php';
require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $judul   = $_POST['judul'];
    $isi     = $_POST['isi'];
    $tanggal = date("Y-m-d");

    $sql = "INSERT INTO berita 
            (id_admin, judul, isi, status, approved_by, tanggal)
            VALUES (?, ?, ?, 'pending', NULL, ?)";

    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) die("Prepare failed: " . mysqli_error($koneksi));

    mysqli_stmt_bind_param($stmt, "isss",
        $admin['id_admin'], $judul, $isi, $tanggal
    );

    if (!mysqli_stmt_execute($stmt)) die("Execute failed: " . mysqli_stmt_error($stmt));

    mysqli_stmt_close($stmt);

    $msg = "Berita berhasil ditambahkan!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Berita</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}

.container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
}

.card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    padding: 30px;
    width: 600px;
}

.card h2 {
    margin-top: 0;
    text-align: center;
    color: #0d6efd;
}

input[type="text"], textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0 20px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 14px;
}

textarea {
    resize: vertical;
}

.btn {
    background-color: #0d6efd;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.msg {
    text-align: center;
    color: green;
    margin-bottom: 20px;
}
</style>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector: 'textarea#isi',
    plugins: 'image media link code lists',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code',
    height: 400,

    images_upload_url: 'upload_image.php',
    automatic_uploads: true,

    images_upload_handler: function (blobInfo, progress) {
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload_image.php');
            xhr.onload = function() {
                if (xhr.status != 200) {
                    reject('Upload error: ' + xhr.status);
                    return;
                }

                var json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON response');
                    return;
                }

                resolve(json.location);
            };

            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        });
    }
});
</script>

</head>
<body>

<div class="container">
    <div class="card">
        <h2>Tambah Berita</h2>

        <?php if ($msg): ?>
            <div class="msg"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Judul</label>
            <input type="text" name="judul" required placeholder="Masukkan judul berita">

            <label>Isi Berita</label>
            <textarea id="isi" name="isi" required></textarea>

            <button class="btn" type="submit">Simpan</button>
        </form>
    </div>
</div>

</body>
</html>
