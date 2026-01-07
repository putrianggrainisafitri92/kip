<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f2ff 0%, #eaddff 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
            overflow: hidden;
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(78, 10, 138, 0.15);
            max-width: 500px;
            width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.6);
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            z-index: 2;
        }

        .icon-lock {
            font-size: 60px;
            color: #4e0a8a;
            margin-bottom: 20px;
            display: inline-block;
            animation: shake 4s ease-in-out infinite;
        }

        h1 {
            font-size: 80px;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(45deg, #4e0a8a, #d32f2f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.1;
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            color: #4e0a8a;
            margin: 10px 0 15px;
        }

        p {
            font-size: 15px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #4e0a8a;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(78, 10, 138, 0.3);
        }

        .btn:hover {
            background: #7b35d4;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(123, 53, 212, 0.4);
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            2% { transform: rotate(-5deg); }
            4% { transform: rotate(5deg); }
            6% { transform: rotate(0deg); }
        }

        /* Background Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
            filter: blur(60px);
            opacity: 0.6;
        }
        .shape-1 {
            width: 300px; height: 300px;
            background: #ffcdd2; /* Slight Red tint for 403 */
            top: -100px; left: -100px;
            animation: moveShape 8s infinite alternate;
        }
        .shape-2 {
            width: 250px; height: 250px;
            background: #e1bee7;
            bottom: -50px; right: -50px;
            animation: moveShape 10s infinite alternate-reverse;
        }

        @keyframes moveShape {
            from { transform: translate(0, 0); }
            to { transform: translate(30px, 30px); }
        }
    </style>
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="container">
        <i class="fas fa-user-lock icon-lock"></i>
        
        <h1>403</h1>
        <h2>Akses Dibatasi</h2>
        <p>
            Mohon maaf, Anda tidak memiliki hak akses yang cukup untuk membuka halaman ini. 
            Laman ini dilindungi untuk alasan keamanan dan privasi data.
        </p>

        <div style="display:flex; justify-content: center; gap: 10px;">
            <a href="javascript:history.back()" class="btn" style="background:#e0e0e0; color:#444; box-shadow:none;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="login.php" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login Ulang
            </a>
        </div>
    </div>

</body>
</html>
