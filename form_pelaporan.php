<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelapor   = mysqli_real_escape_string($koneksi, $_POST['nama_pelapor'] ?? '');
    $email_pelapor  = mysqli_real_escape_string($koneksi, $_POST['email_pelapor'] ?? '');
    $nama_terlapor  = mysqli_real_escape_string($koneksi, $_POST['nama_terlapor'] ?? '');
    $npm_terlapor   = mysqli_real_escape_string($koneksi, $_POST['npm_terlapor'] ?? '');
    $jurusan        = mysqli_real_escape_string($koneksi, $_POST['jurusan'] ?? '');
    $prodi          = mysqli_real_escape_string($koneksi, $_POST['prodi'] ?? '');
    $alasan         = mysqli_real_escape_string($koneksi, $_POST['alasan'] ?? '');
    $detail_laporan = mysqli_real_escape_string($koneksi, $_POST['detail_laporan'] ?? '');

    // ✅ Cek ada minimal 1 file
    if(!isset($_FILES['bukti'])) {
        echo "<script>alert('Bukti pendukung wajib diupload!'); history.back();</script>";
        exit;
    }
    
    $uploaded_files = [];
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $allowed = ['jpg','jpeg','png','pdf','doc','docx','jpg','jpeg','png','pdf','doc','docx','mp4','mov','mkv'];

    foreach ($_FILES['bukti']['tmp_name'] as $index => $tmp_name) {
        $original_name = basename($_FILES['bukti']['name'][$index]);
        $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        if(!in_array($file_ext, $allowed)) {
            echo "<script>alert('Format file tidak diizinkan!'); history.back();</script>";
            exit;
        }

        $file_name = time() . "_" . rand(1000,9999) . "_" . $original_name;
        $target_file = $target_dir . $file_name;

        if(move_uploaded_file($tmp_name, $target_file)) {
            $uploaded_files[] = $file_name;
        } else {
            echo "<script>alert('Upload file gagal!'); history.back();</script>";
            exit;
        }
    }

    // Simpan ke DB (gabungkan nama file dengan koma)
    $bukti_str = implode(',', $uploaded_files);

    $query = "INSERT INTO laporan 
        (nama_pelapor,email_pelapor,nama_terlapor,npm_terlapor,jurusan,prodi,alasan,detail_laporan,bukti,pernyataan) 
        VALUES 
        ('$nama_pelapor','$email_pelapor','$nama_terlapor','$npm_terlapor','$jurusan','$prodi','$alasan','$detail_laporan','$bukti_str','$pernyataan')";

    if (mysqli_query($koneksi, $query)) {

    echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>
        Swal.fire({
            title: 'Terima Kasih!',
            html: 'Laporan Anda telah berhasil dikirim.<br>Admin akan segera meninjaunya.',
            icon: 'success',
            confirmButtonText: 'Kembali',
            confirmButtonColor: '#7c3aed',
            background: '#ffffff',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            window.location = 'pusat_layanan.php';
        });
    </script>

    </body>
    </html>
    ";
    exit;

} else {

    echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>
        Swal.fire({
            title: 'Gagal Mengirim!',
            text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
            icon: 'error',
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Kembali'
        }).then(() => {
            window.history.back();
        });
    </script>

    </body>
    </html>
    ";
    exit;

}

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pelaporan Mahasiswa - KIP Kuliah</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
  body { font-family: 'Tahoma', sans-serif; }
  .bg-hero {
    background-image: url('assets/bg-pelaporan.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
  .card-hover:hover {
    transform: scale(1.02);
    box-shadow: 0 15px 40px rgba(128,90,213,0.5);
  }
  .file-preview {
    background-color: rgba(128,90,213,0.1);
    padding: 5px 10px;
    border-radius: 8px;
    margin-top: 5px;
    font-size: 0.9rem;
    color: #4B0082;
  }

  /* ========== RESPONSIVE DESIGN ========== */
  @media (max-width: 768px) {
    .pt-24 {
      padding-top: 5rem !important;
    }
    .pb-20 {
      padding-bottom: 3rem !important;
    }
    .p-6 {
      padding: 1rem !important;
    }
    .p-10 {
      padding: 1.5rem !important;
    }
    .text-3xl {
      font-size: 1.5rem !important;
    }
    .max-w-2xl {
      max-width: 95% !important;
    }
    .rounded-3xl {
      border-radius: 1rem !important;
    }
    .grid-cols-1.md\\:grid-cols-2 {
      grid-template-columns: 1fr !important;
    }
  }

  @media (max-width: 480px) {
    .pt-24 {
      padding-top: 4.5rem !important;
    }
    .p-10 {
      padding: 1rem !important;
    }
    .text-3xl {
      font-size: 1.25rem !important;
    }
    .px-4 {
      padding-left: 0.75rem !important;
      padding-right: 0.75rem !important;
    }
    .py-3 {
      padding-top: 0.625rem !important;
      padding-bottom: 0.625rem !important;
    }
    input, select, textarea {
      font-size: 14px !important;
    }
    .flex.justify-between {
      flex-direction: column;
      gap: 1rem;
    }
    .flex.justify-between a,
    .flex.justify-between button {
      width: 100%;
      text-align: center;
    }
  }
</style>
</head>
<body class="bg-hero">

<div class="bg-black bg-opacity-60 min-h-screen pt-24 pb-20 flex justify-center items-start p-6">

  <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-2xl card-hover">

    <h2 class="text-3xl font-extrabold text-center text-purple-700 mb-4 drop-shadow-lg">Pelaporan Mahasiswa</h2>
    <p class="text-center text-gray-700 mb-8">
      Laporkan mahasiswa <span class="font-semibold text-red-500">yang tidak layak menerima KIP-Kuliah</span>.
    </p>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4" id="laporanForm">

      <div>
        <label class="block text-gray-700 font-medium mb-1">Nama Pelapor</label>
        <input type="text" name="nama_pelapor" required
               class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Email Pelapor</label>
        <input type="email" name="email_pelapor" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com$" title="Harus menggunakan alamat Gmail" 
               class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Nama Mahasiswa yang Dilaporkan</label>
        <input type="text" name="nama_terlapor" required
               class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">NPM Mahasiswa</label>
        <input type="text" name="npm_terlapor" required
               class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Jurusan</label>
          <input type="text" name="jurusan" required
                 class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-1">Program Studi</label>
          <input type="text" name="prodi" required
                 class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
        </div>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Alasan Laporan</label>
        <input type="text" name="alasan" required
               class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Detail Laporan</label>
        <textarea name="detail_laporan" required
                  class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 focus:ring-2 focus:ring-purple-400 outline-none h-32"></textarea>
      </div>

      <!-- Multi-file upload interaktif -->
<div>
  <label class="block text-gray-700 font-medium mb-1">Bukti Pendukung (WAJIB)</label>
  <button type="button" id="addBukti" 
          class="flex items-center px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 shadow transition-all duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Tambah Bukti
  </button>
  <div id="filePreviewContainer" class="mt-3 space-y-2"></div>
</div>

<div class="flex justify-between mt-4">
    <a href="pusat_layanan.php" 
       class="px-5 py-2 rounded-xl bg-gray-400 hover:bg-gray-500 text-white shadow font-semibold transition-all duration-200">
       ← Kembali
    </a>
    <button type="submit" 
            class="px-6 py-2 rounded-xl bg-gradient-to-r from-purple-700 to-purple-500 hover:from-purple-800 hover:to-purple-600 text-white shadow-lg font-semibold transition-all duration-200 transform hover:-translate-y-0.5 hover:scale-105">
       Kirim Laporan
    </button>
</div>

<script>
let selectedFiles = [];
const addBuktiBtn = document.getElementById('addBukti');
const filePreviewContainer = document.getElementById('filePreviewContainer');
const form = document.getElementById('laporanForm');

// Event untuk menambah file
addBuktiBtn.addEventListener('click', () => {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.jpg,.jpeg,.png,.mp4,.mov,.mkv,.pdf,.doc,.docx';
    fileInput.multiple = true; // Bisa pilih lebih dari 1 file sekaligus
    fileInput.classList.add('hidden');
    fileInput.addEventListener('change', (e) => {
        for (let file of e.target.files) {
            selectedFiles.push(file);
        }
        renderFileList();
    });
    form.appendChild(fileInput);
    fileInput.click();
});

// Render daftar file yang dipilih
function renderFileList() {
    filePreviewContainer.innerHTML = '';
    selectedFiles.forEach((file, index) => {
        const div = document.createElement('div');
        div.className = 'file-preview flex justify-between items-center';
        let icon = '';
        if(file.type.startsWith('image/')){
            icon = '🖼️';
        } else if(file.type.startsWith('video/')){
            icon = '🎥';
        } else {
            icon = '📄';
        }
        div.innerHTML = `<span>${icon} ${file.name}</span> 
                         <button type="button" class="text-red-500 font-bold" onclick="removeFile(${index})">X</button>`;
        filePreviewContainer.appendChild(div);
    });
}

// Hapus file dari list
function removeFile(index) {
    selectedFiles.splice(index,1);
    renderFileList();
}

// Override form submit untuk mengirim selectedFiles
form.addEventListener('submit', function(e){
    if(selectedFiles.length === 0){
        alert('Bukti pendukung wajib diupload!');
        e.preventDefault();
        return;
    }
    const formData = new FormData(form);
    selectedFiles.forEach(file => formData.append('bukti[]', file));

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        document.open();
        document.write(res);
        document.close();
    })
    .catch(err => console.error(err));

    e.preventDefault();
});
</script>
