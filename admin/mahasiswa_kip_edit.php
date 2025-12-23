<?php 
include "../koneksi.php";
include "protect.php";

// IZINKAN LEVEL 12 & 13 AKSES HALAMAN EDIT
check_level(12, 13);

include "sidebar.php";

$id = intval($_GET['id']);


$stmt = $koneksi->prepare("SELECT * FROM mahasiswa_kip WHERE id_mahasiswa_kip=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Data Mahasiswa KIP-K</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #f5f3ff;
        font-family: "Segoe UI", sans-serif;
    }

   .main-content {
    margin-left: 260px;      /* ruang sidebar */
    padding: 30px;           /* ruang dalam */
    padding-top: 20px;       /* NAIIIKKAN form supaya tidak turun */
    min-height: auto;        /* hilangkan efek dorong ke bawah */
}


    .form-card {
        width: 60%;
        margin: 0 auto;
        background: #ffffff;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-left: 8px solid #6a0dad;
        transition: .3s;
    }

    .form-card:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 35px rgba(0,0,0,0.25);
    }

    .title {
        font-size: 26px;
        font-weight: 700;
        color: #6a0dad;
        text-align: center;
        margin-bottom: 25px;
    }

    .btn-ungu {
        background: #6a0dad;
        color: white;
        font-weight: 600;
    }
    .btn-ungu:hover {
        background: #530a9e;
        color: white;
    }

    .form-label {
        font-weight: 600;
    }
</style>
</head>

<body>

<div class="main-content">

    <div class="form-card">

        <h2 class="title">
            <i class="fas fa-edit"></i> Edit Data Mahasiswa KIP-K
        </h2>

        <form method="post">

            <div class="mb-3">
                <label class="form-label">NPM</label>
                <input type="text" name="npm" class="form-control" value="<?= $data['npm']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Mahasiswa</label>
                <input type="text" name="nama" class="form-control" value="<?= $data['nama_mahasiswa']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Program Studi</label>
                <input type="text" name="prodi" class="form-control" value="<?= $data['program_studi']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" value="<?= $data['jurusan']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun" class="form-control" value="<?= $data['tahun']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Skema</label>
                <input type="text" name="skema" class="form-control" value="<?= $data['skema']; ?>" required>
            </div>

            <button class="btn btn-ungu w-100 mt-2" name="update">💾 Simpan Perubahan</button>

            <a href="mahasiswa_kip.php" class="btn btn-secondary w-100 mt-3">⬅ Kembali</a>
        </form>
    </div>

</div>

</body>
</html>

<?php
if (isset($_POST['update'])) {

    $stmt = $koneksi->prepare("
        UPDATE mahasiswa_kip 
        SET npm=?, nama_mahasiswa=?, program_studi=?, jurusan=?, tahun=?, skema=?
        WHERE id_mahasiswa_kip=?
    ");

    $stmt->bind_param(
        "ssssisi",
        $_POST['npm'],
        $_POST['nama'],
        $_POST['prodi'],
        $_POST['jurusan'],
        $_POST['tahun'],
        $_POST['skema'],
        $id
    );

    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil diperbarui'); window.location='mahasiswa_kip.php';</script>";
}
?>
