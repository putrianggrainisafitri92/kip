<?php
session_start();

// FIX LEVEL → 13 untuk admin3
if (!isset($_SESSION['level']) || $_SESSION['level'] != '13') {
    die("Akses ditolak!");
}

// Cek koneksi
$tryK = [
    __DIR__ . "/koneksi.php",
    __DIR__ . "/../koneksi.php",
    __DIR__ . "/../../koneksi.php"
];

foreach ($tryK as $k) {
    if (file_exists($k)) {
        include $k;
        break;
    }
}

if (isset($koneksi)) $db = $koneksi;
elseif (isset($conn)) $db = $conn;
else die("ERROR: Variabel koneksi tidak ditemukan!");

// Sidebar
$sidebarPath = [
    __DIR__ . "/sidebar.php",
    __DIR__ . "/../sidebar.php"
];

foreach ($sidebarPath as $s) {
    if (file_exists($s)) {
        include $s;
        break;
    }
}
?>

<style>
body {
    background: #efeaff;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
}

.content-wrapper {
    margin-left: 260px;
    padding: 35px;
}

/* HEADER CARD */
.header-card {
    background: #ffffff;
    padding: 28px;
    border-radius: 18px;
    border-left: 10px solid #6a0dad;
    box-shadow: 0 6px 22px rgba(106, 13, 173, 0.18);
    margin-bottom: 25px;
}

.header-card h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    color: #4e0a8a;
}

/* TABLE CARD */
.table-card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    margin-top: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* TABLE */
.styled-table {
    width: 100%;
    border-collapse: collapse;
}

.styled-table thead tr {
    background: #6a0dad;
    color: white;
}

.styled-table th,
.styled-table td {
    padding: 14px 16px;
    text-align: center;
    font-size: 14px;
}

.styled-table tbody tr {
    background: #fbf7ff;
    border-bottom: 8px solid #ffffff;
    transition: 0.2s;
}

.styled-table tbody tr:hover {
    background: #f0e4ff;
    transform: scale(1.002);
}
</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>📩 Daftar Saran Pengguna</h2>
    </div>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = $db->query("SELECT * FROM saran ORDER BY id_saran DESC");
                while ($row = $q->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['id_saran']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['pesan']}</td>
                        <td>{$row['tanggal']}</td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
