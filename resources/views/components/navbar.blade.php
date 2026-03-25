@php
$currentRoute = request()->route()->getName();
@endphp

<nav class="navbar" id="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="nav-brand">
            <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost logo">
            <span>maw.kost</span>
        </a>
        <div class="nav-links" id="navLinks">
            <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('home') }}#cara-kerja">Cara Kerja</a>
            <a href="{{ route('tentang') }}" class="{{ $currentRoute === 'tentang' ? 'active' : '' }}">Tentang</a>
            <a href="{{ route('contact.index') }}" class="{{ $currentRoute === 'contact.index' ? 'active' : '' }}">Kontak</a>
            <a href="{{ route('kost.search') }}" class="btn btn-cta btn-sm nav-cta">Cari Kost</a>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="background: var(--primary); color: #fff; margin-left: 8px;">
                        <i class="fa-solid fa-gauge-high" style="margin-right: 4px;"></i> Admin
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn btn-sm" style="background: var(--primary); color: #fff; margin-left: 8px;">
                        <i class="fa-solid fa-user" style="margin-right: 4px;"></i> Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-sm" style="border: 1px solid var(--border); color: var(--text); margin-left: 8px;">
                    <i class="fa-solid fa-right-to-bracket" style="margin-right: 4px;"></i> Masuk
                </a>
            @endauth
        </div>
        <div class="nav-toggle" id="navToggle" onclick="document.getElementById('navLinks').classList.toggle('open')">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

<script>
    // Toggle mobile menu
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('navToggle');
        const links = document.getElementById('navLinks');
        if(toggle && links) {
            toggle.addEventListener('click', function() {
                links.classList.toggle('open');
            });
        }
    });
</script>
