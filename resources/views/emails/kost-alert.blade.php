<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Baru Sesuai Kriteriamu</title>
</head>
<body style="margin:0;padding:0;background:#f4f7f9;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <div style="max-width:560px;margin:40px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">
        <div style="background:linear-gradient(135deg,#8B5E3C 0%,#5C3D2E 100%);padding:32px 32px 24px;text-align:center;">
            <h1 style="color:#fff;margin:0;font-size:24px;font-weight:700;">maw.kost</h1>
            <p style="color:rgba(255,255,255,0.85);margin:8px 0 0;font-size:14px;">{{ $kosts->count() }} Kost Baru Untukmu!</p>
        </div>

        <div style="padding:32px;">
            <h2 style="color:#1e293b;margin:0 0 8px;font-size:20px;">Halo, {{ $user->name }}! 👋</h2>
            <p style="color:#64748b;margin:0 0 24px;font-size:14px;line-height:1.6;">
                Ada {{ $kosts->count() }} kost baru yang sesuai dengan kriteria alert kamu di mawkost.
            </p>

            @foreach($kosts->take(5) as $kost)
            <div style="background:#FFF9F5;border:1px solid #F5E6DB;border-radius:12px;padding:16px 20px;margin-bottom:12px;">
                <h3 style="color:#5C3D2E;margin:0 0 8px;font-size:15px;">🏠 {{ $kost->title }}</h3>
                <div style="font-size:13px;color:#374151;line-height:1.6;">
                    <span>📍 {{ $kost->city->name ?? '-' }}</span> ·
                    <span>🏷️ {{ $kost->kostType->name ?? ucfirst($kost->type) }}</span> ·
                    <span>💰 Rp {{ number_format($kost->price, 0, ',', '.') }}/bln</span>
                </div>
                <div style="margin-top:10px;">
                    <a href="{{ url('/kost/' . ($kost->city->slug ?? '') . '/' . $kost->slug) }}" style="display:inline-block;background:#E8734A;color:#fff;padding:8px 20px;border-radius:9999px;text-decoration:none;font-weight:600;font-size:12px;">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach

            @if($kosts->count() > 5)
            <p style="color:#64748b;font-size:13px;text-align:center;margin:16px 0;">
                ...dan {{ $kosts->count() - 5 }} kost lainnya.
            </p>
            @endif

            <div style="text-align:center;margin:24px 0 16px;">
                <a href="{{ url('/cari-kost') }}" style="display:inline-block;background:#8B5E3C;color:#fff;padding:12px 32px;border-radius:9999px;text-decoration:none;font-weight:700;font-size:14px;">
                    Lihat Semua Kost
                </a>
            </div>

            <div style="background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:14px 16px;margin-top:24px;">
                <p style="color:#92400e;margin:0;font-size:12px;line-height:1.5;">
                    💡 Kamu menerima email ini karena mengaktifkan alert kost di mawkost. Kelola alert di <a href="{{ url('/user/alerts') }}" style="color:#92400e;font-weight:600;">Dashboard → Alert Kost</a>.
                </p>
            </div>
        </div>

        <div style="background:#f8fafc;padding:20px 32px;border-top:1px solid #e2e8f0;text-align:center;">
            <p style="color:#94a3b8;margin:0;font-size:12px;">
                &copy; {{ date('Y') }} mawkost.id — Cari Kost Gampang, Ga Perlu Keliling!
            </p>
        </div>
    </div>
</body>
</html>
