@extends('layouts.app')

@section('title', 'Cari Kost — mawkost')

@section('content')
<!-- ========== BREADCRUMB & HEADER ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Cari Kost</span>
        </div>
        <div class="fade-in" style="padding-bottom: 32px;">
            <h1 style="font-size: 2rem;">Cari Kost Idamanmu</h1>
            <p class="text-muted" style="margin-top: 8px;">Tersedia ratusan pilihan kost di berbagai kota besar di Indonesia.</p>
        </div>
    </div>
</div>

<!-- ========== MAIN CONTENT ========== -->
<section class="section" style="padding-top: 40px;">
    <div class="container">
        <!-- Filter Bar -->
        <form action="{{ route('kost.search') }}" method="GET" class="filter-bar fade-in">
            <div class="filter-group">
                <label>Kota</label>
                <select name="lokasi">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $c)
                        <option value="{{ $c->slug }}" {{ request('lokasi') == $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
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
                <div style="display: flex; gap: 8px; align-items: center;">
                    <input type="number" name="min_harga" value="{{ request('min_harga') }}" placeholder="Min Harga" style="width: 100%; padding: 8px; border: 1px solid var(--border-light); border-radius: var(--radius-sm); font-size: 0.9rem;">
                    <span>-</span>
                    <input type="number" name="max_harga" value="{{ request('max_harga') }}" placeholder="Max Harga" style="width: 100%; padding: 8px; border: 1px solid var(--border-light); border-radius: var(--radius-sm); font-size: 0.9rem;">
                </div>
            </div>
            <div class="filter-group" style="flex: 0 0 auto;">
                <button type="submit" class="btn btn-primary" style="height: 46px; border-radius: var(--radius-sm);">Terapkan Filter</button>
            </div>
            @if(request()->has('lokasi') || request()->has('tipe') || request()->has('min_harga'))
                <div class="filter-group" style="flex: 0 0 auto;">
                    <a href="{{ route('kost.search') }}" class="btn btn-outline" style="height: 46px; border-radius: var(--radius-sm);">Reset</a>
                </div>
            @endif
        </form>

        @if($kosts->isEmpty())
            <div style="text-align: center; padding: 60px 0;">
                <i class="fa-solid fa-box-open" style="font-size: 48px; color: var(--border-light); margin-bottom: 16px;"></i>
                <h3 class="text-muted">Kost tidak ditemukan</h3>
                <p class="text-muted">Coba ubah filter pencarian Anda</p>
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
@endsection
