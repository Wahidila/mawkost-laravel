@php
$currentRoute = request()->route()->getName();
$navCities = \App\Models\City::orderBy('name')->get();
@endphp

<nav class="navbar" id="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="nav-brand">
            <img src="{{ asset('assets/img/logo-128.png') }}" alt="mawkost logo" width="40" height="40">
            <span>maw.kost</span>
        </a>

        <div class="nav-menu" id="navMenu">
            <div class="nav-links-center">
                <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'active' : '' }}">Beranda</a>
                <div class="nav-dropdown">
                    <a href="{{ route('kost.search') }}" class="nav-dropdown-toggle {{ $currentRoute === 'kost.byCity' ? 'active' : '' }}">Kost Terbaik <i class="fa-solid fa-chevron-down nav-dropdown-arrow"></i></a>
                    <div class="nav-dropdown-menu">
                        @foreach($navCities as $c)
                            <a href="{{ route('kost.byCity', $c->slug) }}">{{ $c->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('tentang') }}" class="{{ $currentRoute === 'tentang' ? 'active' : '' }}">Tentang</a>
                <a href="{{ route('contact.index') }}" class="{{ $currentRoute === 'contact.index' ? 'active' : '' }}">Kontak</a>
                <a href="{{ route('blog.index') }}" class="{{ str_starts_with($currentRoute, 'blog') ? 'active' : '' }}">Blog</a>
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
