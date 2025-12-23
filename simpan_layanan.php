<?php
include 'koneksi.php';

// Cek semua input
if (!isset($_POST['jenis'], $_POST['nama'], $_POST['email'], $_POST['pesan'])) {
    echo "<script>
            alert('Form tidak lengkap.');
            window.history.back();
          </script>";
    exit;
}

$jenis  = mysqli_real_escape_string($koneksi, $_POST['jenis']);
$nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
$email  = mysqli_real_escape_string($koneksi, $_POST['email']);
$pesan  = mysqli_real_escape_string($koneksi, $_POST['pesan']);

// Cek input kosong
if ($jenis == "" || $nama == "" || $email == "" || $pesan == "") {
    echo "<script>
            alert('Semua field harus diisi!');
            window.history.back();
          </script>";
    exit;
}

// Tentukan tabel tujuan
if ($jenis === "saran") {
    $query = "INSERT INTO saran (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
    $redirect = 'form_saran_pertanyaan.php'; // ganti sesuai nama file form
} elseif ($jenis === "pertanyaan") {
    $query = "INSERT INTO pertanyaan (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
    $redirect = 'form_saran_pertanyaan.php'; // ganti sesuai nama file form
} else {
    echo "<script>
            alert('Jenis tidak valid!');
            window.history.back();
          </script>";
    exit;
}

// Eksekusi query
if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Pesan berhasil dikirim!');
            window.location.href = '$redirect';
          </script>";
    exit;
} else {
    echo "<script>
            alert('Gagal menyimpan data. Silakan coba lagi.');
            window.history.back();
          </script>";
}
?>
