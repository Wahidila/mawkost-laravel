@extends('layouts.app')

@section('title', 'Tentang Kami — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <span class="current">Tentang Kami</span>
      </div>
      <div class="fade-in" style="padding-bottom: 32px;">
        <h1 style="font-size: 2rem;">Mengenal mawkost Lebih Dekat</h1>
        <p class="text-muted" style="margin-top: 8px;">Transparansi, kemudahan, dan keamanan adalah komitmen kami untuk anak rantau.</p>
      </div>
    </div>
</div>

<!-- ========== MAIN CONTENT ========== -->
<section class="section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="container">
      
      <div style="display: grid; grid-template-columns: 1fr; gap: 48px; @media(min-width: 768px) { grid-template-columns: 1fr 1fr; }">
        
        <!-- Kolom Kiri -->
        <div class="fade-in">
          <h2 style="font-size: 1.75rem; margin-bottom: 24px;">Cerita Kami</h2>
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

        <!-- Kolom Kanan -->
        <div class="fade-in" style="animation-delay: 0.1s;">
          <img src="{{ asset('assets/img/kost-room.png') }}" alt="Tim Mawkost" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin-bottom: 24px;">
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div style="background: var(--primary-lighter); padding: 20px; border-radius: var(--radius); text-align: center;">
              <h3 style="font-size: 2rem; color: var(--primary-dark); margin-bottom: 8px;">500+</h3>
              <p style="font-size: 0.9rem; color: var(--text-muted); font-weight: 500;">Kost Tervalidasi</p>
            </div>
            <div style="background: var(--primary-lighter); padding: 20px; border-radius: var(--radius); text-align: center;">
              <h3 style="font-size: 2rem; color: var(--primary-dark); margin-bottom: 8px;">0%</h3>
              <p style="font-size: 0.9rem; color: var(--text-muted); font-weight: 500;">Biaya Markup/Komisi</p>
            </div>
          </div>
        </div>

      </div>

      <hr style="margin: 60px 0; border: 0; border-top: 1px solid var(--border-light);">

      <!-- Nilai Inti -->
      <div style="text-align: center; margin-bottom: 40px;" class="fade-in">
        <h2 style="font-size: 1.75rem;">Nilai Inti Kami</h2>
      </div>

      <div class="steps-grid fade-in">
        <div class="step-card" style="background: white;">
          <div class="step-icon" style="background: #e6f4ea; color: var(--success);">
            <i class="fa-solid fa-shield-halved"></i>
          </div>
          <h4>Autentik & Validasi Real</h4>
          <p>Setiap foto, fasilitas, dan detail yang kami pajang telah diverifikasi langsung kebenarannya dengan pemilik properti.</p>
        </div>
        <div class="step-card" style="background: white;">
          <div class="step-icon" style="background: var(--primary-lighter); color: var(--primary);">
            <i class="fa-solid fa-wallet"></i>
          </div>
          <h4>Harga Jujur Tanpa Markup</h4>
          <p>Anda membayar harga persis sama (bahkan kadang lebih murah karena promo) seperti saat Anda datang langsung ke ibu kost.</p>
        </div>
        <div class="step-card" style="background: white;">
          <div class="step-icon" style="background: #fff0eb; color: var(--cta);">
            <i class="fa-solid fa-people-group"></i>
          </div>
          <h4>Komunitas Terbuka</h4>
          <p>Kami rutin mengundang feedback dari pencari dan pemilik kost untuk terus memperbaiki ekosistem sewa properti ini.</p>
        </div>
      </div>

    </div>
</section>
@endsection
