@extends('layouts.app')

@section('title', 'Hubungi Kami — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <span class="current">Kontak</span>
      </div>
      <div class="fade-in" style="padding-bottom: 32px;">
        <h1>Hubungi Kami</h1>
        <p class="text-muted" style="margin-top: 8px;">Ada pertanyaan, saran, atau butuh bantuan mendaftarkan properti? Tim mawkost siap membantu.</p>
      </div>
    </div>
</div>

<section class="section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="fade-in">
                <div class="contact-card">
                    <h3 style="margin-bottom: 24px; font-size: 1.25rem;">Informasi Kontak</h3>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4>Alamat Kantor</h4>
                            <p>JL. PULAU BATAM NO. 12<br>Desa/Kelurahan Dauh Puri Kelod<br>Kec. Denpasar Barat, Kota Denpasar<br>Provinsi Bali, Kode Pos: 80114</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h4>WhatsApp</h4>
                            <p><a href="tel:+6282337985404">+62 823-3798-5404</a></p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p><a href="mailto:maw.kost198@gmail.com">maw.kost198@gmail.com</a></p>
                        </div>
                    </div>

                    <div style="margin-top: 32px; padding-top: 20px; border-top: 1px solid var(--border-light);">
                        <h4 style="margin-bottom: 12px;">Jam Operasional</h4>
                        <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">
                            Senin - Jumat: 08.00 - 20.00 WIB<br>
                            Sabtu - Minggu: 09.00 - 15.00 WIB<br>
                            <i>*CS interaktif melalui WhatsApp</i>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="fade-in" style="animation-delay: 0.1s;">
                <div class="contact-card" style="padding: 32px;">
                    <h2 style="margin-bottom: 24px; font-size: 1.5rem;">Kirim Pesan</h2>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span style="color: var(--danger)">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Cth: Budi Santoso" value="{{ old('name') }}" required>
                            @error('name')<div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Alamat Email <span style="color: var(--danger)">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Cth: budi@gmail.com" value="{{ old('email') }}" required>
                                @error('email')<div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="whatsapp">No. WhatsApp</label>
                                <input type="tel" id="whatsapp" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" placeholder="Cth: 081234567890" value="{{ old('whatsapp') }}">
                                @error('whatsapp')<div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subjek / Topik <span style="color: var(--danger)">*</span></label>
                            <select id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" required>
                                <option value="">-- Pilih Topik --</option>
                                <option value="Bantuan Pencarian Kost" {{ old('subject') == 'Bantuan Pencarian Kost' ? 'selected' : '' }}>Bantuan Pencarian Kost</option>
                                <option value="Kendala Transaksi/Pembayaran" {{ old('subject') == 'Kendala Transaksi/Pembayaran' ? 'selected' : '' }}>Kendala Transaksi / Pembayaran</option>
                                <option value="Daftar Mitra Pemilik Kost" {{ old('subject') == 'Daftar Mitra Pemilik Kost' ? 'selected' : '' }}>Daftar Mitra Pemilik Kost</option>
                                <option value="Kerjasama Bisnis" {{ old('subject') == 'Kerjasama Bisnis' ? 'selected' : '' }}>Kerjasama Bisnis</option>
                                <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('subject')<div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="message">Pesan Anda <span style="color: var(--danger)">*</span></label>
                            <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Tuliskan secara detail pesan atau kendala Anda di sini..." required>{{ old('message') }}</textarea>
                            @error('message')<div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px;">Kirim Pesan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
