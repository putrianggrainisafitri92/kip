<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['level'])) {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$data = ['nama_mahasiswa'=>'','judul_prestasi'=>'','tanggal_prestasi'=>'','deskripsi'=>'','file_gambar'=>'[]'];
$is_edit = false;

if ($id > 0) {
    $res = $koneksi->query("SELECT * FROM mahasiswa_prestasi WHERE id_prestasi=$id");
    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $is_edit = true;
    }
}

// Logic Simpan
if (isset($_POST['simpan'])) {
    $nama = $koneksi->real_escape_string($_POST['nama_mahasiswa']);
    $judul = $koneksi->real_escape_string($_POST['judul_prestasi']);
    $tgl = $koneksi->real_escape_string($_POST['tanggal_prestasi']);
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
    
    // Handle Gambar Lama & Hapus
    $gambarArr = json_decode($data['file_gambar'], true);
    if (!is_array($gambarArr)) {
        // Handle legacy single file format
        $gambarArr = !empty($data['file_gambar']) ? [$data['file_gambar']] : [];
    }

    // Jika ada request hapus gambar tertentu
    if (isset($_POST['hapus_gambar'])) {
        foreach ($_POST['hapus_gambar'] as $hapus) {
            if (($key = array_search($hapus, $gambarArr)) !== false) {
                unset($gambarArr[$key]);
                if (file_exists("../uploads/prestasi/" . $hapus)) {
                    unlink("../uploads/prestasi/" . $hapus);
                }
            }
        }
        $gambarArr = array_values($gambarArr); // Reindex
    }

    // Upload Gambar Baru (Multiple)
    if (!empty($_FILES['file_gambar']['name'][0])) {
        $target_dir = "../uploads/prestasi/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $total_files = count($_FILES['file_gambar']['name']);
        
        for($i=0; $i<$total_files; $i++) {
            $tmp_name = $_FILES['file_gambar']['tmp_name'][$i];
            $name = $_FILES['file_gambar']['name'][$i];
            
            if ($tmp_name != "") {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = time() . '_' . $i . '_' . rand(1000,9999) . '.' . $ext;
                
                if(move_uploaded_file($tmp_name, $target_dir . $new_name)){
                    $gambarArr[] = $new_name;
                }
            }
        }
    }
    
    $jsonGambar = json_encode($gambarArr);

    if ($is_edit) {
        $stmt = $koneksi->prepare("UPDATE mahasiswa_prestasi SET nama_mahasiswa=?, judul_prestasi=?, tanggal_prestasi=?, deskripsi=?, file_gambar=?, status='pending', catatan_revisi=NULL WHERE id_prestasi=?");
        $stmt->bind_param("sssssi", $nama, $judul, $tgl, $deskripsi, $jsonGambar, $id);
    } else {
        $stmt = $koneksi->prepare("INSERT INTO mahasiswa_prestasi (nama_mahasiswa, judul_prestasi, tanggal_prestasi, deskripsi, file_gambar, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssss", $nama, $judul, $tgl, $deskripsi, $jsonGambar);
    }

    if ($stmt->execute()) {
        header("Location: prestasi_list.php");
        exit;
    } else {
        $error = "Gagal menyimpan data: " . $koneksi->error;
    }
}

