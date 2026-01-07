<?php
include 'koneksi.php';

// Add status column if not exists
$check = mysqli_query($koneksi, "SHOW COLUMNS FROM pedoman_tahapan LIKE 'status'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($koneksi, "ALTER TABLE pedoman_tahapan ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    // Update existing rows to approved so they don't disappear
    mysqli_query($koneksi, "UPDATE pedoman_tahapan SET status='approved'");
    echo "Added status column.<br>";
}

// Add catatan_revisi column if not exists
$check2 = mysqli_query($koneksi, "SHOW COLUMNS FROM pedoman_tahapan LIKE 'catatan_revisi'");
if (mysqli_num_rows($check2) == 0) {
    mysqli_query($koneksi, "ALTER TABLE pedoman_tahapan ADD COLUMN catatan_revisi TEXT NULL");
    echo "Added catatan_revisi column.<br>";
}

echo "Database update complete.";
?>
