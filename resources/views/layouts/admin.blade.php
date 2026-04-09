<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mawkost Admin - @yield('title')</title>
    <!-- Google Fonts Mawkost -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (CDN for admin only) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
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
</head>
<body class="bg-mawkostbg font-sans text-gray-900 antialiased overflow-x-hidden">
    <div class="flex h-screen overflow-y-hidden">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-white shadow-[0_4px_24px_rgba(92,61,46,0.08)] z-20">
            <div class="flex items-center justify-center p-6 border-b border-orange-50">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold font-display text-primary-dark tracking-tight">Mawkost<span class="text-cta">Admin</span></a>
            </div>
            
            <div class="overflow-y-auto overflow-x-hidden flex-grow custom-scrollbar">
                <ul class="flex flex-col py-4 space-y-1">
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wider text-primary-light uppercase border-b border-orange-50 pb-1 mb-2 w-full">Menu Utama</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-home {{ request()->routeIs('admin.dashboard') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kosts.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.kosts.*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-building {{ request()->routeIs('admin.kosts.*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Kelola Kost</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.cities.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.cities.*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-city {{ request()->routeIs('admin.cities.*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Data Kota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.facilities.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.facilities.*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-wifi {{ request()->routeIs('admin.facilities.*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Fasilitas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.orders.*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-shopping-cart {{ request()->routeIs('admin.orders.*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Pesanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.contacts.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.contacts.*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-envelope {{ request()->routeIs('admin.contacts.*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Pesan Kontak</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.users.*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-users-cog {{ request()->routeIs('admin.users.*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Pengguna</span>
                        </a>
                    </li>

                    <li class="px-5 mt-4">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wider text-primary-light uppercase border-b border-orange-50 pb-1 mb-2 w-full">Pengaturan</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.whatsapp') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.settings.whatsapp*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fab fa-whatsapp {{ request()->routeIs('admin.settings.whatsapp*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Pengaturan WA</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.xendit') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.settings.xendit*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-credit-card {{ request()->routeIs('admin.settings.xendit*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Pengaturan Xendit</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.footer') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-primary-lighter text-gray-600 hover:text-primary-dark border-l-4 {{ request()->routeIs('admin.settings.footer*') ? 'border-cta text-primary-dark bg-primary-lighter font-semibold' : 'border-transparent' }} pr-6 transition duration-200">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-columns {{ request()->routeIs('admin.settings.footer*') ? 'text-cta' : '' }}"></i>
                            </span>
                            <span class="ml-3 text-sm tracking-wide truncate">Pengaturan Footer</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Logout Button -->
            <div class="p-4 border-t border-orange-50 bg-primary-lighter/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center bg-white text-danger hover:bg-danger hover:text-white border border-danger font-semibold py-2 px-4 rounded-full transition duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <!-- Deco blob background loosely matching homepage -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-primary-light rounded-full blur-[100px] opacity-20 pointer-events-none"></div>

            <!-- Topbar (Header) -->
            <header class="bg-white/80 backdrop-blur-md shadow-sm pr-8 pl-6 py-4 flex justify-between items-center z-10 sticky top-0 border-b border-primary-lighter/50">
                <div class="flex items-center">
                    <h2 class="text-xl font-bold font-display text-primary-dark">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-primary hover:text-cta cursor-pointer transition"><i class="fas fa-bell text-lg"></i></span>
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-primary-dark text-sm">Admin</span>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=8B5E3C&color=fff&rounded=true" alt="Avatar" class="h-10 w-10 rounded-full border-2 border-primary-lighter shadow-[0_2px_8px_rgba(92,61,46,0.15)] cursor-pointer">
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Website
                    </a>
                </div>
            </header>

            <!-- Scrollable Content View -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-mawkostbg/50 p-6 sm:p-8 relative z-0">
                <!-- Notifications -->
                @if (session('success'))
                    <div class="mb-6 bg-white border-l-4 border-success rounded-r-lg shadow-sm text-success p-4 flex items-center gap-3" role="alert">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        <p class="font-medium text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-white border-l-4 border-danger rounded-r-lg shadow-sm text-danger p-4 flex items-center gap-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        <p class="font-medium text-sm">{{ session('error') }}</p>
                    </div>
                @endif
                
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    
    <style>
        /* Custom scrollbar for admin sidebar & main content */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: var(--primary-light, #DEB8A0);
            border-radius: 20px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: var(--primary, #8B5E3C);
        }
    </style>
</body>
</html>
            </div>
        </main>
    </div>
    @stack('modals')
    @stack('scripts')
</body>
</html>
