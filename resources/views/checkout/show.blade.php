<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — mawkost</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body style="background: #F4F7F9;">

    <div class="xendit-checkout-container">
        <!-- Main Invoice Card -->
        <div class="xendit-card fade-in">
            <!-- Header -->
            <div class="xendit-header">
                <div class="xendit-merchant">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost logo">
                    <span>mawkost</span>
                </div>
                <div class="xendit-amount-box">
                    <p>Total Pembayaran</p>
                    <h2>Rp {{ number_format($kost->unlock_price, 0, ',', '.') }}</h2>
                    <div class="xendit-order-id">Membuka Kontak: {{ $kost->kode }}</div>
                </div>
            </div>

            <!-- Body -->
            <div class="xendit-body">
                <form class="checkout-form" action="{{ route('checkout.process', $kost->slug) }}" method="POST">
                    @csrf
                    <div class="xendit-section-title">Detail Kontak (Tujuan Pengiriman Info)</div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control xendit-input" placeholder="Budi Santoso" required value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="whatsapp">WhatsApp / No. HP</label>
                        <input type="tel" id="whatsapp" name="whatsapp" class="form-control xendit-input" placeholder="081234567890" pattern="[0-9]*" required value="{{ old('whatsapp') }}">
                    </div>

                    <div class="form-group" style="margin-bottom: 32px;">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control xendit-input" placeholder="budi@gmail.com" required value="{{ old('email') }}">
                    </div>

                    <div class="xendit-section-title">Pilih Metode Pembayaran</div>

                    <div class="xendit-payment-list">
                        <!-- QRIS -->
                        <label class="xendit-payment-option active">
                            <input type="radio" name="payment" value="qris" checked style="display:none;">
                            <div class="xendit-payment-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <rect x="7" y="7" width="3" height="3" />
                                    <rect x="14" y="7" width="3" height="3" />
                                    <rect x="7" y="14" width="3" height="3" />
                                    <rect x="14" y="14" width="3" height="3" />
                                </svg>
                            </div>
                            <div class="xendit-payment-details">
                                <span class="xendit-payment-name">QRIS</span>
                                <span class="xendit-payment-desc">Bayar instan dengan scan QR</span>
                            </div>
                            <div class="xendit-radio-circle"></div>
                        </label>

                        <!-- GoPay -->
                        <label class="xendit-payment-option">
                            <input type="radio" name="payment" value="gopay" style="display:none;">
                            <div class="xendit-payment-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <path d="M2 10h20" />
                                </svg>
                            </div>
                            <div class="xendit-payment-details">
                                <span class="xendit-payment-name">GoPay / e-Wallet</span>
                                <span class="xendit-payment-desc">OVO, DANA, ShopeePay, LinkAja</span>
                            </div>
                            <div class="xendit-radio-circle"></div>
                        </label>

                        <!-- Virtual Account -->
                        <label class="xendit-payment-option">
                            <input type="radio" name="payment" value="va" style="display:none;">
                            <div class="xendit-payment-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                    <path d="M7 15h.01" />
                                    <path d="M11 15h2" />
                                </svg>
                            </div>
                            <div class="xendit-payment-details">
                                <span class="xendit-payment-name">Virtual Account Bank</span>
                                <span class="xendit-payment-desc">BCA, Mandiri, BNI, BRI</span>
                            </div>
                            <div class="xendit-radio-circle"></div>
                        </label>
                    </div>

                    <button type="submit" class="btn xendit-btn-pay" style="width: 100%; margin-top: 32px;">
                        Bayar Rp {{ number_format($kost->unlock_price, 0, ',', '.') }}
                    </button>

                </form>
            </div>

            <!-- Footer -->
            <div class="xendit-footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-right: 4px;">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                Secure payments powered by <strong>Xendit</strong>
            </div>
        </div>

        <div style="text-align: center; margin-top: 24px;">
            <a href="{{ route('kost.show', ['citySlug' => $kost->city->slug, 'slug' => $kost->slug]) }}"
                style="color: var(--text-muted); font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px; height:16px;">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Info {{ $kost->name }}
            </a>
        </div>
    </div>

    <script>
        // Simple active class toggle on payment methods
        document.querySelectorAll('.xendit-payment-option').forEach(label => {
            label.addEventListener('click', function () {
                document.querySelectorAll('.xendit-payment-option').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input').checked = true;
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>
</body>
</html>
