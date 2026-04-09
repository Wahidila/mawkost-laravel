@extends('layouts.app')

@section('title', 'Kebijakan Pengembalian Dana — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <span class="current">Kebijakan Pengembalian Dana</span>
      </div>
      <div class="fade-in" style="padding-bottom: 32px;">
        <h1>Kebijakan Pengembalian Dana (Refund Policy)</h1>
        <p class="text-muted" style="margin-top: 8px;">Di mawkost.id, kepuasan kamu adalah prioritas kami. Kami ingin memastikan setiap rupiah yang kamu keluarkan sebanding dengan informasi yang kamu dapatkan. Karena layanan kami melibatkan akses ke informasi digital yang bersifat instan, berikut adalah aturan main mengenai pengembalian dana.</p>
      </div>
    </div>
</div>

<!-- ========== REFUND POLICY CONTENT ========== -->
<section class="section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="container">
      <div class="tos-wrapper fade-in">

        <!-- Section 1 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">1</span>
            <h3>Prinsip Dasar Produk Digital</h3>
          </div>
          <p>Harap dipahami bahwa biaya Rp 35.000,- yang kamu bayarkan adalah untuk "Membuka Informasi" (Unlock Info). Begitu data pemilik kos terbuka di layar kamu, layanan dianggap telah diberikan secara penuh. Oleh karena itu, dana tidak dapat dikembalikan jika alasan pembatalan bersifat subjektif (contoh: berubah pikiran, sudah dapat kos lain di tempat berbeda, atau tidak jadi survei).</p>
        </div>

        <!-- Section 2 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">2</span>
            <h3>Kondisi yang Memenuhi Syarat Refund/Ganti Akses</h3>
          </div>
          <p>Kami akan dengan senang hati bertanggung jawab jika terjadi kendala teknis atau ketidakakuratan data, seperti:</p>
          <ul class="tos-list">
            <li><strong>Kos Sudah Penuh:</strong> Kamu melakukan unlock info, namun saat dihubungi di hari yang sama, pemilik kos menyatakan kamar sudah penuh (dan tim kami memverifikasi hal tersebut).</li>
            <li><strong>Nomor Tidak Aktif:</strong> Nomor WhatsApp pemilik kos yang diberikan tidak dapat dihubungi atau salah sambung.</li>
            <li><strong>Double Payment:</strong> Terjadi kesalahan sistem yang menyebabkan saldo terpotong dua kali untuk satu kos yang sama.</li>
          </ul>
        </div>

        <!-- Section 3 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">3</span>
            <h3>Mekanisme Pengembalian (Solusi Terbaik)</h3>
          </div>
          <p>Mengingat biaya admin transfer antar-bank seringkali cukup tinggi dibandingkan nilai transaksi (Rp 35k), kami menawarkan dua opsi solusi:</p>
          <ul class="tos-list">
            <li><strong>Opsi A (Sangat Disarankan):</strong> Kami akan memberikan Akses Gratis (Voucher) untuk membuka 1 info kos lain pilihanmu secara gratis sebagai pengganti.</li>
            <li><strong>Opsi B (Refund Tunai):</strong> Pengembalian dana secara tunai hanya akan diproses melalui e-wallet (DANA/OVO/GoPay/ShopeePay) untuk menghindari biaya admin bank.</li>
          </ul>
        </div>

        <!-- Section 4 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">4</span>
            <h3>Cara Melakukan Klaim</h3>
          </div>
          <p>Jika kamu mengalami kendala di atas, jangan panik! Cukup hubungi Admin kami melalui WhatsApp dengan melampirkan:</p>
          <ul class="tos-list">
            <li>Screenshot Bukti Bayar (dari email atau aplikasi).</li>
            <li>Nama Kos yang kamu buka.</li>
            <li>Bukti Kendala (contoh: screenshot chat WhatsApp dengan pemilik kos yang menyatakan sudah penuh).</li>
          </ul>
        </div>

        <!-- Section 5 -->
        <div class="tos-section">
          <div class="tos-section-header">
            <span class="tos-number">5</span>
            <h3>Batas Waktu Klaim</h3>
          </div>
          <p>Laporan kendala harus dikirimkan maksimal <strong>1x24 jam</strong> setelah kamu melakukan transaksi unlock info. Laporan yang masuk setelah melewati batas waktu tersebut tidak dapat kami proses.</p>
        </div>

        <!-- Footer / Contact -->
        <div class="tos-footer" style="text-align: left; background: var(--surface); padding: 24px; border-radius: 12px; border: 1px solid var(--border-light); margin-top: 40px;">
          <h4 style="margin-bottom: 16px;">Kontak Kami</h4>
          <p style="margin-bottom: 8px;">Jika ada pertanyaan mengenai kebijakan privasi atau pengembalian dana ini, kamu bisa menghubungi tim mawkost di:</p>
          <p style="margin-bottom: 4px;"><strong>Email:</strong> admin@mawkost.id</p>
          <p style="margin-bottom: 16px;"><strong>WhatsApp:</strong> +62 821-2222-3333</p>
          <p class="text-muted" style="font-size: 0.9em;">Terakhir diperbarui: April 2026</p>
        </div>

      </div>
    </div>
</section>
@endsection
