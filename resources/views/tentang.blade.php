@extends('layouts.app')

@section('title', 'Tentang Kami — mawkost')
@section('meta_description', 'Kenali mawkost lebih dekat. Platform pencarian kost terpercaya yang mengutamakan transparansi, kemudahan, dan keamanan untuk anak rantau di Malang, Jogja, dan Surabaya.')
@section('og_title', 'Tentang Kami — mawkost')
@section('og_description', 'Kenali mawkost lebih dekat. Platform pencarian kost terpercaya yang mengutamakan transparansi, kemudahan, dan keamanan untuk anak rantau.')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <span class="current">Tentang Kami</span>
      </div>
      <div class="fade-in" style="padding-bottom: 32px;">
        <h1>Mengenal mawkost Lebih Dekat</h1>
        <p class="text-muted" style="margin-top: 8px;">Transparansi, kemudahan, dan keamanan adalah komitmen kami untuk anak rantau.</p>
      </div>
    </div>
</div>

<!-- ========== MAIN CONTENT ========== -->
<section class="section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="container">

      <div class="about-grid">

        <!-- Kolom Kiri: Cerita -->
        <div class="fade-in">
          <h2 style="margin-bottom: 24px;">Cerita Kami</h2>
          <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 16px;">
            Berawal dari keresahan para mahasiswa baru dan anak rantau yang seringkali tertipu calo kost bodong di berbagai grup WhatsApp atau Facebook. Seringkali foto yang ditampilkan tidak sesuai realita, harga yang jauh lebih mahal dari aslinya, hingga hilangnya uang muka (DP) yang dibawa kabur agen tak bertanggung jawab.
          </p>
          <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 16px;">
            <strong>mawkost</strong> lahir dari sebuah project rintisan anak-anak mahasiswa Malang pada tahun 2023. Tujuan kami sederhana: Membuat platform pencarian kos yang <span style="color: var(--primary-dark); font-weight: 600;">100% jujur, anti-calo, dan harganya transparan langsung dari ibu kost.</span>
          </p>
          <p style="color: var(--text-muted); line-height: 1.8;">
            Kami memiliki model "Pay to Unlock Info" yang sangat murah (hanya Rp 15k). Sistem ini melindungi privasi nomor WhatsApp pemilik kost dari spam, sekaligus menyaring agar hanya pencari serius yang menghubungi mereka. Berbeda dengan agen konvensional yang memotong komisi bulanan tinggi, model ini terbukti membuat harga kost kami <strong>lebih murah di pasaran.</strong>
          </p>
        </div>

        <!-- Kolom Kanan: Gambar + Statistik -->
        <div class="fade-in" style="animation-delay: 0.1s;">
          <img src="{{ asset('assets/img/kost-room.png') }}" alt="Kamar Kost Mawkost" loading="lazy"
               style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin-bottom: 24px;">

          <div class="about-stats">
            <div class="stat-card">
              <h3>500+</h3>
              <p>Kost Tervalidasi</p>
            </div>
            <div class="stat-card">
              <h3>0%</h3>
              <p>Biaya Markup/Komisi</p>
            </div>
          </div>
        </div>

      </div>

      <hr style="margin: 60px 0; border: 0; border-top: 1px solid var(--border-light);">

      <!-- ========== NILAI INTI ========== -->
      <div class="section-header fade-in">
        <h2>Nilai Inti Kami</h2>
        <p>Prinsip yang menjadi fondasi setiap keputusan kami.</p>
      </div>

      <div class="nilai-inti-grid fade-in">
        <div class="nilai-inti-card">
          <div class="nilai-inti-icon" style="background: linear-gradient(135deg, #e6f4ea 0%, #d4edda 100%);">
            <i class="fa-solid fa-shield-halved" style="color: var(--success);"></i>
          </div>
          <div class="nilai-inti-body">
            <h4>Autentik & Validasi Real</h4>
            <p>Setiap foto, fasilitas, dan detail yang kami pajang telah diverifikasi langsung kebenarannya dengan pemilik properti.</p>
          </div>
        </div>
        <div class="nilai-inti-card">
          <div class="nilai-inti-icon" style="background: linear-gradient(135deg, var(--primary-lighter) 0%, #edd5c4 100%);">
            <i class="fa-solid fa-wallet" style="color: var(--primary);"></i>
          </div>
          <div class="nilai-inti-body">
            <h4>Harga Jujur Tanpa Markup</h4>
            <p>Anda membayar harga persis sama (bahkan kadang lebih murah karena promo) seperti saat Anda datang langsung ke ibu kost.</p>
          </div>
        </div>
        <div class="nilai-inti-card">
          <div class="nilai-inti-icon" style="background: linear-gradient(135deg, #fff0eb 0%, #ffe0d4 100%);">
            <i class="fa-solid fa-people-group" style="color: var(--cta);"></i>
          </div>
          <div class="nilai-inti-body">
            <h4>Komunitas Terbuka</h4>
            <p>Kami rutin mengundang feedback dari pencari dan pemilik kost untuk terus memperbaiki ekosistem sewa properti ini.</p>
          </div>
        </div>
      </div>

      <hr style="margin: 60px 0; border: 0; border-top: 1px solid var(--border-light);">

      <!-- ========== VISI & MISI ========== -->
      <div class="section-header fade-in">
        <h2>Visi & Misi</h2>
        <p>Arah dan langkah yang membimbing perjalanan mawkost.</p>
      </div>

      <div class="visi-misi-grid fade-in">
        <div class="visi-misi-card">
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <div class="step-icon" style="background: var(--primary-lighter); color: var(--primary); width: 48px; height: 48px; font-size: 1.2rem; margin-bottom: 0;">
              <i class="fa-solid fa-eye"></i>
            </div>
            <h3 style="margin-bottom: 0;">Visi</h3>
          </div>
          <p>Menjadi platform terpercaya dalam pencarian, survei, dan promosi kost di Indonesia yang menghubungkan pencari kost dan pemilik kost secara cepat, mudah, dan transparan.</p>
        </div>

        <div class="visi-misi-card">
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <div class="step-icon" style="background: #fff0eb; color: var(--cta); width: 48px; height: 48px; font-size: 1.2rem; margin-bottom: 0;">
              <i class="fa-solid fa-bullseye"></i>
            </div>
            <h3 style="margin-bottom: 0;">Misi</h3>
          </div>
          <ul>
            <li>Membantu pencari kost menemukan hunian ideal tanpa harus datang langsung.</li>
            <li>Menyediakan layanan survei kost yang jujur dan informatif melalui konten visual.</li>
            <li>Meningkatkan visibilitas kost milik pemilik properti melalui strategi promosi kreatif di media sosial.</li>
            <li>Menghadirkan pengalaman mencari kost yang efisien, aman, dan sesuai kebutuhan pengguna.</li>
          </ul>
        </div>
      </div>

      <hr style="margin: 60px 0; border: 0; border-top: 1px solid var(--border-light);">

      <!-- ========== TEAM ========== -->
      <div class="section-header fade-in">
        <h2>Meet Our Professional Team</h2>
        <p>Orang-orang di balik misi mawkost untuk anak rantau Indonesia.</p>
      </div>

      <div class="team-grid fade-in">
        @forelse($teamMembers as $member)
        <div class="team-card">
          @if($member->photo_url)
            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-avatar-img" loading="lazy">
          @else
            <div class="team-avatar">{{ $member->initials }}</div>
          @endif
          <h4>{{ $member->name }}</h4>
          <p>{{ $member->position }}</p>
        </div>
        @empty
        <div class="team-card">
          <div class="team-avatar">M</div>
          <h4>Tim Mawkost</h4>
          <p>Segera hadir</p>
        </div>
        @endforelse
      </div>

    </div>
</section>
@endsection
