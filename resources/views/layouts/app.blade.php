<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'mawkost'))</title>
    <meta name="description" content="@yield('meta_description', 'mawkost adalah platform pencarian kost terpercaya di Malang, Jogja, dan Surabaya.')">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    
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
        // Hamburger Menu Toggle
        document.addEventListener('DOMContentLoaded', () => {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            if(hamburger && navLinks) {
                hamburger.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }

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
