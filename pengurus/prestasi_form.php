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
        $gambarArr = !empty($data['file_gambar']) ? [$data['file_gambar']] : [];
    }

    if (isset($_POST['hapus_gambar'])) {
        foreach ($_POST['hapus_gambar'] as $hapus) {
            if (($key = array_search($hapus, $gambarArr)) !== false) {
                unset($gambarArr[$key]);
                if (file_exists("../uploads/prestasi/" . $hapus)) {
                    unlink("../uploads/prestasi/" . $hapus);
                }
            }
        }
        $gambarArr = array_values($gambarArr); 
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

$currentImages = json_decode($data['file_gambar'], true);
if(!is_array($currentImages)) $currentImages = !empty($data['file_gambar']) ? [$data['file_gambar']] : [];

include 'sidebar.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $is_edit ? 'Edit' : 'Tambah' ?> Prestasi Mahasiswa</title>
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

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 15px;
            color: #f1e4ff;
        }

        input[type=text], input[type=date], input[type=file], textarea {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            border-color: #ba68ff;
            box-shadow: 0 0 15px rgba(186, 104, 255, 0.3);
        }

        /* ===== Image Gallery Management ===== */
        .image-manager {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 18px;
            margin-top: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .image-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.2);
            aspect-ratio: 1;
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.3s;
        }

        .image-item.marked-del img {
            filter: grayscale(1) brightness(0.5);
        }

        .del-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(211, 47, 47, 0.7);
            color: white;
            font-weight: 800;
            font-size: 12px;
            opacity: 0;
            transition: 0.3s;
            pointer-events: none;
        }

        .image-item.marked-del .del-overlay {
            opacity: 1;
        }

        .btn-toggle-del {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: white;
            color: #d32f2f;
            border: none;
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 11px;
            cursor: pointer;
            font-weight: 700;
            z-index: 2;
        }

        /* ===== BUTTONS ===== */
        .btn-submit {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: white;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(123, 53, 212, 0.3);
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(123, 53, 212, 0.4);
        }

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
            margin-top: 15px;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="form-card">
        <h2><?= $is_edit ? 'Edit' : 'Tambah' ?> Prestasi</h2>

        <?php if(isset($error)): ?>
            <div style="background: rgba(255, 77, 77, 0.2); padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #ff4d4d; color: #ffcccc;">
                <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Nama Mahasiswa</label>
            <input type="text" name="nama_mahasiswa" value="<?= htmlspecialchars($data['nama_mahasiswa']) ?>" required placeholder="Masukkan nama mahasiswa">

            <label>Judul Prestasi / Kejuaraan</label>
            <input type="text" name="judul_prestasi" value="<?= htmlspecialchars($data['judul_prestasi']) ?>" required placeholder="Contoh: Juara 1 Lomba IT Nasional">

            <label>Tanggal Perolehan Prestasi</label>
            <input type="date" name="tanggal_prestasi" value="<?= $data['tanggal_prestasi'] ?>" required>

            <label>Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="5" required placeholder="Ceritakan detail prestasinya..."><?= htmlspecialchars($data['deskripsi']) ?></textarea>

            <label>Upload Bukti Gambar / Piagam (Multiple)</label>
            <input type="file" name="file_gambar[]" accept="image/*" multiple <?= (!$is_edit && empty($currentImages)) ? 'required' : '' ?>>
            <div style="font-size: 12px; color: #f1e4ff; margin-top: 5px;">
                <i class="fas fa-info-circle"></i> Tips: Anda dapat memilih lebih dari satu file sekaligus.
            </div>

            <?php if(!empty($currentImages)): ?>
                <label>Kelola Gambar Saat Ini</label>
                <div class="image-manager">
                    <?php foreach($currentImages as $idx => $img): 
                        if(empty($img)) continue;
                    ?>
                        <div class="image-item" id="item-<?= $idx ?>">
                            <img src="../uploads/prestasi/<?= $img ?>">
                            <div class="del-overlay">AKAN DIHAPUS</div>
                            <input type="checkbox" name="hapus_gambar[]" value="<?= $img ?>" id="chk-<?= $idx ?>" style="display:none;">
                            <button type="button" class="btn-toggle-del" onclick="toggleImageDelete(<?= $idx ?>)" id="btn-<?= $idx ?>">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="font-size: 11px; color: #ccc; margin-top: 10px;">
                    * Gambar yang ditandai merah akan dihapus permanen setelah data disimpan.
                </div>
            <?php endif; ?>

            <button type="submit" name="simpan" class="btn-submit">
                <i class="fas fa-save"></i> <?= $is_edit ? 'Update Data Prestasi' : 'Simpan & Ajukan Prestasi' ?>
            </button>

            <a href="prestasi_list.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </form>
    </div>
</div>

<script>
function toggleImageDelete(idx) {
    const item = document.getElementById('item-' + idx);
    const checkbox = document.getElementById('chk-' + idx);
    const btn = document.getElementById('btn-' + idx);
    
    if (checkbox.checked) {
        checkbox.checked = false;
        item.classList.remove('marked-del');
        btn.innerHTML = '<i class="fas fa-trash"></i> Hapus';
        btn.style.color = '#d32f2f';
    } else {
        checkbox.checked = true;
        item.classList.add('marked-del');
        btn.innerHTML = '<i class="fas fa-undo"></i> Batal';
        btn.style.color = '#555';
    }
}
</script>

</body>
</html>
