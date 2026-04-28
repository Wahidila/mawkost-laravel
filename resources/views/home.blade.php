@extends('layouts.app')

@section('title', 'mawkost — Cari Kost Gampang, Ga Perlu Keliling!')

@section('body_class', '')

@section('content')
<!-- ========== HERO ========== -->
<section class="hero">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="container">
    <div class="hero-content">
      <div class="hero-text fade-in">
        <div style="margin-bottom: 16px;">
          <span class="badge badge-cta">
            <i class="fa-solid fa-layer-group"></i>
            Platform #1 Pencarian Kost
          </span>
        </div>
        <h1>Cari Kost Gampang,<br><span>Ga Perlu Keliling!</span></h1>
        <p>Temukan kost impianmu di Malang, Jogja, dan Surabaya. Lihat foto, fasilitas, dan harga, lalu bayar hanya Rp
          35.000 untuk dapatkan alamat lengkap &amp; kontak pemilik kost.</p>
        <div class="hero-search-container glass fade-in" style="animation-delay: 0.1s;">
          <div class="search-tabs">
            <button class="search-tab active" onclick="switchSearchTab('general', this)">Cari Umum</button>
            <button class="search-tab" onclick="switchSearchTab('kode', this)">Kode Properti</button>
          </div>

          <!-- Tab 1: General Search -->
          <div id="tab-general" class="hero-search">
            <form action="{{ route('kost.search') }}" method="GET" style="display: flex; gap: 12px; flex: 1; flex-wrap: wrap;">
              <div class="search-group" style="flex: 1; min-width: 150px;">
                <label>Lokasi Kota</label>
                <select name="lokasi">
                  <option value="">Semua Kota</option>
                  @foreach($cities as $c)
                    <option value="{{ $c->slug }}">{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="search-group" style="flex: 1; min-width: 150px;">
                <label>Tipe Kost</label>
                <select name="tipe">
                  <option value="">Semua Tipe</option>
                  <option value="putra">Putra</option>
                  <option value="putri">Putri</option>
                  <option value="campur">Campur</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-search">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
              </button>
            </form>
          </div>

          <!-- Tab 2: Kode Properti Search -->
          <div id="tab-kode" class="hero-search" style="display: none;">
            <form action="{{ route('kost.searchByCode') }}" method="POST" style="display: flex; flex-direction: column; gap: 12px; flex: 1;">
              @csrf
              <div class="search-group" style="width: 100%;">
                <label>Punya Kode Properti?</label>
                <div style="display: flex; align-items: center; gap: 8px;">
                  <i class="fa-solid fa-ticket"></i>
                  <input type="text" name="kode" required placeholder="Masukkan kode (contoh: MK-123)" style="width:100%; border:none; background:transparent; font-size:1rem; outline:none;">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-search" style="width: 100%;">
                Cek Kost
              </button>
            </form>
          </div>
          
          @if(session('error'))
            <p style="color: var(--danger); font-size: 0.9rem; margin-top: 8px;">{{ session('error') }}</p>
          @endif
        </div>
        
        <script>
          function switchSearchTab(tabName, element) {
            // Update tabs
            document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
            element.classList.add('active');

            // Update content
            document.getElementById('tab-general').style.display = tabName === 'general' ? 'flex' : 'none';
            document.getElementById('tab-kode').style.display = tabName === 'kode' ? 'flex' : 'none';
          }
        </script>
        <div class="hero-stats">
          <div class="hero-stat">
            <strong>500+</strong>
            <span>Kost Tersedia</span>
          </div>
          <div class="hero-stat">
            <strong>3</strong>
            <span>Kota Operasi</span>
          </div>
          <div class="hero-stat">
            <strong>2.5K+</strong>
            <span>Customer Puas</span>
          </div>
        </div>
      </div>
      <div class="hero-image fade-in">
        <img src="{{ asset('assets/img/kost-1.png') }}" alt="Kost modern di Malang">
        <div class="hero-float-badge">
          <i class="fa-solid fa-users-viewfinder"></i>
          <div>
            <div class="count">42+</div>
            <div class="label">orang beli info hari ini</div>
          </div>
        </div>
        <div class="hero-float-badge hero-float-badge--top">
          <i class="fa-solid fa-shield-halved"></i>
          <div>
            <div class="count">500+</div>
            <div class="label">kost terverifikasi</div>
          </div>
        </div>
        <div class="hero-float-badge hero-float-badge--right">
          <i class="fa-solid fa-star"></i>
          <div>
            <div class="count">4.9</div>
            <div class="label">rating kepuasan</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== KOTA ========== -->
<section class="section" style="padding-top: 40px;">
  <div class="container">
    <div class="section-header fade-in">
      <h2>Pilih Kotamu</h2>
      <p>Kami beroperasi di 3 kota besar Jawa Timur &amp; DIY. Pilih kota untuk mulai cari kost!</p>
    </div>
    <div class="city-grid">
      @foreach($cities as $city)
      <a href="{{ route('kost.byCity', $city->slug) }}" class="city-card fade-in">
        <img src="{{ asset($city->image ?? 'assets/img/city-malang.png') }}" alt="Kost di {{ $city->name }}">
        <div class="city-card-overlay">
          <h3>{{ $city->name }}</h3>
          <p>{{ $city->kosts_count }}+ kost tersedia</p>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<!-- ========== KOST PILIHAN (FEATURED) ========== -->
@if($featuredKosts->count() > 0)
<section class="section" style="background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);">
  <div class="container">
    <div class="section-header fade-in">
      <div style="display:inline-flex;align-items:center;gap:8px;margin-bottom:8px;">
        <span class="badge badge-featured"><i class="fa-solid fa-crown" style="font-size:0.65rem;"></i> Pilihan Premium</span>
      </div>
      <h2>Kost Pilihan</h2>
      <p>Kost premium yang dipilih khusus oleh tim mawkost untuk kamu</p>
    </div>
    <div class="listing-grid">
      @foreach($featuredKosts as $kost)
        <x-kost-card :kost="$kost" />
      @endforeach
    </div>
    <div style="text-align: center; margin-top: 40px;" class="fade-in">
      <a href="{{ route('kost.search') }}?featured=1" class="btn btn-outline" style="background:white;">Lihat Semua Kost Pilihan</a>
    </div>
  </div>
</section>
@endif

<!-- ========== REKOMENDASI KOST ========== -->
<section class="section" style="background: var(--primary-lighter);">
  <div class="container">
    <div class="section-header fade-in">
      <h2>Rekomendasi Kost</h2>
      <p>Kost paling banyak dicari dan direkomendasikan oleh tim mawkost</p>
    </div>
    <div class="listing-grid">
      @foreach($recommendedKosts as $kost)
        <x-kost-card :kost="$kost" />
      @endforeach
    </div>
    <div style="text-align: center; margin-top: 40px;" class="fade-in">
      <a href="{{ route('kost.search') }}?rekomendasi=1" class="btn btn-outline" style="background:white;">Lihat Semua Rekomendasi</a>
    </div>
  </div>
</section>

<!-- ========== HOW IT WORKS ========== -->
<section id="cara-kerja" class="section steps-section">
  <div class="blob blob-1"></div>
  <div class="container">
    <div class="section-header fade-in">
      <h2>Cuma Butuh 3 Langkah</h2>
      <p>Anti ribet, anti calo bodong, 100% transparan</p>
    </div>

    <div class="steps-grid fade-in" style="animation-delay: 0.2s;">
      <!-- Step 1 -->
      <div class="step-card-inner">
        <div class="step-badge">100% Online</div>
        <div class="step-icon-wrap">
          <div class="step-icon">
            <i class="fa-solid fa-mobile-screen-button" style="font-size: 1.5rem;"></i>
          </div>
          <div class="step-number">1</div>
        </div>
        <h4 style="color:var(--primary-dark);">Pilih & Bandingkan</h4>
        <p>Lihat foto kamar, harga, & fasilitas tanpa harus keliling lokasi.</p>
      </div>
      
      <!-- Step 2 -->
      <div class="step-card-inner">
        <div class="step-badge step-badge--success">Aman</div>
        <div class="step-icon-wrap">
          <div class="step-icon step-icon--success">
            <i class="fa-solid fa-lock" style="font-size: 1.5rem;"></i>
          </div>
          <div class="step-number step-number--success">2</div>
        </div>
        <h4 style="color:var(--primary-dark);">Buka Kontak (Rp 35k)</h4>
        <p>Bayar biaya super admin via QRIS untuk tahu alamat & WA pemilik.</p>
      </div>
      
      <!-- Step 3 -->
      <div class="step-card-inner">
        <div class="step-badge">Tanpa Calo</div>
        <div class="step-icon-wrap">
          <div class="step-icon step-icon--accent">
            <i class="fa-solid fa-handshake" style="font-size: 1.5rem;"></i>
          </div>
          <div class="step-number step-number--accent">3</div>
        </div>
        <h4 style="color:var(--primary-dark);">Booking Langsung</h4>
        <p>Chat langsung dengan pemilik (tanpa lewat kami) untuk booking atau DP.</p>
      </div>
    </div>
  </div>
</section>

<!-- ========== DATA KOST TERBARU ========== -->
<section class="section">
  <div class="container">
    <div class="section-header fade-in">
      <h2>Data Kost Terbaru</h2>
      <p>Pilihan kost terbaru yang baru saja ditambahkan di mawkost</p>
    </div>
    <div class="listing-grid">
      @foreach($recentKosts as $kost)
        <x-kost-card :kost="$kost" />
      @endforeach
    </div>
    <div style="text-align: center; margin-top: 40px;" class="fade-in">
      <a href="{{ route('kost.search') }}?sort=terbaru" class="btn btn-outline">Lihat Semua Kost Terbaru</a>
    </div>
  </div>
</section>

@endsection
