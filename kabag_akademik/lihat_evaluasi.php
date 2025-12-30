<?php
include $_SERVER['DOCUMENT_ROOT'] . '../koneksi.php';
session_start();

if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['12', '13'])) {
    die("Akses ditolak!");
}

// ==== PROSES VERIFIKASI ====
if (isset($_GET['verifikasi'])) {
    $id = intval($_GET['verifikasi']);
    mysqli_query($koneksi, "
        UPDATE evaluasi 
        SET status_verifikasi='Diterima' 
        WHERE id_eval=$id
    ");
    header("Location: evaluasi_list.php");
    exit;
}

if (isset($_GET['unverified'])) {
    $id = intval($_GET['unverified']);
    mysqli_query($koneksi, "
        UPDATE evaluasi 
        SET status_verifikasi='Belum Diverifikasi' 
        WHERE id_eval=$id
    ");
    header("Location: evaluasi_list.php");
    exit;
}

if (isset($_GET['batalkan'])) {
    $id = intval($_GET['batalkan']);
    mysqli_query($koneksi, "
        UPDATE evaluasi 
        SET status_verifikasi=NULL 
        WHERE id_eval=$id
    ");
    header("Location: evaluasi_list.php");
    exit;
}


if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    mysqli_begin_transaction($koneksi);

    try {
        // Ambil id_mahasiswa_kip
        $q = mysqli_query($koneksi, "SELECT id_mahasiswa_kip FROM evaluasi WHERE id_eval=$id");
        $row = mysqli_fetch_assoc($q);

        if (!$row) {
            throw new Exception("Data tidak ditemukan");
        }

        $idm = (int)$row['id_mahasiswa_kip'];

        // Hapus file fisik
        $qf = mysqli_query($koneksi, "SELECT file_eval FROM file_eval WHERE id_mahasiswa_kip=$idm");
        while ($f = mysqli_fetch_assoc($qf)) {
            $path = $_SERVER['DOCUMENT_ROOT'] . '../uploads/evaluasi/' . $f['file_eval'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Hapus tabel turunan
        mysqli_query($koneksi, "DELETE FROM file_eval WHERE id_mahasiswa_kip=$idm");
        mysqli_query($koneksi, "DELETE FROM keluarga WHERE id_mahasiswa_kip=$idm");
        mysqli_query($koneksi, "DELETE FROM transportasi WHERE id_mahasiswa_kip=$idm");

        // Terakhir hapus evaluasi
        mysqli_query($koneksi, "DELETE FROM evaluasi WHERE id_eval=$id");

        mysqli_commit($koneksi);

        header("Location: evaluasi_list.php?deleted=1");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "Gagal hapus: " . $e->getMessage();
    }
}


// ==== AMBIL SEMUA DATA LIST ====
$where = "";

if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $where = "WHERE m.nama_mahasiswa LIKE '%$keyword%' 
              OR m.npm LIKE '%$keyword%'";
}

$sql = "SELECT e.*, m.nama_mahasiswa, m.npm, m.program_studi, m.jurusan,
               fe.file_eval
        FROM evaluasi e
        JOIN mahasiswa_kip m ON e.id_mahasiswa_kip = m.id_mahasiswa_kip
        LEFT JOIN file_eval fe ON e.id_mahasiswa_kip = fe.id_mahasiswa_kip
        $where
        ORDER BY e.submitted_at DESC";


$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin - Data Evaluasi</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        background: #efeaff; /* Background lembut tanpa gambar */
    }
</style>
</head>

<body class="min-h-screen">

<?php include 'sidebar.php'; ?>

<div class="ml-64 mt-10 p-8">

<?php if(isset($_GET['verified'])): ?>
  <div class="bg-green-100 text-green-800 p-3 rounded mb-4">Data berhasil diverifikasi ✅</div>
<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>
  <div class="bg-red-100 text-red-800 p-3 rounded mb-4">Data berhasil dihapus ✅</div>
<?php endif; ?>

<div class="flex gap-3 mb-5">

    <a href="verifikasi_all.php" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold shadow">
        Verifikasi Semua
    </a>

    <a href="hapus_all.php" 
        onclick="return confirm('Yakin ingin menghapus semua data?')"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow">
        Hapus Semua
    </a>

</div>


<div class="bg-white shadow-xl p-6 rounded-2xl">
<h1 class="text-3xl font-bold text-purple-800 mb-5">📑 Data Evaluasi Mahasiswa</h1>

<form method="GET" class="mb-4 flex gap-3">
    <input type="text"
           name="keyword"
           value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
           placeholder="Cari Nama atau NPM..."
           class="border px-4 py-2 rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-purple-500">

    <button type="submit"
            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold">
        Cari
    </button>

    <?php if (isset($_GET['keyword']) && $_GET['keyword'] !== ''): ?>
        <a href="evaluasi_list.php"
           class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold">
            Reset
        </a>
    <?php endif; ?>
</form>


<div class="overflow-x-auto">
<table class="w-full border text-sm rounded-lg overflow-hidden">
  <thead class="bg-purple-800 text-white">
    <tr>
      <th class="p-3 text-left">No</th>
      <th class="p-3 text-left">Nama</th>
      <th class="p-3 text-left">Prodi / Jurusan</th>
      <th class="p-3 text-center">File Evaluasi</th>
      <th class="p-3 text-center">Generate PDF</th>
      <th class="p-3 text-center">Status</th>
      <th class="p-3 text-center">Aksi</th>
    </tr>
  </thead>

  <tbody>

<?php
if ($result && mysqli_num_rows($result) > 0) {
  $no = 1;

  while ($row = mysqli_fetch_assoc($result)) {

    $pathEvaluasi  = '../uploads/evaluasi/' . ($row['file_eval'] ?? '');
 

    echo "<tr class='border-b hover:bg-purple-50 transition'>";
    echo "<td class='p-3'>$no</td>";

    echo "<td class='p-3 font-semibold'>" . htmlspecialchars($row['nama_mahasiswa']) . "<br>
            <span class='text-xs text-gray-500'>NPM: " . htmlspecialchars($row['npm']) . "</span>
          </td>";

    echo "<td class='p-3'>" . htmlspecialchars($row['program_studi']) . "<br>
            <span class='text-xs'>" . htmlspecialchars($row['jurusan']) . "</span>
          </td>";

    // FILE EVALUASI
    echo "<td class='p-3 text-center'>";
    echo (!empty($row['file_eval']))
          ? "<a href='$pathEvaluasi' target='_blank'  class='bg-yellow-300 hover:bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold'>Lihat</a>"
          : "-";
    echo "</td>";

    // PDF
    echo "<td class='p-3 text-center'>
            <a href='generate_pdf.php?id={$row['id_eval']}' 
               class='bg-blue-300 hover:bg-blue-400 text-white-900 px-3 py-1 rounded-full text-xs font-bold'>
               Generate
            </a>
          </td>";

    echo "<td class='p-3 text-center'>";

if ($row['status_verifikasi'] === 'Diterima') {

    // VERIFIED
    echo "
        <span class='bg-green-500 text-white px-3 py-1 rounded-full text-xs block mb-2 font-semibold'>
            Verified
        </span>
        <a href='?batalkan={$row['id_eval']}'
           class='inline-block bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-full text-xs'>
            Batalkan
        </a>
    ";

} elseif ($row['status_verifikasi'] === 'Belum Diverifikasi') {

    // UNVERIFIED
    echo "
        <span class='bg-red-500 text-white px-3 py-1 rounded-full text-xs block mb-2 font-semibold'>
            Unverified
        </span>
        <a href='?batalkan={$row['id_eval']}'
           class='inline-block bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-full text-xs'>
            Batalkan
        </a>
    ";

} else {

    // KONDISI AWAL (BELUM DIPILIH)
    echo "
        <a href='?unverified={$row['id_eval']}'
           class='inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs mr-1'>
            Unverified
        </a>
        <a href='?verifikasi={$row['id_eval']}'
           class='inline-block bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full text-xs'>
            Verified
        </a>
    ";
}

echo "</td>";







    // AKSI
    echo "<td class='p-3 text-center'>
            <a href='?hapus={$row['id_eval']}' 
               onclick='return confirm(\"Yakin hapus data?\")'
               class='bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold'>
               Hapus
            </a>
          </td>";

    echo "</tr>";
    $no++;
  }

} else {
  echo "<tr><td colspan='10' class='text-center p-4 text-gray-500 italic'>Belum ada data evaluasi</td></tr>";
}
?>

  </tbody>
</table>
</div>

</div>
</div>

</body>
</html>