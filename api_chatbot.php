<?php
header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);
$message = isset($data['message']) ? strtolower(trim($data['message'])) : '';

// --- FUNGSI FORMAT MENU ---
// --- FUNGSI FORMAT MENU ---
function getMenu() {
    return 'Halo! Saya Asisten Virtual Polinela.<br>Silakan pilih topik bantuan:<br><br>' .
           '<button class="chat-chip" onclick="sendChip(\'Informasi KIP-Kuliah\')"><i class="fas fa-info-circle"></i> Informasi KIP-Kuliah</button>' .
           '<button class="chat-chip" onclick="sendChip(\'Syarat & Alur\')"><i class="fas fa-file-alt"></i> Syarat & Alur</button>' .
           '<button class="chat-chip" onclick="sendChip(\'Jadwal Seleksi\')"><i class="fas fa-calendar-alt"></i> Jadwal Seleksi</button>' .
           '<button class="chat-chip" onclick="sendChip(\'Kendala Evaluasi\')"><i class="fas fa-desktop"></i> Kendala Evaluasi</button>' .
           '<button class="chat-chip" onclick="sendChip(\'Pertanyaan Umum\')"><i class="fas fa-question-circle"></i> Pertanyaan Umum</button>';
}

// Default / Start / Menu Utama
if (empty($message) || $message == 'menu' || strpos($message, 'menu utama') !== false || $message == 'utama') {
    echo json_encode(['reply' => getMenu()]);
    exit;
}

$reply = "Maaf, saya belum mengerti pertanyaan kamu. Silakan hubungi pihak akademik atau kirimkan pertanyaan kamu melalui menu <b>Pusat Layanan</b> (pilih Kotak Saran & Pertanyaan).<br><br>" .
         "Pertanyaan akan dijawab oleh staf kami pada jam operasional melalui email yang kamu daftarkan.<br><br>" .
         '<button class="chat-chip" onclick="sendChip(\'Menu Utama\')"><i class="fas fa-home"></i> Menu Utama</button>';

// LOGIKA MATCHER
// 1. Informasi KIP
if (strpos($message, 'informasi') !== false || strpos($message, 'kip') !== false) {
    if (strpos($message, 'syarat') === false) { // prevent collision
        $reply = "<b><i class='fas fa-info-circle'></i> KIP Kuliah Merdeka</b> adalah bantuan biaya pendidikan dari pemerintah bagi lulusan SMA/SMK yang memiliki potensi akademik baik tetapi memiliki keterbatasan ekonomi.<br><br>" .
                 "Fasilitas:<br><i class='fas fa-check-circle text-success'></i> Bebas biaya pendaftaran seleksi<br><i class='fas fa-check-circle text-success'></i> Bebas biaya kuliah (UKT)<br><i class='fas fa-check-circle text-success'></i> Bantuan biaya hidup bulanan";
    }
}

// 2. Syarat & Alur
if (strpos($message, 'syarat') !== false || strpos($message, 'alur') !== false || strpos($message, 'daftar') !== false) {
    $reply = "<b><i class='fas fa-file-alt'></i> Syarat Pendaftaran:</b><br>" .
             "1. Siswa lulusan terbaru (maks 2 tahun)<br>" .
             "2. Memiliki NISN, NPSN, NIK valid<br>" .
             "3. Terdata di DTKS Kemensos (Prioritas)<br><br>" .
             "<b>Alur Singkat:</b><br>" .
             "Daftar Akun KIP-K <i class='fas fa-arrow-right'></i> Ikuti Seleksi Masuk (SNBP/SNBT/Mandiri) <i class='fas fa-arrow-right'></i> Verifikasi Kampus.";
}

// 3. Jadwal
if (strpos($message, 'jadwal') !== false || strpos($message, 'kapan') !== false || strpos($message, 'tanggal') !== false) {
    $reply = "<b><i class='fas fa-calendar-alt'></i> Jadwal Seleksi KIP-Kuliah 2026:</b><br>" .
             "• <b>SNBP:</b> Februari - Maret<br>" .
             "• <b>SNBT:</b> April - Mei<br>" .
             "• <b>Mandiri:</b> Juni - Juli<br><br>" .
             "<i>*Jadwal dapat berubah, pantau terus website resmi.</i>";
}

