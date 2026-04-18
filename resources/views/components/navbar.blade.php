@php
$currentRoute = request()->route()->getName();
@endphp

<nav class="navbar" id="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="nav-brand">
            <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost logo">
            <span>maw.kost</span>
        </a>

        <div class="nav-menu" id="navMenu">
            <div class="nav-links-center">
                <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('home') }}#cara-kerja">Cara Kerja</a>
                <a href="{{ route('tentang') }}" class="{{ $currentRoute === 'tentang' ? 'active' : '' }}">Tentang</a>
                <a href="{{ route('contact.index') }}" class="{{ $currentRoute === 'contact.index' ? 'active' : '' }}">Kontak</a>
            </div>

            <div class="nav-actions">
                <a href="{{ route('chat.index') }}" class="btn btn-sm nav-ai-chat {{ $currentRoute === 'chat.index' ? 'active' : '' }}"><i class="fa-solid fa-robot"></i> Konsultasi AI</a>
                <a href="{{ route('kost.search') }}" class="btn btn-cta btn-sm nav-cta"><i class="fa-solid fa-magnifying-glass"></i> Cari Kost</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm nav-auth nav-auth-solid">
                            <i class="fa-solid fa-gauge-high"></i> Admin
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn btn-sm nav-auth nav-auth-solid">
                            <i class="fa-solid fa-user"></i> Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm nav-auth nav-auth-icon" title="Masuk" aria-label="Masuk">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                @endauth
            </div>
        </div>

        <button class="nav-toggle" id="navToggle" type="button" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
