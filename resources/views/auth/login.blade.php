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

            <div style="display:flex;align-items:center;gap:12px;margin:20px 0 0;">
                <div style="flex:1;height:1px;background:var(--border);"></div>
                <span style="font-size:.78rem;color:var(--text-muted);font-weight:500;">atau</span>
                <div style="flex:1;height:1px;background:var(--border);"></div>
            </div>

            <button type="button" onclick="document.getElementById('otpModal').style.display='flex'" style="width:100%;margin-top:16px;padding:12px;background:#25D366;color:#fff;border:none;border-radius:9999px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 200ms ease;" onmouseover="this.style.background='#1DA851';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#25D366';this.style.transform=''">
                <i class="fa-brands fa-whatsapp" style="font-size:1.1rem;"></i> Login via WhatsApp OTP
            </button>

            <div style="text-align:center;margin-top:14px;">
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
    <div class="modal-overlay" id="otpModal" onclick="if(event.target===this)this.style.display='none'">
        <div class="modal-card">
            <button type="button" class="modal-close" onclick="document.getElementById('otpModal').style.display='none'">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div style="text-align:center;margin-bottom:20px;">
                <div style="width:52px;height:52px;background:#dcfce7;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <i class="fa-brands fa-whatsapp" style="color:#25D366;font-size:1.4rem;"></i>
                </div>
                <h3 style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--primary-dark);font-size:1.15rem;margin-bottom:4px;">Login via WhatsApp</h3>
                <p style="color:var(--text-muted);font-size:.85rem;">Masukkan nomor WhatsApp terdaftar. Kami akan kirim kode OTP 6 digit.</p>
            </div>

            <div id="otp-alert" style="display:none;padding:12px 16px;border-radius:12px;font-size:.85rem;margin-bottom:16px;"></div>

            <div id="otp-step-1">
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <div class="input-wrapper">
                        <input type="tel" id="otp-phone" placeholder="081234567890" required>
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                </div>
                <button type="button" onclick="sendOtp()" id="otp-send-btn" style="width:100%;padding:12px;background:#25D366;color:#fff;border:none;border-radius:9999px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 200ms ease;">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Kode OTP
                </button>
            </div>

            <div id="otp-step-2" style="display:none;">
                <div class="form-group">
                    <label class="form-label">Kode OTP (6 digit)</label>
                    <div class="input-wrapper">
                        <input type="text" id="otp-code" maxlength="6" placeholder="000000" style="text-align:center;font-size:1.5rem;font-family:'Poppins',sans-serif;font-weight:700;letter-spacing:8px;" required>
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <p style="font-size:.78rem;color:var(--text-muted);margin-top:6px;text-align:center;">Kode berlaku 5 menit. Cek WhatsApp kamu.</p>
                </div>
                <button type="button" onclick="verifyOtp()" id="otp-verify-btn" style="width:100%;padding:12px;background:var(--primary);color:#fff;border:none;border-radius:9999px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 200ms ease;">
                    <i class="fa-solid fa-check"></i> Verifikasi & Login
                </button>
                <button type="button" onclick="document.getElementById('otp-step-1').style.display='';document.getElementById('otp-step-2').style.display='none';otpAlert('','');" style="width:100%;margin-top:10px;padding:8px;background:none;border:1px solid var(--border);border-radius:9999px;color:var(--text-muted);font-size:.82rem;cursor:pointer;font-family:'Open Sans',sans-serif;">
                    <i class="fa-solid fa-arrow-left" style="font-size:.7rem;margin-right:4px;"></i> Ganti Nomor
                </button>
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

    <script>
    var csrfToken = '{{ csrf_token() }}';

    function otpAlert(type, msg) {
        var el = document.getElementById('otp-alert');
        if (!msg) { el.style.display = 'none'; return; }
        el.style.display = 'flex';
        el.style.alignItems = 'flex-start';
        el.style.gap = '8px';
        if (type === 'error') {
            el.style.background = '#fef2f2'; el.style.border = '1px solid #fecaca'; el.style.color = '#991b1b';
            el.innerHTML = '<i class="fa-solid fa-circle-exclamation" style="margin-top:2px"></i><div>' + msg + '</div>';
        } else {
            el.style.background = '#f0fdf4'; el.style.border = '1px solid #bbf7d0'; el.style.color = '#166534';
            el.innerHTML = '<i class="fa-solid fa-circle-check" style="margin-top:2px"></i><div>' + msg + '</div>';
        }
    }

    function sendOtp() {
        var phone = document.getElementById('otp-phone').value.trim();
        if (!phone) return;
        var btn = document.getElementById('otp-send-btn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
        otpAlert('', '');

        fetch('{{ route("otp.send") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ whatsapp: phone })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.ok) {
                otpAlert('success', data.message);
                document.getElementById('otp-step-1').style.display = 'none';
                document.getElementById('otp-step-2').style.display = '';
                document.getElementById('otp-code').focus();
            } else {
                otpAlert('error', data.message);
            }
        })
        .catch(function() { otpAlert('error', 'Terjadi kesalahan. Coba lagi.'); })
        .finally(function() { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Kode OTP'; });
    }

    function verifyOtp() {
        var phone = document.getElementById('otp-phone').value.trim();
        var otp = document.getElementById('otp-code').value.trim();
        if (!otp || otp.length !== 6) { otpAlert('error', 'Masukkan 6 digit kode OTP.'); return; }
        var btn = document.getElementById('otp-verify-btn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memverifikasi...';
        otpAlert('', '');

        fetch('{{ route("otp.verify") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ whatsapp: phone, otp: otp })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.ok) {
                otpAlert('success', data.message + ' Mengalihkan...');
                setTimeout(function() { window.location.href = data.redirect; }, 1000);
            } else {
                otpAlert('error', data.message);
                btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-check"></i> Verifikasi & Login';
            }
        })
        .catch(function() { otpAlert('error', 'Terjadi kesalahan.'); btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-check"></i> Verifikasi & Login'; });
    }
    </script>

    @if(session('forgot_error') || session('forgot_success'))
    <script>document.getElementById('forgotModal').style.display='flex';</script>
    @endif
</body>
</html>
