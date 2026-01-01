-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2026 at 08:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kipweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `level` tinyint(1) NOT NULL COMMENT '11=pengurus, 12=admin, 13=kabag akademik'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `level`) VALUES
(1, 'admin1', '$2y$10$hkqp7JOJeBoRxtXlu6IHteLVNFyaK3fCGbz6kpDj8MqHDyO9SYPem', 'Admin Pengurus', 11),
(2, 'admin2', '$2y$10$w9cjraYTkU2odMlJFUi.VONv3lB7B4INW3.1svkkZlM2gwoIyp8UO', 'Admin SK/KIP', 12),
(3, 'admin3', '$2y$10$AdnqyZnE/QNU5Yx.QvZQcOOzt8qKDMjZDVXWUL3huuDIU76kAiX5C', 'Kabag Akademik', 13),
(4, 'putri', '$2y$10$or41d5iRjxG43rNc3ZZMbuArHXkE.RwjxshRsSZw1oWqIiMMHkDMq', 'putri', 13);

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `id_admin` int(11) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('draft','pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT curdate(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `catatan_revisi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `id_admin`, `judul`, `gambar`, `status`, `approved_by`, `tanggal`, `created_at`, `updated_at`, `catatan_revisi`) VALUES
(19, NULL, 'Seminar Public Speaking: “Ketika Ide Terhenti, Gaya Bicaramu Bisa Jadi Solusi” Sukses Digelar di Politeknik Negeri Lampung', NULL, 'approved', NULL, '2025-12-12', '2025-12-12 03:20:47', '2025-12-30 18:16:13', ''),
(20, NULL, 'Struktur Organisasi Forum Mahasiswa Beasiswa Anak Negeri Resmi Ditetapkan', NULL, 'approved', NULL, '2025-12-12', '2025-12-12 03:28:45', '2025-12-12 03:37:16', ''),
(21, NULL, 'SAMBA KIP-K 2025: Penguatan Karakter dan Pembekalan Mahasiswa Baru Melalui Dua Hari Kegiatan Terstruktur', NULL, 'approved', NULL, '2025-12-12', '2025-12-12 03:36:33', '2025-12-12 03:36:59', ''),
(23, NULL, 'Kegiatan Apresiatif KIP-K 2024: Bentuk Penghargaan bagi Mahasiswa BerprestasI', NULL, 'approved', NULL, '2025-12-12', '2025-12-12 04:06:57', '2025-12-12 04:07:23', ''),
(24, NULL, 'Formaban Polinela Gelar Seminar Public Speaking untuk Tingkatkan Kemampuan Komunikasi Mahasiswa', NULL, 'pending', NULL, '2025-12-12', '2025-12-12 04:09:21', '2025-12-31 01:12:25', 'poto nya mana\r\n'),
(25, NULL, 'Seminar Public Speaking: “Ketika Ide Terhenti, Gaya Bicaramu Bisa Jadi Solusi” Sukses Digelar di Politeknik Negeri Lampung', NULL, 'pending', NULL, '2025-12-31', '2025-12-30 18:14:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `berita_gambar`
--

CREATE TABLE `berita_gambar` (
  `id_gambar` int(11) NOT NULL,
  `id_berita` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `sortorder` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita_gambar`
--

INSERT INTO `berita_gambar` (`id_gambar`, `id_berita`, `file`, `caption`, `sortorder`) VALUES
(8, 19, '1767118521_753.jpeg', 'Minggu, 21 September 2025 — Forum Mahasiswa KIP-K Politeknik Negeri Lampung sukses melaksanakan Seminar Public Speaking dengan tema “Ketika Ide Terhenti, Gaya Bicaramu Bisa Jadi Solusi”. Kegiatan ini diselenggarakan di Gedung Serba Guna (GSG) Politeknik Negeri Lampung pada pukul 07.00 WIB sebagai bagian dari program kerja Divisi Dana dan Usaha (Danus).\r\n\r\nSeminar ini menghadirkan Novi Balga sebagai mentor public speaking. Dalam penyampaiannya, beliau membahas pentingnya kemampuan berkomunikasi saat seseorang mengalami blank moment atau kehilangan ide ketika berbicara di depan umum. Peserta diberikan berbagai teknik dasar public speaking, strategi mengendalikan rasa gugup, serta tips menjaga alur komunikasi agar tetap efektif dan meyakinkan.\r\n\r\nKegiatan ini turut dihadiri oleh mahasiswa penerima KIP-K dari berbagai jurusan. Antusiasme terlihat dari aktifnya peserta dalam sesi diskusi dan simulasi praktik berbicara. Melalui seminar ini, diharapkan mahasiswa mampu meningkatkan kepercayaan diri serta memiliki kemampuan komunikasi yang lebih baik untuk menghadapi dunia akademik dan profesional.\r\n\r\nSelain seminar, kegiatan pagi itu juga dirangkaikan dengan pembagian apresiatif bagi mahasiswa berprestasi yang berhasil meraih IP semester 4.00. Agenda ini merupakan program kerja Divisi Advokasi dan Kesejahteraan Mahasiswa (Advokesma). Penghargaan diberikan sebagai bentuk dukungan sekaligus motivasi agar mahasiswa terus meningkatkan prestasi akademik dan aktif berkontribusi dalam pengembangan diri.\r\n\r\nDengan terselenggaranya dua rangkaian kegiatan ini, Forum Mahasiswa KIP-K Politeknik Negeri Lampung berharap dapat menciptakan lingkungan belajar yang kompetitif, inspiratif, serta mendukung pengembangan potensi seluruh mahasiswa penerima beasiswa.', 0),
(9, 20, '1765510125_647_WhatsApp_Image_2025-12-11_at_18.03.04_b942495b.jpg', 'Forum Mahasiswa Beasiswa Anak Negeri secara resmi mengumumkan struktur organisasi terbaru untuk periode berjalan. Struktur ini disusun untuk memperkuat tata kelola organisasi, meningkatkan koordinasi antar-divisi, serta memastikan seluruh program berjalan lebih optimal dan profesional.\r\n\r\n', 0),
(10, 20, '1765510125_664_WhatsApp_Image_2025-12-12_at_10.10.00_813abede.jpg', 'Pada posisi Ketua Umum, terpilih Sidiq Jaya Laksana, yang akan memimpin seluruh arah kebijakan dan kegiatan forum. Ia didampingi oleh Wakil Ketua Umum, M. Aditya Farhan, yang bertugas mendukung pengawasan dan pelaksanaan program kerja di setiap divisi.\r\n\r\nStruktur organisasi ini terdiri dari beberapa kepala divisi yang memiliki tanggung jawab strategis, di antaranya Divisi Kesekretariatan, Keuangan, PSDM, Danus, Advokesma, Sosma, dan Kominfo. Setiap kepala divisi juga didampingi oleh sekretaris divisi untuk memastikan administrasi serta kegiatan operasional berjalan efektif.\r\n\r\nTersusunnya kepengurusan ini, Forum Mahasiswa Beasiswa Anak Negeri berharap dapat menghadirkan kinerja organisasi yang lebih terarah, transparan, dan berdampak positif bagi seluruh penerima beasiswa. Struktur baru ini juga menjadi langkah penting dalam memperkuat kolaborasi internal, meningkatkan kualitas program, serta memberikan kontribusi nyata bagi pengembangan mahasiswa di lingkungan kampus', 1),
(11, 21, '1765510593_574_WhatsApp_Image_2025-12-12_at_05.32.06_cef219fc.jpg', 'Politeknik Negeri Lampung — 22–23 Oktober 2025. Forum Mahasiswa KIP-K Politeknik Negeri Lampung sukses menyelenggarakan kegiatan tahunan SAMBA (Sambutan Mahasiswa Baru) KIP-K 2025, yang diikuti oleh seluruh mahasiswa baru penerima program KIP Kuliah. Kegiatan ini bertujuan memperkenalkan lingkungan kampus, membangun kedisiplinan, serta memberikan pembekalan awal bagi mahasiswa baru agar siap memasuki dunia perkuliahan.\r\n\r\nHari Pertama: Penguatan Karakter Melalui Berbagai Pos Pembinaan\r\nPelaksanaan hari pertama difokuskan pada kegiatan pengembangan karakter melalui sistem pos. Mahasiswa baru mengikuti rangkaian OSPEK internal KIP-K yang terbagi menjadi beberapa pos, yaitu:\r\nPos Kedisiplinan\r\nMelatih sikap tanggung jawab, ketepatan waktu, serta etika sebagai mahasiswa penerima beasiswa.\r\nPos Game & Kekompakan\r\nBerisi permainan edukatif yang bertujuan memperkuat kerja sama tim dan komunikasi antar peserta.\r\nPos Minat & Bakat\r\nMemberikan ruang bagi mahasiswa baru untuk menunjukkan potensi serta mengenali bidang pengembangan diri.\r\nPos Kepemimpinan\r\nMendorong mahasiswa memahami dasar-dasar jiwa kepemimpinan, kemampuan mengambil keputusan, serta membangun kepercayaan diri.\r\nPos Pengetahuan\r\nMenguji wawasan umum, pengetahuan tentang kampus, serta pemahaman mengenai hak dan kewajiban penerima KIP-K.\r\nRangkaian pos ini dirancang untuk membentuk mahasiswa yang disiplin, kreatif, komunikatif, dan siap mengikuti ritme kehidupan akademik di perguruan tinggi.\r\n', 0),
(12, 21, '1765510593_541_WhatsApp_Image_2025-12-12_at_05.32.06_201f5840.jpg', 'Hari Kedua: Penyerahan Simbolis dan Pembekalan Edukatif\r\n\r\nHari kedua diawali dengan penyerahan simbolis Kartu KIP Kuliah oleh Direktur Politeknik Negeri Lampung. Prosesi ini menjadi tanda resmi dimulainya perjalanan akademik mahasiswa baru sebagai bagian dari penerima bantuan pendidikan KIP-K.\r\n\r\nAcara dilanjutkan dengan dua materi penting:\r\nMateri 1: Pencegahan Kekerasan Seksual\r\nDisampaikan oleh Ibu Marlinda Apriyani, S.P., M.P., yang memberikan pemahaman mengenai bentuk-bentuk kekerasan seksual, cara mengenalinya, serta langkah-langkah perlindungan diri di lingkungan kampus. Materi ini menjadi bagian dari upaya menciptakan kampus yang aman dan bebas kekerasan.\r\nMateri 2: Gerakan Anti Narkoba\r\nDibawakan oleh Bapak Fathurrahman Kurniawan Ikhsan, S.Kom., MTI., yang menekankan bahaya penyalahgunaan narkoba, dampak hukum, serta peran mahasiswa dalam menjauhi dan memberantas peredaran narkoba di lingkungan kampus. Mahasiswa diajak untuk menjadi agen perubahan dalam memerangi penyalahgunaan zat berbahaya.\r\n\r\nDengan berakhirnya kegiatan SAMBA KIP-K 2025, diharapkan mahasiswa baru dapat memahami pentingnya kedisiplinan, menjaga integritas, serta menjauhkan diri dari tindakan yang merugikan diri sendiri dan kampus. Kegiatan ini menjadi langkah awal dalam membentuk mahasiswa KIP-K yang berprestasi, berkarakter, dan siap berkontribusi selama menempuh pendidikan di Politeknik Negeri Lampung', 1),
(17, 23, '1765609419_138.jpeg', 'Politeknik Negeri Lampung — 2024. Forum Mahasiswa KIP-K Politeknik Negeri Lampung melaksanakan Kegiatan Apresiatif KIP-K Tahun 2024 sebagai bentuk penghargaan kepada mahasiswa penerima beasiswa yang berhasil meraih pencapaian akademik terbaik selama semester berjalan. Kegiatan apresiatif ini menjadi program rutin yang bertujuan memberikan motivasi serta dukungan konkret kepada mahasiswa agar terus mempertahankan prestasi mereka.\r\n', 0),
(18, 23, '1765512417_983_Annisa.jpg', 'Annisa Tazqia Sari\r\nJurusan Ekonomi Bisnis\r\nProgram Studi Perjalanan Wisata\r\nJuara 2 Kyorugi Senior Putri\r\nKejuaraan Nasional KONI CUP Series 5 Taekwondo Championship 2024', 1),
(19, 23, '1765512417_414_CANDRA.jpg', 'Chandra Dwi Saputra\r\nJuara 1 Competent Category of Fish Ball Production Techniques (AITeC VI)\r\n2024\r\nJurusan Teknik Pertanian\r\nProgram Studi Teknologi Pangan', 2),
(20, 23, '1765512417_936_AGUNG.jpg', 'Agung Tri Wicaksono\r\nJurusan Peternakan\r\nProgram Studi Agribisnis Peternakan\r\nJuara Perunggu Nasional Bidang Bahasa Indonesia', 3),
(21, 23, '1765512417_841_HAFIS.jpg', 'Hafish Arusal Isfalana\r\nJurusan Teknologi Informasi\r\nProgram Studi Teknologi Rekayasa Internet\r\nJuara 1 Competent Category of Agricultural Technology Innovation Competition (AITeC VI)\r\n2024\r\n\r\n\r\nPada kegiatan ini, forum memberikan penghargaan berupa sertifikat dan amplop apresiasi kepada mahasiswa yang berhasil memperoleh Indeks Prestasi tinggi. Penyerahan penghargaan dilakukan secara simbolis oleh perwakilan pengurus forum dan pembina, disaksikan oleh seluruh peserta yang hadir.\r\n\r\nMelalui kegiatan ini, Forum KIP-K berharap dapat mendorong mahasiswa untuk terus meningkatkan kualitas akademik, menjaga komitmen sebagai penerima beasiswa, serta menjadi teladan bagi angkatan lainnya. Penghargaan sederhana ini diharapkan menjadi penyemangat bagi mahasiswa untuk terus berprestasi dan memanfaatkan kesempatan beasiswa dengan sebaik mungkin.\r\n\r\nKegiatan Apresiatif KIP-K 2024 berlangsung secara sederhana namun penuh makna, menegaskan bahwa setiap pencapaian layak diapresiasi dan dirayakan sebagai bagian dari perjalanan akademik mahasiswa.\r\n\r\n', 4),
(23, 25, '1767118474_317_WhatsApp_Image_2025-12-31_at_01.09.38.jpeg', 'Minggu, 21 September 2025 — Forum Mahasiswa KIP-K Politeknik Negeri Lampung sukses melaksanakan Seminar Public Speaking dengan tema “Ketika Ide Terhenti, Gaya Bicaramu Bisa Jadi Solusi”. Kegiatan ini diselenggarakan di Gedung Serba Guna (GSG) Politeknik Negeri Lampung pada pukul 07.00 WIB sebagai bagian dari program kerja Divisi Dana dan Usaha (Danus).\r\n\r\n\r\n\r\nSeminar ini menghadirkan Novi Balga sebagai mentor public speaking. Dalam penyampaiannya, beliau membahas pentingnya kemampuan berkomunikasi saat seseorang mengalami blank moment atau kehilangan ide ketika berbicara di depan umum. Peserta diberikan berbagai teknik dasar public speaking, strategi mengendalikan rasa gugup, serta tips menjaga alur komunikasi agar tetap efektif dan meyakinkan.\r\n\r\n\r\n\r\nKegiatan ini turut dihadiri oleh mahasiswa penerima KIP-K dari berbagai jurusan. Antusiasme terlihat dari aktifnya peserta dalam sesi diskusi dan simulasi praktik berbicara. Melalui seminar ini, diharapkan mahasiswa mampu meningkatkan kepercayaan diri serta memiliki kemampuan komunikasi yang lebih baik untuk menghadapi dunia akademik dan profesional.\r\n\r\n\r\n\r\nSelain seminar, kegiatan pagi itu juga dirangkaikan dengan pembagian apresiatif bagi mahasiswa berprestasi yang berhasil meraih IP semester 4.00. Agenda ini merupakan program kerja Divisi Advokasi dan Kesejahteraan Mahasiswa (Advokesma). Penghargaan diberikan sebagai bentuk dukungan sekaligus motivasi agar mahasiswa terus meningkatkan prestasi akademik dan aktif berkontribusi dalam pengembangan diri.\r\n\r\n\r\n\r\nDengan terselenggaranya dua rangkaian kegiatan ini, Forum Mahasiswa KIP-K Politeknik Negeri Lampung berharap dapat menciptakan lingkungan belajar yang kompetitif, inspiratif, serta mendukung pengembangan potensi seluruh mahasiswa penerima beasiswa.\r\n\r\nKembali ke Berita', 0);

-- --------------------------------------------------------

--
-- Table structure for table `evaluasi`
--

CREATE TABLE `evaluasi` (
  `id_eval` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa_kip` int(11) UNSIGNED DEFAULT NULL,
  `kondisi_awal` text DEFAULT NULL,
  `kondisi_awal_lain` varchar(255) DEFAULT NULL,
  `keaktifan` text DEFAULT NULL,
  `prestasi` text DEFAULT NULL,
  `penerima_bansos` varchar(150) DEFAULT NULL,
  `info_hp` varchar(20) DEFAULT NULL,
  `nomor_wa` varchar(20) DEFAULT NULL,
  `persetujuan` varchar(50) DEFAULT NULL,
  `status_verifikasi` varchar(50) DEFAULT NULL,
  `catatan_adm` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `id_admin` int(11) UNSIGNED DEFAULT NULL,
  `status_tindak` enum('pending','proses','selesai') DEFAULT 'pending',
  `jenis_bantuan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluasi`
--

INSERT INTO `evaluasi` (`id_eval`, `id_mahasiswa_kip`, `kondisi_awal`, `kondisi_awal_lain`, `keaktifan`, `prestasi`, `penerima_bansos`, `info_hp`, `nomor_wa`, `persetujuan`, `status_verifikasi`, `catatan_adm`, `submitted_at`, `id_admin`, `status_tindak`, `jenis_bantuan`) VALUES
(19, 4672, 'Terdata DTKS', '', 'AKTIF', '', 'Ya', 'k', '0896727276272', 'Ya', NULL, NULL, '2025-12-24 11:40:57', NULL, 'pending', NULL),
(20, 4664, 'Terdata DTKS', '', 'AKTIF', '-', 'Ya', 'vivo y23', '08967546786', 'Ya', NULL, NULL, '2025-12-31 09:15:43', NULL, 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluasi_kip_bbp`
--

CREATE TABLE `evaluasi_kip_bbp` (
  `id_evaluasi` int(11) NOT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `npm` varchar(50) NOT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `tahun_masuk` varchar(10) DEFAULT NULL,
  `jenis_bantuan` varchar(50) DEFAULT NULL,
  `kondisi_awal` text DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `keaktifan_semester` varchar(20) DEFAULT NULL,
  `prestasi_non_akademik` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_eval`
--

CREATE TABLE `file_eval` (
  `id_file` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa_kip` int(11) UNSIGNED DEFAULT NULL,
  `file_eval` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `id_admin` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_eval`
--

INSERT INTO `file_eval` (`id_file`, `id_mahasiswa_kip`, `file_eval`, `uploaded_at`, `id_admin`) VALUES
(17, 4672, 'file_eval_4672_1766551257.pdf', '2025-12-24 11:40:57', NULL),
(18, 4664, 'file_eval_4664_1767147343.docx', '2025-12-31 09:15:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE `keluarga` (
  `id_klrg` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa_kip` int(11) UNSIGNED DEFAULT NULL,
  `nm_ayah` varchar(100) DEFAULT NULL,
  `status_ayah` varchar(50) DEFAULT NULL,
  `pkerjan_ayah` varchar(100) DEFAULT NULL,
  `instansi_ayah` varchar(100) DEFAULT NULL,
  `penghasilan_ayah` varchar(50) DEFAULT NULL,
  `nm_ibu` varchar(100) DEFAULT NULL,
  `status_ibu` varchar(50) DEFAULT NULL,
  `pkerjan_ibu` varchar(100) DEFAULT NULL,
  `instansi_ibu` varchar(100) DEFAULT NULL,
  `penghasilan_ibu` varchar(50) DEFAULT NULL,
  `jumlah_tgngn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluarga`
--

INSERT INTO `keluarga` (`id_klrg`, `id_mahasiswa_kip`, `nm_ayah`, `status_ayah`, `pkerjan_ayah`, `instansi_ayah`, `penghasilan_ayah`, `nm_ibu`, `status_ibu`, `pkerjan_ibu`, `instansi_ibu`, `penghasilan_ibu`, `jumlah_tgngn`) VALUES
(12, 4672, '3', 'Hidup', 'd', '', '1000000-1500000', 'd', 'Hidup', 'd', '', '<=700000', 0),
(13, 4672, '3', 'Hidup', 'd', '', '<=700000', 'd', 'Hidup', 'd', '', '>=4000000', 0),
(14, 4672, '3', 'Hidup', 'd', '', '<=700000', 'd', 'Hidup', 'd', '', '>=4000000', 0),
(15, 4672, '3', 'Hidup', 'd', '', '<=700000', 'd', 'Hidup', 'd', '', '>=4000000', 0),
(16, 4664, 'arya', 'Hidup', 'buruh', 'lampung', '3000000-3500000', 'cindi', 'Hidup', 'ibu rumah tangga', 'lampung', '<=700000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) UNSIGNED NOT NULL,
  `nama_pelapor` varchar(100) NOT NULL,
  `email_pelapor` varchar(100) NOT NULL,
  `nama_terlapor` varchar(100) NOT NULL,
  `npm_terlapor` varchar(30) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `detail_laporan` text NOT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `pernyataan` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_admin` int(11) UNSIGNED DEFAULT NULL,
  `status_tindak` enum('pending','proses','selesai') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `nama_pelapor`, `email_pelapor`, `nama_terlapor`, `npm_terlapor`, `jurusan`, `prodi`, `alasan`, `detail_laporan`, `bukti`, `pernyataan`, `created_at`, `id_admin`, `status_tindak`) VALUES
(11, 'nd', 'putrianggrainisafitri92@gmail.com', 'likew', '3214124', 'slk', 'axm', 'xmz,xzx,z', 'sa', '1767145784_2694_WIN_20251230_23_50_01_Pro.mp4', 0, '2025-12-31 01:49:44', NULL, 'pending'),
(12, 'komang', 'putrianggrainisafitri92@gmail.com', 'vina', '235033', 'JURUSAN TEKNOLOGI INFORMASI', 'D4 Teknologi Rekayasa Elektronika', 'xmz,xzx,z', 'wq', '1767146989_4391_0.png,1767146989_4903_Screen Recording 2025-12-24 085830.mp4,1767146989_3004_putri anggraini_23753030_web 1.docx', 0, '2025-12-31 02:09:49', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa_kip`
--

CREATE TABLE `mahasiswa_kip` (
  `id_mahasiswa_kip` int(11) UNSIGNED NOT NULL,
  `npm` varchar(20) DEFAULT NULL,
  `nama_mahasiswa` varchar(100) DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `skema` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `id_admin` int(11) UNSIGNED DEFAULT NULL,
  `catatan_revisi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa_kip`
--

INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(3766, '21711007', 'Dona Aprilia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3767, '21711012', 'Ignatius Galih Pramudito', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3768, '21711015', 'M. Rama Afandi', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3769, '21711017', 'Melisa Pangestuti', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3770, '21711020', 'Ni Wayan Sri Kandi', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3771, '21711023', 'Rahma Sisilia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3772, '21711025', 'Riska Noviana', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3773, '21711031', 'Yosi Dwitia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3774, '21711033', 'Adi Sutopo', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3775, '21711034', 'Ahmad Said Sholekul Majid', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3776, '21711037', 'Aulia Putri Angel', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3777, '21711039', 'Eka Rismayang Sari', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3778, '21711042', 'Heryana', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3779, '21711044', 'Iis Ike Setiani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3780, '21711049', 'Muhammad Arief Fajaruddin', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3781, '21711051', 'Nita Listiana', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3782, '21711054', 'Randi', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3783, '21711056', 'Rizki Rofi Al Fajri', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3784, '21711057', 'Seli Okta Pia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3785, '21711060', 'Wayan Subawe', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3786, '21711063', 'Maskur Holil', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3787, '21711064', 'Adji Muhammad Afif', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3788, '21711065', 'Aisyah Salsabila', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3789, '21711067', 'Arini', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3790, '21711068', 'Ayu Ningrum', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3791, '21711070', 'Eko Saputra', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3792, '21711071', 'Fadilah Rahmalia Putri', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3793, '21711072', 'Gusti Putu Andrayuga Pratama', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3794, '21711073', 'I Gede Rio Mahendra', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3795, '21711074', 'Ibnu Ashadi', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3796, '21711075', 'Indrawan', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3797, '21711077', 'Laura Lina Apriyanti', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3798, '21711078', 'M. Antero', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3799, '21711079', 'Mery Kris Pesta Limbong', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3800, '21711080', 'Muhammad Miftahurohman', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3801, '21711081', 'Nely Agustin Peyani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3802, '21711082', 'Novita Dong Mariris Simbolon', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3803, '21711083', 'Patrecia Yolanda Sijabat', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3804, '21711084', 'Rafli Silvani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3805, '21711085', 'Rani Indah Lestari', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3806, '21711088', 'Septina Nur Anisa', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3807, '21711090', 'Tantia Rhamadahania Syarif', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3808, '21711092', 'Yosafat Silaban', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3809, '21713003', 'Andini Kurnia Putri', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3810, '21713007', 'Diana', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3811, '21713010', 'Ferawati', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3812, '21713011', 'I Putu Aditya Ardana', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3813, '21713014', 'Jepri Wisnu Wardana', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3814, '21713016', 'Maharani Miranti Rao', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3815, '21713017', 'Nanda Saputra', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3816, '21713020', 'Rajes Pandego Ngesti', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3817, '21713021', 'Rinta Meliana', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3818, '21713022', 'Rizki Rojabi', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3819, '21713025', 'Sherly Mailani', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3820, '21713026', 'Sofyan Nur Zailani', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3821, '21713028', 'Widia Rizka Sonia', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3822, '21714003', 'Aisyah Kusuma Shalimar', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3823, '21714004', 'Alifa Nurul Huda', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3824, '21714012', 'Erma Pertiwi', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3825, '21714013', 'Febby Fatmawati', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3826, '21714015', 'Hazuwan', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3827, '21714016', 'Intan Triani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3828, '21714019', 'Latipa Yuntari Eka Putri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3829, '21714020', 'Made Pranawasa', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3830, '21714024', 'Okta Mulyani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3831, '21714025', 'Pujiyati Wulandari', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3832, '21714026', 'Rahma Zuliana', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3833, '21714031', 'Septi Aprilia', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3834, '21714032', 'Suci Mei Lestari', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3835, '21714033', 'Wahyu Dwi Saputra', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3836, '21714035', 'Zahratul Jannah', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3837, '21714040', 'Ardila Triyani Nur Fadilah', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3838, '21714044', 'Devitra Amanda', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3839, '21714046', 'Eka Nur Rodiawati', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3840, '21714051', 'Jenny Indriyani Putri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3841, '21714053', 'Laras Mega Prasetyo', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3842, '21714054', 'Lufie Aula', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3843, '21714059', 'Popi Septia Sari', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3844, '21714061', 'Rasiqa Oktaviani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3845, '21714062', 'Riki Aldi', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3846, '21714063', 'Riska Dwi Saputri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3847, '21714069', 'Wisnu Tri Widiyanto', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3848, '21714070', 'Inas Amaliya Sajidah', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3849, '21722002', 'Agesty Atika Rahim', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3850, '21722003', 'A Irwan Rohma Dani', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3851, '21722004', 'Aji Pangestu', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3852, '21722005', 'Aldenny Rezky Roham', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3853, '21722010', 'Aprilia Sari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3854, '21722013', 'Betran Aditya Pratama', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3855, '21722014', 'Deli Yulianti', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3856, '21722015', 'Dini Fitria', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3857, '21722016', 'Dwi Sefviani', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3858, '21722022', 'Jefen Fernando', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3859, '21722024', 'Maulita Tiara Putri', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3860, '21722027', 'Putri Andini', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3861, '21722030', 'Romi Widodo', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3862, '21722031', 'Septiyani', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3863, '21722035', 'Adib Minanur Rohman', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3864, '21722041', 'Andre Prasetiyo', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3865, '21722042', 'Anisa Firdaus', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3866, '21722044', 'Arif Cahyono', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3867, '21722049', 'Dira Fanisa Balqis', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3868, '21722050', 'Eko Apriyanto', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3869, '21722052', 'Firelli Eka Aditya', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3870, '21722057', 'M. Mulya Adi Guna', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3871, '21722059', 'Muhammad Hartoni', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3872, '21722060', 'Nurhasanah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3873, '21722062', 'Rikardo Jaya Saputra', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3874, '21722063', 'Rizky Rivaldi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3875, '21722064', 'Septia Widiana', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3876, '21722067', 'Wayan Peki Adi Putra', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3877, '21734007', 'Nurwahid Saputra', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3878, '21734009', 'Rafiqul Hamdi', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3879, '21734012', 'Sang Gita Nur Fatihah', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3880, '21734013', 'Silvia Malum Padang', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3881, '21741001', 'Abdi Kurniawan', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3882, '21741006', 'David Susilo', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3883, '21741007', 'Denada Prasetya Utami', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3884, '21741008', 'Dimas Adi Prayoga', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3885, '21741011', 'Elmon Andreas Dinata', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3886, '21741013', 'Ferdy Cahya Handaru', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3887, '21741018', 'Komang Ega Pratama', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 2', 'approved', NULL, NULL),
(3888, '21741024', 'Niki Satria', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3889, '21741032', 'Ade Winda Rozalia', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3890, '21741034', 'Bagas Ahmad Iqbal', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3891, '21741035', 'Bagus Ahmad Akbar', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3892, '21741039', 'Dimas Andrianto', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3893, '21741040', 'Edison Junedi Sinaga', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3894, '21741041', 'Elisa Pitri', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3895, '21741045', 'Heri Erwin', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3896, '21741052', 'Megi Nuri Agus Saputra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3897, '21741054', 'Muhammad Wahyu Ar Rafyy Anwar', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3898, '21741055', 'Nova Risky Yuwana Putra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3899, '21741056', 'Qoirul Marfungatu', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3900, '21741058', 'Riski Nopriyansyah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3901, '21741062', 'Zaid Hammam Fadli', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3902, '21741063', 'Aghnat Guruh Samudra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3903, '21741067', 'Darul Ilham Suryadi', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3904, '21741068', 'Dela Puji Lestari', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3905, '21741070', 'Doni Alha\'qi', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3906, '21741072', 'Eliza Hilda Saskia', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3907, '21741073', 'Enjelyna Veronika', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3908, '21741077', 'Ilham Tegar Insani', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3909, '21741078', 'Irfani Dimas Hermawan', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3910, '21741082', 'Made Merwido', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3911, '21741083', 'Megi Sidik Saputra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3912, '21741086', 'Novan Ananda Saputra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3913, '21741090', 'Sagita Riski', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3914, '21743005', 'Assyifa Aulia', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3915, '21743033', 'Albertus Ardiyanto', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3916, '21743056', 'Risma Rahayu', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3917, '21743060', 'Verend Bella Yolandha', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3918, '21751001', 'Alfian Jodi Pratama', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3919, '21751004', 'Atia Abel Pratiwi', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3920, '21751005', 'Cindy Cahyani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3921, '21751008', 'Elsa Agustina', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3922, '21751011', 'Fajrun Najah Ahmad', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3923, '21751017', 'Maeydina Pramiswara', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3924, '21751024', 'Rif\'an Maskur Rachman', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3925, '21751025', 'Rissa Marelza', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3926, '21751027', 'Tri Indah Prihatini', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3927, '21751029', 'Wulan Dari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3928, '21751031', 'Yuni Puspita Sari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3929, '21751034', 'Aryati', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3930, '21751041', 'Fadila Rahmadani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3931, '21751042', 'Gusti Made Sindhu Bhagawanta', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3932, '21751051', 'Nessi Rosalinda Sihombing', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3933, '21751052', 'Novia Adinda', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3934, '21751053', 'Paska Op Sunggu', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3935, '21751054', 'Resti Yulida', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3936, '21751055', 'Risma Kurniawati', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3937, '21751056', 'Rohid Febrian', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3938, '21751057', 'Susi Susanti', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3939, '21751058', 'Trio Herwansyah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3940, '21751061', 'Yessy Nadila', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3941, '21752002', 'Ainun Jariah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3942, '21752003', 'Anapi Rahman', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3943, '21752004', 'Anggi Fitriyani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3944, '21752005', 'Bangkit Josua Simamora', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3945, '21752010', 'Dwi Kurniawati', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3946, '21752016', 'Malia Rosyadah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3947, '21752017', 'Meily Salmaria', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3948, '21752018', 'Muhammad Hamid', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3949, '21752019', 'Mutiara Belkis Oktavia', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3950, '21752021', 'Nurmalasari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3951, '21752022', 'Puji Rahayu', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3952, '21752023', 'Refi Aprilianti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3953, '21752026', 'Sania Ghaida Shafa', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3954, '21752027', 'Sarip Hidayattuloh', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3955, '21752028', 'Septi Israviana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3956, '21752029', 'Sinta Dwi Wahyuni', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3957, '21752030', 'Sri Rizqi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3958, '21752032', 'Umi Khasanah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3959, '21752037', 'Annisa Tri Atikah Hayati', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3960, '21752038', 'Betty Anjelina Zalukhu', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3961, '21752039', 'Dea Visca Putri Aziza', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3962, '21752042', 'Diva Anora Salsabila', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3963, '21752043', 'Dwi Safitri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3964, '21752044', 'Hardiana Sari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3965, '21752045', 'I Putu Candra Guptha', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3966, '21752048', 'M. Habib Bachtiar', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3967, '21752050', 'Mico Sepiano', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3968, '21752052', 'Nadia Yaumi Lestari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3969, '21752053', 'Nintan Septiana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3970, '21752054', 'Oktaviani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3971, '21752055', 'Putri Fadilla Finaldy', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3972, '21752061', 'Shalihah Nur Fadilah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3973, '21752064', 'Tria Nafalia', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3974, '21752067', 'Yulis Setiawati', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3975, '21752068', 'Ahmad Sarbani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3976, '21752069', 'Alya Febbyyana Basuki', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3977, '21752072', 'Dania Gloria', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3978, '21752074', 'Dewi Silviani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3979, '21752075', 'Dian Lestari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3980, '21752076', 'Dwi Apriyani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3981, '21752077', 'Fransiska Miranti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3982, '21752078', 'Hariyanti Sholehah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3983, '21752081', 'Lintang Pratiwi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3984, '21752082', 'Mahmudhatul', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3985, '21752083', 'Marwan Hakim', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3986, '21752092', 'Salsa Fira', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3987, '21752096', 'Sopiyan Adi Permana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3988, '21754003', 'Anik Pratiwi', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3989, '21754007', 'Fadhlurrohman', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3990, '21754015', 'Meylda Putri Sislya', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3991, '21754030', 'Alvina Mayadani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3992, '21754034', 'Daud Panggabean', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3993, '21754036', 'Fani Irma Yanti', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3994, '21754044', 'Meyliza', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3995, '21754046', 'Putra Fajar Setiawan', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3996, '21754047', 'Rama Aditama', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3997, '21755001', 'Ade Risman', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3998, '21755002', 'Agung Susanto', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(3999, '21755006', 'Aura Adzra Salsabil', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4000, '21755007', 'Cici Sabrina Kirani Sani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4001, '21755008', 'Dela Puspita Sari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4002, '21755009', 'Desi Fitriyani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4003, '21755015', 'Hani Putri Anggraini', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4004, '21755019', 'Khofsah Nur Hasanah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4005, '21755023', 'Musqi Raihan Andani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4006, '21755026', 'Randi Nanda Khaerudin', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4007, '21755027', 'Restiana', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4008, '21755029', 'Riska Ainurlia Agustin', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4009, '21755030', 'Rizky Rahmatullah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4010, '21755031', 'Santika Alfrida', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4011, '21755034', 'Wardatun Narima', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4012, '21755035', 'Adit Epferiyansah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4013, '21755038', 'Amanda Ramadhani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4014, '21755040', 'Berliyani Ramanda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4015, '21755041', 'David', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4016, '21755046', 'Ernawati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4017, '21755047', 'Fani Kencana Wati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4018, '21755054', 'M. Diego Nugroho', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4019, '21755058', 'Nova Rizki Sumiati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4020, '21755059', 'Rafika Rokhimatunisa', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4021, '21755061', 'Reygi Dwi Cahya', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4022, '21755062', 'Rif\'atul Muna', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4023, '21755067', 'Tri Kesuma Setya Ningsih', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4024, '21755068', 'Yuli Novita Sari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4025, '21755069', 'Siti Nurhayati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4026, '21755073', 'Kanzah Huaedah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2021', 'SKEMA 1', 'approved', NULL, NULL),
(4027, '22711009', 'Dita Larasati', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4028, '22711010', 'Dwi Adinda Pilmasela', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4029, '22711014', 'Iim Anis Mukaromah', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4030, '22711022', 'Nadia Elsa Putri', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4031, '22711023', 'Putu Aldika Pratama', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4032, '22711024', 'Rafa Via Pasha', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4033, '22711026', 'Ratu Ayuka Maharani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4034, '22711027', 'Raynaldi Dwi Putra', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4035, '22711028', 'Rina Aryati Asmara', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4036, '22711030', 'Setiana Brilian', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4037, '22711031', 'Suci Aulia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4038, '22711032', 'Tri Ayu Ningsih', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4039, '22711040', 'Deby Bagus Pratama', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4040, '22711048', 'Jesika Lidya Wati', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4041, '22711052', 'Melia Anggi Safitri', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4042, '22711053', 'Muhabbatin Aliyah', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4043, '22711054', 'Muhamad Viky Rinaldi', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4044, '22711055', 'Muhammad Syaiful Khamid', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4045, '22711057', 'Rahmat Wahyu Sugiantoro', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4046, '22711060', 'Ria Sari Simanjuntak', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4047, '22711066', 'Yoga Fio Pratama', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4048, '22711067', 'Dwi Apriyani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4049, '22713007', 'Bertha Maharani', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4050, '22713010', 'Fitria Mailinda', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4051, '22713011', 'Hellya Mellina', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4052, '22713012', 'Heppy Palupi Ningrum', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4053, '22713015', 'Kibtiah Safitri', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4054, '22713016', 'Krisnandar', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4055, '22713024', 'Riska Yuliyana', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4056, '22713027', 'Suryo Abi Prasetio', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4057, '22714002', 'Andira Puspitarani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4058, '22714003', 'Chani Dara Siva Ayuni', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4059, '22714009', 'Meidi Ardianto', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4060, '22714014', 'Rani Saraswati', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4061, '22714015', 'Renata Chairunissa', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4062, '22714016', 'Rony Colas Malau', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4063, '22714019', 'Suryani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4064, '22714022', 'Widya Ayu Astuti', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4065, '22714024', 'Zakiyah Amalia Silva', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4066, '22714025', 'Ahmad Komarudin', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4067, '22714030', 'I Kadek Nanda Kusuma', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4068, '22714034', 'Melia Sri Astuti', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4069, '22714037', 'Ni Luh Putri Ayu Ningsih', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4070, '22714041', 'Rosdiana Febti', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4071, '22714045', 'Tri Annisa Lubis', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4072, '22714048', 'Yurika Adelia Sari', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4073, '22714057', 'Winda Tarihoran', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4074, '22722001', 'Abdul Febriawan', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4075, '22722011', 'Emi Marsanda', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4076, '22722013', 'Femas Saputra', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4077, '22722014', 'Fitri Novalia', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4078, '22722016', 'Holan Badu', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4079, '22722019', 'M. Naufal', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4080, '22722027', 'Riska Nur Afifa', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4081, '22722034', 'Ahmad Tomiriansah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4082, '22722037', 'Ayu Mariah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4083, '22722040', 'Dicko Sulthan Syauqi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4084, '22722044', 'Galuh Bintang Nataris', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4085, '22722045', 'Henokh Tua Samosir', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4086, '22722046', 'Isroatus Saadah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4087, '22722047', 'Krisna Hidayatulloh', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4088, '22722049', 'Mayumi Itsuwa', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4089, '22722053', 'Novia Safitri', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4090, '22722057', 'Riski Anuris', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4091, '22722061', 'Adi Cahyono', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4092, '22722066', 'Arif Budi Susilo', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4093, '22722068', 'Citra Ananda Prameswari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4094, '22722073', 'Fikarter', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4095, '22722076', 'Jemi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4096, '22722082', 'Naya Ardianti', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4097, '22722083', 'Nur Djanatur Rohmah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL);
INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(4098, '22722086', 'Rio Anggoro', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4099, '22722088', 'Syafira Aprilia', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4100, '22723004', 'Suhada', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4101, '22734006', 'Cindi Aknes Monica', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4102, '22734007', 'Dimas Maulana Ridwan', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4103, '22734012', 'Jovita Dwi Ilfayeni', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4104, '22734024', 'Sari Rohma Saputri', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4105, '22735004', 'Ayunda Tiara Nurjannah', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4106, '22735008', 'Dzidan Alveo', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4107, '22735027', 'Putu Ramah Yani', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4108, '22736009', 'Kharisma Febriana', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4109, '22736019', 'Putri Wahyu Pratiwi', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4110, '22741007', 'Ayu Rahmitha', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4111, '22741013', 'Febri Andriyan', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4112, '22741017', 'Ivan Ramadhan', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4113, '22741021', 'M. Ikhwanudin', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4114, '22741022', 'Melia Handayani', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4115, '22741024', 'Neng Jiha', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4116, '22741025', 'Nur Hasanah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4117, '22741027', 'Ramanda Jaya', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4118, '22741028', 'Repa Hadiyansyah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4119, '22741031', 'Siti Mahmudah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4120, '22741032', 'Tria Melania', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4121, '22741034', 'Yehezkiel Nugroho', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4122, '22741036', 'Ahmad Addinulhaq', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4123, '22741039', 'Anggi Anggreyani', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4124, '22741048', 'Hairani Azizah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4125, '22741050', 'Irfan Ahmad Pranata', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4126, '22741059', 'Nur Hidayah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4127, '22741062', 'Retno Ayu Ningsih', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4128, '22741066', 'Vinky Dwi Sapitri', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4129, '22741068', 'Zuniar Aji Saputra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4130, '22741072', 'Anderu Faturyansyah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4131, '22741073', 'Anisa Fadillah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4132, '22741074', 'Arvika Anggraeni', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4133, '22741076', 'Dea Damayanti', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4134, '22741078', 'Eka Yunita Sari', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4135, '22741081', 'Galih Alfa Rizki', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4136, '22741089', 'Medi Sardiansyah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4137, '22741093', 'Okta Ramadayani', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4138, '22741100', 'Wahyu Hadiwinarno', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4139, '22743003', 'Agil Romadhon', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4140, '22743012', 'Della Okta Diana', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4141, '22743025', 'Muhammad Guna Darma Putra', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4142, '22743047', 'Claudysti Mayang Tama', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4143, '22743051', 'Epi Herlena', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4144, '22743054', 'Gede Sudarme', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4145, '22743061', 'Muhammad Arbiansyah Hardi', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4146, '22743063', 'Navikatul Hasanah', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4147, '22743068', 'Riska Santia', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4148, '22743073', 'Wayan Dimas Andrean', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4149, '22744007', 'Diniati Istiqomah', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4150, '22744011', 'Habyl Algiffary', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4151, '22744019', 'Mega Febrianti', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4152, '22744022', 'Muhammad Ikhwanudin', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4153, '22744025', 'Nur Indah Lestari', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4154, '22744027', 'Rian Santosa', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4155, '22744029', 'Rita Tri Rahmawati', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4156, '22744030', 'Rizal Murtaza Alwi', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4157, '22744032', 'Rofyta Apriliana', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4158, '22744034', 'Wahyu Attur Muzi', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4159, '22744035', 'Wahyu Putri Nikmah', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4160, '22751003', 'Anggi Nopita Sari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4161, '22751004', 'Arif Ananda Sari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4162, '22751005', 'Aryansah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4163, '22751006', 'Aulika C\'tya Hutabarat', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4164, '22751008', 'Chika Florencia Sugara', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4165, '22751009', 'Delpa Yolanda Apriani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4166, '22751015', 'Isnata Alyaturrahmadani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4167, '22751020', 'Putri Ramadani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4168, '22751021', 'Rosdiana', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4169, '22751029', 'Armon Sianipar', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4170, '22751032', 'Bunga Sinta Aprila', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4171, '22751033', 'Cisilia Deltin Safitri', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4172, '22751036', 'Evi Febriyanti', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4173, '22751041', 'Ledi Diana', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4174, '22751045', 'Rimnauli Nursinta Simbolon', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4175, '22751046', 'Rusman Supryadi Sianturi', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4176, '22751047', 'Tiurmaida Situmorang', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4177, '22751048', 'Tumindang Simbolon', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4178, '22752001', 'A. Rachman', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4179, '22752002', 'Adila Hikmaini', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4180, '22752004', 'Andi Dwi Setyawan', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4181, '22752010', 'Danisa Veronika L.Tobing', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4182, '22752016', 'Lukmannudin', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4183, '22752017', 'Marthiya Salsabila', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4184, '22752018', 'Mohamad Haziq', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4185, '22752022', 'Nola Holia', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4186, '22752023', 'Nyimas Marchelia Wulandary', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4187, '22752025', 'Rita Herawati', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4188, '22752030', 'Vira Novita Dewi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4189, '22752032', 'Achmad Ridwan', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4190, '22752035', 'Andriyan Pratama', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4191, '22752037', 'Ayu Rahma Wulandari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4192, '22752041', 'Desti Afyani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4193, '22752042', 'Diki Prasetiyo', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4194, '22752043', 'Dwi Lestari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4195, '22752044', 'Galih Ahmad Fadilah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4196, '22752045', 'Ilham Mustafa Akhyar', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4197, '22752046', 'Leni Berlianti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4198, '22752049', 'Muhammad Al Fadhil Rozadi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4199, '22752051', 'Nabila', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4200, '22752055', 'Reihan Denindra', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 2', 'approved', NULL, NULL),
(4201, '22752058', 'Shalsa Nadya Azzahra', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4202, '22752062', 'Zalfa Nurviyati', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4203, '22752064', 'Aldo Apriansyah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4204, '22752073', 'Dira Aulia Firda', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4205, '22752076', 'Juwita Casandra Hutagalung', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4206, '22752084', 'Nurbaiti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4207, '22752087', 'Rizky Rahmat Hardani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4208, '22752088', 'Sancai Sitanggang', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4209, '22754001', 'Aad Nabila', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4210, '22754010', 'Duwi Juliana Silitonga', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4211, '22754015', 'Hutami Maha Nani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4212, '22754016', 'Irfan', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4213, '22754017', 'Isma Rahmawati', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4214, '22754018', 'Milla Muktiati', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4215, '22754021', 'Nurlita Artauli Sibarani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4216, '22754026', 'Salsa Nur Rahmawati Dewi', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4217, '22754030', 'Thalita Nabhila', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4218, '22754031', 'Yemima Sarulina Marbun', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4219, '22754037', 'Anju Panjaitan', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4220, '22754038', 'Ari Afrizal', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4221, '22754039', 'Aulia Salsabila Dinanti', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4222, '22754041', 'Diva Widiya Dharma Wanti', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4223, '22754048', 'Irma Lusiana Manurung', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4224, '22754049', 'Komang Pegi Dian Astuti', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4225, '22754051', 'Nadia Lestari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4226, '22754052', 'Niki Febrianti', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4227, '22754053', 'Putri Handayani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4228, '22754057', 'Safitri Ulandari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4229, '22755002', 'Agna Khoirun Nisa', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4230, '22755004', 'Ammaya Tasya', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4231, '22755005', 'Ani Meliasari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4232, '22755009', 'Dela Zati Sapitri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4233, '22755012', 'Dwi Anggraini', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4234, '22755019', 'Laila Dzikroo Lawahizh', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4235, '22755022', 'Marina', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4236, '22755026', 'Nadya Vebby Yanti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4237, '22755028', 'Ni Putu Widyawati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4238, '22755029', 'Nungki Indriyani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4239, '22755030', 'Okta Fitriyana', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4240, '22755032', 'Rido Firnando', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4241, '22755034', 'Salwa Ainun Nisa', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4242, '22755035', 'Sindi Novita Sari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4243, '22755039', 'Vimas Wilanda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4244, '22755040', 'Yurike Okvia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4245, '22755047', 'Cahyani Luthfi Aqrobah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4246, '22755049', 'Denny Saputra', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4247, '22755050', 'Dila Nuraini', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4248, '22755054', 'Fauzi Khoiru Rizal', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4249, '22755060', 'Lulu Ardelia Kholillah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4250, '22755063', 'Megga Devi', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4251, '22755064', 'Merry Sartika', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4252, '22755067', 'Ni Kadek Widyantari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4253, '22755069', 'Nur Intan Mutiara', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4254, '22755075', 'Sohibus Syafaat', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4255, '22755077', 'Tiara Octavia Pardede', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4256, '22755078', 'Ummy Miftahul Jannah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4257, '22755079', 'Wulan Novitriani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4258, '22755081', 'Ade Ira Sinta Nainggolan', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4259, '22755082', 'Ahmad Khadafi, Ht', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4260, '22755083', 'Amanda Devi Mutiara', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4261, '22755087', 'Cerya Dara Sidney L', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4262, '22755089', 'Dhea Shevalina', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4263, '22755090', 'Dina Apriliana', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4264, '22755091', 'Dinda Maria Margaretta', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4265, '22755092', 'Dwiyanto Anugrah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4266, '22755093', 'Erydha Wulan Handayani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4267, '22755094', 'Filisana Baeha', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4268, '22755103', 'Mei Dinda Nirmalena', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4269, '22755105', 'Nabila Agustina', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4270, '22755107', 'Ni Luh Arnita Suciantari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4271, '22755108', 'Nicolas Pardamean Napitupulu', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4272, '22755110', 'Putu Edi Sutrisna', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4273, '22755113', 'Safa Silvia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4274, '22755115', 'Suci Wulandari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4275, '22755120', 'Zammil Daffa', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4276, '22755129', 'Diana Aprilia Putri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4277, '22755132', 'Efrilawati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4278, '22755134', 'Fitri Yani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4279, '22755137', 'Kalina Tantri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4280, '22755138', 'Kirana Patricia Putri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4281, '22755139', 'Leo Nardo Ginting', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4282, '22755141', 'Margaretha Rahayu Trisnaningsih', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4283, '22755142', 'Maya Anggraeni', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4284, '22755143', 'Meri Aprilianti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4285, '22755148', 'Novi Safitri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4286, '22755151', 'Revany Putria Hevi', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4287, '22755152', 'Rizky Arfiansyah Putra', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4288, '22755153', 'Saiful Anwar', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4289, '22755158', 'Vika Mutika Suri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4290, '22755161', 'Dila', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4291, '22755165', 'Ketut Rika Saputra', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2022', 'SKEMA 1', 'approved', NULL, NULL),
(4292, '23711003', 'Ananta Satria', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4293, '23711004', 'Andri Setiawan', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4294, '23711006', 'Armada', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4295, '23711008', 'Citra Ayu Lestari', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4296, '23711009', 'Destri Amandasari', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4297, '23711012', 'Fauzi Yanti Nursya', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4298, '23711015', 'Luna Adiswasuri', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4299, '23711016', 'Lusi Wulandari', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4300, '23711018', 'Muhammad Fauzan Falah', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4301, '23711019', 'Muqoddam', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4302, '23711024', 'Rita', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4303, '23712010', 'Desi Nur Lailatul Fitriani', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4304, '23712013', 'Diyah Mutiaradewi', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4305, '23712019', 'Galuh Ira Saputri', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4306, '23712020', 'Hanny Halimah', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4307, '23712030', 'Ni Ketut Sri Astuti', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4308, '23712034', 'Resti Dwi Astuti', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4309, '23713004', 'Asri Ivtiar', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4310, '23713006', 'Clara Aneza Putri', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4311, '23713014', 'Laiza Amalia', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4312, '23713015', 'M. Febriansyah', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4313, '23713016', 'Nanda Sulbiah', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4314, '23713019', 'Prisca. M', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4315, '23713020', 'Reval Frenkiansah', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4316, '23713021', 'Silvi Nur Fadila Alfi', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4317, '23713024', 'Anggi Anugra', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4318, '23713029', 'Dimas Ashari Katama', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4319, '23713032', 'Farrel Mecca Achmad Nurullah', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4320, '23713033', 'Herwin', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4321, '23713035', 'Kholikul Baharudin', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4322, '23713037', 'Maileni', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4323, '23713040', 'Pingkan Agustina', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4324, '23714001', 'Ade Pratama', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4325, '23714002', 'Ahmad Farid Lubab Sabili', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4326, '23714004', 'Aulia Dina Winanti', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4327, '23714007', 'Diego Valdano', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4328, '23714008', 'Dwi Nur Faidah', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4329, '23714010', 'Faraz Yudha Adji Sadewa', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4330, '23714011', 'Fifin Erida Wulandari', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4331, '23714016', 'Melisa Nadia Putri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4332, '23714018', 'Nita Okta Pena Sianturi', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4333, '23714019', 'Pestauli Sianipar', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4334, '23714021', 'Rifqi', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4335, '23714023', 'Sindy Nurhaliza', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4336, '23714024', 'Siti Nuraini', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4337, '23714026', 'Tri Sanjayani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4338, '23714033', 'Berti Lia', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4339, '23714037', 'Erni Elisa Putri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4340, '23714038', 'Fat Qurrohman', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4341, '23714051', 'Siti Hadijah', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4342, '23714053', 'Suparno Wasis', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4343, '23714056', 'Yunida Karisa', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4344, '23714058', 'Angel Livia Putri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4345, '23714059', 'Arista Eka Putri Hartono', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4346, '23714063', 'Dwi Fitriani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4347, '23714065', 'Fadilah Nur Fitriani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4348, '23714066', 'Feni Kurniawati', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4349, '23714069', 'Jamilatun Munawaroh', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4350, '23714070', 'Lira Nadi Armeilita', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4351, '23714073', 'Nadia Dina Alifa', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4352, '23714074', 'Ovilia Putri Puspita Sari', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4353, '23714079', 'Siti Maizaroh', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4354, '23721001', 'Achmad Faisal', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4355, '23721007', 'Dewi Asmawati', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4356, '23721024', 'Wage Aan Kurniawan', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4357, '23721025', 'Adi Pratama', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4358, '23721036', 'Jomiko Saifullah', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4359, '23721039', 'Maya Sari', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4360, '23721043', 'Pradipa Prianggani', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4361, '23722002', 'Agnes Eighlistiani Br Sihotang', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4362, '23722005', 'Anton Nofriansah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4363, '23722006', 'Citra Puspita Sari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4364, '23722010', 'Falgunadi Harits Ramadhan', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4365, '23722011', 'Feny Anggraini', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4366, '23722012', 'Fringki Apriontama', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4367, '23722014', 'Icha Zakia', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4368, '23722015', 'Intan Mutiara', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4369, '23722016', 'Joel Alamsyah Ambarita', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4370, '23722017', 'Lismiyati Nur Khalifah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4371, '23722026', 'Restu Hadi Wijaya', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4372, '23722029', 'Sayu Putu Syawitri Dewi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4373, '23722035', 'Rahmad Aldo Melendy', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4374, '23722036', 'Refa Oktarina Alyani', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4375, '23722037', 'Revalina Dinda Safitri', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4376, '23722038', 'Riska Amellya Yusi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4377, '23722043', 'Yogi Saputra', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4378, '23722044', 'Zidan Maulana', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4379, '23722045', 'Adit Indra Lesmana', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4380, '23722047', 'Aisah Nurhayati', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4381, '23722053', 'Fadilatul Jannah Harahap', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4382, '23722058', 'Imelda Afriana Almet', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4383, '23722060', 'Laili Amanda Safutri', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4384, '23722061', 'Lola Sagita', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4385, '23722066', 'Ni Luh Citra Puspita Dewi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4386, '23722068', 'Oggi Manuel Alonsosiburian', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4387, '23722074', 'Septiara Nova Mariska', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4388, '23722075', 'Syaif Elvand Frisky', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4389, '23722076', 'Triagus Tina', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4390, '23722078', 'Afriedo Sembiring', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4391, '23722080', 'Aitama Poda Sidabutar', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4392, '23722081', 'Anggi Yuni Sartika', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4393, '23722083', 'Deni Septian', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4394, '23722088', 'Fitri Linda Sari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4395, '23722089', 'Hairun Nisah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4396, '23722091', 'Indra Setiawan', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4397, '23722092', 'Ivan Ade Saputra', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4398, '23722093', 'Langen Febri Antika', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4399, '23722096', 'Muhamad Affan', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4400, '23722099', 'Ni Luh Okta Yogiantari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4401, '23722100', 'Nurdaiti', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4402, '23722101', 'Putri Anisah Ardiana', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4403, '23722102', 'Rani Syafitri', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4404, '23722103', 'Rendy Syaputra', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4405, '23722108', 'Syifa Safina Turrahmah', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4406, '23722111', 'Afrizal Aunur Rofiq', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4407, '23722112', 'Ahmad Nur Huda', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4408, '23722115', 'Ceridita Pratiwi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4409, '23722116', 'Dera Rima Wulandari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4410, '23722118', 'Ega Wijaya', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4411, '23722121', 'Fitri Ulan Dari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4412, '23722123', 'I Wayan Rio', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4413, '23722125', 'Jesifa Ardita', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4414, '23722126', 'Lira Yoseva Br Simbolon', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4415, '23722131', 'Nael Natalion', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4416, '23722132', 'Nika Aulia', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4417, '23731013', 'Rofii Syah Putra', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4418, '23731014', 'Sania T F Purba', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4419, '23732002', 'Ahmad Sulaiman', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4420, '23732003', 'Alvan Kurniawan', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4421, '23732004', 'Alvin Kurniawan', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4422, '23732008', 'Ester Gresselia Simanjuntak', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4423, '23732030', 'Taufik Trisna Prasetyo', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4424, '23733022', 'Resna Khodijah', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4425, '23733025', 'Zulipan Arben', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4426, '23733031', 'Candra Dwi Saputra', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4427, '23733033', 'Dame Kristiani Lumban Gaol', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4428, '23733035', 'Eka Wahyuni', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4429, '23733039', 'Kafka Armelsya', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4430, '23733044', 'Niko Apriadi', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4431, '23734004', 'Dahra Fitriatul Hasanah', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4432, '23734005', 'Deasy Christa Yani Br Simanjuntak', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4433, '23734006', 'Dika Nizar Saputra', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4434, '23734009', 'Jansen Marcelino', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4435, '23734010', 'Kasando', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4436, '23734011', 'Mahfud Sidiq Ar Rofi\'i', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL);
INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(4437, '23734014', 'Muhammad Nurrohman', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4438, '23734015', 'Nandito Saputra Siagian', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4439, '23734017', 'Nur Rahmat Abdul Razak', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4440, '23734020', 'Shanti Anisa', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4441, '23734021', 'Shelfia Sekar Sari', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4442, '23734023', 'Yoga Pratama', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4443, '23734027', 'Dea Salsabila Putri', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4444, '23734032', 'Jelita Khairunisa', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4445, '23734036', 'Muhammad Ikhwan Maula', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4446, '23734042', 'Ryan Dias Wicaksana', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4447, '23735019', 'Rahmad Perwira Adha', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4448, '23735024', 'Zinha Lahiddina Melsa', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4449, '23735026', 'Akhmad Aditya Fernando', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4450, '23735040', 'Muhammad Rizky Fergie Ardhana', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4451, '23735041', 'Natanael Barus', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4452, '23735045', 'Satria Kilauan Bintang', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4453, '23736002', 'Ady Permana Putra', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4454, '23736006', 'Daroni Indra Mukti', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4455, '23736012', 'Gina Milanda', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4456, '23736013', 'Hafid', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4457, '23736020', 'Nabila Orilya Putri', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4458, '23736024', 'Reni Istikomah', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4459, '23736025', 'Rivaldo Dewantoro', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4460, '23736026', 'Samuel Goliada L Tobing', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4461, '23736028', 'Siti Saroh', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4462, '23736029', 'Uun Rosita', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4463, '23736033', 'Anjelita', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4464, '23736034', 'Aulia Cintya Bella', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4465, '23736039', 'Elsa Mutia Syahfitri', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4466, '23736040', 'Farichah Aulia Rachma', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4467, '23736042', 'Gabriel Verdichristian Purba', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4468, '23736043', 'Glady Intan Santoso', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4469, '23736046', 'Lauriend Peathryx Handa Yadika', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4470, '23736051', 'Nur Maya Romantir', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4471, '23736058', 'Siti Rahmah', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4472, '23736059', 'Suhairiyah', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4473, '23736060', 'Valencia Floren Hutapea', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4474, '23736061', 'Wahyu Istiqomah', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4475, '23738009', 'Fira Marganingsih', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4476, '23738010', 'Jaka Frastio', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4477, '23741010', 'Andre Erlando', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4478, '23741011', 'Anisa Novi Salsabila', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4479, '23741012', 'Arif Rifai', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4480, '23741021', 'Garren Nobert Laborious', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4481, '23741025', 'M Aji Putra', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4482, '23741026', 'Mifthahul Rizky', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4483, '23741027', 'Novita Sinta Wati', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4484, '23741029', 'Reka Yunanda', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4485, '23741035', 'Yezriel Daeli', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4486, '23741045', 'Andika Yulio Pratama', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4487, '23741058', 'Irfan Hadiq Muiz', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4488, '23741061', 'M. Dafiq Albara', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4489, '23741064', 'Rayhan Ananda Pratama', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4490, '23741067', 'Rifaldo Wanda', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4491, '23741069', 'Sapari Anwar', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4492, '23741071', 'Yogi', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4493, '23741072', 'Zuvi Hazan Basriyan', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4494, '23742001', 'Aditya Rian Dian Setiawan', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4495, '23742006', 'Buhori', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4496, '23742008', 'Dedi Wijaya', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4497, '23742011', 'Fajar Raihan Zaki', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4498, '23742018', 'Lamhot Risky Pardamean Siburian', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4499, '23742026', 'Muhamad Ansor', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4500, '23742029', 'Nuril Anwar', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4501, '23742033', 'Rafi Ubaidillah', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4502, '23743004', 'Akbar Qori Ramadhan', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4503, '23743005', 'Anak Agung Alit Sumanjaya', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4504, '23743009', 'Bagus Tri Wahyudi', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4505, '23743013', 'Evita Yuliana', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4506, '23743014', 'Fadilah Damayanti', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4507, '23743016', 'I Gusti Putu Arya Andika', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4508, '23743019', 'Kadek Widastre', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4509, '23743022', 'Mahkita', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4510, '23743024', 'Muhammad Fadhillah', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4511, '23743025', 'Muhammad Rifa\'i', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4512, '23743028', 'Nurkholis Mujib', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4513, '23743034', 'Septriawan', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4514, '23743046', 'Bayu Susilo', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4515, '23743049', 'Elsi Dwi Masyayu', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4516, '23743051', 'Fais Mahmud Hidayat', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4517, '23743052', 'Hamdan Alif Astanto', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4518, '23743053', 'I Nyoman Trio Dharma Saputra', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4519, '23743055', 'Kadek Nova Satriawan', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4520, '23743058', 'M.Jhody Afrian', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4521, '23743063', 'Nafizza Pradita Selvira', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4522, '23743066', 'Redho Nopriadi', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4523, '23743070', 'Ryco Dwi Wicaksono', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4524, '23743072', 'Wahyu Rifki Kesuma', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4525, '23743076', 'Agata Leona Pebrianti', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4526, '23743082', 'Bagus Eka Saputra', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4527, '23743085', 'Dyana Nursafitri', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4528, '23743090', 'I Putu Indra Wijaya Kusuma', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4529, '23743091', 'Irza Bernanda Hani', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4530, '23743102', 'Putra Akmal Pratama', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4531, '23743104', 'Ridwan Fauzan', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4532, '23743105', 'Riri Apilah Nadia Permatasari', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4533, '23743107', 'Satvika Priaji', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4534, '23743108', 'Tika Amelia Sari', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4535, '23743109', 'Welly Fikhi Ardian', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4536, '23744001', 'Achmad Sopian Amanda', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4537, '23744003', 'Albert Winardo', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4538, '23744006', 'Bagus Restu Juniar', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4539, '23744007', 'Defghi Hari Kurniawan', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4540, '23744010', 'Fani Setiawan', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4541, '23744016', 'Muhamad Abi Azis', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4542, '23744017', 'Muhammad Aditya Farhan', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4543, '23744022', 'Robi Julian', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4544, '23744023', 'Sarino', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4545, '23744027', 'Wahyudi Kurniawan', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4546, '23744029', 'Yudhistira Aryo Wicaksono', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4547, '23744030', 'Zyahra Amelia Putri', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4548, '23744031', 'Adnan Firnanda', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4549, '23744035', 'Bagas Rizki Gunian', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4550, '23744037', 'Dewi Fitriyani', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4551, '23744039', 'Fajar Ramadhani', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4552, '23744043', 'Lutfia Masiana', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4553, '23744044', 'M. Harfi Hidayat', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4554, '23744052', 'Rudiansah', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4555, '23744057', 'Wila Ramadhani Syahri', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4556, '23744058', 'Yogi Sofyadinata', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4557, '23744059', 'Yunisa Aulia Damayanti', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4558, '23745010', 'M. Gymnastiar', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4559, '23745012', 'Masdimitri Mahayana', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4560, '23745013', 'Okta Misnariah', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4561, '23745016', 'Septya Cahyani', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4562, '23745017', 'Siti Khumairoh', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4563, '23745019', 'Ummy Kholifah', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4564, '23751001', 'Adinda Aulia Safitri', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4565, '23751004', 'Ari Darma Yuda Kesuma', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4566, '23751007', 'Clara Putri Fadilla', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4567, '23751010', 'Eris Riski Firli Agus', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4568, '23751013', 'Ikbal Saputra', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4569, '23751015', 'Laila Kurnia Sari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4570, '23751017', 'Memey Cinta Aricha', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4571, '23751022', 'Nopian Aziz', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4572, '23751024', 'Retno Ayu Kusuma Ningrum', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4573, '23751027', 'Siti Fatonah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4574, '23751029', 'Tejo Bagus Binani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4575, '23751030', 'Wiwit Fitrah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4576, '23751036', 'Ayu Lestari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4577, '23751040', 'Ella Iis Soleha', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4578, '23751047', 'M. Ridwan', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4579, '23751048', 'Miranda Aprilia', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4580, '23751057', 'Sabrina Aulia', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4581, '23751058', 'Siti Habibah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4582, '23751060', 'Utami Yatu Rohmah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4583, '23751061', 'Zaki Hafizk Saraji', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4584, '23751063', 'Ana Setiani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4585, '23751064', 'Ardiansyah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4586, '23751068', 'Diah Komala Sari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4587, '23751075', 'Kadek Rani Julianti Dewi', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4588, '23751076', 'Lina Anggreani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4589, '23751080', 'Nadilla Pradana', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4590, '23751083', 'Putri Yunnisa', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4591, '23751084', 'Resti Mustika', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4592, '23751085', 'Rifal M Fahril', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4593, '23751086', 'Rofyk Ariyansah', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4594, '23751087', 'Sandika', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4595, '23751088', 'Sketsy Damayanti', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4596, '23751089', 'Syifa Elysia Agripina', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4597, '23751090', 'Wilis Nugroho', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4598, '23752001', 'Aat Anggraeni', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4599, '23752003', 'Amira Aulia Salsabila', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4600, '23752006', 'Citra Dinda Putri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4601, '23752008', 'Dina Miftahul Jannah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4602, '23752010', 'Fadli Rachman Hidayat', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4603, '23752016', 'M. Deo Prayogi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4604, '23752018', 'Mitha Alia Faradillah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4605, '23752019', 'Muhammad Ilham Ar-Rasyid', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4606, '23752024', 'Nur\'atiah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4607, '23752025', 'Putri Al Fazaroh', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4608, '23752027', 'Reza Maulana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4609, '23752029', 'Silva Nisa Ariani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4610, '23752031', 'Widiya Purwanti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4611, '23752032', 'Yahya Editya Wijanarko', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4612, '23752033', 'Yuni Artika', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4613, '23752035', 'Abdullah Luqman Salim', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4614, '23752036', 'Aldy Anugrah Priyammundy', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4615, '23752040', 'Darusman', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4616, '23752042', 'Dina Roihan Zakia', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4617, '23752043', 'Elin Tika', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4618, '23752044', 'Febri Handriyani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4619, '23752045', 'Heni Nabila Sapitri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4620, '23752047', 'Ismaul Hasanah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4621, '23752048', 'Juwita', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4622, '23752056', 'Natasya Rohimah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4623, '23752057', 'Nisaa Citra Kirana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4624, '23752059', 'Putri Lestari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4625, '23752060', 'Ramadhan Nazar Kabul Sidik', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4626, '23752063', 'Sonia Fertika', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4627, '23752065', 'Widiyana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4628, '23752067', 'Yunika Maritasari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4629, '23752068', 'Agnesta Dheani Putri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4630, '23752069', 'Amelia Putri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4631, '23752074', 'Dhiya Indah Pratiwi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4632, '23752075', 'Dinda Maharani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4633, '23752083', 'Martania Irvani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4634, '23752086', 'Mutia Septiana Dewi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4635, '23752091', 'Okta Yunika Sari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4636, '23752092', 'Putri Lestari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4637, '23752095', 'Shendy Herdiyansyah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4638, '23752097', 'Tosela Ponco Hamdani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4639, '23752100', 'Yunila', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4640, '23752101', 'Ajeng Az Zahrah', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4641, '23752105', 'Chitra Media Pratiwi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4642, '23752107', 'Dian Ariyanti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4643, '23752110', 'Hanyfah Inas Syabira', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4644, '23752111', 'Iis Marlina', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4645, '23752112', 'Intan Nurpianti', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4646, '23752113', 'Jessica Nazwa Bintang Maharani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4647, '23752116', 'Maya Zulida Putri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4648, '23752117', 'Mirnawan Siptauli Simanungkalit', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4649, '23752118', 'Muhammad Hafizh', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4650, '23752120', 'Nadia', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4651, '23752123', 'Novia Faradiba', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4652, '23752124', 'Pendi Adi Saputra', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4653, '23752128', 'Shifa Aulia Maharani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4654, '23752131', 'Windi Yonggi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4655, '23752132', 'Yuliana Maya Sari', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4656, '23753002', 'Agista', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4657, '23753007', 'Atilla Akbar Tawaqal', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4658, '23753008', 'Ayu Try Sary', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4659, '23753009', 'Bayu Pratama', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4660, '23753010', 'Bunga Firstya Luna Ananda', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4661, '23753012', 'Damar Arif', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4662, '23753013', 'Diah Ayu Safitri', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4663, '23753015', 'Dwi Ramadhan', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4664, '23753016', 'Fasni Efwa Juniar', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4665, '23753018', 'Ghaitza Zahira Shofi', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4666, '23753021', 'Kresna Abrori', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4667, '23753022', 'M. Zidane Andrean', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4668, '23753023', 'Mawan Mahmud', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4669, '23753024', 'Muhammad Arya Fadli', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4670, '23753028', 'Ni Komang Yuni Setiari', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4671, '23753029', 'Nyopi Wulandari', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4672, '23753030', 'Putri Anggraini Safitri', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4673, '23753032', 'Rifa Nabela Putra Sp', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4674, '23753033', 'Ris Larasati', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4675, '23753034', 'Rizka Nabillah Azwa', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4676, '23753036', 'Sela Wissi Yani', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4677, '23753038', 'Vina Sahara', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4678, '23753043', 'Aina Fatihatus Salsa Billa', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4679, '23753045', 'Andre Saputra', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4680, '23753049', 'Azhar Rizky Trinanda', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4681, '23753050', 'Bella Nabila', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4682, '23753052', 'Citra Anggun Cahyani', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4683, '23753053', 'Desri Nur Fadilah', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4684, '23753055', 'Dwi Meilia Rosa', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4685, '23753060', 'Ika Novalia', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4686, '23753062', 'Lifty Pavita', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4687, '23753064', 'Miftakhur Rizky', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4688, '23753070', 'Okta Lestari', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4689, '23753073', 'Rinasti Ramadona', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4690, '23753077', 'Shanisa Al Mawadah', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4691, '23753081', 'Yona Amalia', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4692, '23753082', 'Zalfa Zain', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4693, '23753085', 'Amrina', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4694, '23753086', 'Andri Sofyan', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4695, '23753088', 'Asih Nur Annisa', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4696, '23753093', 'Citra Sopti Setianingsih', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4697, '23753098', 'Ferdi Riyanto', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4698, '23753099', 'Galih Azzahra', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4699, '23753102', 'Khairunnisa', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4700, '23753103', 'Linda Nopiati', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4701, '23753104', 'M. Rifan Setiawan', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4702, '23753109', 'Nazwa Mutiya Sherlyna', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4703, '23753110', 'Nova Cahyani .Ms', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4704, '23753111', 'Prayoga Nanda Wiranata', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4705, '23753112', 'Rahmadini Nureva Octania', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4706, '23753113', 'Ricky Anggoro', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4707, '23753114', 'Ripki Pernando Ramadan', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4708, '23753117', 'Safitri', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4709, '23753120', 'Wahyu Sani', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4710, '23754001', 'A. Fauzan Elfarico', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4711, '23754006', 'Asince Fitri', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4712, '23754007', 'Aura Ramadania Eftori', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4713, '23754012', 'Dian Laila Assyifa', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4714, '23754014', 'Elvina Destia', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4715, '23754026', 'Nopita Komala Sari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4716, '23754031', 'Riska Dwi Napiska', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4717, '23754035', 'Yolanda Nurfadila', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4718, '23754039', 'Alda Oktaviana', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4719, '23754040', 'Andri Trio Saputra', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4720, '23754041', 'Anita Sari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4721, '23754044', 'Bunga Dahlyia', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4722, '23754047', 'Dela Handayani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4723, '23754048', 'Diana Nurul Aulia', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4724, '23754057', 'Monika Siagian', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4725, '23754060', 'Ni Putu Sriani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4726, '23754061', 'Nita Istiyani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4727, '23754063', 'Oky Nurhidayat', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4728, '23754065', 'Rika Rahmadani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4729, '23754066', 'Rini Mala Sari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4730, '23754067', 'Risma Rahmawati', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4731, '23754069', 'Siti Marfuah', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4732, '23754072', 'Zaitun Nur Hannifah', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4733, '23754078', 'Aulia Nindi Fahlita', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4734, '23754079', 'Bima Satria', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4735, '23754081', 'Chika Imelda Sari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4736, '23754083', 'Dewa Ayu Amara Wati', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4737, '23754085', 'Elsya Dya Cantika', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4738, '23754087', 'Fika Anatasari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4739, '23754088', 'Intan Aprilia', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4740, '23754089', 'Jenny Partikala', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4741, '23754090', 'Khoirunnisa', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4742, '23754092', 'M. Fathur Risky', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4743, '23754100', 'Qurotin Nabila Azahro', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4744, '23754101', 'Rima Alianda Putri', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4745, '23754102', 'Risa Ariasifa', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4746, '23754105', 'Tri Indah Meyrani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4747, '23755004', 'Alfina Rahmadani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4748, '23755005', 'Annisa Salsabila', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4749, '23755006', 'Asman Daniel S', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4750, '23755007', 'Azahra Siwi Maiwa', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4751, '23755010', 'Dhea Rahma Meisya', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4752, '23755014', 'Fenna Enjellia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4753, '23755015', 'Halimah Tussa\'diah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4754, '23755016', 'Ienne Feronika Sormin', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4755, '23755018', 'Khansa Nabilah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4756, '23755019', 'Lia Hadi Safitri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4757, '23755022', 'Muhammad Al Qindy', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4758, '23755024', 'Nanchy Silvia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4759, '23755026', 'Nur Lela', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4760, '23755027', 'Okta Grace V. Purba', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4761, '23755032', 'Varisa Utami', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4762, '23755035', 'Ade Dewi Nuriska', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4763, '23755037', 'Aisyah Arsinta', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4764, '23755039', 'Arinia Amanda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4765, '23755044', 'Dian Marlinda Putri Mayasari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4766, '23755045', 'Dwi Amrina Rosyda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4767, '23755050', 'Imanuella Eventa Rara Mustika', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4768, '23755051', 'Jeny Riska Ananda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4769, '23755054', 'Maharani Putri Azzahra', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4770, '23755055', 'Melati Nainggolan', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4771, '23755060', 'Nur Sintia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4772, '23755062', 'Rana Rohadattul Aisy', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4773, '23755066', 'Vieta Vidhiana', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4774, '23755068', 'Yulianti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4775, '23755069', 'Adelia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4776, '23755071', 'Aisyah Firnanda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4777, '23755077', 'Dewi Oktavia', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4778, '23755084', 'Indah Kusuma Ayu', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4779, '23755088', 'Maia Eka Putri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4780, '23755092', 'Natasya Qonitah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4781, '23755093', 'Ni Wayan Gita Gayatri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4782, '23755094', 'Nurhidayah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4783, '23755096', 'Resti Stianingsih', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4784, '23755098', 'Sidiq Jaya Laksana', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4785, '23755099', 'Syafira Daniela Nahuway', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4786, '23755104', 'Agung Tri Wibowo', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4787, '23755106', 'Annisa Novita Hasna', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4788, '23755110', 'Destary Nataselvia Zai', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4789, '23755112', 'Dikky Evandro Sitorus', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4790, '23755113', 'Egha Henijayanti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4791, '23755114', 'Erlinawati', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL);
INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(4792, '23755122', 'Manda Yunita', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4793, '23755126', 'Ni Nengah Astuti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4794, '23755127', 'Nur Laila Maharani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4795, '23755128', 'Nyoman Diana Maharani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4796, '23755130', 'Reza Hanisya Putri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4797, '23755131', 'Sabrina Damayanti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4798, '23755134', 'Vivi Wulandari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4799, '23756004', 'Annisa Tazqia Sari', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4800, '23756006', 'Azizah Azannah.Sr', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4801, '23756011', 'Elmaya Tri Sahara', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4802, '23756014', 'Gita Aulia Indriyani', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4803, '23756016', 'Laras Nur Faizah', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4804, '23756024', 'Regita Nabila Putri', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4805, '23756025', 'Samuel Ardi Herlambang', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4806, '23756026', 'Sastia', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4807, '23756029', 'Vina Mariana', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4808, '23756031', 'Adelia Nurhajijah', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4809, '23756033', 'Anisa Putri', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4810, '23756035', 'Ardiyanto', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4811, '23756038', 'Cita Ilhani', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4812, '23756040', 'Dian Novita', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4813, '23756041', 'Edlyn Dewari Artanti', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4814, '23756046', 'Indri Yunianti', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4815, '23756047', 'Julio Sutanto Sinambela', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4816, '23756051', 'Mayang Nara Jingga', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4817, '23756052', 'Nabilla Meilani Putri', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4818, '23756055', 'Rana Santayana', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4819, '23756056', 'Rechi Madu Reni', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4820, '23756059', 'Wely Yulianti', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4821, '23756060', 'Wildan Damar Saputra', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4822, '23756061', 'Yoshi Amaria Azzahra', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4823, '23757023', 'Tatran Zianli', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4824, '23758042', 'Hafish Arrusal Isfalana', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 1', 'approved', NULL, NULL),
(4825, '23758051', 'Rahmat Hadinata', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2023', 'SKEMA 2', 'approved', NULL, NULL),
(4826, '24711003', 'ALMAISA DELSI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4827, '24711008', 'DEA ANANDA OKTAPIANA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4828, '24711009', 'Deswita Anggraini', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4829, '24711013', 'FIKA SELVI YANTI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4830, '24711018', 'LEONITA CASTAVIA FIRSTY', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4831, '24711019', 'LIVIA PUSPITA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4832, '24711024', 'NAILA AMALIA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4833, '24711027', 'RENATA PUTRI AYU', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4834, '24711032', 'SHOFIYANA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4835, '24711034', 'Suri Juwita', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4836, '24711035', 'Yunidayani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4837, '24711040', 'ANGGUN NESA ADYATMA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4838, '24711043', 'CHELSY AGUS DIANA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4839, '24711044', 'DESTI WIDIA NINGRUM', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4840, '24711051', 'HELLEN VANISA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4841, '24711052', 'JANISA DARA AYUNDA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4842, '24711058', 'MUHAMAD INDRA DWI KISWARA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4843, '24711061', 'NUROHIM FITRIYONO', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4844, '24711067', 'SHANTYA SAFITRI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4845, '24711070', 'WAYAN ALLAN WIJAYA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4846, '24712003', 'Alyarsi Amwalian Anfus', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4847, '24712004', 'ANNISA FATWA YURINDA', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4848, '24712008', 'DIAN DESTIANA', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4849, '24712011', 'DWI RAHMAWATI', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4850, '24712014', 'MAULANA FAUZAN', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4851, '24712020', 'Yuki Elisabeth Hutabarat', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4852, '24713010', 'IZAH NASTURIAH', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4853, '24713011', 'Jaza Abdillah', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4854, '24713012', 'LINDA AGUSTINA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4855, '24713014', 'MARNI MARSELINA BR.SINAGA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4856, '24713017', 'MURIZKI', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4857, '24713018', 'NADIA SILVA DINATA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4858, '24713019', 'NAIZA MILDA SAFITRI', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4859, '24713020', 'NATASYA BR PURBA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4860, '24713026', 'RIKA HASTUTI', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4861, '24713027', 'RUSTIN RAMADON SAPUTRA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4862, '24713028', 'SATRIO SETIAWAN', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4863, '24714003', 'ANAS MARJUKI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4864, '24714004', 'ANGGRAINI SALSABILA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4865, '24714007', 'DEANTI IVANKA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4866, '24714009', 'DINDA CITRA AMELIA PUTRI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4867, '24714010', 'DWI RATNA SARI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4868, '24714013', 'HANIF WAHYU ALGHOZI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4869, '24714015', 'intan kurnia', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4870, '24714018', 'MIGUEL DEO SAPUTRA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4871, '24714020', 'MUHAMMAD KEVIN AKBAR PUTRA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4872, '24714023', 'PURWADI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4873, '24714024', 'RARA DWITA ANGRAINI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4874, '24714029', 'SYA\'DIYAH', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4875, '24714035', 'ADINDA ANGGRAENI LESTARI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4876, '24714040', 'CINDI APRILIANA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4877, '24714042', 'DHECA ERI CAHYANI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4878, '24714047', 'HERLIZA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4879, '24714048', 'INDRI FEBRIYANI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4880, '24714049', 'Istihana Nurhutanti', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4881, '24714055', 'NAULIA TRISNA PRATIWI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4882, '24714059', 'Rido kurniawan', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4883, '24714064', 'SYIFA RAHMADHANI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4884, '24721001', 'ADE PUTRI RAHMAWATI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4885, '24721005', 'DHIKA DHARMAWAN', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4886, '24721006', 'DIMAS LUMBANTORUAN', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4887, '24721007', 'DWI LESTARI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4888, '24721010', 'HABIB ALIM LAKSONO', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4889, '24721012', 'INDRA SAPUTRA', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4890, '24721023', 'WILKY GREY SANTONO SARAGIH', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4891, '24721026', 'ANDRE TAMPUBOLON', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4892, '24721034', 'HAZIZAH', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4893, '24721035', 'Imam Ackmal As Shodiq', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4894, '24721036', 'INTAN AULIA RAHMADANI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4895, '24721040', 'MUHAMMAD JOWNER MUKTIONO', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4896, '24721042', 'Okta Agusalim', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4897, '24721044', 'REALITA SILABAN', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4898, '24722008', 'Ari Aganta Sembiring', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4899, '24722017', 'INTAN REHMADIANA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4900, '24722019', 'LILIS WIDIAWATI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4901, '24722025', 'NOVI WIDIA SARI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4902, '24722027', 'REFITA SELVIA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4903, '24722028', 'Rindi Antika Sari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4904, '24722031', 'Tia devitri Anggraini', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4905, '24722034', 'ADES AHUN SIANIPAR', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4906, '24722035', 'AGRI MAUTA PUTRA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4907, '24722036', 'AHMAD LA\'ILLANA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4908, '24722038', 'ALFI MAULANA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4909, '24722044', 'DIENDRA CHIKO AFRESSA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4910, '24722046', 'FATMA WATI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4911, '24722047', 'FIQI FANIZAR', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4912, '24722050', 'IRSYAD PRATAMA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4913, '24722052', 'LIMPAT KARUNIA WIBOWO', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4914, '24722053', 'M. RHAMANDA HARRYZ AL HAKIM', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4915, '24722054', 'Maulid Rizki Setiawan', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4916, '24722057', 'NIDYA RATNA BARADA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4917, '24722059', 'RAHMA AULIA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4918, '24722063', 'SILVA RANISA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4919, '24722065', 'YENI TANIA DOLOKSARIBU', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4920, '24722067', 'ADI NISUR GINTING', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4921, '24722071', 'ALI FIRMANSYAH', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4922, '24722076', 'DESILA ARMAYANI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4923, '24722077', 'DIO RAHMADI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4924, '24722078', 'Fani Debora br Sidabalok', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4925, '24722079', 'Fauzyan Arzantya', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4926, '24722080', 'GALIH MARANATHA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4927, '24722084', 'LENI MARLINA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4928, '24722087', 'MEYLANI SRI WULANDARI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4929, '24722090', 'NINGRUM SAFITRI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4930, '24722098', 'YESIKA TIO LIA SILABAN', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4931, '24722101', 'A. SETIAWAN', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4932, '24722106', 'ARTIKA ANGELINA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4933, '24722111', 'FEBBI TRI OKTAFIANI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4934, '24722115', 'JOSA HERFANDA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4935, '24722121', 'NAZILA NAHU AIZA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4936, '24722126', 'SAPRIYANSAH', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4937, '24731006', 'APRIZAL MAULANA', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4938, '24731010', 'ERWIN GUTAWA SIAGIAN', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4939, '24731017', 'LESTARI DOLOKSARIBU', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4940, '24731023', 'MUHAMMAD RAFLI TIRTA ARDANA', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4941, '24732010', 'Dian Rahma Aliya', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4942, '24732012', 'ELVINA ARDIKA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4943, '24732015', 'KOMANG ANDESTA PURWANI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4944, '24732017', 'Marini Syaira Valda', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4945, '24732018', 'MAYA ADELIA WIRASTI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4946, '24732021', 'NABILA ROFI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4947, '24732026', 'REZA PRAMADHANI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4948, '24732028', 'Rohmatul Ghina', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4949, '24732030', 'TESALONIKA HASUGIAN', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4950, '24732034', 'AMELIA APRIANI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4951, '24732039', 'CLARISSA AZZAHRA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4952, '24732040', 'DEVI AYU WULANDARI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4953, '24732043', 'FAKKIA KHUSNUL HIDAYAH', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4954, '24732053', 'NAELI ERIKA JUFRIYAH', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4955, '24732054', 'NURUL AMANAH', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4956, '24732057', 'Ridho Panca Sanjaya', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4957, '24732060', 'SITI KHAIRIYAH DWIYANA PUTRI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4958, '24732062', 'ZALFA AZZURA PUTRI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4959, '24733025', 'OVI DWI SRI ANJANI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4960, '24733028', 'RIYA JULIYANTI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4961, '24733029', 'Rosinta Suci Handayani', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4962, '24733031', 'SHOFA DESMALIA PUTRI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4963, '24733032', 'SURADI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4964, '24733035', 'AMALIA HANDAYANI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4965, '24733043', 'DWI AYUNINGTIAS', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4966, '24733044', 'ELSA FATIKHA SARI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4967, '24733049', 'IPAN PEBRIANA', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4968, '24733055', 'NABILA NUR AULIA', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4969, '24733056', 'NAJHA BRILIAN CANNAVARO', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4970, '24733061', 'Risqia Asya Dewi', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4971, '24733065', 'SRI SALSABILA NATASYA TUMANGGER', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4972, '24741003', 'AMELIA BINTANG HANDIYAH', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4973, '24741004', 'ANDES ILHAM FERNANDO', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4974, '24741006', 'Arida Saputri', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4975, '24741009', 'CINDY SHERLYANA PUTRI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4976, '24741012', 'EZAR NAYAKA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4977, '24741016', 'JAGAT MUDA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4978, '24741017', 'Julia Nurul Aisah', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4979, '24741019', 'Mayyodi', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4980, '24741020', 'MUHAMAD RIZKI FAJAR SAPUTRA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4981, '24741022', 'Muhammad Toyib', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4982, '24741024', 'NUR MEISA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4983, '24741029', 'AGUNG TRI WICAKSONO', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4984, '24741032', 'ANDIKA PRATAMA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4985, '24741036', 'BELVA CARISSA VERDA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4986, '24741043', 'i putu denny pradnyana', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4987, '24741050', 'MUHAMAD YANSYAH PUTRA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4988, '24741051', 'NAYLA SALSABILA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4989, '24741052', 'NUR TRETIYANI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4990, '24741055', 'UMAR SAPUTRA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4991, '24741056', 'ZELMA MUSTARI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4992, '24741057', 'AHMAD HAIQI AL-MASYHARI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4993, '24741062', 'ARISKY FEBRYANTO', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4994, '24741068', 'FAHRUL ROSYID', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4995, '24741070', 'GALANG ANGGORO WIJAYA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4996, '24741074', 'Mangappu Tua Marbun', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4997, '24741075', 'MUHAMAD IQBAL NUR HOLIQ', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4998, '24741080', 'NURUL HASANAH', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(4999, '24741084', 'ZIDAN RADINAL KHUSNA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5000, '24742007', 'BISMA WAHYU PAMUNGKAS', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5001, '24742017', 'M. DEPRI NUR HIDAYAT', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5002, '24742021', 'NURITA DESILIANA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5003, '24742025', 'SASHA ADELIA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5004, '24742030', 'AHMAD RESTIAWAN', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5005, '24742056', 'AJI PALWAGUNA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5006, '24742059', 'ARLIN YUANITA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5007, '24742063', 'ELA NURUL HIDAYAH', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5008, '24742068', 'ITA MONIKA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5009, '24751002', 'AHMAT SONI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5010, '24751008', 'EKA ANGGRAINI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5011, '24751011', 'HABIBUL MULUK', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5012, '24751018', 'MUHAMMAD  RAHMAT ASSAUMI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5013, '24751021', 'NI WAYAN TRISYA CITRA WARDANI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5014, '24751026', 'ROMDONI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5015, '24751029', 'SITI ZAHROTUN NISA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5016, '24751031', 'VARIDATUL KHASANAH', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5017, '24751035', 'Aidil Aditia', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5018, '24751038', 'BELLINKA RIZKI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5019, '24751041', 'ELSA RAYUNDA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5020, '24751048', 'MANGARA PANE', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5021, '24751049', 'MARZAN KAPELO', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5022, '24751051', 'MUHAMMAD BAYU SAPUTRA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5023, '24751053', 'NATASYA AULIA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5024, '24751057', 'RAHMA YULIYANTI SAFITRI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5025, '24751059', 'RUSTIKA MEY BR TUMEANG', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5026, '24751062', 'SUCI FADHILAH RAHMAWATI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5027, '24751064', 'VIOLA ABSISKA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5028, '24751071', 'CAMELIA ANDARA MULYONO', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5029, '24751074', 'ENI OKTA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5030, '24751076', 'Friska Natalia Siregar', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5031, '24751079', 'Junika Astina', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5032, '24751093', 'SELLI SELVI PUTRIA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5033, '24751094', 'SILUH PUTU RINA PRAMITA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5034, '24751096', 'TESALONIKA LAURA KHATRIN KATILIK', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5035, '24751105', 'DINDA APRILYA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5036, '24751106', 'ERLANGGA INTAN PRAYOGA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5037, '24751117', 'Nabila rosaliza kirana', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5038, '24751120', 'NOVELINA PANGARIBUAN', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5039, '24751122', 'RETNO PALUPI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5040, '24751127', 'SUSI SUSANTI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5041, '24752009', 'DEA SABRINA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5042, '24752010', 'Desi Putri Auliya', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5043, '24752012', 'EKA MAULINA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5044, '24752013', 'FADILA AMELIA FEBRIYANTI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5045, '24752019', 'MARLINA DWI CAHYANI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5046, '24752022', 'NABILA SALSABILA NAHUWAY', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5047, '24752025', 'NI PUTU DEVI SUSILA WATI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5048, '24752030', 'SEPTA ADITTIYA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5049, '24752031', 'SINDI VAURA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5050, '24752038', 'ANANDA PUTRI AWALIA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5051, '24752039', 'ANI SETIYAWATI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5052, '24752042', 'CITRA AYU PANJAWI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5053, '24752048', 'HANDIKA SETIADI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5054, '24752052', 'M. PUTRA PRATAMA ISWANTO', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5055, '24752053', 'MARTHASATRY NOVALIA INDRATARA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5056, '24752058', 'NI KADEK BELLA KARLINA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5057, '24752059', 'NIRMA RISKIATI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5058, '24752062', 'RIYANDI TL TOBING', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5059, '24752071', 'AMELIA AL HASNAH', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5060, '24752076', 'Citra Ervanisa Putri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5061, '24752078', 'Devi Saptiyani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5062, '24752107', 'ANGELINA DESYANTI SURYAMAN', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5063, '24752114', 'EGI YULIA VAMARA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5064, '24752120', 'M. DWI SAPUTRA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5065, '24752136', 'ZAHRA KUSUMANINGRUM IRIAWAN', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5066, '24753007', 'Deswita Santa Monica', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5067, '24753008', 'DIRA APRIZA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5068, '24753012', 'I GEDE TONI ARDIYASA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5069, '24753014', 'LIDYA CAHYA BINTANG', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5070, '24753016', 'Marsanda Parasta', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5071, '24753017', 'MUHAMMAD AFDHAL ALGHAZALI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5072, '24753018', 'NABILAH NUR AZIZAH', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5073, '24753028', 'TRI GUSTIA RINI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5074, '24753031', 'ADELIA RAHMA FITRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5075, '24753034', 'ANTI AMARA PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5076, '24753037', 'DIAN NOVASARI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5077, '24753040', 'FIRDA HERLIANA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5078, '24753043', 'JUAN KRISTOPER SIHOMBING', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5079, '24753044', 'Linda Wati', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5080, '24753050', 'NIA AMELIA SUTRISNO', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5081, '24753052', 'PUTRI WULANDARI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5082, '24753053', 'RETI LUTHFI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5083, '24753055', 'Saffanah Afifah', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5084, '24753059', 'WINDA PUSPITA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5085, '24753061', 'ADRONI SANDIKA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5086, '24753063', 'AMELIA CAHYANI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5087, '24753071', 'HARUM RAHMAWATI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5088, '24753073', 'JURIA AZIZAH', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5089, '24753080', 'NUNTIARA SAFIRA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5090, '24753085', 'SENA AULIA PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5091, '24753087', 'SITI NURAINI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5092, '24753088', 'TUBRANI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5093, '24753089', 'Windy Mustifa Tumangger', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5094, '24753097', 'Dinda Aulia Rahmadani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5095, '24753100', 'GEMBIRA ERNAWATI SIHOMBING', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5096, '24753106', 'MELATI SUKMA MS', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5097, '24753108', 'NAJWA DIAN MAULINA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5098, '24753109', 'Neisha Agustine Girsang', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5099, '24753113', 'REVILLIA AZZAHRA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5100, '24753115', 'SEPTI MELANI PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5101, '24753116', 'SINTA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5102, '24754002', 'AHMAD QADLI ZAKA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5103, '24754007', 'AULIA JULIANA BAHRI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5104, '24754010', 'Desi Maya Sari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5105, '24754013', 'ELSA MIRANDA SARI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5106, '24754019', 'MARIA MELDIANA NAINGGOLAN', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5107, '24754020', 'MUHAMAD HANDYHARTONO', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5108, '24754021', 'MUTIA NURAIDA AZ ZAHRA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5109, '24754027', 'RAYHAN SESARIO', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5110, '24754032', 'SYINTIYA OKTAFIYA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5111, '24754033', 'UMMU SALMA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5112, '24754035', 'ZAHERATUS SAQDIAH', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5113, '24754036', 'ADELA MUTIA SAPUTRI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5114, '24754039', 'ALYA NANDINI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5115, '24754042', 'AULIA SANTIKA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5116, '24754044', 'CINTA AGUSTINA ANGGRAINI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5117, '24754045', 'DESY APRILIA PRAMITA SARI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5118, '24754054', 'Maulana Yusuf Ramadhan', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5119, '24754056', 'NADIA UTAMI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5120, '24754059', 'NURLAILA MAULIDYA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5121, '24754062', 'RENALDO HANDIKA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5122, '24754063', 'rossalinda puspita ningrum', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5123, '24754065', 'SINTIA PUTRI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5124, '24754068', 'VALENTINA MANURUNG', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5125, '24754072', 'AISYAH NURFADILAH', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5126, '24754073', 'ALFAREZA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5127, '24754074', 'ALYA WANDA PRATIWI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5128, '24754075', 'Andine Citra Lestari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5129, '24754077', 'AULIYA PRATIWI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5130, '24754079', 'Citta Cahya Fitria', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5131, '24754081', 'Dina Juliana', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5132, '24754082', 'Ellen puti Afrida', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5133, '24754083', 'EVELYN SECHA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5134, '24754085', 'Gwen Alliyah Paramita Trianto', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL);
INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(5135, '24754087', 'Hidayatul Atha', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5136, '24754088', 'LITA AGUSTINA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5137, '24754093', 'NOVIA RAHMAWATI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5138, '24754094', 'NURUL REFIAH', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5139, '24754097', 'RINANDA ELSAFANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5140, '24754100', 'SISKA APRILIANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5141, '24754101', 'SUSI IRA WATI DEWI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5142, '24754102', 'TRIKSI MELADIANTI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5143, '24754103', 'VIA MISRIANI UTAMI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5144, '24754104', 'YULI EFRIDA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5145, '24754107', 'AJENG GESTI VEBIOLA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5146, '24754109', 'AMANDA DITA SARI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5147, '24754110', 'Anes Ridho Refanda', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5148, '24754112', 'AULIYA RAHMA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5149, '24754115', 'Diana Hemalia Sari', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5150, '24754122', 'Ika Five Putri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5151, '24754128', 'NOVITA SURYA ELIYANSA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5152, '24754129', 'Octa Putri Ramadhani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5153, '24754130', 'RAFAEL HESEIKEL MANIK', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5154, '24754132', 'Riska Elviani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5155, '24754136', 'SUSI WULANDARI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5156, '24754137', 'ULE NAZWA KHAIRUNISA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5157, '24754138', 'VIDIA SULISTIAWATI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5158, '24754139', 'YUSHII BUDIARTI WARDHANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5159, '24755001', 'A REVANY NUGRAHA SESUNAN', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5160, '24755003', 'AMELIA PUTRI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5161, '24755008', 'DIAN MEGAWATI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5162, '24755014', 'JUNI ASTUTI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5163, '24755016', 'M. ZAIDAN RIFQI ANAS', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5164, '24755018', 'MUHAMMAD WAHIDIN', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5165, '24755021', 'NURFANYA RAMADHANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5166, '24755033', 'ASSYIFA SAHARA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5167, '24755037', 'DIAN OCTAVIANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5168, '24755046', 'Moch.Hidayat Nur Awaludin', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5169, '24755056', 'TRYA USWATUN HASANAH', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5170, '24755059', 'AMELIA DWI CAHYANINGRUM', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5171, '24755064', 'DEWI MAHARANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5172, '24755065', 'Evika Ermanda', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5173, '24755067', 'GILBERT BRILIAN IVANKA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5174, '24755068', 'HESTI DWIYANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5175, '24755069', 'INTAN DWI RAHMADANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5176, '24755075', 'NABILA ANISA GANDI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5177, '24755076', 'NADYA AFIFA RAHMA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5178, '24755082', 'SITI ROSANAH', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2024', 'skema 1', 'approved', NULL, NULL),
(5179, '24761003', 'ASTRI SEPTIA', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5180, '24761006', 'DEBORA DINAWATI SIHOTANG', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5181, '24761007', 'DIAN ANGGRAINI', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5182, '24761008', 'ERLINDA PUTRI KARTIKA', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5183, '24761010', 'FAJAR PEBRIYAN', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5184, '24761012', 'FRISKA EVELIENE', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5185, '24761016', 'Nanda Sisi Naena Agustina', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5186, '24762006', 'CINTIA YULINDRA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5187, '24762007', 'Deliya ariska', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5188, '24762011', 'ENNO DINA AMELIA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5189, '24762016', 'HASAEL MARGARETHA HUTAGALUNG', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5190, '24762017', 'I KETUT BUYUT SURATNATA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5191, '24762019', 'JHON HANAN SIPAKKAR', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5192, '24762022', 'LUKI AMINAH', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5193, '24762024', 'Marselina Tri Zahra', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5194, '24762025', 'NADINDA SITI ROSYIDAH', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5195, '24762029', 'RESA NURVIA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5196, '24762035', 'Selvia Wati', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5197, '24762040', 'ANGGITA MONALISA RITONGA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5198, '24762043', 'CRUISER YUDIKA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5199, '24762044', 'DESTILIA EKA PRATIWI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5200, '24762045', 'Dian Lestari', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5201, '24762046', 'DYA AYU LESTARI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5202, '24762051', 'HAFIDH ILHAM SYAHRI RAMADHAN', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5203, '24762056', 'JONAVA MARKETA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5204, '24762057', 'KIARA SALSABILLA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5205, '24762058', 'LAILA WARDATI RAHMA SEPTIANA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5206, '24762060', 'Muhammad Daffa Al Zaidan', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5207, '24762066', 'RESMA ANANTYA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5208, '24762067', 'Rihat Sinaga', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5209, '24762074', 'VINA RUSWARDANI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5210, '24763003', 'ALBERTO BREMA GINTING', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5211, '24763005', 'AMELIA NURUL FADILAH', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5212, '24763008', 'BAGAS DWI NOVIANTO', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5213, '24763013', 'EKI SUSANTI', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5214, '24763017', 'Ilham Kurniawan', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5215, '24763025', 'Reno Ardiansyah', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5216, '24763044', 'ELA FIBRIANY', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5217, '24763051', 'NADILA AULIA FITRI', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5218, '24763057', 'TIARA BUDI RAHAYU', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5219, '24763058', 'TITA ELENTIA', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2024', 'skema 1', 'approved', NULL, NULL),
(5220, '24771001', 'ADITYA TAUFIQ ALBAR', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5221, '24771002', 'AMMAR MUBAROK ROBBANI', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5222, '24771004', 'CERI HELENA OKTA', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5223, '24771005', 'Danar Marwansyah', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5224, '24771006', 'DAUD HAMONANGAN SIPAYUNG', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5225, '24771009', 'Fajr Thoriq Al-Farouq', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5226, '24771014', 'MUHAMAD ARPIAN', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5227, '24771023', 'Yolanda Br Purba', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5228, '24771024', 'YUNI SEFTILIA', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5229, '24772010', 'DOBY HARIYADI', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5230, '24772012', 'ERGI IRVANSYAH', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5231, '24772013', 'EROH JULIANTI DESTI', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5232, '24772014', 'FATIMAH RAMADANTI', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5233, '24772016', 'HAFID FITRA ABDILLAH', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5234, '24772022', 'Meida Pagayo', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5235, '24772025', 'MUHAMMAD GALIH SYAUQII APRIANTO', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5236, '24772029', 'Muhammad Satrio', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5237, '24772031', 'Nadia Aulia Putri', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5238, '24772036', 'RORO AYU MEIDA SURTI KANTI', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5239, '24772038', 'SITI FUJIAH', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5240, '24773002', 'AZWA VIRZINAYA AGUSTINA', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5241, '24773003', 'FIRMA OKTARIA', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5242, '24773006', 'SITI FITRI HANDAYANI', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5243, '24773007', 'Agil Faruq. A', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5244, '24773008', 'Susi Amelia Agustin', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5245, '24773009', 'KHAILA CANTIKA KHASALI', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2024', 'skema 1', 'approved', NULL, NULL),
(5246, '24781005', 'Bunga Putri Salsabilla', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5247, '24781006', 'DAFA ANGGARA YONATA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5248, '24781008', 'DONA VIRZA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5249, '24781013', 'Jesfitrina Sihombing', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5250, '24781014', 'LIA AGUSTINA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5251, '24781015', 'M. RAYHAN ZULKARNAIN', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5252, '24781023', 'RIFKI RANGGA SAPUTRA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5253, '24781026', 'SEPTI CAHYANINGTIAS', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5254, '24781027', 'SOFI RAMADHANI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5255, '24781033', 'AIDIL YOSEF', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5256, '24781038', 'DESTY ANGELINA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5257, '24781039', 'Egi Rivaldi', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5258, '24781042', 'FRANS YUDA RIZKI PRAMUDYA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5259, '24781043', 'ILHAM KURNIAWAN RIZKI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5260, '24781048', 'Nabila Rizky Ilahi', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5261, '24781049', 'NAIFAH AINI ZAHRA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5262, '24781050', 'NOFIDYANDRA SITORUS', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5263, '24781051', 'ORLEAN WONKLY KHATULISTIWA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5264, '24781053', 'REZA FAHMI ALKHAMDANI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5265, '24781057', 'SHAKINAH ZULAYNI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5266, '24781058', 'SRI PANENTI VIDITONA LUBIS', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5267, '24781060', 'UMI KHOIRULLATIFAH', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5268, '24781066', 'AZ ZAHRA JUAS DINDA DINATA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5269, '24781069', 'Devnis Arga Vanis Setiawan', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5270, '24781070', 'eka nursani', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5271, '24781082', 'PUTRI SARI RIZKIYAH', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5272, '24781088', 'Shofiyyah Nabila Putri', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5273, '24781095', 'Atha Talitha Nabil', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5274, '24781102', 'FIQA KHAIRUNISA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5275, '24781103', 'GOVIN GAUTAMA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5276, '24781104', 'jeni amanda', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5277, '24781106', 'M.HAIDIR SEPTIAN', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5278, '24781113', 'refha ardinata m.noer', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5279, '24781116', 'Sarifah Elizabeth Simamora', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5280, '24781117', 'Silvia Nanda Agustin', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5281, '24781120', 'Yayuk Febriat Praba', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5282, '24782001', 'AAN KRISNAWATI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5283, '24782009', 'FADHILA AZLIANA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5284, '24782023', 'Nagita Aulia', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5285, '24782033', 'YUSUF FERDI RYANDI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5286, '24782046', 'Johannes Hutapea', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5287, '24782058', 'NURUL BAETI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5288, '24782059', 'PUTU RADIT ARDIKA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5289, '24782062', 'RIZKY BINTANG FADILLAH', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5290, '24782064', 'SYIFA AMALIA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5291, '24782065', 'YULIA ROSLINA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5292, '24782066', 'ZINNUR RAHMAT', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5293, '24782072', 'DEFI MIGIA PUTRI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5294, '24782076', 'IKROM SAFEI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5295, '24782090', 'Okta Erlisa', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5296, '24782094', 'ROBBY ALLAILY', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5297, '24783016', 'M. RIFAN ADI SAPUTRA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5298, '24783025', 'OKTA TRI RAHMADANI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5299, '24783029', 'RENHAT DENIL RAMADHAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5300, '24783041', 'BULAN OKA NAZARA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5301, '24783075', 'DEDE APRIZAL', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5302, '24783079', 'HENDI FIRMANSAH', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5303, '24783085', 'MARSHAL FRANS FAITH WOLF', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5304, '24783087', 'MUHAMMAD FAHRY ARIEF BILLAH', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5305, '24783088', 'MUHAMMAD KELVIN AZZUFAR', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5306, '24783092', 'NOVA ADE IRMA LESTARI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5307, '24783093', 'OKTAVIANA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5308, '24783095', 'RAFLES ARFATORA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5309, '24783101', 'WATI PUSPITA SARI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5310, '24783115', 'JUAN SBASTIAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5311, '24783116', 'M DIKA PUTRA PRATAMA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5312, '24783126', 'Nurhayati', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5313, '24783135', 'WENDA RESTIANA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5314, '24784001', 'ABDUL GADIR', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5315, '24784003', 'ADELINA MIRANDA NABABAN', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5316, '24784004', 'Aknisa Alqibetia Sari', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5317, '24784006', 'ANNISA NEDIA AMAROBIT TAQWA', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5318, '24784011', 'FERDI DINATA FIANTAMA', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5319, '24784013', 'INTAN KOMALA SARI', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5320, '24784018', 'MARTIN LOVA TAMA', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5321, '24784041', 'Fatkhan Kausar', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5322, '24784056', 'RENALDI PRATAMA', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5323, '24784059', 'RIZKA WINATA', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2024', 'skema 1', 'approved', NULL, NULL),
(5324, '25711002', 'AGATSA DANAR SAPUTRA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5325, '25711006', 'DARMAWAN', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5326, '25711007', 'Despa Yulistia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5327, '25711011', 'FUTSALIA PUTRI SANI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5328, '25711016', 'MIA UTAMA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5329, '25711019', 'NOVERI ADITYA FERNANDEZ', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5330, '25711029', 'ALIYA SAFFANAH RAHMADANTI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5331, '25711031', 'BELA NOVETA WATI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5332, '25711032', 'Debora Lumaris Naipospos', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5333, '25711035', 'FAJAR NURRUSMAWATI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5334, '25711038', 'Helena Faustina', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5335, '25711039', 'Indah Anjani', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5336, '25711040', 'Jihan Azzahidah', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5337, '25711044', 'MUHAMMAD NUR FARIS HAIDAR', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5338, '25711047', 'Riski Desma Putri', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5339, '25711050', 'VERONIKA PERTAMA SARI', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5340, '25711052', 'Zalika Dara Alfaridji', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5341, '25711058', 'Dela Oktavia', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5342, '25711064', 'Ibrahim Abdurrahman', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5343, '25711065', 'INTAN OKTAVIA', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5344, '25711074', 'Sarah Kristina Simangunsong', 'D4 Teknologi Produksi Tanaman Pangan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5345, '25712002', 'AHMAD RAMADHAN', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5346, '25712009', 'ELSA ADELIA', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5347, '25712010', 'EVA RAHMAWATI', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5348, '25712011', 'FADIL MAHREZZA', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5349, '25712012', 'IKE LISTIYANI', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5350, '25712014', 'Luqman Nur Hakim', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5351, '25712017', 'RAHMA NITA ARIANTI', 'D3 Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5352, '25713001', 'ANDRE ISMAR SENIOSA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5353, '25713015', 'Ivan Lubis', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5354, '25713016', 'MAHARANI ZAHRA JULIANA ZULFA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5355, '25713021', 'PITRI YANI', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5356, '25713022', 'Shofia Ayu Azizah', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5357, '25713023', 'VIGO NUSANTARA', 'D4 Teknologi Perbenihan', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5358, '25714002', 'ALYA DWI CAHYANING ARUM', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5359, '25714005', 'CHELSEA ABELIA VICTOR', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5360, '25714006', 'Cristin Angelina Samosir', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5361, '25714008', 'DWI ARYADI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5362, '25714016', 'Mila Salwa', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5363, '25714017', 'MUHAMMAD ARIL STIVEN', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5364, '25714019', 'NASWA AYU PRAMESELLA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5365, '25714023', 'REVI FELISHA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5366, '25714025', 'Rizky Saputra', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5367, '25714027', 'SALWA NAISYA PUTRI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5368, '25714036', 'DINDA HAFIDZAH', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5369, '25714037', 'DZULKARNAIN MAKDUNI', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5370, '25714039', 'Freshsyla Maharani Putri', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5371, '25714044', 'Melani Salsabila', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5372, '25714048', 'NUR AZIZAH', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5373, '25714051', 'Regina Siburian', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5374, '25714053', 'RISKYA MAULIDDINA', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5375, '25714056', 'Safira Ramadani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5376, '25714057', 'Sayu Putu Vina Handayani', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5377, '25714062', 'DICKY FEBRIAN', 'D4 Teknologi Produksi Tanaman Hortikultura', 'JURUSAN BUDIDAYA TANAMAN PANGAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5378, '25721006', 'ANGGUN PURNAMASARI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5379, '25721011', 'DIMAS SURYO RAHARJO', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5380, '25721019', 'JOHAN SAPUTRA', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5381, '25721020', 'KIKI RAHMADANI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5382, '25721022', 'MARIFATUL KHASMA KUSNIAH', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5383, '25721024', 'Noval Nur Diansyah', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5384, '25721025', 'pasha olanda', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5385, '25721029', 'RIVKA LOIDI HUTABARAT', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5386, '25721034', 'YABES PANGARIBUAN', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5387, '25721035', 'ZAHRA JULIANA FADHILA', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5388, '25721039', 'AFIFAH NUR JANNAH', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5389, '25721041', 'ANGGA CAHYO PRAYOGA', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5390, '25721042', 'ANINDA SAPUTRI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5391, '25721043', 'Astrid Mutia Rahmadani', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5392, '25721047', 'DONI ISWANTO', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5393, '25721051', 'Fika Maharani Ramadhon', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5394, '25721054', 'Intan Nur\'aini', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5395, '25721057', 'MARATU SHOLEHATI', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5396, '25721060', 'Paola Destiny Lumban Gaol', 'D3 Produksi Tanaman Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5397, '25722002', 'Aditya Ramdhani', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5398, '25722005', 'ANDHIKA RAFFA FEBRINNO', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5399, '25722017', 'M. Fahmi', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5400, '25722018', 'Marshel Triandika', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5401, '25722022', 'MUSTIKA PUTRI AMELIA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5402, '25722025', 'Ratih Hapsari', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5403, '25722026', 'REVA CANDAR WINATA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5404, '25722031', 'VAREL PRATAMA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5405, '25722034', 'AILA AJURA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5406, '25722040', 'DINA AZWATI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5407, '25722041', 'EGO REVALDO TUAHTA SEMBIRING', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5408, '25722044', 'FRANSISKUS XAVERIUS TRI WISNU DESTANTO', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5409, '25722054', 'PUTRI MARIYANA SARI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5410, '25722058', 'RIZKY MUNANDAR', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5411, '25722063', 'ABY PRATAMA PUTRA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5412, '25722068', 'Arda Putra Maulana Nababan', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5413, '25722070', 'Dela Safira', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5414, '25722072', 'EKA PUTRI RAMADHANI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5415, '25722074', 'FEBRI RAJAWALI PAMUNGKAS', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5416, '25722077', 'Juni Elizabeth Pasaribu', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5417, '25722081', 'MUHAMMAD ARI PRATAMA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5418, '25722083', 'MUHRIFKI SYAIFAN', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5419, '25722088', 'RIDO ADITIA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5420, '25722089', 'RONI HIDAYAT', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5421, '25722091', 'SYARIFUDIN AFRIANSYAH', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5422, '25722093', 'Victor Jaya Simanjuntak', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5423, '25722099', 'ARIPUDDIN SIREGAR', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5424, '25722103', 'ELIZA NENI FAUZIAH', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5425, '25722118', 'REGI ADICHA PUTRA JAYA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5426, '25722121', 'Semi Suprapti', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5427, '25722127', 'ALDIANSYAH MAULANA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5428, '25722129', 'APRILIAN ANGGIT SAVIRA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5429, '25722133', 'Dzaky Raditya Ahmad', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5430, '25722134', 'EMILIA HANI APRILIANA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5431, '25722137', 'ICHA NENDEN WINESTI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5432, '25722139', 'KARTA WINATA SITANGGANG', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5433, '25722141', 'MA\'RIFATUL JANAH', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5434, '25722145', 'MULYADI MANDROFA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5435, '25722150', 'RISKA TRI SAPUTRA', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5436, '25722153', 'TEDIY ANANTO', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5437, '25722156', 'M. RISKI EFENDI', 'D4 Produksi dan Manajemen Industri Perkebunan', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5438, '25723007', 'Fiter Rohman Permana', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5439, '25723009', 'HIJRAL MUTTAQIN', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5440, '25723010', 'IRMANSYAH', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5441, '25723013', 'Mutiara Andriani', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5442, '25723019', 'Riski Wahyu Pratama', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5443, '25723020', 'Rizani Chelcilia Putri', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5444, '25723021', 'SAYYIDAH ULIL FADHILAH ALY', 'D4 Pengelolaan Perkebunan Kopi', 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5445, '25731003', 'ARDIANSYAH PUTRA AL AZIZI', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5446, '25731005', 'BINSAR TIMOTIUS L. TOBING', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5447, '25731013', 'irma natasya br barus', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5448, '25731016', 'Muhammad Zainal Alim', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5449, '25731021', 'RIO YUNUS SILITONGA', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5450, '25731043', 'ridwan halim', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5451, '25731044', 'Ririn A. C Siburian', 'D3 Mekanisasi Pertanian', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5452, '25732001', 'ABELIA MARGARETA LOVA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5453, '25732008', 'EVA LAILA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5454, '25732009', 'GABRIELLA LUCIANA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5455, '25732016', 'NI WAYAN DIAN DESVITA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5456, '25732017', 'PUTRI FEBRIANTI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5457, '25732025', 'Trivena M. Aprilia Sinaga', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5458, '25732027', 'Zhaskia Adiva Afridho', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5459, '25732034', 'Dyaningrum Sisca Putri', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5460, '25732037', 'Jesyka Rahmadani', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5461, '25732038', 'LILIAN ZALIYANTI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5462, '25732040', 'MEUTIA WINDAYANI SYAHTRI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5463, '25732041', 'MUTIA JULINDA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5464, '25732043', 'NURUL ZUHRIA ERVANI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5465, '25732047', 'Roma Ramayana Silitonga', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5466, '25732052', 'TUBAGUS RANGGA JATI', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5467, '25732054', 'Amelia Br. Siringo Ringo', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL);
INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(5468, '25732079', 'ZASKIA VEGA AULIA', 'D3 Teknologi Pangan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5469, '25733002', 'Ade Zovi Hidayat', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5470, '25733007', 'ARMAN', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5471, '25733010', 'HELYA MEI BANUREA', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5472, '25733013', 'ISMI AZIZAH', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5473, '25733024', 'OKTA MUTIARA', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5474, '25733028', 'Ririn Dwi Septiana', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5475, '25733032', 'SOFIYA NABILA', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5476, '25733035', 'Zainal Arif Julistian', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5477, '25733037', 'Afita Fina Fatmasari', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5478, '25733041', 'Ardiansyah Saputra', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5479, '25733044', 'HAYA AZ ZAHWAH', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5480, '25733053', 'Merlinda Fitri', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5481, '25733057', 'NAZELA RAMADHANI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5482, '25733059', 'PRIYA FATIMAH ANDAYANI', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5483, '25733060', 'Rani Dwi Yuliani', 'D4 Pengembangan Produk Agroindustri', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5484, '25735002', 'ALMIRA CALISTA DEVIYANA', 'D4 Kimia Terapan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5485, '25735008', 'Febbi Andini', 'D4 Kimia Terapan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5486, '25735015', 'Nurul Azzahra', 'D4 Kimia Terapan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5487, '25735017', 'Rizka Julinar', 'D4 Kimia Terapan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5488, '25735021', 'Zaskia Fitri Ramadani', 'D4 Kimia Terapan', 'JURUSAN TEKNOLOGI PERTANIAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5489, '25741001', 'A. WILDAN DANI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5490, '25741008', 'BUNGA PUJI RACHMADANI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5491, '25741009', 'DAME ERWINNA MANIK', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5492, '25741027', 'Rangga Pratama', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5493, '25741032', 'SUTEDI INDRIYANTO', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5494, '25741036', 'Ahmad Maedani Rais', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5495, '25741039', 'ARJUAN YANUWAR', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5496, '25741044', 'DIRGA SAPUTRA PRATAMA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5497, '25741053', 'Marsel', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5498, '25741062', 'RIWAL DONI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5499, '25741064', 'SEPTA ARYA RAMADHAN', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5500, '25741065', 'SYAHRIAN', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5501, '25741073', 'BELLA PUJI FITRIANI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5502, '25741075', 'Dava Septian', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5503, '25741078', 'ERISA MULYADI', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5504, '25741081', 'GHALIF LAMSO AFRIZAL', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5505, '25741095', 'Rizka Arianti', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5506, '25741104', 'Arbaul Fauzi', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5507, '25741111', 'ERLITA WIDIANTIKA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5508, '25741117', 'JELYWANA PANDIANGAN', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5509, '25741130', 'SURYA PRATAMA', 'D4 Agribisnis Peternakan', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5510, '25742005', 'ALIF RIVALDO SEMBIRING', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5511, '25742008', 'BAGAS DWIKI RIANTO', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5512, '25742011', 'EXSEL MALANDO', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5513, '25742013', 'FITRAH LEGOWO', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5514, '25742015', 'I Gede Desma Yoga', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5515, '25742018', 'MIARDI ASRONI', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5516, '25742028', 'Ubay Dillah', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5517, '25742029', 'ZAHARA Y PUTRI', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5518, '25742036', 'Arpin Aditiya', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5519, '25742039', 'DAVA DHELSEN ANDESTIN', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5520, '25742042', 'FEBI RAHMA RAMADHAN', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5521, '25742045', 'IKMAL NURIQMAR SYAUQAS', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5522, '25742046', 'M. ANDRE WIDJAYA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5523, '25742047', 'MARCELLINO TEGUH WIDIANTO', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5524, '25742055', 'RIDHO BIMA SAKTI', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5525, '25742059', 'ZAKI AKBAR', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5526, '25742062', 'AHMAD AZIZ HS', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5527, '25742066', 'AURIEL FAHRI GUSTAFA', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5528, '25742080', 'NELI ISNAINI', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5529, '25742085', 'SEPTO NUR HIDAYAT', 'D4 Teknologi Produksi Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5530, '25743019', 'Raihan Ramadani', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5531, '25743023', 'SELA ZULFANIA', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5532, '25743024', 'Trisno Darmawan Sitorus', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5533, '25743026', 'Arip Burhan Pani', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5534, '25743031', 'FADILAH ASMAULKHUSNA', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5535, '25743038', 'NABILA LIL NASYA', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5536, '25743043', 'REALITA SHABRINA KHAIRIL HAKIM', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5537, '25743044', 'Rexsin Ardiyansyah', 'D4 Teknologi Pakan Ternak', 'JURUSAN PETERNAKAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5538, '25751010', 'Enggal Lestari Putri', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5539, '25751011', 'FERRA PERISKA SHARI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5540, '25751014', 'INNEKE CHANDRA WATI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5541, '25751017', 'LAILI YANI AS', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5542, '25751020', 'MIYA AGUSTINA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5543, '25751023', 'NADIA ALDINA PUTRI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5544, '25751032', 'VERLITA KRISTIN SINAGA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5545, '25751041', 'Defy Syafitri Br Sitorus', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5546, '25751042', 'elisa dea putri', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5547, '25751043', 'ENJELITA PRECILIA GANEPA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5548, '25751046', 'HERLINDA SARI SINAGA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5549, '25751048', 'Istika Dwi Kurnia', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5550, '25751051', 'M ILHAM SUPRIADI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5551, '25751052', 'Mega Selfiana', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5552, '25751056', 'NADIN CINTYA PUTRI RAMADHANI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5553, '25751058', 'Nurfadila Permatasari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5554, '25751061', 'SAHRONI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5555, '25751062', 'Sekar Lita Sepriantari', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5556, '25751063', 'SITI ADIRA KANIA G.S.', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5557, '25751068', 'ALDINO RIVALDI FEBRIAN', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5558, '25751072', 'Cici Dwi Hidayat', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5559, '25751074', 'DELA AYU', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5560, '25751080', 'INTANIA NATACHA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5561, '25751082', 'KHOIRU FAHRIZAL', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5562, '25751083', 'LIDIYA SALWA KHOIRIA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5563, '25751084', 'MAIA ASHA AZ ZAHRA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5564, '25751085', 'Meitisa', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5565, '25751088', 'MUHAMMAD ROMATULLA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5566, '25751091', 'OKTO VITER ARFANIUS SAPUTRA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5567, '25751094', 'SALMA NITI RIZQI FADILLAH', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5568, '25751096', 'Soypi Kurniawan', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5569, '25751101', 'ALIA NUR HIDAYAH', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5570, '25751105', 'CICI MEILIAWATI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5571, '25751109', 'FADIL ARDIANSAH', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5572, '25751112', 'INDI DANIATI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5573, '25751121', 'NABILA FITRIA WATI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5574, '25751124', 'PINA PANDU WINATA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5575, '25751127', 'SALSABILA NURLITA', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5576, '25751131', 'Zahara Ramadani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5577, '25751133', 'Andri Kurniawan', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5578, '25751142', 'Frisca Efriani', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5579, '25751144', 'INDRY HERMANDA PUTRI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5580, '25751146', 'KARINA PERMATA SARI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5581, '25751147', 'KUSHAI', 'D4 Pengelolaan Agribisnis', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5582, '25752005', 'Apriliana Aulia Rizqi', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5583, '25752008', 'Chelsy Virginia Marcella', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5584, '25752011', 'Diah Putri Saharani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5585, '25752018', 'LUNA MAYLANI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5586, '25752020', 'MELLIZA EVILITA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5587, '25752023', 'Nabila Salsabila', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5588, '25752024', 'Nisa Dwi Ramadhani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5589, '25752026', 'PUTRI TRISNAWATI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5590, '25752028', 'REA CHULWA OKTAMAYA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5591, '25752046', 'FERDITA TALENTA BARUS', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5592, '25752053', 'Melva Dwi Syahrani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5593, '25752055', 'NADIA NAFFISA SYARIF', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5594, '25752056', 'Nov Rindi Ronauli Hasugian', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5595, '25752059', 'RAMA ARDIANSYAH', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5596, '25752061', 'REFI DESTIANA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5597, '25752063', 'SASA OKTARINA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5598, '25752064', 'SINDY KUMALA SARI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5599, '25752072', 'Azahra Naura Dania', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5600, '25752074', 'DAFFA ABDI FADHL', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5601, '25752076', 'DIANA MARETHA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5602, '25752080', 'Ika Fitriani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5603, '25752084', 'M. SYUJA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5604, '25752086', 'MUHAMAD BILAL', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5605, '25752089', 'NUR EVA YANTI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5606, '25752095', 'Seruni', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5607, '25752099', 'Zahrah Putri Ramadhani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5608, '25752100', 'Aditya Bagas Prayoga', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5609, '25752102', 'ANISA FAUZIAH', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5610, '25752106', 'Bunga Erliana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5611, '25752108', 'Della Kirana Putri', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5612, '25752114', 'Ketut Lisna Pratika', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5613, '25752116', 'Lilis', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5614, '25752120', 'MUTIA ANDRIANI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5615, '25752122', 'NUR MUKHAMAD FAHREZA ARBI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5616, '25752123', 'PUTRI NABILA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5617, '25752127', 'Roni Uli Sidabutar', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5618, '25752131', 'ZARKA SALSABILA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5619, '25752132', 'AGUNG SATRIA PERMANA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5620, '25752133', 'AMALIA ARRAHIM', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5621, '25752138', 'CATERINA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5622, '25752145', 'JESIKA DESTASARI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5623, '25752150', 'Missel Keisya Suci Ramadhita', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5624, '25752152', 'Nabila Aulia Rahmadani', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5625, '25752153', 'NI PUTU DEVI ANJANI', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5626, '25752155', 'PUTRI SIMAMORA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5627, '25752156', 'RAHEL AMONITA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5628, '25752157', 'RAPIO SITUMORANG', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5629, '25752158', 'Riana', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5630, '25752159', 'SABSA AULIA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5631, '25752161', 'SUGANDA', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5632, '25752163', 'ZELIYA JORAN', 'D4 Akuntansi Bisnis Digital', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5633, '25753001', 'Abel Naila Yuniza', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5634, '25753002', 'AFIKA RAMADANI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5635, '25753004', 'Alvia Zahra Ramadani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5636, '25753006', 'Artika Maulid Dyana Umar', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5637, '25753007', 'Bagus Saputra', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5638, '25753010', 'DEWI AYU PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5639, '25753013', 'Flodya Agrifa Br Ginting', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5640, '25753015', 'INTAN NOVELA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5641, '25753016', 'KAMILATUZ ZAHRA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5642, '25753019', 'MELI ERLINA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5643, '25753021', 'NADINE OLIVIA CANDRA PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5644, '25753025', 'RISKA OKTAVIA RAMADHANI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5645, '25753032', 'YEHEZKIEL PEBRIAN SITORUS', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5646, '25753033', 'ZELPIYA JORAN', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5647, '25753039', 'ASYIFA AULIA PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5648, '25753041', 'CAHCA OKTA KIRANA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5649, '25753042', 'DANNA ISWARA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5650, '25753045', 'FANINA AL KAILA PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5651, '25753046', 'FRISYA ELFALIKA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5652, '25753047', 'HERDA ADESTRIA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5653, '25753049', 'Karin Losa Thania', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5654, '25753050', 'LULU WULANDARI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5655, '25753051', 'MADE WIDYA APRIYATI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5656, '25753054', 'PAULA LISMINA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5657, '25753059', 'SALFA FAUZIAH', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5658, '25753063', 'USWATUN HASANAH', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5659, '25753066', 'Zipora Agus Revellah Silaban', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5660, '25753078', 'Esra Sinaga', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5661, '25753082', 'JOKI PURBA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5662, '25753083', 'KHAIRANI TANJUNG', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5663, '25753084', 'M. Rehan Alma arif', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5664, '25753089', 'RAHMA DESWITA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5665, '25753090', 'Rindu Tarusia Habibah', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5666, '25753097', 'Wahyuni Lestari', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5667, '25753101', 'AHMAD HIDAYAT', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5668, '25753107', 'CIKE LIDIA KIRANI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5669, '25753108', 'DEVI INDRIYANI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5670, '25753119', 'Nengsi Giopani Pasaribu', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5671, '25753120', 'Qannetha Nindy Elsya K', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5672, '25753124', 'Sekar Ayu Kusuma Wardani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5673, '25753126', 'SITI NAISA HABSARI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5674, '25753127', 'TEGAR SEFI AL FATIH', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5675, '25753130', 'ZAHROTUS SHITA', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5676, '25753140', 'Eleksa Ayu R. Sinaga', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5677, '25753145', 'KAIT LANA RANTIKA PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5678, '25753149', 'NADIA PUTRI DWIYANTI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5679, '25753153', 'Riska Mulya', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5680, '25753156', 'SIGIT NUR MALIK', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5681, '25753157', 'SOVIA DIAN PUTRI', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5682, '25753160', 'Wulan Suci Rahmadani', 'D4 Agribisnis Pangan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5683, '25754002', 'Adinda Triyani', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5684, '25754005', 'ANGELIKA DESSY SETIANINGRUM', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5685, '25754015', 'HIKMAH RAHMADHANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5686, '25754016', 'JHIRA NERAZURRE', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5687, '25754023', 'Nova Rianti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5688, '25754027', 'REVA APRIYANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5689, '25754033', 'YULI YANTI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5690, '25754040', 'Azzahra Radhitya', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5691, '25754041', 'CHANTIKA MAULANI SAPUTRI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5692, '25754042', 'Cikal Vinsky Yunanta', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5693, '25754043', 'DEA AYU PRATIWI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5694, '25754050', 'Laura Deza Fajriah', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5695, '25754051', 'MARCHA YOLA AULIA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5696, '25754057', 'PARIDA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5697, '25754063', 'Sheloka Langit Bening', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5698, '25754065', 'TARIMA TIARANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5699, '25754067', 'ADELIA MALFINA RAMADANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5700, '25754068', 'Aghes Aprillia Fikri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5701, '25754071', 'Anggun Novianti', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5702, '25754076', 'Debora Crachella Marbun', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5703, '25754079', 'FLORENCY ANGEL SINAGA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5704, '25754084', 'Maria Verina Meisy Evelin', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5705, '25754087', 'NATASYA SELINA FIRDAUS TAHAR', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5706, '25754088', 'NESSA WIJAYANTI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5707, '25754090', 'PUTRA HADITAMA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5708, '25754091', 'RAHMA SUGIMIN', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5709, '25754101', 'ALMA YETI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5710, '25754104', 'ARTIZA CLARA LAURA RAVISTA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5711, '25754108', 'DIAN SARY NISSY SITUMORANG', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5712, '25754109', 'FACHRIE MAULANA HAMID', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5713, '25754113', 'JEPI YOLA ULFA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5714, '25754117', 'Muhammad Ainun Najib', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5715, '25754119', 'NAYLA ADYA RAMADANI KUSWAN', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5716, '25754127', 'SENDY SIREGAR', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5717, '25754131', 'Adi Putra', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5718, '25754133', 'Amanda Ellianti Putri', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5719, '25754136', 'AULIA RIZKA IRFANTI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5720, '25754138', 'Chintya Laura', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5721, '25754139', 'DAWAM HABIBI ALHASANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5722, '25754141', 'FAIZYA ARASWARY', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5723, '25754144', 'HESTI DAMAYANTI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5724, '25754153', 'OKTAVIANA RAHMADANI', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5725, '25754154', 'PUTRI ROMADONA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5726, '25754157', 'RINI AGUSTIN', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5727, '25754160', 'SITI AMELIA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5728, '25754161', 'SYIFA SALSABILLA', 'D4 Akuntansi Perpajakan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5729, '25755001', 'ADRIUS TIMOTI HUTAGALUNG', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5730, '25755003', 'Alinda Rahmadini', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5731, '25755006', 'DHEA AUFAH ATIQAH', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5732, '25755009', 'FERA SELVIA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5733, '25755010', 'Grace Yela Sinambela', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5734, '25755011', 'IMELDA ATIKA BELLA BORU HITE', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5735, '25755012', 'KALISTA MEGAWATI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5736, '25755017', 'NOVA ERPINA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5737, '25755020', 'PUTU WIDIYANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5738, '25755023', 'Rizki Septian Ramadan', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5739, '25755029', 'TRI FEBRIYANDAMA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5740, '25755030', 'VIKA MAWARIDATUSSOFIAH', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5741, '25755032', 'Ahmad Reza Afandi', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5742, '25755034', 'ALYA PUTRI NADIRA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5743, '25755035', 'ANDHIKA MASYHUR JOHANIS', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5744, '25755037', 'Dhea Sandrina', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5745, '25755038', 'Dina Amelia Butar-Butar', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5746, '25755046', 'Muhammad Rassya Yudi Saputra', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5747, '25755049', 'OKTAVIA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5748, '25755052', 'RATANJA ARLEGA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5749, '25755057', 'SINTA DWI PRIYATNA KUSUMA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5750, '25755061', 'WAFIQ AZIZAH', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5751, '25755068', 'DIA SAFITRI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5752, '25755074', 'KENY ADE DWI SELA', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5753, '25755077', 'NATIA RAMADANI', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5754, '25755078', 'Nikita Sinta Bela', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5755, '25755087', 'Sindi Maulida', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5756, '25755088', 'SITI MUNTAMAH', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5757, '25755090', 'Tika Sri Wahyuni', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5758, '25755091', 'VANNISA AZZAHRA ARIFIN', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5759, '25755092', 'WITA YANA SITORUS', 'D3 Perjalanan Wisata', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5760, '25756006', 'ANISA OKTAVIA RAMADHANI', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5761, '25756010', 'Cinta Kamelia Putri Munthe', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5762, '25756011', 'Daniel Abieza', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5763, '25756013', 'Dona Kharisma', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5764, '25756014', 'Florentinus Yudi Prastowo', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5765, '25756019', 'Muhammad Rava Fadillah', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5766, '25756021', 'NADILA NUR AZIZA', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5767, '25756024', 'RAKAN THORIQ MU\'AFA', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5768, '25756034', 'YOLA SEPTIANA PUTRI', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5769, '25756040', 'Anggi Laowo', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5770, '25756041', 'ANNISA RAMADANI', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5771, '25756044', 'Bela Riyana', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5772, '25756045', 'CITRA CINTA PASYA', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5773, '25756047', 'Dimas Prasetio', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5774, '25756058', 'PUTRI YANA RISMAWATI', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5775, '25756060', 'Restu Azi Nugraha', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5776, '25756061', 'RIDWAN SUSANTO', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5777, '25756063', 'SALSABILA NOVA KIRANA', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5778, '25756066', 'SITI JIMANINGSIH', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5779, '25756067', 'Tri Aisyah Hidayati', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5780, '25756069', 'YOUVANA DEVI FEBRIAN', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5781, '25756072', 'AISIA BALQIS', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5782, '25756074', 'Anggi Saputra', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5783, '25756083', 'Herayuni Wulandari', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5784, '25756098', 'SELVI CANIA', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5785, '25756106', 'ALDI ROMA DIANSYAH', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5786, '25756111', 'Azza Ardino Mardiana', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5787, '25756112', 'CHANTIKA NIATI', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5788, '25756119', 'M RISKI', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5789, '25756130', 'SAFINATUN NAJAH', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5790, '25756132', 'SELVI RAMADHANY', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5791, '25756135', 'Vendra Vernando', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5792, '25756139', 'Jelita Putri Mardiana', 'D4 Pengelolaan Perhotelan', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5793, '25757003', 'INTAN SAPUTRI', 'D4 Pengelolaan Konvensi dan Acara', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5794, '25757010', 'NILUWIH SUGESTI', 'D4 Pengelolaan Konvensi dan Acara', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5795, '25757011', 'Novi Anggriani', 'D4 Pengelolaan Konvensi dan Acara', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5796, '25757013', 'RANTY MERLYANA PUTRI', 'D4 Pengelolaan Konvensi dan Acara', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5797, '25758004', 'Alisa', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5798, '25758005', 'ANGGI KURNIAWAN', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5799, '25758007', 'Bimo Aji Prasetyo', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5800, '25758022', 'MUHAMMAD SYAHRUL ROMADHONI', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5801, '25758030', 'Salwa Fadhila Assyifah', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5802, '25758031', 'SISKA AMELIA PUTRI', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5803, '25758039', 'Ajeng Restu Prahamita', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5804, '25758040', 'ANA RIDHOTUL SIFA', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5805, '25758043', 'Bunga Aidila Lorenza', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5806, '25758061', 'NUH', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5807, '25758062', 'Pebri Cahya Kamila', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5808, '25758064', 'REVALERIE ZEFANYA SOFIANADINE HUTAHAEAN', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5809, '25758065', 'Rizqon Adi Darma', 'D4 Produksi Media', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5810, '25759001', 'ACHMAD FADIL RIVAN', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5811, '25759007', 'BUNGA SYIFA AULIA', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5812, '25759015', 'Mahesa Birawa', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5813, '25759019', 'MUTIARA RAMADHANTI', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5814, '25759024', 'REPHINGGA NUR ALFALAKH', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5815, '25759028', 'Uswatunnisa', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5816, '25759042', 'FITRI YANI ARDIYANA', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5817, '25759054', 'RENA SAPUTRI', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5818, '25759055', 'REYSHELA DHINI PRASMITHA', 'D4 Bahasa Inggris untuk Bisnis dan Profesional', 'JURUSAN EKONOMI DAN BISNIS', '2025', 'skema 1', 'approved', NULL, NULL),
(5819, '25761003', 'Allyssa Nilam Anggraini', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5820, '25761010', 'IMMANUEL MANURUNG', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5821, '25761019', 'RENITA RAMADANI', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5822, '25761024', 'ANISA WIDIANTI', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5823, '25761026', 'DIKHA AGUNG NUGROHO', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5824, '25761027', 'Dinda Rahayu', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL);
INSERT INTO `mahasiswa_kip` (`id_mahasiswa_kip`, `npm`, `nama_mahasiswa`, `program_studi`, `jurusan`, `tahun`, `skema`, `status`, `id_admin`, `catatan_revisi`) VALUES
(5825, '25761032', 'M. ILHAM KHOIRUDDIN', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5826, '25761035', 'NASIVA YASMINE AISYA', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5827, '25761038', 'Rahmat Maulana', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5828, '25761041', 'Succi Arya Kristine. D', 'D3 Teknik Sumberdaya Lahan dan Lingkungan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5829, '25762001', 'ADELIA KHOTAMI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5830, '25762003', 'ALETA MEIKA DIANVIKA PUTRI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5831, '25762014', 'FERDIANSAH SAPUTRA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5832, '25762017', 'KUKUH DESTA PRATAMA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5833, '25762020', 'Nabila Adtry', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5834, '25762026', 'RISNA AYU AMALIA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5835, '25762033', 'ADEN MAULANA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5836, '25762034', 'AGHIS MUNADA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5837, '25762036', 'ASTRID INKA FITRI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5838, '25762040', 'DERLI DWI ANGGARA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5839, '25762042', 'DIMAS FAKHRUDIN', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5840, '25762045', 'FAREL WAHYU NUGRAHA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5841, '25762051', 'Muhammad Ridwan', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5842, '25762054', 'Nazila Naza Risma', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5843, '25762060', 'SEPTI DWI PAMUKTI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5844, '25762062', 'Tresya Anggrefya', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5845, '25762063', 'Zahra Zaria Atika Alzu', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5846, '25762064', 'ADINDA NADZLA NOVIANI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5847, '25762069', 'Dea Asita Alamsyah', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5848, '25762076', 'FEBRI VILARIAN', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5849, '25762077', 'FITRI ANTIKA', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5850, '25762083', 'NADIRA SHAFIA PUTRI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5851, '25762085', 'NAZWA ALICA QHOIRUL ROHIM', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5852, '25762087', 'RASYA DINAR AL GHIFARI', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5853, '25762090', 'Salsabila Ayu Ramadhani', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5854, '25762093', 'Wahyu Maulana', 'D4 Teknologi Rekayasa Kimia Industri', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5855, '25763013', 'MASTER ADMIRAL CALVIN', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5856, '25763019', 'Rahman Bayhaqi', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5857, '25763021', 'RIZKY FIRMANSYAH', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5858, '25763027', 'Aurel Salsabila', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5859, '25763031', 'Farrel Archie Nowitzky', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5860, '25763032', 'HARI FERNANDO SIHOMBING', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5861, '25763034', 'JULITA ANGEL TAMBUNAN', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5862, '25763036', 'M. RAFLI ARRAHMAN', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5863, '25763040', 'Nur Havit Aridho', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5864, '25763051', 'AYU LESTARI SINAGA', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5865, '25763053', 'DZAKY WAHYU TRIPRASONGKO', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5866, '25763057', 'Intan Pratiwi', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5867, '25763058', 'KEMAS ODHI ILHAM SAPUTRA', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5868, '25763066', 'RAFLY ARVA FERDINAND', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5869, '25763073', 'NURRAHMAH AULYA SHABRINA', 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5870, '25764003', 'Ahmad Sadikin', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5871, '25764007', 'Andi Imam Saputra', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5872, '25764012', 'Dimas aripin', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5873, '25764014', 'DWIKI R. M. PANJAITAN', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5874, '25764016', 'FARHAN MAULANA', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5875, '25764025', 'M. RIFKI AL GHIFARI', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5876, '25764031', 'RAFLY ALFATIR', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5877, '25764033', 'RIVALDO PURBA', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5878, '25764038', 'AGUS WASESO', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5879, '25764051', 'FAREL', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5880, '25764058', 'Khadafi Djunaidi', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5881, '25764060', 'M. BARAA ALFARISHI MAULANA', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5882, '25764061', 'MAQBUL JULIAN AJI NUGROHO', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5883, '25764064', 'MUHAMMAD RIDWAN', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5884, '25764065', 'ORIENT SEPO PASARIBU', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5885, '25764066', 'Racel Satrya Widiartha', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5886, '25764067', 'Raihan Muhammad Fadli', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5887, '25764073', 'RIVALDO SIREGAR', 'D4 Teknologi Rekayasa Otomotif', 'JURUSAN TEKNIK', '2025', 'skema 1', 'approved', NULL, NULL),
(5888, '25771003', 'Annisa Nur Oktaviani', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5889, '25771015', 'LINA P. HUTASOIT', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5890, '25771016', 'M. RIFQI MUSHOFFA', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5891, '25771017', 'Maruli Star Pasaribu', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5892, '25771022', 'Muhammad Farel Aleandra', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5893, '25771025', 'PANI LASTARI', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5894, '25771027', 'Reihan Titan Saputra', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5895, '25771028', 'Riya Susanti', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5896, '25771029', 'VIRDI AZIS PRATAMA', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5897, '25771033', 'ZESEN PRAYOGA PARDOSI', 'D3 Budidaya Perikanan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5898, '25772002', 'AJI PRATAMA', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5899, '25772003', 'AMANDA ANGGUN FEBRIA', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5900, '25772013', 'JHORDY APRIAN DINATA', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5901, '25772024', 'Seno Aji Permana', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5902, '25772038', 'JENTI YESI MONIKA SITORUS', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5903, '25772047', 'RIDHO YANSYAH CHANDRA', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5904, '25772051', 'VICKY ADRIANTO', 'D4 Teknologi Pembenihan Ikan', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5905, '25773004', 'FIOLAN YUMANDA', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5906, '25773005', 'SHERINA FITRIANI', 'D3 Perikanan Tangkap', 'JURUSAN PERIKANAN DAN KELAUTAN', '2025', 'skema 1', 'approved', NULL, NULL),
(5907, '25781001', 'ABDUL QOHHAR ATTAQIYYU', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5908, '25781017', 'NAZSWA FEBIOLA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5909, '25781018', 'PUTRI AULIA RAHMATILAH', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5910, '25781020', 'RAZZI RONALDI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5911, '25781021', 'RISKI WINATA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5912, '25781022', 'ROSMERI REVALITA SIMATUPANG', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5913, '25781023', 'Sebriana Sihotang', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5914, '25781025', 'YANDRI UTAMA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5915, '25781027', 'ahmad anwarul iman alfaqih', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5916, '25781028', 'ANDI SAPUTRA SIJABAT', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5917, '25781031', 'DIEGI RADILA VISTA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5918, '25781034', 'GHIFARI AZHAR', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5919, '25781036', 'Kadek Purne Wijaya', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5920, '25781037', 'LEVI MUHAMMAD WAHYU', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5921, '25781042', 'NAJUA EL JANUARI GISPA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5922, '25781043', 'OKTA QIRANIA SYAHFITRI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5923, '25781047', 'RIZQI LAILSYAH', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5924, '25781049', 'SHAFIRA NAILA PUTRI', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5925, '25781052', 'ZIYAN RAMADHAN', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5926, '25781058', 'DIMAS ELSON SAPUTRA MANALU', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5927, '25781064', 'Lulu Amalia Putri', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5928, '25781068', 'Nabiila Kumala Putri Haya', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5929, '25781070', 'PEPPY NAZZIFAH', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5930, '25781071', 'RADYT DZAKY PRATAMA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5931, '25781079', 'ZULFA NUR SHABRINA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5932, '25781087', 'Grace Lamria Tambunan', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5933, '25781094', 'NADYA APRILIA', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5934, '25781100', 'RIZKI APRIANSYAH', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5935, '25781101', 'Rosiq Hardiansyah', 'D3 Manajemen Informatika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5936, '25782003', 'AMBAR WATI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5937, '25782005', 'Aziza Khulva', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5938, '25782008', 'DEWI ARDIANTI FORTUNA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5939, '25782019', 'MUHAMMAD REHANSYAH', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5940, '25782024', 'Romiyadi', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5941, '25782026', 'seliya saputri', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5942, '25782027', 'SULTAN AQIL SYAFIQ', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5943, '25782028', 'TENGKU GEISYA GUSTIANA SYAH', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5944, '25782030', 'ADELLIA RAHMADANI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5945, '25782034', 'AZZRIL ANDREAN', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5946, '25782036', 'DEA ANGGRAENI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5947, '25782038', 'DINA SEPTIYANI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5948, '25782039', 'FADILLAH AKBAR', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5949, '25782042', 'Kezia Dias Ateta Br Ginting', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5950, '25782046', 'MUHAMMAD EGI ANGGARA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5951, '25782048', 'MUTIA QAUNA HIDAYAH', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5952, '25782050', 'RAHEL NISA SEPTIYANA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5953, '25782053', 'SALIM SUHERI SITOMPUL', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5954, '25782057', 'THESA SEPTI LISTIANA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5955, '25782059', 'AILA NADIANTI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5956, '25782060', 'ALFIAN KURNIAWAN', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5957, '25782069', 'HAFIZ RAHMAD KURNIAWAN', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5958, '25782071', 'LILI CAHYA PUTRI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5959, '25782080', 'REZA AURELIA SAPUTRI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5960, '25782082', 'SALMA ANGGUN VELYZA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5961, '25782084', 'Sofy Salsabila', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5962, '25782100', 'LILIS MAYANG SARI', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5963, '25782103', 'Muhammad Arya Zaki', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5964, '25782108', 'Rasya Agustina', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5965, '25782112', 'Sekar Maulia', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5966, '25782113', 'SULANA WIJAYA', 'D4 Teknologi Rekayasa Internet', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5967, '25783008', 'Danish Ara Safina', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5968, '25783026', 'Paskalis Alpredo', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5969, '25783043', 'DIMAS ARDES PUTRA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5970, '25783047', 'FARREL MAULANA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5971, '25783050', 'I KOMANG ARTAYASA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5972, '25783052', 'Khaila Halimatu Syadiya', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5973, '25783053', 'M. Irfan Rizki', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5974, '25783054', 'M. RICKI FADILAH', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5975, '25783055', 'MOHAMAD NURAMADHANI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5976, '25783060', 'PINDRA GATRIE UTAMA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5977, '25783062', 'Resti Jannysa Ulandari', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5978, '25783066', 'Sheva Ghania Ramadhani', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5979, '25783070', 'ACHMAD MAISUR AFNAN NIAMI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5980, '25783087', 'Immanuel Sihotang', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5981, '25783088', 'KHOIRUL AKBAR', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5982, '25783096', 'PUTRI ADITYA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5983, '25783097', 'Raflino Epraim Tambunan', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5984, '25783104', 'Ade Chandra Darmawan', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5985, '25783115', 'Fahri Febriansyah', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5986, '25783118', 'Holilayani', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5987, '25783119', 'IBNU FATAH GHANI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5988, '25783123', 'M.HASAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5989, '25783126', 'MUKHLIS NAINI RAMADITIA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5990, '25783136', 'YUNITA', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5991, '25783139', 'ALFANO YULIAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5992, '25783146', 'DODY SETIAWAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5993, '25783152', 'Ilham Miftahul Huda', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5994, '25783156', 'MALA FAUZIATI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5995, '25783158', 'MUHAMMAD MARWAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5996, '25783160', 'NATANNAEL PARLUHUTAN SIHOTANG', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5997, '25783162', 'raden chairil aji wicaksono', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5998, '25783165', 'RINTO IRAWAN', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(5999, '25783166', 'SERA SELVIYANTI', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6000, '25783169', 'Zahra Khairunnisa Ika Sari', 'D4 Teknologi Rekayasa Perangkat Lunak', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6001, '25784003', 'ALIF JANNIS GHIFARI', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6002, '25784010', 'Dirgahayu Saputra', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6003, '25784015', 'JOVANKA ALFAREDZY', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6004, '25784027', 'Ramzi Hadi Saputra', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6005, '25784033', 'ABI YUSA', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6006, '25784037', 'Aprian Galuh Pradinata', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6007, '25784039', 'BILLY ANDARA SAQI', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6008, '25784041', 'Devin Aviza Royan', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6009, '25784043', 'GUNAWAN HAMZAH', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6010, '25784046', 'JERICHO SIMANULLANG', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL),
(6011, '25784047', 'Julia Ismawati', 'D4 Teknologi Rekayasa Elektronika', 'JURUSAN TEKNOLOGI INFORMASI', '2025', 'skema 1', 'approved', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa_prestasi`
--

CREATE TABLE `mahasiswa_prestasi` (
  `id_prestasi` int(11) NOT NULL,
  `judul_prestasi` varchar(255) NOT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `tanggal_prestasi` date NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deskripsi` text DEFAULT NULL,
  `file_gambar` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan_revisi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa_prestasi`
--

INSERT INTO `mahasiswa_prestasi` (`id_prestasi`, `judul_prestasi`, `nama_mahasiswa`, `tanggal_prestasi`, `tanggal_upload`, `deskripsi`, `file_gambar`, `status`, `catatan_revisi`) VALUES
(2, 'sn', 'm', '2026-01-06', '2026-01-01 17:16:30', 'smnsmns', '[\"1767286174_0_3214.jpeg\",\"1767286349_0_6530.jpeg\"]', 'approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pedoman`
--

CREATE TABLE `pedoman` (
  `id_pedoman` int(11) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `catatan_revisi` text DEFAULT NULL,
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedoman`
--

INSERT INTO `pedoman` (`id_pedoman`, `nama_file`, `file_path`, `id_admin`, `status`, `catatan_revisi`, `approved_by`, `tanggal_upload`, `created_at`, `updated_at`) VALUES
(8, '20240207-Pedoman-Pendaftaran-KIP-Kuliah-2024_dfb2c1.pdf', 'uploads/pedoman/20240207-Pedoman-Pendaftaran-KIP-Kuliah-2024_dfb2c1_6933f7f4d2f15.pdf', NULL, 'approved', NULL, NULL, '2025-12-06 09:31:32', '2025-12-06 09:31:32', '2025-12-12 04:29:19'),
(9, 'Panduan-Reklaim-Akun-KIP-Kuliah-2024_eb8bb0.pdf', 'uploads/pedoman/Panduan-Reklaim-Akun-KIP-Kuliah-2024_eb8bb0_6933f800a9789.pdf', NULL, 'approved', NULL, NULL, '2025-12-06 09:31:44', '2025-12-06 09:31:44', '2025-12-24 08:40:33'),
(10, 'Pedoman-Pendaftaran-KIP-K-2022-ver-20220202---final_cd9b5e.pdf', 'uploads/pedoman/Pedoman-Pendaftaran-KIP-K-2022-ver-20220202---final_cd9b5e_6933f80a6fc2e.pdf', NULL, 'approved', NULL, NULL, '2025-12-06 09:31:54', '2025-12-06 09:31:54', '2025-12-08 01:00:57'),
(11, 'Pedoman-Pendaftaran-KIP-Kuliah-2023-update-15Mei2023-_e79a89.pdf', 'uploads/pedoman/Pedoman-Pendaftaran-KIP-Kuliah-2023-update-15Mei2023-_e79a89_6933f814b4bc3.pdf', NULL, 'approved', NULL, NULL, '2025-12-06 09:32:04', '2025-12-06 09:32:04', '2025-12-12 04:29:17'),
(16, 'Pedoman-Pendaftaran-KIP-Kuliah-2025-v1-0_6fab51.pdf', 'uploads/pedoman/Pedoman-Pendaftaran-KIP-Kuliah-2025-v1-0_6fab51_693b9cb72b29b.pdf', NULL, 'approved', NULL, NULL, '2025-12-12 04:40:23', '2025-12-12 04:40:23', '2025-12-24 05:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` date NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `tanggal`, `penulis`, `gambar`) VALUES
(1, 'Mahasiswa Polinela Juara 1 Lomba Karya Ilmiah Nasional', 'Selamat kepada tim mahasiswa Polinela yang berhasil meraih juara 1 dalam Lomba Karya Ilmiah Nasional di Jakarta.', '2025-09-23', 'Humas Polinela', 'prestasi1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `status_balasan` enum('belum','sudah') DEFAULT 'belum',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `nama`, `email`, `pesan`, `status_balasan`, `tanggal`) VALUES
(2, 'KINARA', 'cindynsllismail@gmail.com', 'daftar kip gimna ya kak?', 'belum', '2025-11-28 07:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE `saran` (
  `id_saran` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`id_saran`, `nama`, `email`, `pesan`, `tanggal`) VALUES
(1, 'cindy', 'cindynsllismail@gmail.com', 'LBIH BAGUSIN LAGI', '2025-11-28 06:55:04'),
(6, 'putri', 'putrianggrainisafitri92@gmail.com', 'lebih baik lagi', '2025-12-31 02:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `sk_kipk`
--

CREATE TABLE `sk_kipk` (
  `id_sk_kipk` int(11) NOT NULL,
  `nama_sk` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nomor_sk` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan_revisi` text DEFAULT NULL,
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `id_admin` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_kipk`
--

INSERT INTO `sk_kipk` (`id_sk_kipk`, `nama_sk`, `tahun`, `nomor_sk`, `file_path`, `file_url`, `status`, `catatan_revisi`, `approved_by`, `id_admin`) VALUES
(9, 'SK PENETAPAN KIPK 2024-3', '2024', '828', '../uploads/sk/1765013974_828_SK_PENETAPAN_KIPK_2024-3.pdf', '/KIPWEB/uploads/sk/1765013974_828_SK_PENETAPAN_KIPK_2024-3.pdf', 'pending', NULL, NULL, NULL),
(10, 'SK PENETAPAN KIPK 2023-5 SKEMA 1', '2023', '829', '../uploads/sk/1765013595_829_SK_PENETAPAN_KIPK_2023-5_SKEMA_1.pdf', '/KIPWEB/uploads/sk/1765013595_829_SK_PENETAPAN_KIPK_2023-5_SKEMA_1.pdf', 'approved', NULL, 0, NULL),
(11, 'SK PENETAPAN KIPK 2022', '2022', '917', '../uploads/sk/1765013647_917_SK_PENETAPAN_KIPK_2022.pdf', '/KIPWEB/uploads/sk/1765013647_917_SK_PENETAPAN_KIPK_2022.pdf', 'approved', NULL, 0, NULL),
(12, 'SK PENETAPAN KIPK SKEMA 2 25', '2025', '918', '../uploads/sk/1765013676_918_SK_PENETAPAN_KIPK_SKEMA_2_25.pdf', '/KIPWEB/uploads/sk/1765013676_918_SK_PENETAPAN_KIPK_SKEMA_2_25.pdf', 'approved', NULL, 0, NULL),
(13, 'penetapan mhs baru KIPK  2025 SNBP SNBT', '2025', '934', '../uploads/sk/1765013711_934_penetapan_mhs_baru_KIPK__2025_SNBP_SNBT.pdf', '/KIPWEB/uploads/sk/1765013711_934_penetapan_mhs_baru_KIPK__2025_SNBP_SNBT.pdf', 'approved', NULL, 0, NULL),
(14, 'Penetapan Mahasiswa Penerima Kartu Indonesia Pintar Kuliah (KIP-K) Usulan Masyarakat 2025', '2025', '1059', '../uploads/sk/1765013738_1059_Penetapan_Mahasiswa_Penerima_Kartu_Indonesia_Pintar_Kuliah__KIP-K__Usulan_Masyarakat_2025_.pdf', '/KIPWEB/uploads/sk/1765013738_1059_Penetapan_Mahasiswa_Penerima_Kartu_Indonesia_Pintar_Kuliah__KIP-K__Usulan_Masyarakat_2025_.pdf', 'approved', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `statistik_jurusan`
-- (See below for the actual view)
--
CREATE TABLE `statistik_jurusan` (
`jurusan` varchar(100)
,`jumlah_mahasiswa` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `statistik_prodi`
-- (See below for the actual view)
--
CREATE TABLE `statistik_prodi` (
`program_studi` varchar(100)
,`jumlah_mahasiswa` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `statistik_tahun`
-- (See below for the actual view)
--
CREATE TABLE `statistik_tahun` (
`tahun` year(4)
,`jumlah_mahasiswa` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `tindak_lanjut`
--

CREATE TABLE `tindak_lanjut` (
  `id_tindak_lanjut` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `file_tindak_lanjut` varchar(255) DEFAULT NULL,
  `dibuat_oleh` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transportasi`
--

CREATE TABLE `transportasi` (
  `id_transportasi` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa_kip` int(11) UNSIGNED DEFAULT NULL,
  `alat_transportasi` varchar(100) DEFAULT NULL,
  `detail_transportasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportasi`
--

INSERT INTO `transportasi` (`id_transportasi`, `id_mahasiswa_kip`, `alat_transportasi`, `detail_transportasi`) VALUES
(9, 4672, 'Kendaraan Pribadi', ''),
(10, 4672, 'Kendaraan Umum', ''),
(11, 4672, 'Kendaraan Pribadi', 'w'),
(12, 4672, 'Kendaraan Umum', ''),
(13, 4664, 'Jalan Kaki', '-');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_log`
--

CREATE TABLE `visitor_log` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `visit_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor_log`
--

INSERT INTO `visitor_log` (`id`, `ip_address`, `user_agent`, `visit_date`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-29'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31'),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-01');

-- --------------------------------------------------------

--
-- Structure for view `statistik_jurusan`
--
DROP TABLE IF EXISTS `statistik_jurusan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `statistik_jurusan`  AS SELECT `mahasiswa_kip`.`jurusan` AS `jurusan`, count(0) AS `jumlah_mahasiswa` FROM `mahasiswa_kip` GROUP BY `mahasiswa_kip`.`jurusan` ;

-- --------------------------------------------------------

--
-- Structure for view `statistik_prodi`
--
DROP TABLE IF EXISTS `statistik_prodi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `statistik_prodi`  AS SELECT `mahasiswa_kip`.`program_studi` AS `program_studi`, count(0) AS `jumlah_mahasiswa` FROM `mahasiswa_kip` GROUP BY `mahasiswa_kip`.`program_studi` ;

-- --------------------------------------------------------

--
-- Structure for view `statistik_tahun`
--
DROP TABLE IF EXISTS `statistik_tahun`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `statistik_tahun`  AS SELECT `mahasiswa_kip`.`tahun` AS `tahun`, count(0) AS `jumlah_mahasiswa` FROM `mahasiswa_kip` GROUP BY `mahasiswa_kip`.`tahun` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `berita_gambar`
--
ALTER TABLE `berita_gambar`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `id_berita` (`id_berita`);

--
-- Indexes for table `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD PRIMARY KEY (`id_eval`),
  ADD KEY `id_mahasiswa_kip` (`id_mahasiswa_kip`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `evaluasi_kip_bbp`
--
ALTER TABLE `evaluasi_kip_bbp`
  ADD PRIMARY KEY (`id_evaluasi`);

--
-- Indexes for table `file_eval`
--
ALTER TABLE `file_eval`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `id_mahasiswa_kip` (`id_mahasiswa_kip`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id_klrg`),
  ADD KEY `id_mahasiswa_kip` (`id_mahasiswa_kip`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `mahasiswa_kip`
--
ALTER TABLE `mahasiswa_kip`
  ADD PRIMARY KEY (`id_mahasiswa_kip`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `mahasiswa_prestasi`
--
ALTER TABLE `mahasiswa_prestasi`
  ADD PRIMARY KEY (`id_prestasi`);

--
-- Indexes for table `pedoman`
--
ALTER TABLE `pedoman`
  ADD PRIMARY KEY (`id_pedoman`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`);

--
-- Indexes for table `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`id_saran`);

--
-- Indexes for table `sk_kipk`
--
ALTER TABLE `sk_kipk`
  ADD PRIMARY KEY (`id_sk_kipk`);

--
-- Indexes for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD PRIMARY KEY (`id_transportasi`),
  ADD KEY `id_mahasiswa_kip` (`id_mahasiswa_kip`);

--
-- Indexes for table `visitor_log`
--
ALTER TABLE `visitor_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `berita_gambar`
--
ALTER TABLE `berita_gambar`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `evaluasi`
--
ALTER TABLE `evaluasi`
  MODIFY `id_eval` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `evaluasi_kip_bbp`
--
ALTER TABLE `evaluasi_kip_bbp`
  MODIFY `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_eval`
--
ALTER TABLE `file_eval`
  MODIFY `id_file` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id_klrg` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mahasiswa_kip`
--
ALTER TABLE `mahasiswa_kip`
  MODIFY `id_mahasiswa_kip` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6012;

--
-- AUTO_INCREMENT for table `mahasiswa_prestasi`
--
ALTER TABLE `mahasiswa_prestasi`
  MODIFY `id_prestasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pedoman`
--
ALTER TABLE `pedoman`
  MODIFY `id_pedoman` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `saran`
--
ALTER TABLE `saran`
  MODIFY `id_saran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sk_kipk`
--
ALTER TABLE `sk_kipk`
  MODIFY `id_sk_kipk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transportasi`
--
ALTER TABLE `transportasi`
  MODIFY `id_transportasi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `visitor_log`
--
ALTER TABLE `visitor_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita_gambar`
--
ALTER TABLE `berita_gambar`
  ADD CONSTRAINT `berita_gambar_ibfk_1` FOREIGN KEY (`id_berita`) REFERENCES `berita` (`id_berita`) ON DELETE CASCADE;

--
-- Constraints for table `file_eval`
--
ALTER TABLE `file_eval`
  ADD CONSTRAINT `file_eval_ibfk_1` FOREIGN KEY (`id_mahasiswa_kip`) REFERENCES `mahasiswa_kip` (`id_mahasiswa_kip`),
  ADD CONSTRAINT `file_eval_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD CONSTRAINT `fk_keluarga_mhs` FOREIGN KEY (`id_mahasiswa_kip`) REFERENCES `mahasiswa_kip` (`id_mahasiswa_kip`) ON DELETE CASCADE,
  ADD CONSTRAINT `keluarga_ibfk_1` FOREIGN KEY (`id_mahasiswa_kip`) REFERENCES `mahasiswa_kip` (`id_mahasiswa_kip`);

--
-- Constraints for table `mahasiswa_kip`
--
ALTER TABLE `mahasiswa_kip`
  ADD CONSTRAINT `mahasiswa_kip_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pedoman`
--
ALTER TABLE `pedoman`
  ADD CONSTRAINT `pedoman_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD CONSTRAINT `fk_transportasi_mhs` FOREIGN KEY (`id_mahasiswa_kip`) REFERENCES `mahasiswa_kip` (`id_mahasiswa_kip`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
