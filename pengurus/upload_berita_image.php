<?php

// PATH FISIK
$uploadDirDisk = realpath(__DIR__ . '/../uploads/berita') . '/';

// URL (HARUS bisa diakses browser)
$uploadDirUrl  = '/uploads/berita/';

// Buat folder jika belum ada
if (!is_dir($uploadDirDisk)) {
    mkdir($uploadDirDisk, 0777, true);
}

$funcNum = $_GET['CKEditorFuncNum'] ?? 1;

if (isset($_FILES['upload']) && $_FILES['upload']['error'] === 0) {

    $ext = strtolower(pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed)) {
        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', 'Format file tidak diizinkan');</script>";
        exit;
    }

    // Bersihkan nama file
    $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES['upload']['name']);

    $filename = time() . "_" . $safeName;
    $target = $uploadDirDisk . $filename;

    if (move_uploaded_file($_FILES['upload']['tmp_name'], $target)) {

        // URL harus absolut (tidak boleh ../)
        $fileUrl = $uploadDirUrl . $filename;

        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$fileUrl');</script>";
    } else {
        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', 'Gagal upload');</script>";
    }

} else {
    echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', 'Tidak ada file');</script>";
}