// 4. Kendala Evaluasi (Menu Baru)
if (strpos($message, 'gabisa') !== false && (strpos($message, 'evaluasi') !== false || strpos($message, 'masuk') !== false)) {
    $reply = "Kalau kamu tidak bisa masuk ke evaluasi, silakan hubungi pihak akademik.<br>" .
             "Atau kamu bisa mengirim pertanyaan ke Pusat Layanan melalui web ini dengan cara:<br><br>" .
             "1. Klik ikon garis 3 di samping.<br>" .
             "2. Setelah menu muncul, klik 'Pusat Layanan'.<br>" .
             "3. Kemudian klik 'Kotak Saran & Pertanyaan'.<br>" .
             "4. Pada bagian 'Jenis Pesan', pilih 'Pertanyaan'.<br>" .
             "5. Masukkan nama, email, dan pertanyaan kamu.<br>" .
             "6. Kirim pesan.";
} else if (strpos($message, 'kendala') !== false || strpos($message, 'evaluasi') !== false || strpos($message, 'gagal') !== false) {
    $reply = "<b><i class='fas fa-desktop'></i> Kendala Evaluasi:</b><br>" .
             "Jika mengalami kendala saat mengisi Form Evaluasi:<br>" .
             "1. Pastikan ukuran file PDF max 2MB.<br>" .
             "2. Gunakan browser Chrome terbaru.<br>" .
             "3. Jika error berlanjut, hubungi admin kemahasiswaan dengan menyertakan screenshot.";
}

// 5. Cara Memberikan Saran
if (strpos($message, 'saran') !== false) {
    $reply = "<b>Untuk memberikan saran melalui web:</b><br><br>" .
             "1. Klik ikon garis 3 di samping.<br>" .
             "2. Cari dan klik 'Pusat Layanan'.<br>" .
             "3. Pada Pusat Layanan, klik 'Kotak Saran & Pertanyaan'.<br>" .
             "4. Pada bagian 'Jenis Pesan', pilih 'Saran'.<br>" .
             "5. Masukkan nama, email, dan saran kamu.<br>" .
             "6. Klik 'Kirim'.";
}

// 6. Cara Melapor Seseorang
if (strpos($message, 'melapor') !== false || strpos($message, 'lapor') !== false) {
    $reply = "<b>Untuk melaporkan mahasiswa melalui web:</b><br><br>" .
             "1. Klik ikon garis 3 di samping.<br>" .
             "2. Cari dan klik 'Pusat Layanan'.<br>" .
             "3. Klik menu 'Pelaporan Mahasiswa Tidak Layak'.<br>" .
             "4. Isi semua kolom yang diminta:<br>" .
             "   - Nama Pelapor<br>" .
             "   - Email Pelapor<br>" .
             "   - Nama Mahasiswa yang Dilaporkan<br>" .
             "   - NPM Mahasiswa<br>" .
             "   - Jurusan<br>" .
             "   - Program Studi<br>" .
             "   - Alasan Laporan<br>" .
             "   - Detail Laporan<br>" .
             "   - Bukti Pendukung (WAJIB)<br>" .
             "5. Untuk menambahkan bukti, klik 'Tambah Bukti'.<br>" .
             "6. Jika sudah selesai, klik 'Kirim Laporan'.";
}

// 7. Pertanyaan Umum
if (strpos($message, 'umum') !== false || strpos($message, 'tanya') !== false) {
    if (empty($reply) || $reply == "Maaf, saya belum mengerti...") { // secondary check
        $reply = "<b><i class='fas fa-question-circle'></i> FAQ:</b><br>" .
                 "Q: Apakah KIP-K bisa dicabut?<br>" .
                 "A: Bisa, jika IPK turun dibawah standar (2.75) atau melanggar aturan kampus.<br><br>" .
                 "Q: Kapan dana cair?<br>" .
                 "A: Biasanya di pertengahan semester (Maret/September).";
    }
}

// Tambah tombol back to menu di setiap response
$reply .= '<br><br><button class="chat-chip-small" onclick="sendChip(\'Menu Utama\')"><i class="fas fa-arrow-left"></i> Menu Utama</button>';

echo json_encode(['reply' => $reply]);
?>
