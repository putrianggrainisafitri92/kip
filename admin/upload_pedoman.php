<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../koneksi.php';


// Pastikan folder upload ada
$target_dir = "../uploads/pedoman/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_file = basename($_FILES["file"]["name"]);
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    // Validasi hanya PDF
    if ($ext != "pdf") {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
        exit;
    }

    // Buat nama unik biar tidak bentrok
    $nama_baru = pathinfo($nama_file, PATHINFO_FILENAME) . "_" . uniqid() . ".pdf";
    $target_file = $target_dir . $nama_baru;
    $file_path_db = "uploads/pedoman/" . $nama_baru;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO pedoman (nama_file, file_path) VALUES ('$nama_file', '$file_path_db')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('File berhasil diupload!'); window.location.href='daftar_pedoman.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan ke database.');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload file.');</script>";
    }
}
?>