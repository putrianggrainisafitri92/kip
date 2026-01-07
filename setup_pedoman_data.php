<?php
include 'koneksi.php';

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS pedoman_tahapan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(50) NOT NULL,
    judul VARCHAR(255) NOT NULL,
    deskripsi VARCHAR(255),
    urutan INT DEFAULT 0
)";

if (mysqli_query($koneksi, $sql)) {
    echo "Table pedoman_tahapan created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($koneksi) . "<br>";
}

// Check if data exists
$check = mysqli_query($koneksi, "SELECT count(*) as total FROM pedoman_tahapan");
$row = mysqli_fetch_assoc($check);

if ($row['total'] == 0) {
    // Seed data
    $data = [
        // Tahapan Umum
        ['tahapan_umum', 'Pendaftaran Akun', '4 Februari – 31 Oktober 2026', 1],
        ['tahapan_umum', 'Seleksi SNBP', '4 – 18 Februari 2026', 2],
        ['tahapan_umum', 'Seleksi SNBT', '11 – 27 Maret 2026', 3],
        ['tahapan_umum', 'Mandiri PTN', '4 Juni – 30 September 2026', 4],
        ['tahapan_umum', 'Mandiri PTS', '4 Juni – 31 Oktober 2026', 5],

        // SNBP
        ['snbp', 'Registrasi Akun SNBP Siswa', '13 Januari – 18 Februari 2026', 1],
        ['snbp', 'Pendaftaran SNBP', '4 – 18 Februari 2026', 2],
        ['snbp', 'Pengumuman Hasil SNBP', '18 Maret 2026', 3],
        ['snbp', 'Masa Unduh Kartu Peserta SNBP', '4 Februari – 30 April 2026', 4],

        // UTBK
        ['utbk', 'Registrasi Akun SNPMB Siswa', '13 Januari – 27 Maret 2026', 1],
        ['utbk', 'Pendaftaran UTBK-SNBT', '11 – 27 Maret 2026', 2],
        ['utbk', 'Pembayaran Biaya UTBK', '11 – 28 Maret 2026', 3],
        ['utbk', 'Pelaksanaan UTBK', '23 April – 3 Mei 2026', 4],
        ['utbk', 'Pengumuman Hasil SNBT', '28 Mei 2026', 5],
        ['utbk', 'Masa Unduh Sertifikat UTBK', '3 Juni – 31 Juli 2026', 6],

        // KIP
        ['kip', 'Registrasi/Pendaftaran Akun KIP-K', '3 Februari – 31 Oktober 2025', 1],
        ['kip', 'Seleksi KIP-K di Perguruan Tinggi', '1 Juli – 31 Oktober 2025', 2],
        ['kip', 'Penetapan Penerima Baru', '1 Juli – 31 Oktober 2025', 3]
    ];

    foreach ($data as $item) {
        $kategori = $item[0];
        $judul = mysqli_real_escape_string($koneksi, $item[1]);
        $deskripsi = mysqli_real_escape_string($koneksi, $item[2]);
        $urutan = $item[3];

        $insert = "INSERT INTO pedoman_tahapan (kategori, judul, deskripsi, urutan) VALUES ('$kategori', '$judul', '$deskripsi', '$urutan')";
        mysqli_query($koneksi, $insert);
    }
    echo "Data seeded successfully.";
} else {
    echo "Data already exists.";
}
?>
