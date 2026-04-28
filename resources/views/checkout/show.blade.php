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

                    @if(session('error'))
                    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; color: #991b1b; font-size: 0.9rem;">
                        <i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px;"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="xendit-section-title">Detail Kontak (Tujuan Pengiriman Info)</div>

                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control xendit-input" placeholder="Budi Santoso" required value="{{ old('name', auth()->user()->name ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="whatsapp">WhatsApp / No. HP</label>
                            <input type="tel" id="whatsapp" name="whatsapp" class="form-control xendit-input" placeholder="081234567890" pattern="[0-9]*" required value="{{ old('whatsapp', auth()->user()->whatsapp ?? '') }}">
                        </div>

                        <div class="form-group" style="margin-bottom: 32px;">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control xendit-input" placeholder="budi@gmail.com" required value="{{ old('email', auth()->user()->email ?? '') }}">
                        </div>

                    <div class="xendit-section-title">Punya Kode Voucher?</div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="voucher_input" name="voucher_code" class="form-control xendit-input" placeholder="Masukkan kode voucher" style="flex: 1; text-transform: uppercase;">
                            <button type="button" onclick="checkVoucher()" id="voucher_btn" style="padding: 10px 20px; border-radius: 8px; border: 1px solid #E8734A; background: #fff; color: #E8734A; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='#E8734A';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#E8734A'">
                                Terapkan
                            </button>
                        </div>
                        <div id="voucher_result" style="margin-top: 8px; display: none;"></div>
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

                    <button type="submit" class="btn xendit-btn-pay" id="pay_btn" style="width: 100%; margin-top: 32px;">
                        Bayar <span id="pay_amount">Rp {{ number_format($kost->unlock_price, 0, ',', '.') }}</span>
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
                Kembali ke Info {{ $kost->title }}
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

        var originalAmount = {{ $kost->unlock_price }};

        function formatRp(n) {
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        function checkVoucher() {
            var code = document.getElementById('voucher_input').value.trim();
            var result = document.getElementById('voucher_result');
            if (!code) { result.style.display = 'none'; return; }

            var btn = document.getElementById('voucher_btn');
            btn.textContent = '...';
            btn.disabled = true;

            fetch('{{ route("checkout.validateVoucher") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ code: code, amount: originalAmount })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                result.style.display = 'block';
                if (data.valid) {
                    result.innerHTML = '<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 14px;color:#166534;font-size:0.85rem;">'
                        + '<i class="fa-solid fa-check-circle" style="margin-right:6px;"></i>' + data.message
                        + '<br><span style="font-size:0.8rem;color:#15803d;">Diskon: ' + formatRp(data.discount) + ' → Total: <strong>' + formatRp(data.final_amount) + '</strong></span></div>';
                    document.getElementById('pay_amount').textContent = formatRp(data.final_amount);
                } else {
                    result.innerHTML = '<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;color:#991b1b;font-size:0.85rem;">'
                        + '<i class="fa-solid fa-times-circle" style="margin-right:6px;"></i>' + data.message + '</div>';
                    document.getElementById('pay_amount').textContent = formatRp(originalAmount);
                }
            })
            .catch(function() {
                result.style.display = 'block';
                result.innerHTML = '<div style="color:#991b1b;font-size:0.85rem;">Gagal memvalidasi voucher.</div>';
            })
            .finally(function() {
                btn.textContent = 'Terapkan';
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>
