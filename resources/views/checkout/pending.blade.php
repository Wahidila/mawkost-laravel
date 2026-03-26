<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Pembayaran — mawkost</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .pending-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .pending-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            max-width: 520px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
        }
        .pending-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #FEF3C7;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pending-icon i {
            font-size: 36px;
            color: #F59E0B;
        }
        .pending-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .pending-card p {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 24px;
        }
        .pending-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            text-align: left;
            margin-bottom: 24px;
        }
        .pending-info .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 0.9rem;
        }
        .pending-info .label {
            color: #94a3b8;
            font-weight: 500;
        }
        .btn-pay-now {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: #fff;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 4px 12px rgba(245,158,11,.3);
        }
        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245,158,11,.4);
        }
        .auto-refresh-note {
            margin-top: 20px;
            font-size: 0.8rem;
            color: #94a3b8;
        }
        .pulse-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #F59E0B;
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }
    </style>
</head>

<body style="background: #F4F7F9;">
    <div class="pending-container">
        <div class="pending-card">
            <div class="pending-icon">
                <i class="fa-solid fa-clock"></i>
            </div>
            <h2>Menunggu Pembayaran</h2>
            <p>Silakan selesaikan pembayaran Anda melalui halaman Xendit. Halaman ini akan otomatis berubah saat pembayaran dikonfirmasi.</p>

            <div class="pending-info">
                <div class="info-row">
                    <span class="label">No. Invoice:</span>
                    <span style="font-family: monospace; font-weight: 600;">{{ $order->invoice_no }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Item:</span>
                    <span>Info {{ $order->kost->name ?? 'Kost' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Total:</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ $order->formatted_amount }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span style="color: #F59E0B; font-weight: 600;">
                        <span class="pulse-dot"></span>Menunggu Pembayaran
                    </span>
                </div>
            </div>

            @if($order->xendit_invoice_url)
            <a href="{{ $order->xendit_invoice_url }}" class="btn-pay-now">
                <i class="fa-solid fa-arrow-right"></i> Bayar Sekarang
            </a>
            @endif

            <p class="auto-refresh-note">
                <i class="fa-solid fa-sync-alt"></i> Halaman ini auto-refresh setiap 5 detik
            </p>

            <div style="margin-top: 24px;">
                <a href="{{ route('home') }}" style="color: #64748b; font-size: .9rem; text-decoration: none;">
                    <i class="fa-solid fa-arrow-left" style="margin-right: 4px;"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh: check payment status every 5 seconds
        setInterval(function() {
            fetch('{{ route("checkout.status", $order->invoice_no) }}')
                .then(r => r.json())
                .then(data => {
                    if (data.paid) {
                        window.location.href = '{{ route("checkout.success", $order->invoice_no) }}';
                    }
                })
                .catch(() => {});
        }, 5000);
    </script>
</body>
</html>
