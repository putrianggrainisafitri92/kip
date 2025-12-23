<?php
include $_SERVER['DOCUMENT_ROOT'] . '/KIPWEB/koneksi.php';
session_start();

// ==== PROSES VERIFIKASI ====
if (isset($_GET['verifikasi'])) {
    $id = intval($_GET['verifikasi']);
    mysqli_query($koneksi, "UPDATE evaluasi SET status_verifikasi='Diterima' WHERE id_eval=$id");
    header("Location: evaluasi_list.php?verified=1");
    exit;
}

// ==== PROSES HAPUS ====
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $get = mysqli_query($koneksi, "SELECT e.*, fe.file_eval, fe.file_revisi1, fe.file_revisi2
             FROM evaluasi e
             LEFT JOIN file_eval fe ON e.id_mahasiswa_kip = fe.id_mahasiswa_kip
             WHERE e.id_eval=$id");
    $data = mysqli_fetch_assoc($get);

    if ($data) {
        $files = [
            $_SERVER['DOCUMENT_ROOT'] . '/KIPWEB/uploads/evaluasi/' . ($data['file_eval'] ?? ''),
            $_SERVER['DOCUMENT_ROOT'] . '/KIPWEB/uploads/evaluasi/' . ($data['file_revisi1'] ?? ''),
            $_SERVER['DOCUMENT_ROOT'] . '/KIPWEB/uploads/evaluasi/' . ($data['file_revisi2'] ?? ''),
            $_SERVER['DOCUMENT_ROOT'] . '/KIPWEB/uploads/evaluasi/' . ($data['pdf_hasil_form'] ?? ''),
        ];

        foreach ($files as $file) {
            if (!empty($file) && file_exists($file)) {
                unlink($file);
            }
        }

        mysqli_query($koneksi, "DELETE FROM evaluasi WHERE id_eval=$id");
        header("Location: evaluasi_list.php?deleted=1");
        exit;
    }
}

// ==== AMBIL SEMUA DATA LIST (TANPA WHERE) ====
$sql = "SELECT e.*, m.nama_mahasiswa, m.npm, m.program_studi, m.jurusan,
               fe.file_eval, fe.file_revisi1, fe.file_revisi2
        FROM evaluasi e
        JOIN mahasiswa_kip m ON e.id_mahasiswa_kip = m.id_mahasiswa_kip
        LEFT JOIN file_eval fe ON e.id_mahasiswa_kip = fe.id_mahasiswa_kip
        ORDER BY e.submitted_at DESC";

$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin - Data Evaluasi</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<?php include 'sidebar.php'; ?>

<div class="ml-64 mt-10 p-8">
<?php if(isset($_GET['verified'])): ?>
  <div class="bg-green-100 text-green-800 p-3 rounded mb-4">Data berhasil diverifikasi ✅</div>
<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>
  <div class="bg-red-100 text-red-800 p-3 rounded mb-4">Data berhasil dihapus ✅</div>
<?php endif; ?>

<div class="bg-white shadow-lg p-6 rounded-xl">
<h1 class="text-2xl font-bold text-purple-800 mb-5">📑 List Evaluasi Mahasiswa</h1>

<div class="overflow-x-auto">
<table class="w-full border text-sm">
  <thead class="bg-purple-800 text-white">
    <tr>
      <th class="p-2 text-left">No</th>
      <th class="p-2 text-left">Nama</th>
      <th class="p-2 text-left">Prodi / Jurusan</th>
      <th class="p-2 text-center">File Evaluasi</th>
      <th class="p-2 text-center">Revisi 1</th>
      <th class="p-2 text-center">Revisi 2</th>
      <th class="p-2 text-center">PDF Hasil Form</th>
      <th class="p-2 text-center">Generate PDF</th>
      <th class="p-2 text-center">Status</th>
      <th class="p-2 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>

