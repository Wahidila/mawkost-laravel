<footer class="footer" id="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost">
                    <span>maw.kost</span>
                </div>
                <p class="footer-desc">Platform digital yang memudahkan kamu menemukan, mengecek, dan mempromosikan kost secara praktis dan terpercaya</p>
                <div class="footer-social">
                    <a href="#" aria-label="TikTok">
                        <i class="fa-brands fa-tiktok" style="font-size: 24px; color: #fff;"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="fa-brands fa-instagram" style="font-size: 24px; color: #fff;"></i>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp" style="font-size: 24px; color: #fff;"></i>
                    </a>
                </div>
            </div>
            <div>
                <h4>Kota</h4>
                <ul>
                    @php
                        $defaultKota = json_encode([
                            ['label' => 'Malang', 'url' => '/kost/malang'],
                            ['label' => 'Surabaya', 'url' => '/kost/surabaya'],
                            ['label' => 'Yogyakarta', 'url' => '/kost/yogyakarta'],
                            ['label' => 'Bali', 'url' => '/kost/bali'],
                        ]);
                        $footerKota = json_decode(\App\Models\Setting::get('footer_kota', $defaultKota), true) ?: [];
                    @endphp
                    @foreach($footerKota as $item)
                        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>Layanan</h4>
                <ul>
                    @php
                        $defaultLayanan = json_encode([
                            ['label' => 'Cariin Kost', 'url' => '/cari-kost'],
                            ['label' => 'Survey Kost', 'url' => '/#cara-kerja'],
                            ['label' => 'Promosi Kost', 'url' => '/kontak'],
                            ['label' => 'Info Kost', 'url' => '/cari-kost'],
                        ]);
                        $footerLayanan = json_decode(\App\Models\Setting::get('footer_layanan', $defaultLayanan), true) ?: [];
                    @endphp
                    @foreach($footerLayanan as $item)
                        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>Kontak</h4>
                <ul>
                    @php
                        $defaultKontak = json_encode([
                            ['label' => 'maw.kost198@gmail.com', 'url' => 'mailto:maw.kost198@gmail.com'],
                            ['label' => '+62 823-3798-5404', 'url' => 'tel:+6282337985404'],
                            ['label' => '@maw.kost', 'url' => '#'],
                        ]);
                        $footerKontak = json_decode(\App\Models\Setting::get('footer_kontak', $defaultKontak), true) ?: [];
                    @endphp
                    @foreach($footerKontak as $item)
                        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div>&copy; {{ date('Y') }} mawkost. All rights reserved.</div>
            <div style="font-size: 0.9em;">
                <a href="{{ route('tos') }}" style="color: inherit; text-decoration: none; margin-right: 16px;">Terms of Service</a>
                <a href="{{ route('privacy') }}" style="color: inherit; text-decoration: none; margin-right: 16px;">Kebijakan Privasi</a>
                <a href="{{ route('refund') }}" style="color: inherit; text-decoration: none;">Kebijakan Pengembalian Dana</a>
            </div>
        </div>
    </div>
</footer>
