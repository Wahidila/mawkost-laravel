<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Akun Login mawkost</title>
</head>
<body style="margin:0;padding:0;background:#f4f7f9;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <div style="max-width:560px;margin:40px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">
        <!-- Header -->
        <div style="background:linear-gradient(135deg,#1E40AF 0%,#3B82F6 100%);padding:32px 32px 24px;text-align:center;">
            <h1 style="color:#fff;margin:0;font-size:24px;font-weight:700;">maw.kost</h1>
            <p style="color:rgba(255,255,255,0.85);margin:8px 0 0;font-size:14px;">Platform Pencarian Kost #1</p>
        </div>

        <!-- Body -->
        <div style="padding:32px;">
            <h2 style="color:#1e293b;margin:0 0 8px;font-size:20px;">Halo, {{ $user->name }}! 👋</h2>
            <p style="color:#64748b;margin:0 0 24px;font-size:14px;line-height:1.6;">
                Berikut adalah detail akun login Anda di mawkost. Gunakan kredensial ini untuk mengakses Dashboard dan melihat info kost yang sudah Anda beli.
            </p>

            <!-- Credentials Box -->
            <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:20px;margin-bottom:24px;">
                <h3 style="color:#0369a1;margin:0 0 12px;font-size:14px;text-transform:uppercase;letter-spacing:0.05em;">🔑 Login Credentials</h3>
                <table style="width:100%;border-collapse:collapse;">
                    <tr>
                        <td style="padding:6px 0;color:#64748b;font-size:13px;width:100px;">Email</td>
                        <td style="padding:6px 0;color:#0f172a;font-size:14px;font-weight:600;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding:6px 0;color:#64748b;font-size:13px;">Password</td>
                        <td style="padding:6px 0;color:#0f172a;font-size:14px;font-weight:600;font-family:monospace;letter-spacing:1px;">{{ $plainPassword }}</td>
                    </tr>
                </table>
            </div>

            <!-- CTA -->
            <div style="text-align:center;margin:28px 0 16px;">
                <a href="{{ url('/login') }}" style="display:inline-block;background:#1E40AF;color:#fff;padding:12px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;">
                    Masuk ke Dashboard
                </a>
            </div>

            <!-- Warning -->
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:14px 16px;margin-top:20px;">
                <p style="color:#991b1b;margin:0;font-size:12px;line-height:1.5;">
                    ⚠️ <strong>Penting:</strong> Segera ganti password Anda setelah login demi keamanan akun. Jangan bagikan informasi login ini kepada siapapun.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background:#f8fafc;padding:20px 32px;border-top:1px solid #e2e8f0;text-align:center;">
            <p style="color:#94a3b8;margin:0;font-size:12px;">
                © {{ date('Y') }} mawkost.id — Cari Kost Gampang, Ga Perlu Keliling!
            </p>
            <p style="color:#cbd5e1;margin:8px 0 0;font-size:11px;">
                Email ini dikirim oleh Admin mawkost. Jangan membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
