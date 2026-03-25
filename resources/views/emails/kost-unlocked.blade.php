<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Kontak Kost Terbuka</title>
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
                Terima kasih telah menggunakan mawkost! Pembelian tiket info kontak untuk kost <strong>{{ $kost->name }}</strong> telah berhasil diproses (Invoice: {{ $order->invoice_no }}).
            </p>

            <!-- Unlocked Contact Info -->
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:20px;margin-bottom:24px;">
                <h3 style="color:#166534;margin:0 0 12px;font-size:14px;text-transform:uppercase;letter-spacing:0.05em;">🔓 Info Kontak Kost (Unlocked)</h3>
                <div style="font-size:13px;color:#374151;line-height:1.6;">
                    <p style="margin:0 0 8px;"><strong>📱 Nama Pemilik:</strong><br>{{ $kost->owner_name ?? 'Bapak/Ibu Kost' }}</p>
                    <p style="margin:0 0 8px;"><strong>📞 WhatsApp Pemilik:</strong><br><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $kost->owner_contact ?? '')) }}" style="color:#16a34a;font-weight:600;text-decoration:none;">{{ $kost->owner_contact ?? '-' }}</a></p>
                    <p style="margin:0 0 8px;"><strong>📍 Alamat Lengkap:</strong><br>{{ $kost->address ?? '-' }}</p>
                    @if($kost->maps_link)
                    <p style="margin:0;"><strong>🗺️ Google Maps:</strong><br><a href="{{ $kost->maps_link }}" style="color:#2563eb;text-decoration:none;">Buka Titik Lokasi di Maps</a></p>
                    @endif
                </div>
            </div>
            
            <p style="color:#64748b;margin:0 0 24px;font-size:14px;line-height:1.6;text-align:center;">
                Anda kini bisa langsung menghubungi pemilik kost untuk bertanya lebih detail atau memesan kamar.
            </p>

            <!-- CTA -->
            <div style="text-align:center;margin:28px 0 16px;display:flex;flex-direction:column;gap:12px;align-items:center;">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $kost->owner_contact ?? '')) }}?text={{ urlencode('Halo, saya ' . $user->name . '. Saya tertarik dengan ' . $kost->name . ' (Kode: ' . $kost->kode . '). Apakah masih tersedia?') }}" style="display:inline-block;background:#16A34A;color:#fff;padding:12px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;width:fit-content;">
                    Hubungi via WhatsApp
                </a>
                
                <a href="{{ route('user.orders.show', $order->id) }}" style="display:inline-block;background:#F1F5F9;color:#334155;padding:12px 32px;border-radius:8px;text-decoration:none;font-weight:600;border:1px solid #E2E8F0;font-size:14px;width:fit-content;">
                    Lihat Detail Pesanan
                </a>
            </div>

            <!-- Notice -->
            <div style="background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:14px 16px;margin-top:32px;">
                <p style="color:#92400e;margin:0;font-size:12px;line-height:1.5;">
                    💡 Seluruh histori transaksi dan info kontak yang terbuka selamanya tersimpan di akun Anda. Login kapan saja ke <strong>mawkost.id</strong> untuk melihatnya kembali.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background:#f8fafc;padding:20px 32px;border-top:1px solid #e2e8f0;text-align:center;">
            <p style="color:#94a3b8;margin:0;font-size:12px;">
                © {{ date('Y') }} mawkost.id — Cari Kost Gampang, Ga Perlu Keliling!
            </p>
            <p style="color:#cbd5e1;margin:8px 0 0;font-size:11px;">
                Email ini dikirim otomatis. Jangan membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