// Persiapan Tampilan Gambar
$currentImages = json_decode($data['file_gambar'], true);
if(!is_array($currentImages)) $currentImages = !empty($data['file_gambar']) ? [$data['file_gambar']] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $is_edit ? 'Edit' : 'Tambah' ?> Prestasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bs-primary: #6f42c1; /* Purple */
            --bs-primary-rgb: 111, 66, 193;
        }
        .btn-primary { background-color: #6f42c1 !important; border-color: #6f42c1 !important; }
        .btn-primary:hover { background-color: #59359a !important; border-color: #59359a !important; }
        .text-primary { color: #6f42c1 !important; }
        .bg-primary { background-color: #6f42c1 !important; }
        .card-header { border-bottom: 2px solid #e9ecef; }
        
        /* Delete State Style */
        .img-delete-overlay {
            position: absolute; inset: 0; background: rgba(220, 53, 69, 0.8);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: bold; border-radius: 4px;
            opacity: 0; transition: 0.3s; pointer-events: none;
        }
        .marked-for-delete .img-delete-overlay { opacity: 1; }
        .marked-for-delete img { filter: grayscale(100%); }
    </style>
</head>
<body class="bg-light">
    
    <?php include 'sidebar.php'; ?>

    <div class="main-content" style="margin-left: 260px; padding: 20px;">
        <div class="container-fluid">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-bold text-primary"><?= $is_edit ? 'Edit' : 'Tambah' ?> Data Prestasi</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Mahasiswa</label>
                            <input type="text" name="nama_mahasiswa" class="form-control" value="<?= htmlspecialchars($data['nama_mahasiswa']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Prestasi / Kejuaraan</label>
                            <input type="text" name="judul_prestasi" class="form-control" value="<?= htmlspecialchars($data['judul_prestasi']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Perolehan Prestasi</label>
                            <input type="date" name="tanggal_prestasi" class="form-control" value="<?= $data['tanggal_prestasi'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Bukti Gambar / Piagam (Bisa Banyak)</label>
                            <input type="file" name="file_gambar[]" class="form-control" accept="image/*" multiple <?= (!$is_edit && empty($currentImages)) ? 'required' : '' ?>>
                            <div class="form-text text-primary">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Tips HP:</strong> Tekan dan tahan lama pada foto untuk memilih banyak sekaligus. <br>
                                <strong>Tips PC:</strong> Tahan tombol CTRL sambil klik foto.
                            </div>
                            
                            <!-- Preview Gambar Lama -->
                            <?php if(!empty($currentImages)): ?>
                                <div class="mt-4 p-3 border rounded bg-light">
                                    <label class="form-label fw-bold text-muted mb-3">Foto Saat Ini (Kelola):</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php foreach($currentImages as $idx => $img): 
                                            if(empty($img)) continue;
                                        ?>
                                            <div class="position-relative border p-1 rounded bg-white shadow-sm img-wrapper" id="wrapper-<?= $idx ?>" style="width: 140px;">
                                                <img src="../uploads/prestasi/<?= $img ?>" class="w-100 rounded" style="height: 120px; object-fit: cover;">
                                                
                                                <div class="img-delete-overlay">
                                                    <span><i class="fas fa-trash"></i> DIHAPUS</span>
                                                </div>

                                                <!-- Checkbox Hidden -->
                                                <input type="checkbox" name="hapus_gambar[]" value="<?= $img ?>" id="chk-<?= $idx ?>" class="d-none">
                                                
                                                <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2 fw-bold" onclick="toggleDelete(<?= $idx ?>)" id="btn-<?= $idx ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-text mt-2">* Foto yang ditandai "DIHAPUS" akan hilang permanen setelah tombol Simpan ditekan.</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="prestasi_list.php" class="btn btn-secondary px-4">Kembali</a>
                            <button type="submit" name="simpan" class="btn btn-primary px-4 fw-bold">
                                <?= $is_edit ? 'Update Data' : 'Simpan Data' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function toggleDelete(idx) {
            const wrapper = document.getElementById('wrapper-' + idx);
            const checkbox = document.getElementById('chk-' + idx);
            const btn = document.getElementById('btn-' + idx);
            
            if (checkbox.checked) {
                // Cancel Delete
                checkbox.checked = false;
                wrapper.classList.remove('marked-for-delete');
                btn.innerHTML = '<i class="fas fa-trash"></i> Hapus';
                btn.className = 'btn btn-sm btn-outline-danger w-100 mt-2 fw-bold';
            } else {
                // Mark for Delete
                checkbox.checked = true;
                wrapper.classList.add('marked-for-delete');
                btn.innerHTML = '<i class="fas fa-undo"></i> Batal';
                btn.className = 'btn btn-sm btn-secondary w-100 mt-2 fw-bold';
            }
        }
    </script>
</body>
</html>
