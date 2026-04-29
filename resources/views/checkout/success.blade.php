<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil — mawkost</title>
    <link rel="icon" href="{{ asset('assets/img/logo-128.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body style="background: var(--primary-lighter);">
    <div class="success-container">
        <div class="success-card">
            <div class="success-checkmark">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2>Pembayaran Berhasil!</h2>
            <p>Terima kasih. Info lengkap kost telah kami kirimkan.</p>

            <div class="success-info">
                <h4>Detail Pengiriman</h4>
                <div class="info-row">
                    <span class="label">Status WhatsApp:</span>
                    <span style="color: var(--success); font-weight: 600; display:flex; align-items:center; gap:4px;">
                        <i class="fa-solid fa-check"></i> Terkirim
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Status Email:</span>
                    @if(session('email_error'))
                    <span style="color: #ef4444; font-weight: 600; display:flex; align-items:center; gap:4px;">
                        <i class="fa-solid fa-xmark"></i> Gagal
                    </span>
                    @else
                    <span style="color: var(--success); font-weight: 600; display:flex; align-items:center; gap:4px;">
                        <i class="fa-solid fa-check"></i> Terkirim
                    </span>
                    @endif
                </div>
                <div class="info-row">
                    <span class="label">Item:</span>
                    <span>Info {{ $order->kost->title }}</span>
                </div>
                <div class="info-row">
                    <span class="label">No. Invoice:</span>
                    <span style="font-family: monospace;">{{ $order->invoice_no }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="info-row">
                    <span class="label">Voucher:</span>
                    <span style="color: #16a34a; font-weight: 600;">{{ $order->voucher->code ?? '-' }} (-Rp {{ number_format($order->discount_amount, 0, ',', '.') }})</span>
                </div>
                @endif
            </div>

            @if(session('email_error'))
            <div class="success-info" style="margin-top: 16px; background-color: #fef2f2; border: 1px solid #fecaca;">
                <h4 style="color: #b91c1c;"><i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px;"></i> Gagal Mengirim Email</h4>
                <p style="font-size: 0.85rem; color: #7f1d1d; margin-bottom: 0;">
                    Pesan Error: <code>{{ session('email_error') }}</code><br><br>
                    Tenang saja, <strong>pembayaran Anda tetap berhasil tercatat</strong> dan Anda bisa melihat detail info kost di kotak info bawah ini atau lewat Dashboard.
                </p>
            </div>
            @endif

            <!-- Account Info for New Users -->
            @if(session('is_new_user'))
            <div class="success-info" style="margin-top: 16px; background-color: #eff6ff; border: 1px solid #bfdbfe;">
                <h4 style="color: #1e40af;"><i class="fa-solid fa-user-plus" style="margin-right: 6px;"></i> Akun Anda Telah Dibuat!</h4>
                <p style="font-size: 0.85rem; color: #475569; margin-bottom: 12px;">
                    Kami telah membuat akun khusus untuk Anda. <strong>Email dan password</strong> sudah dikirim ke <strong>{{ $order->customer_email }}</strong>. 
                    Gunakan akun ini untuk mengakses Dashboard dan melihat kembali info kost yang sudah Anda beli kapan saja.
                </p>
                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #1E40AF; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Dashboard
                </a>
            </div>
            @endif

            <div style="margin-top: 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px;">
                <h4 style="color: #166534; display: flex; align-items: center; gap: 8px; margin: 0 0 16px; font-size: 15px;">
                    <i class="fa-solid fa-unlock-keyhole"></i> Info Kost Terbuka
                </h4>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px; color: #374151;">
                    <div>
                        <strong style="color: #166534; font-size: 12px; display: block; margin-bottom: 2px;">Nama Kost</strong>
                        <span style="font-weight: 600;">{{ $order->kost->name }}</span>
                    </div>
                    <div>
                        <strong style="color: #166534; font-size: 12px; display: block; margin-bottom: 2px;">Nama Pemilik</strong>
                        <span>{{ $order->kost->owner_name ?? 'Bapak/Ibu Kost' }}</span>
                    </div>
                    <div>
                        <strong style="color: #166534; font-size: 12px; display: block; margin-bottom: 2px;">WhatsApp Pemilik</strong>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $order->kost->owner_contact ?? '')) }}" target="_blank" style="color: #16a34a; text-decoration: none; font-weight: 600;">
                            {{ $order->kost->owner_contact ?? '-' }} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px;"></i>
                        </a>
                    </div>
                    <div>
                        <strong style="color: #166534; font-size: 12px; display: block; margin-bottom: 2px;">Alamat Lengkap</strong>
                        <span>{{ $order->kost->address ?? '-' }}</span>
                    </div>
                    @if($order->kost->maps_link)
                    <div>
                        <strong style="color: #166534; font-size: 12px; display: block; margin-bottom: 2px;">Google Maps</strong>
                        <a href="{{ $order->kost->maps_link }}" target="_blank" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                            <i class="fa-solid fa-map-location-dot" style="margin-right: 4px;"></i> Buka Titik Lokasi
                        </a>
                    </div>
                    @endif
                </div>
                <div style="margin-top: 16px; padding-top: 12px; border-top: 1px solid #bbf7d0;">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $order->kost->owner_contact ?? '')) }}?text={{ urlencode('Halo, saya ' . $order->customer_name . '. Saya tertarik dengan ' . $order->kost->name . ' (Kode: ' . $order->kost->kode . '). Apakah kamar masih tersedia?') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: #16a34a; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i> Hubungi Pemilik via WhatsApp
                    </a>
                </div>
            </div>

            <p style="font-size: .85rem; margin-top: 24px; margin-bottom: 24px; color: var(--text-muted);">Selain ditampilan di atas, info ini juga telah masuk ke WhatsApp dan Email Anda.</p>

            <div class="success-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
                <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#E8734A,#D4622E);color:#fff;padding:14px 32px;border-radius:9999px;text-decoration:none;font-family:'Poppins',sans-serif;font-weight:700;font-size:1rem;box-shadow:0 6px 20px rgba(232,115,74,0.35);transition:all 200ms ease;animation:loginPulse 2s ease-in-out infinite;" onmouseover="this.style.transform='translateY(-3px) scale(1.03)';this.style.boxShadow='0 10px 28px rgba(232,115,74,0.45)'" onmouseout="this.style.transform='';this.style.boxShadow='0 6px 20px rgba(232,115,74,0.35)'">
                    <i class="fa-solid fa-right-to-bracket" style="font-size:1.1rem;"></i> Login Akunmu
                </a>
            </div>
            <style>
                @keyframes loginPulse { 0%,100%{box-shadow:0 6px 20px rgba(232,115,74,0.35)} 50%{box-shadow:0 6px 28px rgba(232,115,74,0.5)} }
            </style>
        </div>
    </div>
</body>
</html>
