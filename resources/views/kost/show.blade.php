@extends('layouts.app')

@section('title', $kost->name . ' — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">/</span>
        <a href="{{ route('kost.search') }}">Cari Kost</a>
        <span class="sep">/</span>
        <a href="{{ route('kost.byCity', $kost->city->slug) }}">{{ $kost->city->name }}</a>
        <span class="sep">/</span>
        <span class="current">{{ $kost->name }}</span>
      </div>
    </div>
</div>

<!-- ========== MAIN CONTENT ========== -->
<section class="section" style="padding-top: 32px;">
    <div class="container">

        <!-- Gallery -->
        <div class="gallery fade-in">
            @php 
                $images = $kost->images; 
                $mainImg = $images->count() > 0 ? asset($images[0]->image_path) : asset('assets/img/kost-1.png');
                $sideImg1 = $images->count() > 1 ? asset($images[1]->image_path) : asset('assets/img/kost-room.png');
                $sideImg2 = $images->count() > 2 ? asset($images[2]->image_path) : asset('assets/img/kost-bathroom.png');
            @endphp
            <div class="gallery-main" onclick="openLightbox(0)">
                <img src="{{ $mainImg }}" alt="{{ $kost->name }}">
            </div>
            <div class="gallery-side">
                <div class="gallery-thumb" onclick="openLightbox(1)">
                    <img src="{{ $sideImg1 }}" alt="Kamar Kost">
                </div>
                <div class="gallery-thumb gallery-more" onclick="openLightbox(2)">
                    <img src="{{ $sideImg2 }}" alt="Kamar Mandi Kost">
                    <div class="gallery-more-overlay">
                        <i class="fa-solid fa-images"></i>
                        <span>Lihat Semua Foto</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div class="lightbox" id="lightbox">
            <button class="lightbox-close" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></button>
            <button class="lightbox-nav lightbox-prev" onclick="changeLightbox(-1)"><i class="fa-solid fa-chevron-left"></i></button>
            <img class="lightbox-img" id="lightboxImg" src="" alt="Gallery Image">
            <button class="lightbox-nav lightbox-next" onclick="changeLightbox(1)"><i class="fa-solid fa-chevron-right"></i></button>
            <div class="lightbox-counter" id="lightboxCounter">1 / {{ max($images->count(), 3) }}</div>
        </div>

        @push('scripts')
        <script>
            const galleryImages = [
                @foreach($images as $img)
                    '{{ asset($img->image_path) }}',
                @endforeach
                @if($images->isEmpty())
                    '{{ asset('assets/img/kost-1.png') }}',
                    '{{ asset('assets/img/kost-room.png') }}',
                    '{{ asset('assets/img/kost-bathroom.png') }}'
                @endif
            ];
            let currentImg = 0;
            function openLightbox(index) {
                if(index >= galleryImages.length) index = galleryImages.length - 1;
                currentImg = index;
                document.getElementById('lightboxImg').src = galleryImages[currentImg];
                document.getElementById('lightboxCounter').textContent = (currentImg + 1) + ' / ' + galleryImages.length;
                document.getElementById('lightbox').classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            function closeLightbox() {
                document.getElementById('lightbox').classList.remove('active');
                document.body.style.overflow = '';
            }
            function changeLightbox(dir) {
                currentImg = (currentImg + dir + galleryImages.length) % galleryImages.length;
                document.getElementById('lightboxImg').src = galleryImages[currentImg];
                document.getElementById('lightboxCounter').textContent = (currentImg + 1) + ' / ' + galleryImages.length;
            }
            document.getElementById('lightbox').addEventListener('click', function (e) {
                if (e.target === this) closeLightbox();
            });
        </script>
        @endpush

        <!-- Info Grid layout -->
        <div class="info-grid">

            <!-- MAIN COLUMN (Kiri) -->
            <div class="info-main fade-in">

                <!-- Header Info -->
                <div>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;">
                        @if($kost->is_featured)
                            <span class="badge badge-featured"><i class="fa-solid fa-crown" style="font-size:0.65rem;"></i> Featured</span>
                        @endif
                        @if($kost->is_recommended)
                            <span class="badge badge-recommended"><i class="fa-solid fa-thumbs-up" style="font-size:0.65rem;"></i> Rekomendasi</span>
                        @endif
                        @php
                            $typeBadgeClass = 'badge-kost-type badge-' . ($kost->kostType ? $kost->kostType->slug : ($kost->type ?? 'campur'));
                            $typeName = $kost->kostType ? $kost->kostType->name : ucfirst($kost->type ?? 'Campur');
                        @endphp
                        <span class="badge {{ $typeBadgeClass }}">Kost {{ $typeName }}</span>
                        <span class="badge {{ $kost->statusBadge['class'] }}" {!! isset($kost->statusBadge['style']) ? 'style="'.$kost->statusBadge['style'].'"' : '' !!}>{{ $kost->statusBadge['text'] }}</span>
                    </div>
                    <h1 class="kost-title">{{ $kost->name }}</h1>
                    <p class="text-muted" style="display:flex;flex-wrap:wrap;align-items:center;gap:12px;font-size:1.05rem;">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <i class="fa-solid fa-location-dot"></i> {{ $kost->area_label ?? $kost->city->name }}
                        </span>
                        @if($kost->kode)
                        <span style="display:flex;align-items:center;gap:6px;padding:4px 10px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);font-size:0.9rem;">
                            <i class="fa-solid fa-ticket" style="color:var(--cta);"></i> Kode: <strong style="color:var(--primary-dark);">{{ $kost->kode }}</strong>
                        </span>
                        @endif
                    </p>
                </div>

                <!-- Deskripsi -->
                <div class="info-block">
                    <h3>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                        </svg>
                        Deskripsi Kost
                    </h3>
                    <p style="color:var(--text-muted);line-height:1.7;">
                        {{ $kost->description }}
                    </p>
                </div>

                <!-- Fasilitas Kamar -->
                <div class="info-block">
                    <h3>
                        <i class="fa-solid fa-bed"></i>
                        Fasilitas Kamar
                    </h3>
                    <div class="facilities-grid">
                        @foreach($kost->roomFacilities as $facility)
                            <div class="facility-tag"><i class="{{ $facility->icon }}"></i> {{ $facility->pivot->label ?? $facility->name }}</div>
                        @endforeach
                    </div>
                </div>

                <!-- Fasilitas Bersama -->
                <div class="info-block">
                    <h3>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        Fasilitas Bersama
                    </h3>
                    <div class="facilities-grid">
                        @foreach($kost->sharedFacilities as $facility)
                            <div class="facility-tag"><i class="{{ $facility->icon }}"></i> {{ $facility->pivot->label ?? $facility->name }}</div>
                        @endforeach
                    </div>
                </div>

                <!-- Lokasi Strategis -->
                @if($kost->nearbyPlaces->count() > 0)
                <div class="info-block">
                    <h3>
                        <i class="fa-regular fa-clock"></i>
                        Lokasi Strategis
                    </h3>
                    <ul class="location-list">
                        @foreach($kost->nearbyPlaces as $place)
                        <li><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg> {{ $place->description }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <!-- SIDEBAR (Kanan) -->
            <div class="info-sidebar fade-in">

                <!-- Pricing Block -->
                <div class="info-block" style="position: sticky; top: calc(var(--nav-h) + 24px); border-color: var(--primary); box-shadow: var(--shadow-sm);">
                    <div style="font-size: .9rem; color: var(--text-muted); margin-bottom: 4px;">Mulai dari</div>
                    <div class="kost-price">
                        {{ $kost->formatted_price }}<span>/bln</span>
                    </div>

                    <hr class="order-divider">

                    <div style="display: flex; gap: 12px; margin-bottom: 24px; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: var(--surface); box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="flex:1; text-align: center;">
                            <div style="color: var(--primary); margin-bottom: 4px;">
                                <i class="fa-solid fa-building" style="font-size:16px;"></i>
                            </div>
                            <strong style="display:block; font-size:14px; color:var(--primary-dark); font-family: 'Poppins', sans-serif;">{{ $kost->floor_count ?? '-' }}</strong>
                            <div style="font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing: 0.05em; margin-top:2px;">Lantai</div>
                        </div>
                        <div style="width: 1px; background: var(--border-light);"></div>
                        <div style="flex:1; text-align: center;">
                            <div style="color: var(--primary); margin-bottom: 4px;">
                                <i class="fa-solid fa-door-open" style="font-size:16px;"></i>
                            </div>
                            <strong style="display:block; font-size:14px; color:var(--primary-dark); font-family: 'Poppins', sans-serif;">{{ $kost->total_rooms ?? '-' }}</strong>
                            <div style="font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing: 0.05em; margin-top:2px;">Kamar</div>
                        </div>
                        <div style="width: 1px; background: var(--border-light);"></div>
                        <div style="flex:1; text-align: center;">
                            <div style="color: var(--primary); margin-bottom: 4px;">
                                <i class="fa-solid fa-shower" style="font-size:16px;"></i>
                            </div>
                            <strong style="display:block; font-size:14px; color:var(--primary-dark); font-family: 'Poppins', sans-serif;">{{ $kost->total_bathrooms ?? '-' }}</strong>
                            <div style="font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing: 0.05em; margin-top:2px;">K. Mandi</div>
                        </div>
                    </div>

                    <!-- CONTACT INFO SECTION -->
                    @if($isUnlocked)
                    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; padding: 20px; border-radius: var(--radius-sm); margin-bottom: 24px;">
                        <h4 style="color: #166534; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 16px; margin-top: 0;">
                            <i class="fa-solid fa-unlock-keyhole"></i> Info Kontak Terbuka
                        </h4>
                        
                        <div style="margin-bottom: 16px;">
                            <strong style="display: block; font-size: 13px; color: #166534; opacity: 0.9; margin-bottom: 4px;">Alamat Lengkap:</strong>
                            <p style="margin:0; color: #15803D; font-size: 14px; line-height: 1.5;">{{ $kost->address ?? '-' }}</p>
                        </div>
                        
                        <div style="margin-bottom: 16px;">
                            <strong style="display: block; font-size: 13px; color: #166534; opacity: 0.9; margin-bottom: 6px;">Kontak Pemilik (Bpk/Ibu {{ $kost->owner_name ?? 'Kost' }}):</strong>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $kost->owner_contact)) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; color: #16A34A; font-weight: 600; text-decoration: none; padding: 10px 14px; background: white; border-radius: 8px; border: 1px solid #BBF7D0; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.background='#DCFCE7'" onmouseout="this.style.background='white'">
                                <i class="fab fa-whatsapp" style="font-size: 18px;"></i> {{ $kost->owner_contact ?? '-' }}
                            </a>
                        </div>
                        
                        @if($kost->maps_link)
                        <div>
                            <strong style="display: block; font-size: 13px; color: #166534; opacity: 0.9; margin-bottom: 4px;">Google Maps:</strong>
                            <a href="{{ $kost->maps_link }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; color: #2563EB; text-decoration: none; font-size: 14px; font-weight: 500;">
                                <i class="fa-solid fa-map-location-dot"></i> Buka Titik Lokasi
                            </a>
                        </div>
                        @endif
                    </div>
                    @else
                    <!-- THE BLUR SECTION (PAY TO UNLOCK) -->
                    <div class="blur-section">
                        <div class="blur-content">
                            <strong>Alamat Lengkap:</strong>
                            <p>{{ $kost->address ?? 'Jl. Placeholder No XXX, Kota' }}</p>
                            <strong>Kontak Pemilik (Bpk/Ibu {{ $kost->owner_name ?? '...' }}):</strong>
                            <p>{{ $kost->owner_contact ?? '+62 8XX-XXXX-XXXX' }} (WhatsApp aktif)</p>
                            <strong>Link Google Maps:</strong>
                            <p>{{ $kost->maps_link ?? 'https://maps.app.goo.gl/xxxxxxxxxxxxx' }}</p>
                        </div>

                        <div class="blur-overlay">
                            <div class="lock-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                            <div>
                                <h4>Buka Kontak & Alamat</h4>
                                <div class="blur-price">Rp {{ number_format($kost->unlock_price, 0, ',', '.') }}</div>
                            </div>
                            <a href="{{ route('checkout.show', $kost->slug) }}" class="btn btn-cta" style="width: 100%;">
                                Buka Info Sekarang
                            </a>
                            <div class="social-proof">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                {{ $kost->purchase_count }} orang sudah beli info kos ini
                            </div>
                        </div>
                    </div>
                    <!-- END BLUR SECTION -->
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========== REKOMENDASI MINGGU INI ========== -->
@if($otherKosts->count() > 0)
<section class="section" style="background: var(--surface);">
    <div class="container">
      <div class="section-header fade-in">
        <h2>Rekomendasi Serupa</h2>
        <p>Kost lain yang mungkin cocok dengan pencarianmu</p>
      </div>
      
      <div class="listing-grid fade-in" style="animation-delay: 0.2s;">
        @foreach($otherKosts as $otherKost)
          <x-kost-card :kost="$otherKost" />
        @endforeach
      </div>
    </div>
</section>
@endif
@endsection
