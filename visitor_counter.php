<?php
$ip = $_SERVER['REMOTE_ADDR'];
$tanggal = date('Y-m-d');
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (preg_match('/bot|crawl|spider|slurp|wget|curl|facebook|whatsapp/i', $user_agent)) {
    return;
}

$cek = mysqli_query($koneksi, "
    SELECT id FROM visitor_log
    WHERE ip_address='$ip' AND visit_date='$tanggal'
");

if (mysqli_num_rows($cek) == 0) {
    mysqli_query($koneksi, "
        INSERT INTO visitor_log (ip_address, visit_date, user_agent)
        VALUES ('$ip', '$tanggal', '$user_agent')
    ");
}
