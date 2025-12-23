<?php
session_start();

// LEVEL ADMIN3 HARUS 13
if (!isset($_SESSION['level']) || $_SESSION['level'] != '13') {
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

// Update status jika admin klik SELESAI
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    mysqli_query($koneksi, "UPDATE pertanyaan SET status_balasan='sudah' WHERE id_pertanyaan='$id'");
    echo "<script>alert('Pertanyaan ditandai sudah dibalas'); window.location='pertanyaan.php';</script>";
}
?>

<style>
/* ============================= */
/* AREA UTAMA */
/* ============================= */
.content-wrapper {
    margin-left: 260px;
    padding: 35px;
    font-family: 'Poppins', sans-serif;
}

/* HEADER */
.header-card {
    background: #fff;
    padding: 24px;
    border-radius: 18px;
    border-left: 10px solid #7c2ae8;
    box-shadow: 0 6px 18px rgba(124,42,232,0.20);
    margin-bottom: 25px;
}

.header-card h2 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #4e0a8a;
}

/* TABEL WRAPPER */
.table-card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    margin-top: 15px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}

/* TABEL */
.styled-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.styled-table thead tr {
    background: #6a0dad;
    color: white;
}

.styled-table th {
    padding: 14px;
    font-size: 14px;
}

.styled-table tbody tr {
    background: #faf5ff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.styled-table td {
    padding: 16px;
    font-size: 14px;
    vertical-align: top;
}

/* ============================= */
/* BADGES */
/* ============================= */
.badge-belum {
    background: #ff4d4d;
    padding: 6px 12px;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
}

.badge-sudah {
    background: #22c55e;
    padding: 6px 12px;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
}

/* ============================= */
/* ACTION BUTTON GROUP */
/* ============================= */
.action-box {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.copy-group {
    padding: 10px;
    background: #f3e8ff;
    border-radius: 12px;
    border: 1px solid #ddbaff;
}

.copy-title {
    font-size: 12px;
    font-weight: 700;
    color: #5b089e;
    margin-bottom: 5px;
}

/* tombol */
.action-btn {
    display: inline-block;
    padding: 7px 14px;
    border-radius: 8px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.copy-btn {
    background: #7c2ae8;
    color: white;
}

.copy-btn:hover {
    background: #5a16b8;
}

.done-btn {
    background: #22c55e;
    color: white;
}

.done-btn:hover {
    background: #1a9f4d;
}
</style>

<script>
function copyText(text) {
    navigator.clipboard.writeText(text);
    alert("Tersalin:\n\n" + text);
}
</script>

<div class="content-wrapper">

    <div class="header-card">
        <h2>📩 Daftar Pertanyaan Pengguna</h2>
    </div>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pertanyaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM pertanyaan ORDER BY id_pertanyaan DESC");
                while ($row = mysqli_fetch_assoc($q)) {

                    $status = $row['status_balasan'] == "belum"
                        ? "<span class='badge-belum'>Belum</span>"
                        : "<span class='badge-sudah'>Selesai</span>";

                    echo "
                    <tr>
                        <td>{$row['id_pertanyaan']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['pesan']}</td>
                        <td>$status</td>

                        <td>
                            <div class='action-box'>

                                <div class='copy-group'>
                                    <div class='copy-title'>COPY DATA</div>
                                    <a href='#' class='action-btn copy-btn' onclick=\"copyText('{$row['email']}')\">Copy Email</a>
                                    <a href='#' class='action-btn copy-btn' onclick=\"copyText('{$row['pesan']}')\">Copy Pesan</a>
                                </div>";

                    if ($row['status_balasan'] == "belum") {
                        echo "
                                <a class='action-btn done-btn' href='?done={$row['id_pertanyaan']}'>
                                    Tandai Selesai
                                </a>";
                    }

                    echo "</div></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
