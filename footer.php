<!-- FOOTER FINAL -->
<footer class="bg-gradient-to-br from-[#1d0b33] to-[#2d0f4d] py-12 pb-6 text-indigo-100" style="background-color: #1d0b33;">

<?php
include 'koneksi.php'; // sesuaikan path

$pengunjung_bulanan = [];

if ($koneksi) {
    // cek tabel visitor_log ada
    $table_exists = mysqli_query($koneksi, "SHOW TABLES LIKE 'visitor_log'");
    if ($table_exists && mysqli_num_rows($table_exists) > 0) {

        // inisialisasi bulan Januari–Desember
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pengunjung_bulanan[$bulan] = 0;
        }
        
        $pengunjung_hari_ini = 0;

if ($koneksi) {
    $row = mysqli_fetch_assoc(mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS total FROM visitor_log WHERE visit_date = CURDATE()"
    ));
    $pengunjung_hari_ini = (int) ($row['total'] ?? 0);
}

        // ambil total pengunjung per bulan (tahun berjalan)
        $query = mysqli_query($koneksi, "
            SELECT MONTH(visit_date) AS bulan, COUNT(*) AS jumlah
            FROM visitor_log
            WHERE YEAR(visit_date) = YEAR(CURDATE())
            GROUP BY MONTH(visit_date)
        ");

        while ($row = mysqli_fetch_assoc($query)) {
            $pengunjung_bulanan[(int)$row['bulan']] = (int)$row['jumlah'];
        }
    }
}

?>

<div class="max-w-7xl mx-auto px-6 grid md:grid-cols-5 gap-8">

  <!-- Kolom 1: Info Polinela -->
  <div class="space-y-5">
    <div class="flex items-center">
      <img src="<?= isset($base_url) ? $base_url : '' ?>assets/logo-polinela.png" alt="Logo Polinela" class="w-14 mr-3 drop-shadow-lg">
      <div>
        <h4 class="font-bold text-lg text-white leading-tight">POLITEKNIK NEGERI LAMPUNG</h4>
        <p class="text-sm italic text-indigo-200">Kampus Unggul, Profesional, dan Mandiri</p>
      </div>
    </div>
    <p class="text-sm text-indigo-100 leading-relaxed">
      Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa,<br>
      Kota Bandar Lampung, Lampung 35144
    </p>
    <div class="space-y-1 text-sm text-indigo-100">
      <p><span class="font-semibold text-white">Telp:</span> (0721) 703995</p>
      <p><span class="font-semibold text-white">Email:</span> humas@polinela.ac.id</p>
      <p><span class="font-semibold text-white">WA:</span> 0812 7893 3860</p>
    </div>
  </div>

  <!-- Kolom 2: Laman Terkait -->
  <div class="space-y-5">
    <h4 class="font-semibold text-white text-lg">LAMAN TERKAIT</h4>
    <ul class="space-y-2 text-sm text-indigo-100">
      <li><a href="https://kip-kuliah.kemdikbud.go.id" target="_blank" class="hover:text-white hover:underline transition">Pendaftaran KIP-Kuliah</a></li>
      <li><a href="https://www.polinela.ac.id" target="_blank" class="hover:text-white hover:underline transition">Website Polinela</a></li>
      <li><a href="https://pddikti.kemdiktisaintek.go.id/" target="_blank" class="hover:text-white hover:underline transition">PDDIKTI</a></li>
      <li><a href="https://dikti.kemdikbud.go.id" target="_blank" class="hover:text-white hover:underline transition">Kemdikbudristek</a></li>
    </ul>
  </div>

  <!-- Kolom 3: Sosial Media -->
  <div class="space-y-5">
    <h4 class="font-semibold text-white text-lg">SOSIAL MEDIA POLINELA</h4>
    <ul class="space-y-2 text-sm text-indigo-100">
      <li><a href="https://www.instagram.com/politeknik_negeri_lampung/" target="_blank" class="hover:text-white hover:underline transition">Instagram: <span class="text-white">@politeknik_negeri_lampung</span></a></li>
      <li><a href="https://www.youtube.com/@politeknik_negeri_lampung" target="_blank" class="hover:text-white hover:underline transition">YouTube: <span class="text-white">Politeknik Negeri Lampung</span></a></li>
      <li><a href="https://www.facebook.com/politekniknegerilampung/" target="_blank" class="hover:text-white hover:underline transition">Facebook: <span class="text-white">Politeknik Negeri Lampung</span></a></li>
      <li><a href="https://www.facebook.com/humaspolinela/" target="_blank" class="hover:text-white hover:underline transition">Humas Polinela: <span class="text-white">facebook.com/humaspolinela</span></a></li>
    </ul>
  </div>

  <!-- Kolom 4: Tentang Web -->
  <div class="space-y-5">
    <h4 class="font-semibold text-white text-lg">TENTANG WEB</h4>
    <p class="text-sm text-indigo-100 leading-relaxed">
      Portal resmi informasi KIP-Kuliah yang menyediakan berita, pengumuman,
      serta panduan lengkap bagi mahasiswa penerima KIP-K. Dikembangkan untuk
      memberikan kemudahan akses informasi secara cepat dan terpercaya.
    </p>
  </div>

  <div class="footer-statistik">
 <h4 class="font-semibold text-white text-lg">VISITOR</h4>
    <div class="stat-box">
        <span>Pengunjung Hari Ini</span>
        <strong><?= $pengunjung_hari_ini; ?></strong>
    </div>

    <div class="stat-box">
        <span>Total Pengunjung <?= date('Y'); ?></span>
        <strong><?= array_sum($pengunjung_bulanan); ?></strong>
    </div>

    <div class="bulan-grid">
        <?php
        $nama_bulan = [
            1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr',
            5=>'Mei', 6=>'Jun', 7=>'Jul', 8=>'Agu',
            9=>'Sep', 10=>'Okt', 11=>'Nov', 12=>'Des'
        ];

        foreach ($pengunjung_bulanan as $bulan => $jumlah) {
            echo "
                <div class='bulan-item'>
                    <span>{$nama_bulan[$bulan]}</span>
                    <b>{$jumlah}</b>
                </div>
            ";
        }
        ?>
    </div>

