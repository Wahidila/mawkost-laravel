@props(['kost'])

@php
    $firstImage = $kost->images->first();
    $imageUrl = $firstImage ? $firstImage->url : asset('assets/img/kost-1.png');
    $typeBadge = 'badge-kost-type badge-' . ($kost->kostType ? $kost->kostType->slug : ($kost->type ?? 'campur'));
    $typeName = $kost->kostType ? $kost->kostType->name : ucfirst($kost->type ?? 'Campur');
    $cardClass = $kost->is_featured ? 'listing-card card fade-in card-featured' : 'listing-card card fade-in';
@endphp

<a href="{{ route('kost.show', ['citySlug' => $kost->city->slug, 'slug' => $kost->slug]) }}" class="{{ $cardClass }}">
    <div style="position:relative;">
        <img src="{{ $imageUrl }}" alt="{{ $kost->title }}" class="card-img" loading="lazy">
        <div class="card-badges">
            @if($kost->is_featured)
                <span class="badge badge-featured"><i class="fa-solid fa-crown" style="font-size:0.65rem;"></i> Featured</span>
            @elseif($kost->is_recommended)
                <span class="badge badge-recommended"><i class="fa-solid fa-thumbs-up" style="font-size:0.65rem;"></i> Rekomendasi</span>
            @endif
            <span class="badge {{ $typeBadge }}">{{ $typeName }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="listing-price">Rp {{ number_format($kost->price, 0, ',', '.') }} <span>/bulan</span></div>
        <div class="listing-name">{{ $kost->title }}</div>
        <div class="listing-area">
            <i class="fa-solid fa-location-dot"></i>
            {{ $kost->area_label ?? $kost->city->name }}
        </div>
        <div class="listing-facilities">
            @foreach($kost->facilities->take(3) as $facility)
                <div class="facility-item">
                    <i class="{{ $facility->icon }}"></i>
                    {{ $facility->name }}
                </div>
            @endforeach
        </div>
    </div>
</a>
