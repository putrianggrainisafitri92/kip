<?php
include 'koneksi.php';

// Check if biaya_hidup data exists
$check = mysqli_query($koneksi, "SELECT count(*) as total FROM pedoman_tahapan WHERE kategori='biaya_hidup'");
$row = mysqli_fetch_assoc($check);

if ($row['total'] == 0) {
    // Seed data
    $data = [
        ['biaya_hidup', 'Rp 800.000', 'Klaster 1', 1],
        ['biaya_hidup', 'Rp 950.000', 'Klaster 2', 2],
        ['biaya_hidup', 'Rp 1.100.000', 'Klaster 3', 3],
        ['biaya_hidup', 'Rp 1.250.000', 'Klaster 4', 4],
        ['biaya_hidup', 'Rp 1.400.000', 'Klaster 5', 5]
    ];

    foreach ($data as $item) {
        $kategori = $item[0];
        $judul = mysqli_real_escape_string($koneksi, $item[1]);
        $deskripsi = mysqli_real_escape_string($koneksi, $item[2]);
        $urutan = $item[3];

        // Insert with Approved status so it shows up immediately, or pending? User said "tambahkan edit", presumably existing data should be there.
        // Let's make them approved initially.
        $insert = "INSERT INTO pedoman_tahapan (kategori, judul, deskripsi, urutan, status) VALUES ('$kategori', '$judul', '$deskripsi', '$urutan', 'approved')";
        mysqli_query($koneksi, $insert);
    }
    echo "Biaya hidup seeded successfully.";
} else {
    echo "Biaya hidup data already exists.";
}
?>
