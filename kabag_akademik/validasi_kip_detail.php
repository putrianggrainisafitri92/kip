<?php
include '../protect.php';
check_level(13); // Admin3/Admin1
include '../koneksi.php';
include 'sidebar.php';

if(!isset($_GET['skema']) || !isset($_GET['tahun'])){
    echo "Batch tidak ditemukan.";
    exit;
}

$skema = $_GET['skema'];
$tahun = intval($_GET['tahun']);

// Ambil semua mahasiswa di batch ini
$stmt = $koneksi->prepare("SELECT * FROM mahasiswa_kip WHERE TRIM(skema)=? AND tahun=? ORDER BY nama_mahasiswa ASC");
$stmt->bind_param("si", $skema, $tahun);
$stmt->execute();
$res = $stmt->get_result();
?>

<div style="margin-left:220px; padding:20px;">
    <h2>Detail Batch: <?= htmlspecialchars(trim($skema) . " / " . $tahun); ?></h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>NPM</th>
            <th>Nama Mahasiswa</th>
            <th>Prodi</th>
            <th>Jurusan</th>
            <th>Status</th>
            <th>Catatan Revisi</th>
        </tr>

        <?php $no=1; while($d = $res->fetch_assoc()){ ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($d['npm']); ?></td>
            <td><?= htmlspecialchars($d['nama_mahasiswa']); ?></td>
            <td><?= htmlspecialchars($d['program_studi']); ?></td>
            <td><?= htmlspecialchars($d['jurusan']); ?></td>
            <td><?= ucfirst($d['status']); ?></td>
            <td><?= htmlspecialchars($d['catatan_revisi'] ?? '-'); ?></td>
        </tr>
        <?php } ?>
    </table>

    <?php
    // Tombol APPROVED / REJECTED hanya jika batch masih pending
    $stmt2 = $koneksi->prepare("SELECT COUNT(*) AS pending_count FROM mahasiswa_kip WHERE TRIM(skema)=? AND tahun=? AND status='pending'");
    $stmt2->bind_param("si", $skema, $tahun);
    $stmt2->execute();
    $res2 = $stmt2->get_result()->fetch_assoc();
    if($res2['pending_count'] > 0){
    ?>
    <p>
        <a href="validasi_kip_proses.php?skema=<?= urlencode($skema); ?>&tahun=<?= $tahun; ?>&status=approved"
           onclick="return confirm('Setujui semua mahasiswa pada batch ini?')">APPROVED</a> | 
        <a href="#" 
           onclick="
              var catatan = prompt('Masukkan catatan revisi untuk batch ini:');
              if(catatan != null){
                 window.location.href='validasi_kip_proses.php?skema=<?= urlencode($skema); ?>&tahun=<?= $tahun; ?>&status=rejected&catatan='+encodeURIComponent(catatan);
              }
              return false;
           ">REJECTED</a>
    </p>
    <?php } ?>
</div>
