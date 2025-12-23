<?php
$gambarData = json_decode($row['gambar'], true);

if (!empty($gambarData)) {
    echo "<div style='display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;'>";

    foreach ($gambarData as $img) {
        echo "
        <div style='flex:1 1 45%;'>
            <img src=\"../uploads/berita/$img\" 
                 style='width:100%; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.25);'>
        </div>";
    }

    echo "</div>";
}
?>
