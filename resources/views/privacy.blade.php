@extends('layouts.app')

@section('title', 'Kebijakan Privasi — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <span class="current">Kebijakan Privasi</span>
      </div>
      <div class="fade-in" style="padding-bottom: 32px;">
        <h1>Kebijakan Privasi mawkost.id</h1>
        <p class="text-muted" style="margin-top: 8px;">Di mawkost.id, kami sangat menghargai privasi kamu. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan menjaga informasi pribadi kamu saat menggunakan platform kami untuk mencari atau menawarkan kos.</p>
      </div>
    </div>
</div>

<!-- ========== PRIVACY POLICY CONTENT ========== -->
<section class="section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="container">
      <div class="tos-wrapper fade-in">

        <!-- Section 1 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">1</span>
            <h3>Informasi yang Kami Kumpulkan</h3>
          </div>
          <p>Untuk memberikan layanan terbaik, kami mengumpulkan beberapa data berikut:</p>
          <ul class="tos-list">
            <li><strong>Data Akun:</strong> Nama, alamat email, dan nomor WhatsApp (untuk keperluan koordinasi dan verifikasi).</li>
            <li><strong>Data Pencarian:</strong> Riwayat pencarian kos untuk membantu kami memberikan rekomendasi yang lebih relevan.</li>
            <li><strong>Data Pembayaran:</strong> Saat kamu melakukan transaksi "Unlock Info", data pembayaran diproses melalui payment gateway pihak ketiga yang aman. Kami tidak menyimpan informasi kartu kredit atau detail perbankan pribadi kamu di server kami.</li>
            <li><strong>Data Kos (untuk Pemilik):</strong> Foto, alamat, harga, dan fasilitas kos yang kamu daftarkan.</li>
          </ul>
        </div>

        <!-- Section 2 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">2</span>
            <h3>Penggunaan Informasi</h3>
          </div>
          <p>Kami menggunakan data kamu untuk:</p>
          <ul class="tos-list">
            <li>Menghubungkan pencari kos dengan pemilik secara langsung.</li>
            <li>Memproses transaksi pembayaran akses informasi secara cepat dan aman.</li>
            <li>Melakukan verifikasi untuk memastikan tidak ada "calo" atau akun bodong di platform kami.</li>
            <li>Memberikan notifikasi terkait status pesanan atau info kos terbaru di Malang.</li>
          </ul>
        </div>

        <!-- Section 3 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">3</span>
            <h3>Keamanan Data & Privasi Nomor WhatsApp</h3>
          </div>
          <p>Kami mengerti bahwa nomor WhatsApp adalah privasi sensitif.</p>
          <ul class="tos-list">
            <li><strong>Untuk Pencari:</strong> Nomor kamu hanya akan diketahui oleh sistem dan admin untuk keperluan bantuan.</li>
            <li><strong>Untuk Pemilik:</strong> Nomor WhatsApp kamu diproteksi di balik sistem "Pay to Unlock". Ini memastikan bahwa hanya orang yang benar-benar serius mencari kos yang bisa menghubungi kamu, sehingga meminimalisir gangguan spam atau penipuan.</li>
          </ul>
        </div>

        <!-- Section 4 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">4</span>
            <h3>Berbagi Informasi dengan Pihak Ketiga</h3>
          </div>
          <p>Kami tidak menjual, menyewakan, atau menukar data pribadi kamu kepada pihak luar. Kami hanya membagi informasi dengan:</p>
          <ul class="tos-list">
            <li><strong>Pemilik Kos:</strong> Hanya jika kamu telah melakukan "Unlock Info" untuk memulai komunikasi.</li>
            <li><strong>Penyedia Layanan Pembayaran:</strong> Untuk memvalidasi transaksi yang kamu lakukan secara resmi.</li>
            <li><strong>Otoritas Hukum:</strong> Jika diwajibkan oleh undang-undang yang berlaku di Indonesia.</li>
          </ul>
        </div>

        <!-- Section 5 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">5</span>
            <h3>Cookies & Teknologi Pelacakan</h3>
          </div>
          <p>Kami menggunakan cookies sederhana untuk mengingat preferensi pencarian kamu dan memastikan kamu tidak perlu login berulang kali dalam waktu singkat. Kamu bisa mengatur browser untuk menolak cookies, namun beberapa fitur mawkost mungkin menjadi tidak maksimal.</p>
        </div>

        <!-- Section 6 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">6</span>
            <h3>Hak Kamu atas Data</h3>
          </div>
          <p>Kamu berhak untuk:</p>
          <ul class="tos-list">
            <li>Meminta penghapusan akun dan data pribadi kamu dari sistem kami.</li>
            <li>Memperbarui informasi profil atau detail kos yang kamu kelola.</li>
            <li>Menghubungi admin jika merasa ada penggunaan data yang tidak sesuai.</li>
          </ul>
        </div>

        <!-- Section 7 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">7</span>
            <h3>Perubahan Kebijakan Privasi</h3>
          </div>
          <p>Kami dapat memperbarui kebijakan ini sewaktu-waktu mengikuti perkembangan layanan kami. Perubahan akan selalu kami tampilkan di halaman ini dengan tanggal pembaruan terbaru.</p>
        </div>

        <!-- Footer / Contact -->
        <div class="tos-footer" style="text-align: left; background: var(--surface); padding: 24px; border-radius: 12px; border: 1px solid var(--border-light); margin-top: 40px;">
          <h4 style="margin-bottom: 16px;">Kontak Kami</h4>
          <p style="margin-bottom: 8px;">Jika ada pertanyaan mengenai kebijakan privasi ini, kamu bisa menghubungi tim mawkost di:</p>
          <p style="margin-bottom: 4px;"><strong>Email:</strong> admin@mawkost.id</p>
          <p style="margin-bottom: 16px;"><strong>WhatsApp:</strong> +6282337985404 / +6282146613332</p>
          <p class="text-muted" style="font-size: 0.9em;">Terakhir diperbarui: April 2026</p>
        </div>

      </div>
    </div>
</section>
@endsection
