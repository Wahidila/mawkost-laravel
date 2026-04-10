@props(['kost'])

@php
    $firstImage = $kost->images->first();
    $imagePath = $firstImage ? $firstImage->image_path : 'assets/img/kost-1.png';
    $typeBadge = 'badge-kost-type badge-' . ($kost->kostType ? $kost->kostType->slug : ($kost->type ?? 'campur'));
    $typeName = $kost->kostType ? $kost->kostType->name : ucfirst($kost->type ?? 'Campur');
@endphp

<a href="{{ route('kost.show', ['citySlug' => $kost->city->slug, 'slug' => $kost->slug]) }}" class="listing-card card fade-in">
    <div style="position:relative;">
        <img src="{{ asset($imagePath) }}" alt="{{ $kost->name }}" class="card-img">
        <div class="card-badges">
            <span class="badge {{ $typeBadge }}">{{ $typeName }}</span>
            @if($kost->status === 'tersedia')
                <span class="badge badge-success">Tersedia</span>
            @elseif($kost->status === 'penuh')
                <span class="badge badge-danger">Penuh</span>
            @else
                <span class="badge badge-success">Sisa {{ $kost->available_rooms ?? '' }} Kamar</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="listing-price">Rp {{ number_format($kost->price, 0, ',', '.') }} <span>/bulan</span></div>
        <div class="listing-name">{{ $kost->name }}</div>
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
