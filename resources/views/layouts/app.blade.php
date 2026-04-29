<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'mawkost'))</title>
    <meta name="description" content="@yield('meta_description', 'mawkost adalah platform pencarian kost terpercaya di Malang, Jogja, dan Surabaya.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('assets/img/logo-128.png') }}" type="image/png">

    <meta property="og:title" content="@yield('og_title', 'mawkost — Cari Kost Gampang, Ga Perlu Keliling!')">
    <meta property="og:description" content="@yield('og_description', 'Platform pencarian kost terpercaya di Malang, Jogja, dan Surabaya.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="mawkost">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'mawkost — Cari Kost Gampang, Ga Perlu Keliling!')">
    <meta name="twitter:description" content="@yield('og_description', 'Platform pencarian kost terpercaya di Malang, Jogja, dan Surabaya.')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/img/logo.png'))">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('css/styles.css') }}?v={{ filemtime(public_path('css/styles.css')) }}" as="style">
    <link rel="preload" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" as="style">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ filemtime(public_path('css/styles.css')) }}">
    @stack('styles')
</head>

<body class="@yield('body_class')">
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @if(!View::hasSection('hide_footer'))
        <x-footer />
    @endif

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile nav toggle
            const navToggle = document.getElementById('navToggle');
            const navMenu = document.getElementById('navMenu');
            if (navToggle && navMenu) {
                navToggle.addEventListener('click', () => {
                    navMenu.classList.toggle('open');
                    navToggle.classList.toggle('active');
                });
                // Close menu when clicking a link
                navMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navMenu.classList.remove('open');
                        navToggle.classList.remove('active');
                    });
                });
            }

            // Mobile dropdown toggle
            document.querySelectorAll('.nav-dropdown-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        this.closest('.nav-dropdown').classList.toggle('open');
                    }
                });
            });

            // Intersection Observer for fade-in animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            
            document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
        });
    </script>
    @stack('scripts')
</body>
</html>
