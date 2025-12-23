<?php

$dir = __DIR__ . '/../../uploads/berita/';

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

if (isset($_FILES['file'])) {

    $name = time() . "_" . basename($_FILES['file']['name']);
    $path = $dir . $name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {

        echo json_encode([
            'location' => 'uploads/berita/' . $name
        ]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['error' => 'Upload gagal']);
