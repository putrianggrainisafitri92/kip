<?php
include 'koneksi.php';

$id = intval($_GET['id']);

// tampilkan berita yang disetujui
$q = $koneksi->prepare("SELECT * FROM berita WHERE id_berita = ? AND status = 'approved' LIMIT 1");
$q->bind_param("i", $id);
$q->execute();
$res = $q->get_result();
$berita = $res->fetch_assoc();
$q->close();

if (!$berita) {
    die("Berita tidak ditemukan atau belum disetujui.");
}

// ambil gambar terkait (urut berdasarkan sortorder)
$gq = $koneksi->prepare("SELECT * FROM berita_gambar WHERE id_berita = ? ORDER BY sortorder ASC, id_gambar ASC");
$gq->bind_param("i", $id);
$gq->execute();
$gres = $gq->get_result();
$gambars = $gres->fetch_all(MYSQLI_ASSOC);
$gq->close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($berita['judul']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="max-w-4xl mx-auto py-10 px-5">
  <div class="bg-white shadow-xl rounded-2xl p-8">

    <h1 class="text-4xl font-extrabold text-purple-700 mb-4">
        <?= htmlspecialchars($berita['judul']) ?>
    </h1>

    <p class="text-gray-500 text-sm mb-6">
        Dipublikasikan pada: <?= date('d M Y', strtotime($berita['tanggal'])) ?>
    </p>

    <!-- TAMPILKAN GAMBAR (FULL WIDTH) + CAPTION -->
    <?php foreach ($gambars as $g): ?>
      <div class="mb-8 bg-white border rounded-xl overflow-hidden shadow-sm">
        <img src="uploads/berita/<?= htmlspecialchars($g['file']) ?>" 
             class="w-full object-cover max-h-[650px]">

       <?php if (!empty($g['caption'])): ?>
  <div class="px-4 py-5 border-t bg-gray-50">
      <p class="text-gray-800 text-base leading-relaxed text-justify whitespace-pre-line">
    <?= nl2br(htmlspecialchars($g['caption'])) ?>
</p>

  </div>
<?php endif; ?>

      </div>
    <?php endforeach; ?>

    <a href="index.php#berita" 
       class="inline-block mt-8 px-5 py-3 rounded-lg bg-purple-600 text-white">
       ← Kembali ke Berita
    </a>

  </div>
</div>

</body>
</html>
