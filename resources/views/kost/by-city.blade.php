@extends('layouts.app')

@section('title', 'Kost di ' . $city->name . ' — mawkost')

@section('content')
<!-- ========== HEAD CITY ========== -->
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light);">
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
        @if($kosts->isEmpty())
            <div style="text-align: center; padding: 60px 0;">
                <i class="fa-solid fa-building" style="font-size: 48px; color: var(--border-light); margin-bottom: 16px;"></i>
                <h3 class="text-muted">Belum ada kost di kota ini</h3>
                <p class="text-muted">Kami sedang menambahkan kost baru di daerah ini.</p>
            </div>
        @else
            <!-- Listing Grid -->
            <div class="listing-grid">
                @foreach($kosts as $kost)
                    <x-kost-card :kost="$kost" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $kosts->links('pagination::bootstrap-4') }}
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
@endsection
