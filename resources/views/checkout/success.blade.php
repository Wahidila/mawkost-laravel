<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil — mawkost</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
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

            <!-- Provide the actual contact info -->
            <div class="success-info" style="margin-top: 16px; background-color: var(--surface);">
                <h4>Info Kontak & Alamat (Unlocked)</h4>
                <p style="margin-bottom: 8px;"><strong>Nama Pemilik:</strong> {{ $order->kost->owner_name ?? 'Bapak/Ibu Kost' }}</p>
                <p style="margin-bottom: 8px;"><strong>WhatsApp:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $order->kost->owner_contact ?? '')) }}" target="_blank" style="color: var(--cta); text-decoration: none; font-weight: 600;">{{ $order->kost->owner_contact ?? '-' }} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 12px; margin-left:4px;"></i></a></p>
                <p style="margin-bottom: 8px;"><strong>Alamat Pas:</strong> {{ $order->kost->address ?? 'Jl. Placeholder No XXX' }}</p>
                @if($order->kost->maps_link)
                <p style="margin-bottom: 0;"><strong>Link Maps:</strong> <a href="{{ $order->kost->maps_link }}" target="_blank" style="color: var(--cta); text-decoration: none;">Buka di Google Maps</a></p>
                @endif
            </div>

            <p style="font-size: .85rem; margin-top: 24px; margin-bottom: 24px; color: var(--text-muted);">Selain ditampilan di atas, info ini juga telah masuk ke WhatsApp dan Email Anda.</p>

            <div class="success-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
                <a href="{{ route('kost.show', ['citySlug' => $order->kost->city->slug, 'slug' => $order->kost->slug]) }}" class="btn btn-primary">Lihat Detail Kost</a>
            </div>
        </div>
    </div>
</body>
</html>
