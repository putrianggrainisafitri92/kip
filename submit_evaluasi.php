<?php
session_start();
include 'koneksi.php'; // koneksi database

// ---- VALIDASI LOGIN ----
if (!isset($_SESSION['npm'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil id_mahasiswa_kip dari DB berdasarkan NPM
$npm = $_SESSION['npm'];
$stmt = $koneksi->prepare("SELECT id_mahasiswa_kip FROM mahasiswa_kip WHERE npm = ? LIMIT 1");
$stmt->bind_param("s", $npm);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
if (!$user) die("Data mahasiswa tidak ditemukan untuk NPM $npm");

$id = $user['id_mahasiswa_kip'];

// Pastikan semua session tahap tersedia
$tahap1 = $_SESSION['tahap1'] ?? [];
$tahap2 = $_SESSION['tahap2'] ?? [];
$tahap3 = $_SESSION['tahap3'] ?? [];
$tahap4 = $_SESSION['tahap4'] ?? [];

if (empty($tahap1) || empty($tahap2) || empty($tahap3)) {
    die("Data evaluasi belum lengkap. Lengkapi semua tahap terlebih dahulu.");
}

// --- AMBIL DATA DARI SESSION DAN ESCAPE ---
$persetujuan       = mysqli_real_escape_string($koneksi, $tahap1['persetujuan'] ?? '');
$kondisi_awal      = mysqli_real_escape_string($koneksi, isset($tahap2['kondisi_awal']) ? implode(", ", $tahap2['kondisi_awal']) : '');
$kondisi_awal_lain = mysqli_real_escape_string($koneksi, $tahap2['kondisi_awal_lain'] ?? '');
$keaktifan         = mysqli_real_escape_string($koneksi, $tahap2['keaktifan'] ?? '');
$prestasi          = mysqli_real_escape_string($koneksi, $tahap2['prestasi'] ?? '');
$penerima_bansos   = mysqli_real_escape_string($koneksi, $tahap3['penerima_bansos'] ?? '');
$info_hp           = mysqli_real_escape_string($koneksi, $tahap3['info_hp'] ?? '');
$nomor_wa          = mysqli_real_escape_string($koneksi, $tahap3['nomor_wa'] ?? '');

// --- SIMPAN/UPDATE TABEL EVALUASI ---
$cekEval = mysqli_query($koneksi, "SELECT id_eval FROM evaluasi WHERE id_mahasiswa_kip='$id' LIMIT 1");
if($cekEval && mysqli_num_rows($cekEval) > 0){
    mysqli_query($koneksi, "
        UPDATE evaluasi SET
            persetujuan='$persetujuan',
            kondisi_awal='$kondisi_awal',
            kondisi_awal_lain='$kondisi_awal_lain',
            keaktifan='$keaktifan',
            prestasi='$prestasi',
            penerima_bansos='$penerima_bansos',
            info_hp='$info_hp',
            nomor_wa='$nomor_wa',
            submitted_at=NOW()
        WHERE id_mahasiswa_kip='$id'
    ");
} else {
    mysqli_query($koneksi, "
        INSERT INTO evaluasi
        (id_mahasiswa_kip, persetujuan, kondisi_awal, kondisi_awal_lain, keaktifan, prestasi, penerima_bansos, info_hp, nomor_wa, submitted_at)
        VALUES
        ('$id','$persetujuan','$kondisi_awal','$kondisi_awal_lain','$keaktifan','$prestasi','$penerima_bansos','$info_hp','$nomor_wa',NOW())
    ");
}

// --- SIMPAN FILE TAHAP 4 ---
$file_eval  = mysqli_real_escape_string($koneksi, $tahap4['file_eval'] ?? '');


$cekFile = mysqli_query($koneksi, "SELECT id_file FROM file_eval WHERE id_mahasiswa_kip='$id' LIMIT 1");
if($cekFile && mysqli_num_rows($cekFile) > 0){
    mysqli_query($koneksi, "
        UPDATE file_eval SET
            file_eval='$file_eval',
          
            uploaded_at=NOW()
        WHERE id_mahasiswa_kip='$id'
    ");
} else {
    mysqli_query($koneksi, "
        INSERT INTO file_eval
        (id_mahasiswa_kip, file_eval, uploaded_at)
        VALUES
        ('$id','$file_eval','$file_rev1','$file_rev2',NOW())
    ");
}

// --- HAPUS SESSION SETELAH SUBMIT ---
unset($_SESSION['tahap1'], $_SESSION['tahap2'], $_SESSION['tahap3'], $_SESSION['tahap4']);


?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Terima Kasih | KIP Kuliah Polinela</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
}
.animate-bounce-slow {
  animation: bounce 1.8s infinite;
}
</style>
</head>

<body class="bg-gradient-to-b from-purple-900 via-purple-800 to-purple-950 text-white min-h-screen flex flex-col justify-center items-center px-6">

<div class="bg-white text-gray-800 rounded-2xl shadow-2xl p-10 max-w-xl text-center mt-10">

    <div class="flex justify-center mb-6">
        <div class="bg-gradient-to-r from-purple-700 to-pink-600 text-white rounded-full p-5 shadow-lg animate-bounce-slow">
            <i class="bi bi-check-circle text-6xl"></i>
        </div>
    </div>

    <h1 class="text-3xl font-bold text-purple-800 mb-4">Terima Kasih!</h1>

    <p class="text-gray-700 leading-relaxed mb-6 text-left">
        Anda telah berhasil menyelesaikan proses 
        <strong>Monitoring dan Evaluasi Penerima KIP Kuliah & Bantuan Biaya Pendidikan (BBP)</strong>.<br><br>

        Semua data dan dokumen yang Anda unggah telah diterima dan akan segera diverifikasi oleh tim pengelola.
    </p>

    <div class="flex justify-center">
        <a href="form_evaluasi.php" 
           class="px-8 py-3 bg-gradient-to-r from-purple-700 to-pink-600 text-white font-semibold rounded-full shadow-md hover:scale-105 transition-transform duration-300">
            <i class="bi bi-house-door mr-2"></i> Kembali ke Beranda Evaluasi
        </a>
    </div>

</div>

<p class="text-sm text-purple-200 mt-10 mb-4">
    &copy; 2025 Politeknik Negeri Lampung | Sistem Informasi KIP Kuliah
</p>

</body>
</html>
