@extends('layouts.app')

@section('title', 'Terms of Service — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <span class="current">Terms of Service</span>
      </div>
      <div class="fade-in" style="padding-bottom: 32px;">
        <h1>Terms of Service</h1>
        <p class="text-muted" style="margin-top: 8px;">Syarat dan ketentuan penggunaan platform mawkost.id</p>
      </div>
    </div>
</div>

<!-- ========== TOS CONTENT ========== -->
<section class="section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="container">
      <div class="tos-wrapper fade-in">

        <!-- Intro -->
        <div class="tos-intro">
          <p>Selamat datang di <strong>mawkost.id</strong>! Sebelum kamu lanjut mencari kos impianmu di Malang, tolong baca sebentar "kontrak persahabatan" kita di bawah ini. Dengan menggunakan platform kami, berarti kamu setuju dengan aturan main berikut:</p>
        </div>

        <!-- Section 1 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">1</span>
            <h3>Semangat Kami: Anti-Calo & Kejujuran</h3>
          </div>
          <p>mawkost.id dibangun untuk memberantas praktik calo bodong. Kamu dilarang keras menggunakan platform ini jika kamu adalah agen/perantara yang bertujuan mengambil keuntungan sepihak atau menaikkan harga di luar harga asli pemilik kos. Kami berhak memblokir akun yang terindikasi sebagai calo.</p>
        </div>

        <!-- Section 2 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">2</span>
            <h3>Sistem "Pay to Unlock Info"</h3>
          </div>
          <p>Untuk menjaga privasi pemilik kos dan memastikan hanya pencari serius yang menghubungi, kami menggunakan sistem buka kunci informasi (Unlock Info).</p>
          <ul class="tos-list">
            <li><strong>Biaya:</strong> Sebesar Rp 35.000,- (atau nominal yang tertera saat transaksi).</li>
            <li><strong>Fungsi:</strong> Biaya ini digunakan untuk mengakses nomor WhatsApp/kontak langsung pemilik kos dan detail lokasi spesifik.</li>
            <li><strong>Status:</strong> Biaya ini adalah biaya akses informasi, bukan uang muka (DP) kos, dan tidak mengurangi harga sewa kos nantinya.</li>
          </ul>
        </div>

        <!-- Section 3 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">3</span>
            <h3>Keakuratan Data</h3>
          </div>
          <p>Kami berusaha 100% untuk melakukan verifikasi data. Namun, perlu dipahami bahwa:</p>
          <ul class="tos-list">
            <li>Foto dan deskripsi fasilitas disediakan oleh pemilik kos atau mitra lapangan kami saat pengambilan data.</li>
            <li>Ketersediaan kamar (availability) bisa berubah sewaktu-waktu. Kami sangat menyarankan kamu untuk segera menghubungi pemilik setelah melakukan unlock info.</li>
            <li>Mawkost.id tidak bertanggung jawab atas perubahan harga atau fasilitas yang dilakukan secara mendadak oleh pemilik kos tanpa pemberitahuan kepada kami.</li>
          </ul>
        </div>

        <!-- Section 4 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">4</span>
            <h3>Kebijakan Pengembalian Dana (Refund)</h3>
          </div>
          <p>Karena produk yang kamu beli adalah informasi digital yang langsung terbuka seketika:</p>
          <ul class="tos-list">
            <li><strong>Pembayaran yang sudah berhasil tidak dapat dibatalkan atau diuangkan kembali.</strong></li>
            <li><strong>Pengecualian:</strong> Jika nomor kontak pemilik kos terbukti tidak aktif atau kos sudah penuh dalam waktu kurang dari 24 jam setelah kamu melakukan unlock, silakan hubungi Admin dengan bukti yang jelas untuk mendapatkan saldo/akses ganti kos lain.</li>
          </ul>
        </div>

        <!-- Section 5 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">5</span>
            <h3>Privasi & Keamanan</h3>
          </div>
          <ul class="tos-list">
            <li><strong>Pencari Kos:</strong> Kami menjaga data pribadimu dan tidak akan menjualnya ke pihak ketiga.</li>
            <li><strong>Pemilik Kos:</strong> Dengan mendaftarkan kosmu, kamu setuju nomor WhatsApp-mu diberikan kepada pengguna yang telah membayar biaya unlock. Ini adalah sistem penyaring agar kamu tidak terkena spam dari orang tidak bertanggung jawab.</li>
          </ul>
        </div>

        <!-- Section 6 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">6</span>
            <h3>Transaksi di Luar Platform</h3>
          </div>
          <p>Mawkost.id hanya berperan sebagai penyedia informasi dan penghubung. Segala bentuk transaksi pembayaran kos (DP atau pelunasan) dilakukan langsung antara kamu dan pemilik kos. Kami sangat menyarankan untuk melakukan survei lokasi (atau video call) sebelum mengirimkan uang dalam jumlah besar.</p>
        </div>

        <!-- Section 7 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">7</span>
            <h3>Perubahan Aturan</h3>
          </div>
          <p>Dunia startup bergerak cepat, begitu juga kami. Mawkost.id berhak mengubah poin-poin dalam ToS ini kapan saja untuk kenyamanan bersama. Kamu akan kami beri tahu jika ada perubahan signifikan.</p>
        </div>

        <!-- Footer -->
        <div class="tos-footer">
          <p>Terakhir diperbarui: <strong>April 2026</strong></p>
          <p style="color: var(--primary); font-weight: 600;">Mawkost.id – Cari Kos Jujur, Gak Pake Ribet.</p>
        </div>

      </div>
    </div>
</section>
@endsection
