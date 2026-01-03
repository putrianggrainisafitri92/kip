<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Berprestasi - KIP K</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');
        
        body { font-family: 'Outfit', sans-serif; margin: 0; min-height: 100vh; overflow-x: hidden; color: #333; }

        /* ========== ANIMATED BACKGROUND (Style from berita_detail.php) ========== */
        .animated-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden; }
        .gradient-bg {
            position: absolute; width: 100%; height: 100%;
            background: linear-gradient(-45deg, #1e1b4b, #4338ca, #6d28d9, #8b5cf6, #a855f7, #7c3aed);
            background-size: 400% 400%; animation: gradientMove 10s ease infinite;
        }
        @keyframes gradientMove { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

        .floating-circles { position: absolute; width: 100%; height: 100%; pointer-events: none; }
        .circle { position: absolute; border-radius: 50%; animation: floatCircle 18s ease-in-out infinite; }
        
        .circle-1 {
            width: 300px; height: 300px; background: rgba(139,92,246,0.4); border: 3px solid rgba(167,139,250,0.6);
            box-shadow: 0 0 60px 20px rgba(139,92,246,0.5), inset 0 0 60px rgba(255,255,255,0.1);
            top: -50px; left: -50px; animation-delay: 0s;
        }
        .circle-2 {
            width: 400px; height: 400px; background: rgba(124,58,237,0.3); border: 2px solid rgba(139,92,246,0.5);
            box-shadow: 0 0 80px rgba(124,58,237,0.4); top: 50%; right: -100px; animation-delay: -5s; animation-duration: 22s;
        }
        .circle-3 {
            width: 200px; height: 200px; background: rgba(167,139,250,0.5); border: 4px solid rgba(255,255,255,0.3);
            box-shadow: 0 0 40px rgba(255,255,255,0.2); bottom: 10%; left: 20%; animation-delay: -10s; animation-duration: 15s;
        }
        @keyframes floatCircle {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -50px) scale(1.1); }
        }

        /* Animasi Text Gradient */
        .gradient-text {
            background: linear-gradient(to right, #ffffff, #e9d5ff, #ffffff); background-size: 200% auto;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            animation: shine 4s linear infinite; text-shadow: 0 4px 10px rgba(0,0,0,0.2);
            position: relative; z-index: 10;
        }
        @keyframes shine { to { background-position: 200% center; } }

        /* Card Styles */
        .card-animate {
            opacity: 0; transform: translateY(30px); animation: fadeInUp 0.8s ease-out forwards;
            background: rgba(255, 255, 255, 0.95); z-index: 1;
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .card-animate:nth-child(n) { animation-delay: calc(0.1s * var(--i)); }

        .prestasi-card { transition: all 0.4s; }
        .prestasi-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 20px 50px rgba(0,0,0,0.3); }
        
        .img-container { overflow: hidden; height: 220px; border-radius: 16px 16px 0 0; cursor: pointer; position: relative; }
        .slider-wrapper { width: 100%; height: 100%; position: relative; }
        .slider-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out; }
        .slider-img.active { opacity: 1; z-index: 1; }
        
        /* Modal Style Update - GLASSMORPHISM / PURPLE THEME */
        #detailModal { 
            display: none; position: fixed; z-index: 9999; inset: 0; 
            /* Background Ungu Transparan agar animasi belakang terlihat */
            background: rgba(20, 5, 50, 0.82); 
            backdrop-filter: blur(10px);
            justify-content: center; align-items: center; opacity: 0; transition: opacity 0.3s; 
        }
        #detailModal.show { opacity: 1; }
        
        .modal-content-custom { 
            background: rgba(255, 255, 255, 0.95); /* Sedikit transparan */
            width: 95%; max-width: 900px; max-height: 90vh; border-radius: 20px; 
            overflow: hidden; display: flex; flex-direction: column; transform: scale(0.95); transition: transform 0.3s; 
            box-shadow: 0 0 50px rgba(139, 92, 246, 0.5); /* Glow ungu */
            border: 1px solid rgba(255,255,255,0.3);
        }
        #detailModal.show .modal-content-custom { transform: scale(1); }
        
        /* Gallery Container - Transparent to show Blur/BG */
        .modal-gallery-container { 
            position: relative; height: 50vh; 
            background: transparent; /* Transparan, bukan hitam */
            display: flex; align-items: center; justify-content: center; 
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        .modal-gallery-img { 
            max-width: 100%; max-height: 100%; object-fit: contain; display: none; 
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3)); /* Shadow agar gambar pop */
        }
        .modal-gallery-img.active { display: block; animation: zoomIn 0.4s ease; }
        @keyframes zoomIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .gallery-nav { 
            position: absolute; top: 50%; transform: translateY(-50%); 
            background: rgba(139, 92, 246, 0.8); color: white; border: none;
            width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(139, 92, 246, 0.4);
        }
        .gallery-nav:hover { background: #6d28d9; transform: translateY(-50%) scale(1.1); }
        .gallery-prev { left: 20px; }
        .gallery-next { right: 20px; }
        
        .gallery-dots { position: absolute; bottom: 15px; display: flex; gap: 8px; background: rgba(0,0,0,0.3); padding: 5px 10px; rounded-full; }
        .dot { width: 10px; height: 10px; background: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; transition: 0.2s; }
        .dot.active { background: #d8b4fe; transform: scale(1.2); }
    </style>
</head>
<body>

<!-- ANIMATED BACKGROUND (Berita Detail Style) -->
<div class="animated-bg">
    <div class="gradient-bg"></div>
    <div class="floating-circles">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" onclick="closeDetail()">
    <div class="modal-content-custom" onclick="event.stopPropagation()">
        <!-- Gallery Section -->
        <div class="modal-gallery-container">
            <button onclick="changeModalImage(-1)" class="gallery-nav gallery-prev"><i class="fas fa-chevron-left"></i></button>
            <div id="modal-images-wrapper" class="w-full h-full flex justify-center items-center">
                <!-- Images injected here -->
            </div>
            <button onclick="changeModalImage(1)" class="gallery-nav gallery-next"><i class="fas fa-chevron-right"></i></button>
            <div class="gallery-dots" id="modal-dots"></div>
            
            <button onclick="closeDetail()" class="absolute top-4 right-4 bg-black/50 hover:bg-black text-white rounded-full p-2 px-3 transition z-50">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Info Section -->
        <div class="p-6 overflow-y-auto flex-grow bg-white">
            <h3 id="modal-judul" class="text-2xl font-bold text-gray-800 mb-2"></h3>
            <div class="flex items-center text-purple-700 font-semibold mb-3">
                <i class="fas fa-user-graduate me-2"></i> <span id="modal-nama"></span>
            </div>
            <div class="flex items-center text-gray-500 text-sm mb-4 space-x-4 border-b pb-4">
                <span><i class="fas fa-calendar-alt me-1"></i> <span id="modal-tgl"></span></span>
                <span><i class="fas fa-clock me-1"></i> Upload: <span id="modal-upload"></span></span>
            </div>
            <p id="modal-desc" class="text-gray-700 leading-relaxed text-justify whitespace-pre-wrap"></p>
        </div>
    </div>
</div>

<?php include 'sidebar.php'; ?>
<?php include 'koneksi.php'; ?>

<div class="main-content min-h-screen pt-24 pb-12 px-4 md:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-6xl font-extrabold mb-4 gradient-text tracking-tight drop-shadow-lg">
                Mahasiswa Berprestasi
                <div class="text-base font-normal mt-4 text-purple-100 tracking-wide leading-relaxed max-w-2xl mx-auto">
                    Galeri kebanggaan penerima KIP-Kuliah di Politeknik Negeri Lampung yang sukses menorehkan prestasi gemilang.
                </div>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $query = "SELECT * FROM mahasiswa_prestasi WHERE status = 'approved' ORDER BY id_prestasi DESC";
            $result = $koneksi->query($query);
            $cardDelay = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $cardDelay++;
                    // Decode JSON Images
                    $rawGambar = $row['file_gambar'];
                    $gambarArr = json_decode($rawGambar, true);
                    if (!is_array($gambarArr)) {
                        $gambarArr = !empty($rawGambar) ? [$rawGambar] : [];
                    }
                    if (empty($gambarArr)) $gambarArr = ['default']; // Placeholder if needed

                    // Prepare Image URLs
                    $imgUrls = [];
                    foreach ($gambarArr as $g) {
                        $imgUrls[] = ($g == 'default') ? 'assets/no-image.jpg' : 'uploads/prestasi/' . $g;
                    }
                    $jsonImgUrls = htmlspecialchars(json_encode($imgUrls), ENT_QUOTES, 'UTF-8');

                    // Data for JS (Raw is better for json_encode)
                    $judulRaw = $row['judul_prestasi'];
                    $namaRaw = $row['nama_mahasiswa'];
                    $descRaw = $row['deskripsi'];
                    $tglSafe = date('d M Y', strtotime($row['tanggal_prestasi']));
                    $uploadSafe = date('d/m/Y', strtotime($row['tanggal_upload']));
                    
                    // JSON for JS
                    $jsonJudul = htmlspecialchars(json_encode($judulRaw), ENT_QUOTES, 'UTF-8');
                    $jsonNama = htmlspecialchars(json_encode($namaRaw), ENT_QUOTES, 'UTF-8');
                    $jsonDesc = htmlspecialchars(json_encode($descRaw), ENT_QUOTES, 'UTF-8');
                    
                    // Display Safe Txt (Clean up literal \n from DB for the sneak-peek)
                    $descClean = str_replace(['\r\n', '\r', '\n'], ' ', $descRaw);
                    $judulSafe = htmlspecialchars($judulRaw);
                    $namaSafe = htmlspecialchars($namaRaw);
                    $descSafe = htmlspecialchars($descClean);
                    ?>
                    <div class="card-animate rounded-2xl shadow-xl prestasi-card flex flex-col h-full group relative overflow-hidden" 
                         style="--i:<?= $cardDelay ?>">
                        
                        <!-- Slider Thumbnail -->
                        <div class="img-container" onclick='openDetail(<?= $jsonJudul ?>, <?= $jsonNama ?>, "<?= $tglSafe ?>", "<?= $uploadSafe ?>", <?= $jsonDesc ?>, <?= $jsonImgUrls ?>)'>
                            <div class="slider-wrapper">
                                <?php foreach($imgUrls as $idx => $url): ?>
                                    <img src="<?= $url ?>" class="slider-img <?= $idx==0?'active':'' ?>">
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Overlay CTA -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-10">
                                <span class="text-white font-bold bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/50 transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                    <i class="fas fa-images me-2"></i> Lihat <?= count($imgUrls) ?> Foto
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow relative bg-white">
                            <div class="absolute -top-4 right-4 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg z-10">
                                <?= $tglSafe ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-700 transition-colors line-clamp-2">
                                <?= $judulSafe ?>
                            </h3>
                            <div class="flex items-center mb-4">
                                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded mr-2">Mahasiswa</span>
                                <span class="font-semibold text-gray-700 text-sm truncate"><?= $namaSafe ?></span>
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-3">
                                <?= $descSafe ?>
                            </p>
                            <button onclick='openDetail(<?= $jsonJudul ?>, <?= $jsonNama ?>, "<?= $tglSafe ?>", "<?= $uploadSafe ?>", <?= $jsonDesc ?>, <?= $jsonImgUrls ?>)' 
                                class="mt-auto w-full text-center py-2 rounded-lg border border-purple-200 text-purple-600 font-bold hover:bg-purple-600 hover:text-white transition-all duration-300">
                                Lihat Galeri & Detail <i class="fas fa-arrow-right ms-1 text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-span-full text-center text-white py-20">Belum ada data prestasi.</div>';
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    // --- Auto Slider for Thumbnails ---
    document.addEventListener('DOMContentLoaded', () => {
        const wrappers = document.querySelectorAll('.slider-wrapper');
        wrappers.forEach(wrapper => {
            const images = wrapper.querySelectorAll('.slider-img');
            if(images.length > 1) {
                let current = 0;
                setInterval(() => {
                    images[current].classList.remove('active');
                    current = (current + 1) % images.length;
                    images[current].classList.add('active');
                }, 3000 + Math.random() * 2000); // Random offset biar gak barengan banget
            }
        });
    });

    // --- Modal Logic ---
    let currentModalImages = [];
    let currentModalIndex = 0;

    function openDetail(judul, nama, tgl, upload, desc, imgArray) {
        document.getElementById('modal-judul').innerText = judul;
        document.getElementById('modal-nama').innerText = nama;
        document.getElementById('modal-tgl').innerText = tgl;
        document.getElementById('modal-upload').innerText = upload;
        
        // Bersihkan literal \n atau \r\n bawan database agar jadi line break asli
        let cleanDesc = desc
            .replace(/\\r\\n/g, '\n')
            .replace(/\\n/g, '\n')
            .replace(/\\r/g, '\n');
            
        document.getElementById('modal-desc').innerText = cleanDesc;
        
        // Setup Modal Gallery
        currentModalImages = imgArray;
        currentModalIndex = 0;
        renderModalImages();

        const modal = document.getElementById('detailModal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    
    function renderModalImages() {
        const wrapper = document.getElementById('modal-images-wrapper');
        const dots = document.getElementById('modal-dots');
        wrapper.innerHTML = '';
        dots.innerHTML = '';
        
        currentModalImages.forEach((src, idx) => {
            // Image
            const img = document.createElement('img');
            img.src = src;
            img.className = `modal-gallery-img ${idx === currentModalIndex ? 'active' : ''}`;
            wrapper.appendChild(img);
            
            // Dot
            const dot = document.createElement('div');
            dot.className = `dot ${idx === currentModalIndex ? 'active' : ''}`;
            dot.onclick = (e) => { e.stopPropagation(); setModalImage(idx); };
            dots.appendChild(dot);
        });

        // Hide nav if only 1 image
        const navs = document.querySelectorAll('.gallery-nav');
        navs.forEach(n => n.style.display = currentModalImages.length > 1 ? 'block' : 'none');
    }

    function changeModalImage(dir) {
        if(currentModalImages.length <= 1) return;
        currentModalIndex = (currentModalIndex + dir + currentModalImages.length) % currentModalImages.length;
        renderModalImages();
    }
    
    function setModalImage(idx) {
        currentModalIndex = idx;
        renderModalImages();
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
    
    document.addEventListener('keydown', e => {
        if(document.getElementById('detailModal').style.display === 'flex') {
            if(e.key === "Escape") closeDetail();
            if(e.key === "ArrowLeft") changeModalImage(-1);
            if(e.key === "ArrowRight") changeModalImage(1);
        }
    });
</script>

<?php include 'chatbot_widget.php'; ?>
</body>
</html>
