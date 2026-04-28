<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — mawkost</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
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
            --border: #E8DDD5;
            --border-light: #F0E8E1;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .blob-1 { width: 400px; height: 400px; background: var(--primary-light); opacity: 0.35; top: -120px; left: -100px; }
        .blob-2 { width: 300px; height: 300px; background: var(--cta); opacity: 0.15; bottom: -80px; right: -60px; }
        .blob-3 { width: 200px; height: 200px; background: var(--primary-lighter); opacity: 0.4; top: 50%; right: 10%; }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 24px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(232, 221, 213, 0.5);
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: 0 16px 48px rgba(92, 61, 46, 0.12);
        }

        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .login-logo img {
            width: 44px;
            height: 44px;
        }

        .login-logo span {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--primary-dark);
        }

        .login-logo span em {
            font-style: normal;
            color: var(--cta);
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: .9rem;
            margin-bottom: 28px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: .85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: .82rem;
            color: var(--primary-dark);
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-light);
            font-size: .85rem;
            transition: color 200ms ease;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: .95rem;
            color: var(--text);
            background: var(--surface);
            transition: all 200ms ease;
            outline: none;
            font-family: 'Open Sans', sans-serif;
        }

        .input-wrapper input::placeholder {
            color: var(--text-muted);
            opacity: 0.6;
        }

        .input-wrapper input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 94, 60, 0.1);
        }

        .input-wrapper input:focus + i,
        .input-wrapper:focus-within i {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 9999px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            cursor: pointer;
            transition: all 200ms ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(92, 61, 46, 0.2);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 500;
            transition: color 200ms ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .login-footer a:hover {
            color: var(--cta);
        }

        .login-paw {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            opacity: 0.12;
        }

        .login-paw i {
            font-size: .9rem;
            color: var(--primary);
        }

        .login-paw i:nth-child(2) { transform: rotate(-12deg); }
        .login-paw i:nth-child(3) { transform: rotate(8deg); }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(92, 61, 46, 0.4);
            backdrop-filter: blur(4px);
            z-index: 100;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .modal-card {
            background: var(--surface);
            border-radius: 24px;
            padding: 32px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 16px 48px rgba(92, 61, 46, 0.2);
            position: relative;
            animation: modalIn 200ms ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(16px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: var(--border-light);
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            transition: all 200ms ease;
        }

        .modal-close:hover {
            background: var(--primary-lighter);
            color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost">
                <span>maw.<em>kost</em></span>
            </div>
            <p class="login-subtitle">Masuk ke akun Anda</p>

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check" style="margin-top:2px;"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" required autofocus value="{{ old('email') }}" placeholder="email@example.com">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" required placeholder="••••••••">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </button>
            </form>

            <div style="text-align:center;margin-top:16px;">
                <button type="button" onclick="document.getElementById('forgotModal').style.display='flex'" style="background:none;border:none;color:var(--cta);font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Open Sans',sans-serif;">
                    <i class="fa-solid fa-key" style="font-size:.75rem;margin-right:4px;"></i> Lupa Password?
                </button>
            </div>

            <div class="login-footer">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-arrow-left" style="font-size:.75rem;"></i> Kembali ke Beranda
                </a>
            </div>

            <div class="login-paw">
                <i class="fa-solid fa-paw"></i>
                <i class="fa-solid fa-paw"></i>
                <i class="fa-solid fa-paw"></i>
            </div>
        </div>
    </div>
    <div class="modal-overlay" id="forgotModal" onclick="if(event.target===this)this.style.display='none'">
        <div class="modal-card">
            <button type="button" class="modal-close" onclick="document.getElementById('forgotModal').style.display='none'">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div style="text-align:center;margin-bottom:20px;">
                <div style="width:52px;height:52px;background:var(--primary-lighter);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <i class="fa-solid fa-key" style="color:var(--primary);font-size:1.2rem;"></i>
                </div>
                <h3 style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--primary-dark);font-size:1.15rem;margin-bottom:4px;">Lupa Password?</h3>
                <p style="color:var(--text-muted);font-size:.85rem;">Masukkan email atau nomor WhatsApp yang terdaftar. Password baru akan dikirim ke email & WA kamu.</p>
            </div>

            @if(session('forgot_error'))
            <div class="alert alert-error" style="margin-bottom:16px;">
                <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;"></i>
                <div>{{ session('forgot_error') }}</div>
            </div>
            @endif

            @if(session('forgot_success'))
            <div class="alert alert-success" style="margin-bottom:16px;">
                <i class="fa-solid fa-circle-check" style="margin-top:2px;"></i>
                <div>{{ session('forgot_success') }}</div>
            </div>
            @endif

            <form method="POST" action="{{ route('forgot-password') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email atau No. WhatsApp</label>
                    <div class="input-wrapper">
                        <input type="text" name="identifier" required placeholder="email@example.com atau 08123456789">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login" style="background:var(--cta);">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Password Baru
                </button>
            </form>
        </div>
    </div>

    @if(session('forgot_error') || session('forgot_success'))
    <script>document.getElementById('forgotModal').style.display='flex';</script>
    @endif
</body>
</html>
