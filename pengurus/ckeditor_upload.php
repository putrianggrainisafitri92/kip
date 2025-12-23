<?php
// ckeditor_upload.php
// simple upload handler for CKEditor inline image uploads

// konfigurasi
$uploadDirDisk = __DIR__ . '/../uploads/berita/';
$uploadDirUrl  = '/uploads/berita/'; // atau '/kipweb/uploads/berita/' jika aplikasi di subfolder

if (!is_dir($uploadDirDisk)) mkdir($uploadDirDisk, 0777, true);

$funcNum = $_GET['CKEditorFuncNum'] ?? 1;
$url = '';
$msg = '';

if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] === 0) {
    $safe = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['upload']['name']));
    $ext = strtolower(pathinfo($safe, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];

    if (!in_array($ext, $allowed)) {
        $msg = 'Format file tidak diizinkan';
    } else {
        $filename = time() . '_' . rand(100,999) . '_' . $safe;
        $target = $uploadDirDisk . $filename;
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $target)) {
            // gunakan URL yang dapat diakses oleh browser
            $url = $uploadDirUrl . $filename;
        } else {
            $msg = 'Gagal meng-upload file';
        }
    }
} else {
    $msg = 'Tidak ada file';
}

echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$msg');</script>";
