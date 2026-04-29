<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | mawkost</title>
    <link rel="icon" href="{{ asset('assets/img/logo-128.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8B5E3C;
            --primary-light: #DEB8A0;
            --primary-lighter: #F5E6DB;
            --primary-dark: #5C3D2E;
            --cta: #E8734A;
            --bg: #FFF9F5;
            --surface: #FFFFFF;
            --text: #3D2B1F;
            --text-muted: #8C7A6E;
            --border-light: #F0E8E1;
            --shadow-lg: 0 16px 48px rgba(92, 61, 46, .12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
        }
        .blob-1 {
            width: 400px; height: 400px;
            background: var(--primary-light);
            top: -100px; right: -100px;
        }
        .blob-2 {
            width: 300px; height: 300px;
            background: var(--cta);
            bottom: -80px; left: -80px;
            opacity: 0.2;
        }

        .error-container {
            text-align: center;
            z-index: 1;
            padding: 40px 24px;
            max-width: 520px;
        }

        .error-logo {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            animation: floatLogo 3s ease-in-out infinite;
        }

        .error-code {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(5rem, 15vw, 8rem);
            font-weight: 800;
            color: var(--primary-lighter);
            line-height: 1;
            margin-bottom: 8px;
            position: relative;
        }

        .error-code span {
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--cta) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .error-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 12px;
        }

        .error-desc {
            font-size: 1rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 9999px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 200ms ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background: var(--surface);
            color: var(--primary);
            border-color: var(--primary);
        }
        .btn-outline:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
        }

        .error-paw {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 12px;
            opacity: 0.15;
        }
        .error-paw i {
            font-size: 1.2rem;
            color: var(--primary);
        }
        .error-paw i:nth-child(2) { transform: rotate(-15deg); }
        .error-paw i:nth-child(3) { transform: rotate(10deg); }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="error-container">
        <img src="{{ asset('assets/img/logo-128.png') }}" alt="mawkost" class="error-logo">

        <div class="error-code"><span>404</span></div>

        <h1 class="error-title">Halaman Tidak Ditemukan</h1>

        <p class="error-desc">
            Maaf, halaman yang kamu cari tidak ada atau sudah dipindahkan.
            Mungkin kost impianmu ada di halaman lain? 😊
        </p>

        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fa-solid fa-home"></i> Ke Beranda
            </a>
            <a href="{{ url('/cari-kost') }}" class="btn btn-outline">
                <i class="fa-solid fa-magnifying-glass"></i> Cari Kost
            </a>
        </div>

        <div class="error-paw">
            <i class="fa-solid fa-paw"></i>
            <i class="fa-solid fa-paw"></i>
            <i class="fa-solid fa-paw"></i>
        </div>
    </div>
</body>
</html>
