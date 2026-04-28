<footer class="footer" id="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost">
                    <span>maw.kost</span>
                </div>
                <p class="footer-desc">Platform digital yang memudahkan kamu menemukan, mengecek, dan mempromosikan kost secara praktis dan terpercaya</p>
                @php
                    $defaultSosmed = json_encode([
                        ['platform' => 'tiktok', 'url' => '#'],
                        ['platform' => 'instagram', 'url' => '#'],
                        ['platform' => 'whatsapp', 'url' => '#'],
                    ]);
                    $footerSosmed = json_decode(\App\Models\Setting::get('footer_sosmed', $defaultSosmed), true) ?: [];
                    $platformIcons = [
                        'tiktok' => 'fa-brands fa-tiktok',
                        'instagram' => 'fa-brands fa-instagram',
                        'whatsapp' => 'fa-brands fa-whatsapp',
                        'facebook' => 'fa-brands fa-facebook-f',
                        'twitter' => 'fa-brands fa-x-twitter',
                        'youtube' => 'fa-brands fa-youtube',
                        'linkedin' => 'fa-brands fa-linkedin-in',
                        'telegram' => 'fa-brands fa-telegram',
                    ];
                @endphp
                <div class="footer-social">
                    @foreach($footerSosmed as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($social['platform']) }}">
                            <i class="{{ $platformIcons[$social['platform']] ?? 'fa-solid fa-link' }}" style="font-size: 20px; color: #fff;"></i>
                        </a>
                    @endforeach
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
        <div class="footer-bottom">
            <div style="margin-bottom: 8px;">&copy; {{ date('Y') }} mawkost. All rights reserved.</div>
            <div class="footer-links">
                <a href="{{ route('tos') }}">Terms of Service</a>
                <a href="{{ route('privacy') }}">Kebijakan Privasi</a>
                <a href="{{ route('refund') }}">Kebijakan Pengembalian Dana</a>
            </div>
        </div>
    </div>
</footer>
