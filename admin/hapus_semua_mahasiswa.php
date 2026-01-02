<?php
include "../koneksi.php";     
include "protect.php";        

$msg = "";

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

if (isset($_POST['hapus_tahun'])) {
    hapus_mahasiswa_aman($koneksi, 'tahun', $_POST['tahun_hapus']);
    $msg = "✅ Data mahasiswa tahun {$_POST['tahun_hapus']} berhasil dihapus!";
}

if (isset($_POST['hapus_jurusan'])) {
    hapus_mahasiswa_aman($koneksi, 'jurusan', $_POST['jurusan_hapus']);
    $msg = "✅ Data jurusan {$_POST['jurusan_hapus']} berhasil dihapus!";
}

if (isset($_POST['hapus_prodi'])) {
    hapus_mahasiswa_aman($koneksi, 'program_studi', $_POST['prodi_hapus']);
    $msg = "✅ Data program studi {$_POST['prodi_hapus']} berhasil dihapus!";
}

if (isset($_POST['hapus_npm'])) {
    $npm = trim($_POST['npm_hapus']);
    $cek = $koneksi->prepare("SELECT npm FROM mahasiswa_kip WHERE npm = ?");
    $cek->bind_param("s", $npm);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        hapus_mahasiswa_aman($koneksi, 'npm', $npm);
        $msg = "✅ Data mahasiswa dengan NPM $npm berhasil dihapus!";
    } else {
        $msg = "⚠️ NPM $npm tidak ditemukan!";
    }
}

$tahunList   = $koneksi->query("SELECT DISTINCT tahun FROM mahasiswa_kip ORDER BY tahun ASC");
$jurusanList = $koneksi->query("SELECT DISTINCT jurusan FROM mahasiswa_kip ORDER BY jurusan ASC");
$prodiList   = $koneksi->query("SELECT DISTINCT program_studi FROM mahasiswa_kip ORDER BY program_studi ASC");

include "sidebar.php";         
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Data Mahasiswa KIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.9);
        }

        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .content {
            margin-left: 230px;
            padding: 40px 20px;
            transition: all 0.3s ease;
        }

        .form-card {
            width: 100%;
            max-width: 900px;
            margin: auto;
            padding: 40px;
            border-radius: 24px;
            background: var(--glass-purple);
            backdrop-filter: blur(12px);
            color: white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 15px;
            text-align: center;
        }
        .alert-info { background: rgba(37, 117, 252, 0.2); border: 1px solid #2575fc; color: #fff; }

        .warning-box {
            background: rgba(255, 77, 77, 0.2);
            border: 1px solid #ff4d4d;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            color: #ffcccc;
            font-size: 14px;
        }

        .deletion-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .deletion-item {
            background: rgba(255,255,255,0.05);
            padding: 25px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: 0.3s;
        }
        .deletion-item:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-5px);
            border-color: #ff4d4d;
        }
        .deletion-item h4 {
            margin-top: 0;
            color: #ba68ff;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-select, .form-input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: white;
            margin-top: 10px;
            font-family: inherit;
        }
        .form-select option { color: #333; }

        .btn-delete {
            background: #d32f2f;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-delete:hover { background: #b71c1c; transform: translateY(-2px); }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            margin-top: 30px;
            transition: 0.3s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.15); transform: translateY(-2px); }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .deletion-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="form-card">
        <h2>Hapus Data Mahasiswa</h2>

        <?php if ($msg): ?>
            <div class="alert alert-info shadow-lg"><?= $msg ?></div>
        <?php endif; ?>

        <div class="warning-box">
            <i class="fas fa-exclamation-triangle"></i>
            <b>Peringatan:</b> Penghapusan data ini bersifat permanen dan akan menghapus juga file evaluasi yang terkait dengan mahasiswa tersebut.
        </div>

        <div class="deletion-grid">
            <!-- Berdasarkan Tahun -->
            <div class="deletion-item">
                <form method="post" onsubmit="return confirm('Hapus semua mahasiswa di tahun ini?')">
                    <h4><i class="fas fa-calendar-alt"></i> Hapus Per Tahun</h4>
                    <select name="tahun_hapus" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php while ($r = $tahunList->fetch_assoc()): ?>
                            <option value="<?= $r['tahun'] ?>"><?= $r['tahun'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" name="hapus_tahun" class="btn-delete">Hapus Data Tahun</button>
                </form>
            </div>

            <!-- Berdasarkan Jurusan -->
            <div class="deletion-item">
                <form method="post" onsubmit="return confirm('Hapus semua mahasiswa di jurusan ini?')">
                    <h4><i class="fas fa-graduation-cap"></i> Hapus Per Jurusan</h4>
                    <select name="jurusan_hapus" class="form-select" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php while ($r = $jurusanList->fetch_assoc()): ?>
                            <option value="<?= $r['jurusan'] ?>"><?= $r['jurusan'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" name="hapus_jurusan" class="btn-delete">Hapus Data Jurusan</button>
                </form>
            </div>

            <!-- Berdasarkan Prodi -->
            <div class="deletion-item">
                <form method="post" onsubmit="return confirm('Hapus semua mahasiswa di prodi ini?')">
                    <h4><i class="fas fa-book"></i> Hapus Per Prodi</h4>
                    <select name="prodi_hapus" class="form-select" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php while ($r = $prodiList->fetch_assoc()): ?>
                            <option value="<?= $r['program_studi'] ?>"><?= $r['program_studi'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" name="hapus_prodi" class="btn-delete">Hapus Data Prodi</button>
                </form>
            </div>

            <!-- Berdasarkan NPM -->
            <div class="deletion-item">
                <form method="post">
                    <h4><i class="fas fa-id-card"></i> Hapus Per NPM</h4>
                    <input type="text" name="npm_hapus" class="form-input" placeholder="Masukkan NPM Mahasiswa..." required>
                    <button type="submit" name="hapus_npm" class="btn-delete">Hapus Data NPM</button>
                </form>
            </div>
        </div>

        <a href="mahasiswa_kip.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard Mahasiswa
        </a>
    </div>
</div>

</body>
</html>
