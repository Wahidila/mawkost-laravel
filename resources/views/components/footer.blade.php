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
                        <i class="fa-brands fa-tiktok" style="font-size: 24px;"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="fa-brands fa-instagram" style="font-size: 24px;"></i>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp" style="font-size: 24px;"></i>
                    </a>
                </div>
            </div>
            <div>
                <h4>Kota</h4>
                <ul>
                    @php $footerCities = \App\Models\City::orderBy('name')->take(4)->get(); @endphp
                    @foreach($footerCities as $city)
                        <li><a href="{{ route('kost.byCity', $city->slug) }}">{{ $city->name }}</a></li>
                    @endforeach
                    @if($footerCities->isEmpty())
                        <li><a href="#">Malang</a></li>
                        <li><a href="#">Surabaya</a></li>
                        <li><a href="#">Yogyakarta</a></li>
                        <li><a href="#">Bali</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('kost.search') }}">Cariin Kost</a></li>
                    <li><a href="{{ route('home') }}#cara-kerja">Survey Kost</a></li>
                    <li><a href="{{ route('contact.index') }}">Promosi Kost</a></li>
                    <li><a href="{{ route('kost.search') }}">Info Kost</a></li>
                </ul>
            </div>
            <div>
                <h4>Kontak</h4>
                <ul>
                    <li><a href="mailto:maw.kost198@gmail.com">maw.kost198@gmail.com</a></li>
                    <li><a href="tel:+6282337985404">+62 823-3798-5404</a></li>
                    <li><a href="#">@maw.kost</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} mawkost. All rights reserved.
        </div>
    </div>
</footer>
