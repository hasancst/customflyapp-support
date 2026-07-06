<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Halaman Tidak Ditemukan - Rumah Koalisi</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #014A7A;
            --accent: #f59e0b;
            --bg: #0f172a;
            --text: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }

        .container {
            position: relative;
            z-index: 10;
            padding: 20px;
            max-width: 600px;
            width: 100%;
        }

        /* Animation */
        .loader-wrapper {
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
        }

        .house-animation {
            width: 120px;
            height: 120px;
            position: relative;
        }

        .house-body {
            position: absolute;
            bottom: 0;
            width: 80px;
            height: 60px;
            background: var(--primary);
            left: 20px;
            border-radius: 4px;
            animation: bounce 2s infinite ease-in-out;
        }

        .house-roof {
            position: absolute;
            bottom: 60px;
            left: 10px;
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-bottom: 40px solid var(--accent);
            animation: bounce 2s infinite ease-in-out 0.2s;
        }

        .crane {
            position: absolute;
            top: -20px;
            right: -40px;
            width: 100px;
            height: 100px;
            border-right: 4px solid var(--text-muted);
            border-top: 4px solid var(--text-muted);
            animation: craneMove 4s infinite ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes craneMove {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(-10deg); }
        }

        h1 {
            font-size: clamp(4rem, 15vw, 8rem);
            font-weight: 800;
            margin-bottom: 0;
            line-height: 0.8;
            background: linear-gradient(135deg, white 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.05em;
        }

        h2 {
            font-size: 1.5rem;
            margin: 20px 0 10px;
            font-weight: 700;
            color: var(--text);
        }

        p {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(1, 74, 122, 0.3);
        }

        .btn:hover {
            background: #025da1;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(1, 74, 122, 0.4);
        }

        /* Background Bubbles */
        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(1, 74, 122, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            filter: blur(80px);
            z-index: 1;
        }

        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
            animation: float 10s infinite linear;
        }

        @keyframes float {
            from { transform: translateY(0) rotate(0deg); opacity: 1; }
            to { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    
    <!-- Floating background decorative elements -->
    <div class="bubble" style="width: 80px; height: 80px; left: 10%; bottom: -100px; animation-duration: 15s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; left: 80%; bottom: -150px; animation-duration: 20s; animation-delay: 2s;"></div>
    <div class="bubble" style="width: 50px; height: 50px; left: 40%; bottom: -80px; animation-duration: 12s; animation-delay: 5s;"></div>

    <div class="container">
        <div class="loader-wrapper">
            <div class="house-animation">
                <div class="crane"></div>
                <div class="house-body"></div>
                <div class="house-roof"></div>
            </div>
        </div>

        <h1>404</h1>
        <h2>Halaman Hilang!</h2>
        <p>Sepertinya rumah yang Anda cari belum dibangun atau sudah berpindah lokasi.</p>

        <a href="/" class="btn">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Script to create more bubbles -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            for(let i = 0; i < 5; i++) {
                const bubble = document.createElement('div');
                bubble.className = 'bubble';
                const size = Math.random() * 60 + 20;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${Math.random() * 100}%`;
                bubble.style.bottom = `-${size + 50}px`;
                bubble.style.animationDuration = `${Math.random() * 10 + 10}s`;
                bubble.style.animationDelay = `${Math.random() * 10}s`;
                body.appendChild(bubble);
            }
        });
    </script>
</body>
</html>
