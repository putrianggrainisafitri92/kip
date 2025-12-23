<?php
include '../sidebar.php';
include '../../koneksi.php';

// -------------------- HAPUS DATA --------------------
$msg = "";

if (isset($_POST['hapus_tahun'])) {
    $tahun_hapus = $_POST['tahun_hapus'];
    $stmt = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE tahun = ?");
    $stmt->bind_param("s", $tahun_hapus);
    $stmt->execute();
    $stmt->close();
    $msg = "✅ Data tahun <b>$tahun_hapus</b> berhasil dihapus!";
}

if (isset($_POST['hapus_jurusan'])) {
    $jurusan_hapus = $_POST['jurusan_hapus'];
    $stmt = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE jurusan = ?");
    $stmt->bind_param("s", $jurusan_hapus);
    $stmt->execute();
    $stmt->close();
    $msg = "✅ Data jurusan <b>$jurusan_hapus</b> berhasil dihapus!";
}

if (isset($_POST['hapus_prodi'])) {
    $prodi_hapus = $_POST['prodi_hapus'];
    $stmt = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE program_studi = ?");
    $stmt->bind_param("s", $prodi_hapus);
    $stmt->execute();
    $stmt->close();
    $msg = "✅ Data program studi <b>$prodi_hapus</b> berhasil dihapus!";
}

if (isset($_POST['hapus_npm'])) {
    $npm_hapus = trim($_POST['npm_hapus']);
    
    // Cek apakah NPM ada
    $cek = $koneksi->prepare("SELECT npm FROM mahasiswa_kip WHERE npm = ?");
    $cek->bind_param("s", $npm_hapus);
    $cek->execute();
    $result = $cek->get_result();
    
    if ($result->num_rows > 0) {
        $stmt = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE npm = ?");
        $stmt->bind_param("s", $npm_hapus);
        $stmt->execute();
        $stmt->close();
        $msg = "✅ Data mahasiswa dengan NPM <b>$npm_hapus</b> berhasil dihapus!";
    } else {
        $msg = "⚠️ NPM <b>$npm_hapus</b> tidak ditemukan di database!";
    }
    
    $cek->close();
}

// -------------------- DROPDOWN --------------------
$tahunList = $koneksi->query("SELECT DISTINCT tahun FROM mahasiswa_kip ORDER BY tahun ASC");
$jurusanList = $koneksi->query("SELECT DISTINCT jurusan FROM mahasiswa_kip ORDER BY jurusan ASC");
$prodiList = $koneksi->query("SELECT DISTINCT program_studi FROM mahasiswa_kip ORDER BY program_studi ASC");
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>🗑️ Hapus Data Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; font-family: "Segoe UI", sans-serif; }
    .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
    @media (max-width: 768px) { .main-content { margin-left: 0; padding: 20px; } }
    h2 i { margin-right: 10px; }
    .form-select, .form-control { border-radius: 8px; }
    .btn-danger { border-radius: 8px; font-weight: 600; }
    .bg-white.shadow-sm { transition: 0.3s; }
    .bg-white.shadow-sm:hover { transform: scale(1.02); }
  </style>
</head>
<body>

<div class="main-content">
  <div class="container bg-light rounded shadow p-4">
    <h2 class="text-danger mb-4"><i class="fas fa-trash-alt"></i> Hapus Data Mahasiswa</h2>

    <?php if ($msg) : ?>
      <div class="alert alert-success text-center"><?= $msg; ?></div>
    <?php endif; ?>

    <div class="alert alert-warning">
      <i class="fas fa-exclamation-triangle"></i>
      <strong>Perhatian:</strong> Penghapusan data bersifat permanen dan tidak dapat dibatalkan!
    </div>

    <div class="row g-4">
      <!-- Hapus Per Tahun -->
      <div class="col-md-6">
        <form method="post" class="p-3 border rounded bg-white shadow-sm">
          <h5><i class="fas fa-calendar-alt"></i> Hapus Berdasarkan Tahun</h5>
          <select name="tahun_hapus" required class="form-select my-2">
            <option value="">-- Pilih Tahun --</option>
            <?php while ($row = $tahunList->fetch_assoc()) : ?>
              <option value="<?= htmlspecialchars($row['tahun']); ?>"><?= htmlspecialchars($row['tahun']); ?></option>
            <?php endwhile; ?>
          </select>
          <button type="submit" name="hapus_tahun" class="btn btn-danger w-100">🗑️ Hapus Data</button>
        </form>
      </div>

      <!-- Hapus Per Jurusan -->
      <div class="col-md-6">
        <form method="post" class="p-3 border rounded bg-white shadow-sm">
          <h5><i class="fas fa-graduation-cap"></i> Hapus Berdasarkan Jurusan</h5>
          <select name="jurusan_hapus" required class="form-select my-2">
            <option value="">-- Pilih Jurusan --</option>
            <?php while ($row = $jurusanList->fetch_assoc()) : ?>
              <option value="<?= htmlspecialchars($row['jurusan']); ?>"><?= htmlspecialchars($row['jurusan']); ?></option>
            <?php endwhile; ?>
          </select>
          <button type="submit" name="hapus_jurusan" class="btn btn-danger w-100">🗑️ Hapus Data</button>
        </form>
      </div>

      <!-- Hapus Per Program Studi -->
      <div class="col-md-6">
        <form method="post" class="p-3 border rounded bg-white shadow-sm">
          <h5><i class="fas fa-book"></i> Hapus Berdasarkan Program Studi</h5>
          <select name="prodi_hapus" required class="form-select my-2">
            <option value="">-- Pilih Program Studi --</option>
            <?php while ($row = $prodiList->fetch_assoc()) : ?>
              <option value="<?= htmlspecialchars($row['program_studi']); ?>"><?= htmlspecialchars($row['program_studi']); ?></option>
            <?php endwhile; ?>
          </select>
          <button type="submit" name="hapus_prodi" class="btn btn-danger w-100">🗑️ Hapus Data</button>
        </form>
      </div>

      <!-- Hapus Per NPM -->
      <div class="col-md-6">
        <form method="post" class="p-3 border rounded bg-white shadow-sm">
          <h5><i class="fas fa-id-card"></i> Hapus Berdasarkan NPM</h5>
          <input type="text" name="npm_hapus" placeholder="Masukkan NPM Mahasiswa" required class="form-control my-2">
          <button type="submit" name="hapus_npm" class="btn btn-danger w-100">🗑️ Hapus Data</button>
        </form>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Data Mahasiswa
      </a>
    </div>
  </div>
</div>

</body>
</html>