</div>



  </div>

</div>

<!-- Copyright -->
<div class="border-t border-white/20 pt-10 pb-6 text-center text-indigo-200 text-sm" style="background-color: #1d0b33;">
  © <?= date('Y'); ?> Sistem Informasi KIP-Kuliah POLINELA. Semua hak cipta dilindungi.
</div>
</footer>

<style>
.footer-statistik {
    width: 100%;
    color: #fff;
    font-size: 13px;
}

.footer-statistik h4 {
    margin-bottom: 10px;
    font-size: 15px;
    font-weight: 600;
}

.stat-box {
    display: flex;
    justify-content: space-between;
    padding: 10px 12px;
    margin-bottom: 12px;
    background: rgba(255,255,255,0.08);
    border-radius: 8px;
    font-weight: 600;
}

.stat-box strong {
    font-size: 16px;
}

.bulan-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.bulan-item {
    background: rgba(255,255,255,0.06);
    border-radius: 6px;
    padding: 6px 0;
    text-align: center;
}

.bulan-item span {
    display: block;
    font-size: 11px;
    opacity: 0.8;
}

.bulan-item b {
    font-size: 14px;
    margin-top: 2px;
    display: block;
}

@media (max-width: 768px) {
    .max-w-7xl {
        padding-left: 20px;
        padding-right: 20px;
    }
    .footer-statistik {
        max-width: 100%;
    }
    .bulan-grid {
        grid-template-columns: repeat(4, 1fr); /* more cols on mobile to save space */
    }
}
</style>
