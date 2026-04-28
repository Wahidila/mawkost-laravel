@extends('layouts.app')

@section('title', 'Kost di ' . $city->name . ' — mawkost')

@section('content')
<!-- ========== HEAD CITY ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('kost.search') }}">Cari Kost</a>
            <span class="sep">/</span>
            <span class="current">Kost {{ $city->name }}</span>
        </div>
        <div class="fade-in" style="padding-bottom: 32px; display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
            <div>
                <h1 style="font-size: 2rem;">Sewa Kost di {{ $city->name }}</h1>
                <p class="text-muted" style="margin-top: 8px;">Menampilkan pilihan kost terbaik di sekitar {{ $city->name }}.</p>
            </div>
            @if($city->image)
            <div style="margin-left: auto; display: none; @media(min-width: 768px) { display: block; }">
                 <img src="{{ asset($city->image) }}" alt="{{ $city->name }}" style="height: 80px; width: auto; border-radius: var(--radius-sm); object-fit: cover;">
            </div>
            @endif
        </div>
    </div>
</div>

<section class="section" style="padding-top: 40px;">
    <div class="container">
        <!-- Filter Bar -->
        <form action="{{ route('kost.byCity', $city->slug) }}" method="GET" class="filter-bar fade-in">
            <div class="filter-group">
                <label>Tipe Kost</label>
                <select name="tipe">
                    <option value="">Semua Tipe</option>
                    @foreach($kostTypes as $type)
                        <option value="{{ $type->slug }}" {{ request('tipe') == $type->slug ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group price-range-wrapper">
                <label class="range-label">Rentang Harga</label>
                <div class="range-values">
                    <span id="minPriceLabel">Rp 500rb</span>
                    <span id="maxPriceLabel">Rp 5jt</span>
                </div>
                <div class="multi-range" id="multiRange">
                    <input type="range" id="minRange" min="500000" max="5000000" step="100000" value="{{ request('min_harga', 500000) }}">
                    <input type="range" id="maxRange" min="500000" max="5000000" step="100000" value="{{ request('max_harga', 5000000) }}">
                </div>
                <input type="hidden" name="min_harga" id="minHargaInput" value="{{ request('min_harga') }}">
                <input type="hidden" name="max_harga" id="maxHargaInput" value="{{ request('max_harga') }}">
            </div>
            <div class="filter-group" style="flex: 0 0 auto;">
                <label style="font-size: .85rem; color: var(--text-muted); margin-bottom: 4px; display: block;">Label</label>
                <div style="display: flex; gap: 12px; height: 46px; align-items: center;">
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: .9rem; color: var(--primary-dark); font-weight: 500; white-space: nowrap;">
                        <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }} style="accent-color: #F59E0B; width: 16px; height: 16px;">
                        <i class="fa-solid fa-crown" style="color: #F59E0B; font-size: .75rem;"></i> Featured
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: .9rem; color: var(--primary-dark); font-weight: 500; white-space: nowrap;">
                        <input type="checkbox" name="rekomendasi" value="1" {{ request('rekomendasi') ? 'checked' : '' }} style="accent-color: #3B82F6; width: 16px; height: 16px;">
                        <i class="fa-solid fa-thumbs-up" style="color: #3B82F6; font-size: .75rem;"></i> Rekomendasi
                    </label>
                </div>
            </div>
            <div class="filter-group" style="flex: 0 0 auto;">
                <button type="submit" class="btn btn-primary" style="height: 46px; border-radius: var(--radius-sm);">Terapkan Filter</button>
            </div>
            @if(request()->has('tipe') || request()->has('min_harga') || request()->has('featured') || request()->has('rekomendasi'))
                <div class="filter-group" style="flex: 0 0 auto;">
                    <a href="{{ route('kost.byCity', $city->slug) }}" class="btn btn-outline" style="height: 46px; border-radius: var(--radius-sm);">Reset</a>
                </div>
            @endif
        </form>

        @if($kosts->isEmpty())
            <div style="text-align: center; padding: 60px 0;">
                <i class="fa-solid fa-building" style="font-size: 48px; color: var(--border-light); margin-bottom: 16px;"></i>
                <h3 class="text-muted">Kost tidak ditemukan</h3>
                <p class="text-muted">Coba ubah filter pencarian atau <a href="{{ route('kost.byCity', $city->slug) }}" style="color: var(--primary); font-weight: 600;">reset filter</a></p>
            </div>
        @else
            <!-- Listing Grid -->
            <div class="listing-grid">
                @foreach($kosts as $kost)
                    <x-kost-card :kost="$kost" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 40px;">
                {{ $kosts->links('vendor.pagination.mawkost') }}
            </div>
        @endif
    </div>
</section>

<!-- Call to action search -->
<section class="section" style="background: var(--primary-lighter); text-align: center;">
    <div class="container">
        <h3 style="margin-bottom: 16px;">Tidak menemukan yang pas di {{ $city->name }}?</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">Coba atur ulang filter atau cari di kota lain</p>
        <a href="{{ route('kost.search') }}" class="btn btn-primary">Cari Ulang Kost</a>
    </div>
</section>
@push('scripts')
<script>
(function() {
    const minRange = document.getElementById('minRange');
    const maxRange = document.getElementById('maxRange');
    const minLabel = document.getElementById('minPriceLabel');
    const maxLabel = document.getElementById('maxPriceLabel');
    const minInput = document.getElementById('minHargaInput');
    const maxInput = document.getElementById('maxHargaInput');
    const container = document.getElementById('multiRange');

    const RANGE_MIN = 500000;
    const RANGE_MAX = 5000000;
    const GAP = 100000;

    function formatPrice(val) {
        val = parseInt(val);
        if (val >= 1000000) {
            const jt = val / 1000000;
            return 'Rp ' + (jt % 1 === 0 ? jt : jt.toFixed(1).replace('.0', '')) + 'jt';
        }
        return 'Rp ' + (val / 1000) + 'rb';
    }

    function update() {
        let minVal = parseInt(minRange.value);
        let maxVal = parseInt(maxRange.value);

        if (minVal > maxVal - GAP) { minVal = maxVal - GAP; minRange.value = minVal; }
        if (maxVal < minVal + GAP) { maxVal = minVal + GAP; maxRange.value = maxVal; }

        minLabel.textContent = formatPrice(minVal);
        maxLabel.textContent = formatPrice(maxVal);

        minInput.value = minVal > RANGE_MIN ? minVal : '';
        maxInput.value = maxVal < RANGE_MAX ? maxVal : '';

        const pctMin = ((minVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN)) * 100;
        const pctMax = ((maxVal - RANGE_MIN) / (RANGE_MAX - RANGE_MIN)) * 100;
        container.style.setProperty('--min-pct', pctMin + '%');
        container.style.setProperty('--max-pct', pctMax + '%');
    }

    minRange.addEventListener('input', update);
    maxRange.addEventListener('input', update);
    update();
})();
</script>
@endpush
@endsection
