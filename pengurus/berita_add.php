<?php
session_start();
if(!isset($_SESSION['level']) || $_SESSION['level'] != '11') die("Akses ditolak!");

include "../koneksi.php";
include "sidebar.php";

// Proses simpan
if (isset($_POST['simpan'])) {

    $judul = trim($_POST['judul']);
    $tgl_kegiatan = $_POST['tanggal_kegiatan'];

    $stmt = $koneksi->prepare("
        INSERT INTO berita (judul, tanggal, tanggal_kegiatan)
        VALUES (?, NOW(), ?)
    ");
    $stmt->bind_param("ss", $judul, $tgl_kegiatan);
    $stmt->execute();

    $idBerita = $stmt->insert_id;
    $stmt->close();

    // Upload Gambar
    if (!empty($_FILES['gambar_files'])) {

        $uploadDir = "../uploads/berita/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $allowed = ['jpg','jpeg','png','gif','webp'];

        foreach ($_FILES['gambar_files']['tmp_name'] as $i => $tmpName) {
           if (!empty($_FILES['gambar_files']['tmp_name'][$i]) && $_FILES['gambar_files']['error'][$i] === 0) {


                $originalName = $_FILES['gambar_files']['name'][$i];
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) continue;

                $safe = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);
                $filename = time().'_'.rand(100,999).'_'.$safe;
                $target = $uploadDir . $filename;

                if (move_uploaded_file($tmpName, $target)) {

                    $caption = $_POST['captions'][$i] ?? null;

                    $ins = $koneksi->prepare("
                        INSERT INTO berita_gambar (id_berita, file, caption, sortorder)
                        VALUES (?, ?, ?, ?)
                    ");
                    $ins->bind_param("issi", $idBerita, $filename, $caption, $i);
                    $ins->execute();
                    $ins->close();
                }
            }
        }
    }

    echo "<script>alert('Berita disimpan. Menunggu validasi.'); window.location='berita_list.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
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

        label, h3 {
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

        /* ===== GRID GAMBAR ===== */
        .grid {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 18px;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 20px;
            align-items: start;
            position: relative;
        }

        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
        }

        /* ===== BUTTONS ===== */
        button {
            padding: 12px 18px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-del {
            background: #ff4d4d;
            color: white;
            margin-top: 10px;
            width: auto;
        }
        .btn-del:hover { background: #ff1a1a; transform: scale(1.02); }

        .btn-add {
            background: rgba(255,255,255,0.1);
            border: 2px dashed rgba(255,255,255,0.3);
            color: white;
            padding: 18px;
            width: 100%;
            border-radius: 16px;
            margin-top: 15px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-add:hover { 
            background: rgba(255,255,255,0.2); 
            border-color: rgba(255,255,255,0.5);
        }

        .btn-save {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: white;
            width: 100%;
            padding: 15px;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(123, 53, 212, 0.3);
        }
        .btn-save:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 15px 25px rgba(123, 53, 212, 0.4); }

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

        /* Responsive */
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
        <h2>Tambah Berita Baru</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Judul Berita</label>
            <input type="text" name="judul" required placeholder="Contoh: Mahasiswa Polinela Juara 1 Nasional">

            <label>Tanggal Kegiatan</label>
            <input type="date" name="tanggal_kegiatan" required>

            <h3>Gambar & Deskripsi</h3>

            <div id="galleryRows">
                <div class="grid">
                    <div>
                        <label style="margin-top:0">Pilih Gambar</label>
                        <input type="file" name="gambar_files[]" accept="image/*" required>
                    </div>
                    <div>
                        <label style="margin-top:0">Deskripsi Gambar</label>
                        <textarea name="captions[]" placeholder="Masukkan deskripsi gambar..."></textarea>
                        <button type="button" class="btn-del" onclick="removeRow(this)">
                            <i class="fas fa-trash"></i> Hapus Slot
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn-add" onclick="addRow()">
                <i class="fas fa-plus"></i> Tambah Slot Gambar
            </button>

            <button type="submit" name="simpan" class="btn-save">
                <i class="fas fa-save"></i> Simpan & Ajukan Berita
            </button>

            <a href="berita_list.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </form>
    </div>
</div>

<script>
function addRow() {
    let container = document.getElementById('galleryRows');
    let div = document.createElement('div');
    div.className = "grid";
    div.innerHTML = `
        <div>
            <label style="margin-top:0">Pilih Gambar</label>
            <input type="file" name="gambar_files[]" accept="image/*">
        </div>
        <div>
            <label style="margin-top:0">Deskripsi Gambar</label>
            <textarea name="captions[]" placeholder="Masukkan deskripsi gambar..."></textarea>
            <button type="button" class="btn-del" onclick="removeRow(this)">
                <i class="fas fa-trash"></i> Hapus Slot
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeRow(btn) {
    if (document.querySelectorAll('.grid').length > 1) {
        btn.closest('.grid').remove();
    } else {
        alert("Minimal harus ada 1 slot gambar.");
    }
}
</script>

</body>
</html>
