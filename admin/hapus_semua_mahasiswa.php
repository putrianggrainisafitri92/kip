<?php
include "../koneksi.php";     
include "protect.php";        
include "sidebar.php";         

$msg = "";

// ============== Fungsi Hapus Aman ==================
function hapus_mahasiswa_aman($koneksi, $whereColumn, $value) {
    $stmt1 = $koneksi->prepare("DELETE fe FROM file_eval fe 
                               INNER JOIN mahasiswa_kip mk 
                               ON fe.id_mahasiswa_kip = mk.id_mahasiswa_kip 
                               WHERE mk.$whereColumn = ?");
    $stmt1->bind_param("s", $value);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE $whereColumn = ?");
    $stmt2->bind_param("s", $value);
    $stmt2->execute();
    $stmt2->close();
}

// ============== HAPUS DATA ==================
if (isset($_POST['hapus_tahun'])) {
    hapus_mahasiswa_aman($koneksi, 'tahun', $_POST['tahun_hapus']);
    $msg = "✅ Data tahun <b>{$_POST['tahun_hapus']}</b> berhasil dihapus!";
}

if (isset($_POST['hapus_jurusan'])) {
    hapus_mahasiswa_aman($koneksi, 'jurusan', $_POST['jurusan_hapus']);
    $msg = "✅ Data jurusan <b>{$_POST['jurusan_hapus']}</b> berhasil dihapus!";
}

if (isset($_POST['hapus_prodi'])) {
    hapus_mahasiswa_aman($koneksi, 'program_studi', $_POST['prodi_hapus']);
    $msg = "✅ Data program studi <b>{$_POST['prodi_hapus']}</b> berhasil dihapus!";
}

if (isset($_POST['hapus_npm'])) {
    $npm = trim($_POST['npm_hapus']);
    $cek = $koneksi->prepare("SELECT npm FROM mahasiswa_kip WHERE npm = ?");
    $cek->bind_param("s", $npm);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        hapus_mahasiswa_aman($koneksi, 'npm', $npm);
        $msg = "✅ Data mahasiswa dengan NPM <b>$npm</b> berhasil dihapus!";
    } else {
        $msg = "⚠️ NPM <b>$npm</b> tidak ditemukan!";
    }
}

// ============== Dropdown ==============
$tahunList   = $koneksi->query("SELECT DISTINCT tahun FROM mahasiswa_kip ORDER BY tahun ASC");
$jurusanList = $koneksi->query("SELECT DISTINCT jurusan FROM mahasiswa_kip ORDER BY jurusan ASC");
$prodiList   = $koneksi->query("SELECT DISTINCT program_studi FROM mahasiswa_kip ORDER BY program_studi ASC");

?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hapus Data Mahasiswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background: #f3f1ff;
        font-family: "Segoe UI", sans-serif;
    }

    .main-content {
        margin-left: 260px;
        padding: 40px;
    }

    .card-panel {
        background: #ffffff;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-left: 10px solid #6a0dad;
        transition: .3s;
    }
    .card-panel:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    .header-title {
        font-size: 28px;
        font-weight: 700;
        color: #6a0dad;
    }

    /* Ungu theme */
    .btn-ungu {
        background: #6a0dad;
        color: white;
        font-weight: 600;
        border-radius: 8px;
    }
    .btn-ungu:hover {
        background: #530a9e;
        color: white;
    }

    .danger-box {
        background: #ffeaea;
        border-left: 6px solid red;
        padding: 12px 18px;
        border-radius: 10px;
    }

    .form-box {
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #e0e0e0;
        transition: .25s;
    }
    .form-box:hover {
        transform: scale(1.02);
        border-color: #6a0dad;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
</style>

</head>

<body>

<div class="main-content">

    <div class="card-panel">

        <h2 class="header-title">
            <i class="fas fa-trash-alt"></i> Hapus Data Mahasiswa KIP-K
        </h2>

        <?php if ($msg): ?>
            <div class="alert alert-info mt-3"><?= $msg ?></div>
        <?php endif; ?>

        <div class="danger-box mt-3">
            <i class="fas fa-exclamation-circle"></i>
            <b>Peringatan penting:</b> Penghapusan data bersifat permanen & tidak bisa dikembalikan.
        </div>

        <div class="row mt-4 g-4">

            <!-- Tahun -->
            <div class="col-md-6">
                <form method="post" class="form-box">
                    <h5><i class="fas fa-calendar-alt"></i> Hapus Berdasarkan Tahun</h5>
                    <select name="tahun_hapus" class="form-select mt-2" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php while ($r = $tahunList->fetch_assoc()): ?>
                            <option><?= $r['tahun'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button class="btn btn-danger w-100 mt-3" name="hapus_tahun">Hapus Data</button>
                </form>
            </div>

            <!-- Jurusan -->
            <div class="col-md-6">
                <form method="post" class="form-box">
                    <h5><i class="fas fa-graduation-cap"></i> Hapus Berdasarkan Jurusan</h5>
                    <select name="jurusan_hapus" class="form-select mt-2" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php while ($r = $jurusanList->fetch_assoc()): ?>
                            <option><?= $r['jurusan'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button class="btn btn-danger w-100 mt-3" name="hapus_jurusan">Hapus Data</button>
                </form>
            </div>

            <!-- Prodi -->
            <div class="col-md-6">
                <form method="post" class="form-box">
                    <h5><i class="fas fa-book"></i> Hapus Berdasarkan Prodi</h5>
                    <select name="prodi_hapus" class="form-select mt-2" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php while ($r = $prodiList->fetch_assoc()): ?>
                            <option><?= $r['program_studi'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button class="btn btn-danger w-100 mt-3" name="hapus_prodi">Hapus Data</button>
                </form>
            </div>

            <!-- NPM -->
            <div class="col-md-6">
                <form method="post" class="form-box">
                    <h5><i class="fas fa-id-card"></i> Hapus Berdasarkan NPM</h5>
                    <input type="text" name="npm_hapus" class="form-control mt-2" placeholder="Masukkan NPM...">
                    <button class="btn btn-danger w-100 mt-3" name="hapus_npm">Hapus Data</button>
                </form>
            </div>

        </div>

        <div class="text-center mt-4">
            <a href="mahasiswa_kip.php" class="btn btn-secondary btn-back mt-2">← Kembali</a>
        </div>

    </div>
</div>

</body>
</html>
