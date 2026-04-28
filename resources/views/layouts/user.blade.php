<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mawkost — @yield('title')</title>
    <!-- Google Fonts Mawkost -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#8B5E3C',
                            light: '#DEB8A0',
                            lighter: '#F5E6DB',
                            dark: '#5C3D2E',
                        },
                        cta: {
                            DEFAULT: '#E8734A',
                            hover: '#D4622E',
                        },
                        mawkostbg: '#FFF9F5',
                    },
                    fontFamily: {
                        sans: ['"Open Sans"', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Mobile sidebar overlay */
        .sidebar-overlay { display: none; }
        .sidebar-overlay.active { display: block; backdrop-filter: blur(4px); }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: var(--primary-light, #DEB8A0); border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background-color: var(--primary, #8B5E3C); }
    </style>
</head>
<body class="bg-mawkostbg font-sans text-gray-900 antialiased overflow-x-hidden">
    <div class="flex h-screen overflow-y-hidden">

        {{-- Mobile overlay --}}
        <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-primary-dark/40 z-40 lg:hidden transition-all" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 bg-white shadow-[0_4px_24px_rgba(92,61,46,0.08)] border-r border-primary-lighter/50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">
            <div class="flex items-center justify-between p-6 border-b border-orange-50">
                <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold font-display text-primary-dark tracking-tight">maw<span class="text-cta">kost</span></a>
                {{-- Close button (mobile only) --}}
                <button onclick="toggleSidebar()" class="lg:hidden text-primary-light hover:text-primary-dark transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="overflow-y-auto overflow-x-hidden flex-grow custom-scrollbar">
                <ul class="flex flex-col py-4 space-y-1">
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wider text-primary-light uppercase border-b border-orange-50 pb-1 mb-2 w-full">Menu Utama</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('user.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('user.dashboard') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-home {{ request()->routeIs('user.dashboard') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.orders') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('user.orders*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-key {{ request()->routeIs('user.orders*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Kost Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.alerts') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('user.alerts*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-bell {{ request()->routeIs('user.alerts*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Alert Kost</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.profile') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('user.profile*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-user-pen {{ request()->routeIs('user.profile*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Edit Profil</span>
                        </a>
                    </li>
                    
                    <li class="px-5 mt-4">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wider text-primary-light uppercase border-b border-orange-50 pb-1 mb-2 w-full">Lainnya</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" target="_blank" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 border-transparent pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Kembali ke Website</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Logout --}}
            <div class="p-4 border-t border-orange-50 bg-primary-lighter/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center bg-white text-danger hover:bg-danger hover:text-white border border-danger font-semibold py-2 px-4 rounded-full transition duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">
            
            <!-- Soft Deco blob mapped from homepage -->
            <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-primary-light rounded-full blur-[100px] opacity-20 pointer-events-none"></div>

            {{-- Topbar --}}
            <header class="bg-white/80 backdrop-blur-md shadow-sm px-4 lg:px-6 py-4 flex justify-between items-center z-10 sticky top-0 border-b border-primary-lighter/50">
                <div class="flex items-center gap-3">
                    {{-- Hamburger button (mobile only) --}}
                    <button onclick="toggleSidebar()" class="lg:hidden text-primary hover:text-cta p-2 bg-primary-lighter rounded-lg transition-colors">
                        <i class="fas fa-bars mx-1"></i>
                    </button>
                    <h2 class="text-xl font-bold font-display text-primary-dark tracking-tight">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4 bg-white/50 px-3 py-1.5 rounded-full border border-primary-lighter shadow-[0_2px_8px_rgba(92,61,46,0.05)]">
                    <span class="text-sm font-medium text-gray-500 hidden sm:inline">Halo,</span>
                    <span class="font-bold text-primary-dark text-sm sm:text-base truncate max-w-[120px] sm:max-w-none">{{ auth()->user()->name }}</span>
                    <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=8B5E3C&color=fff' }}" alt="Avatar" class="h-8 w-8 sm:h-9 sm:w-9 rounded-full border border-primary-light object-cover ml-1 shadow-sm">
                </div>
            </header>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-mawkostbg/50 p-4 sm:p-6 md:p-8 relative z-0">
                <div class="max-w-6xl mx-auto">
                    @if (session('success'))
                        <div class="mb-6 bg-white border-l-4 border-success rounded-r-xl shadow-sm text-success p-4 flex items-center gap-3" role="alert">
                            <i class="fa-solid fa-circle-check text-lg"></i>
                            <p class="font-medium text-sm">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-white border-l-4 border-danger rounded-r-xl shadow-sm text-danger p-4 flex items-center gap-3" role="alert">
                            <i class="fa-solid fa-circle-exclamation text-lg"></i>
                            <p class="font-medium text-sm">{{ session('error') }}</p>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }
    </script>
</body>
</html>