<?php
if ($result && mysqli_num_rows($result) > 0) {
  $no = 1;
  while ($row = mysqli_fetch_assoc($result)) {

    $pathEvaluasi  = '/KIPWEB/uploads/evaluasi/' . ($row['file_eval'] ?? '');
    $pathRevisi1   = '/KIPWEB/uploads/evaluasi/' . ($row['file_revisi1'] ?? '');
    $pathRevisi2   = '/KIPWEB/uploads/evaluasi/' . ($row['file_revisi2'] ?? '');
    $pathHasilPdf  = '/KIPWEB/uploads/evaluasi/' . ($row['pdf_hasil_form'] ?? '');

    echo "<tr class='border-b hover:bg-gray-50'>";
    echo "<td class='p-2'>$no</td>";

    echo "<td class='p-2 font-semibold'>" . htmlspecialchars($row['nama_mahasiswa']) . "<br>
            <span class='text-xs text-gray-500'>NPM: " . htmlspecialchars($row['npm']) . "</span>
          </td>";

    echo "<td class='p-2'>" . htmlspecialchars($row['program_studi']) . "<br>
            <span class='text-xs'>" . htmlspecialchars($row['jurusan']) . "</span>
          </td>";

    // ==== FILE EVALUASI ====
    echo "<td class='p-2 text-center'>";
    echo (!empty($row['file_eval']) && file_exists($_SERVER['DOCUMENT_ROOT'].$pathEvaluasi))
          ? "<a href='$pathEvaluasi' target='_blank' class='text-blue-600 underline'>Lihat</a>"
          : "<span class='text-gray-400'>-</span>";
    echo "</td>";

    // ==== REVISI 1 ====
    echo "<td class='p-2 text-center'>";
    echo (!empty($row['file_revisi1']) && file_exists($_SERVER['DOCUMENT_ROOT'].$pathRevisi1))
          ? "<a href='$pathRevisi1' target='_blank' class='text-blue-600 underline'>Lihat</a>"
          : "<span class='text-gray-400'>-</span>";
    echo "</td>";

    // ==== REVISI 2 ====
    echo "<td class='p-2 text-center'>";
    echo (!empty($row['file_revisi2']) && file_exists($_SERVER['DOCUMENT_ROOT'].$pathRevisi2))
          ? "<a href='$pathRevisi2' target='_blank' class='text-blue-600 underline'>Lihat</a>"
          : "<span class='text-gray-400'>-</span>";
    echo "</td>";

    // ==== PDF HASIL FORM (TIDAK HILANG) ====
    echo "<td class='p-2 text-center'>";
    echo (!empty($row['pdf_hasil_form']) && file_exists($_SERVER['DOCUMENT_ROOT'].$pathHasilPdf))
          ? "<a href='$pathHasilPdf' target='_blank' class='bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs'>Lihat PDF</a>"
          : "<span class='text-gray-400 text-xs italic'>Belum ada</span>";
    echo "</td>";

    // ==== GENERATE PDF ====
    echo "<td class='p-2 text-center'>
            <a href='generate_pdf.php?id={$row['id_eval']}' class='bg-yellow-200 hover:bg-yellow-300 text-yellow-900 px-3 py-1 rounded-full text-xs font-semibold'>Generate PDF</a>
          </td>";

    // ==== STATUS ====
    echo "<td class='p-2 text-center'>";
    echo ($row['status_verifikasi'] == 'Diterima')
          ? "<span class='bg-green-500 text-white px-2 py-1 rounded-full text-xs'>Verified</span>"
          : "<span class='bg-red-400 text-white px-2 py-1 rounded-full text-xs'>Unverified</span><br>
             <a href='?verifikasi={$row['id_eval']}' onclick='return confirm(\"Verifikasi data ini?\")' class='text-purple-700 text-xs underline'>Verifikasi</a>";
    echo "</td>";

    // ==== AKSI HAPUS ====
    echo "<td class='p-2 text-center'>
            <a href='?hapus={$row['id_eval']}' onclick='return confirm(\"Yakin hapus data?\")' class='bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold'>Hapus</a>
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
