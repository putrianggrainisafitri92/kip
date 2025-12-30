<?php
include('../koneksi.php');
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 0;
if(!$tahun) exit(json_encode([]));

$res = $koneksi->query("SELECT nama_sk, file_path 
                        FROM sk_kipk 
                        WHERE tahun=$tahun AND status='approved' 
                        ORDER BY id_sk_kipk ASC");

$list = [];
while($row = $res->fetch_assoc()){
    $file_url = '../sk/' . $row['file_path'];
    $list[] = ['nama_sk'=>$row['nama_sk'], 'file_url'=>$file_url];
}

header('Content-Type: application/json');
echo json_encode($list);
