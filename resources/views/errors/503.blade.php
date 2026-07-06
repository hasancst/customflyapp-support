<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumahnya Masih Dibangun - Rumah Koalisi</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
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
            max-width: 800px;
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
            font-size: clamp(2rem, 8vw, 4rem);
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, white 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Countdown */
        .countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 2rem;
        }

        .countdown-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 20px;
            min-width: 100px;
        }

        .countdown-value {
            display: block;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
        }

        .countdown-label {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-top: 5px;
        }

        /* Background Bubbles */
        .bg-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(1, 74, 122, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            filter: blur(50px);
            z-index: 1;
        }

        @media (max-width: 600px) {
            .countdown {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    
    <div class="container">
        @php
            $pengaturan = \DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
            $target = $pengaturan['pemeliharaan_sampai'] ?? '';
            $pesan = $pengaturan['pemeliharaan_pesan'] ?? 'Rumahnya Masih Dibangun';
        @endphp
        <div class="loader-wrapper">
            <div class="house-animation">
                <div class="crane"></div>
                <div class="house-body"></div>
                <div class="house-roof"></div>
            </div>
        </div>

        <h1>{{ $pesan }}</h1>
        <p>Mohon maaf atas ketidaknyamanannya. Kami sedang merenovasi situs ini agar dapat memberikan pengalaman terbaik untuk Anda.</p>

        <div class="countdown" id="timer">
            <div class="countdown-item">
                <span class="countdown-value" id="days">00</span>
                <span class="countdown-label">Hari</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-value" id="hours">00</span>
                <span class="countdown-label">Jam</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-value" id="minutes">00</span>
                <span class="countdown-label">Menit</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-value" id="seconds">00</span>
                <span class="countdown-label">Detik</span>
            </div>
        </div>
    </div>

    <script>
        // Set target date from database
        const targetStr = "{{ $target }}";
        const targetDate = targetStr ? new Date(targetStr) : new Date(Date.now() + 7 * 24 * 60 * 60 * 1000);

        function updateTimer() {
            const now = new Date().getTime();
            const difference = targetDate - now;

            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');

            if (difference < 0) {
                clearInterval(interval);
                document.getElementById('timer').innerHTML = "<h1>Selesai!</h1>";
            }
        }

        const interval = setInterval(updateTimer, 1000);
        updateTimer();
    </script>
</body>
</html>
