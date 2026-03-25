<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mawkost — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        accent: '#3B82F6',
                    }
                }
            }
        }
    </script>
    <style>
        /* Mobile sidebar overlay */
        .sidebar-overlay { display: none; }
        .sidebar-overlay.active { display: block; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased overflow-x-hidden">
    <div class="flex h-screen overflow-y-hidden">

        {{-- Mobile overlay --}}
        <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black/50 z-40 lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 bg-white shadow-xl border-r border-gray-100 transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold text-primary">maw<span class="text-blue-400">.kost</span></a>
                {{-- Close button (mobile only) --}}
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="overflow-y-auto overflow-x-hidden flex-grow">
                <ul class="flex flex-col py-4 space-y-1">
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase border-b border-gray-200 pb-1 mb-2 w-full">Menu</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('user.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('user.dashboard') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.orders') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('user.orders*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-key"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Kost Saya</span>
                        </a>
                    </li>
                    <li class="px-5 mt-4">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase border-b border-gray-200 pb-1 mb-2 w-full">Lainnya</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" target="_blank" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 border-transparent pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-globe"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Lihat Website</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Logout --}}
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-150 text-sm">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden w-full">
            {{-- Topbar --}}
            <header class="bg-white shadow-sm px-4 lg:px-6 py-4 flex justify-between items-center z-10 sticky top-0 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    {{-- Hamburger button (mobile only) --}}
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-blue-600 p-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="text-sm text-gray-500 hidden sm:inline">Selamat datang,</span>
                    <span class="font-bold text-gray-700 text-sm sm:text-base truncate max-w-[100px] sm:max-w-none">{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3B82F6&color=fff" alt="Avatar" class="h-8 w-8 sm:h-9 sm:w-9 rounded-full border-2 border-blue-100 shadow-sm">
                </div>
            </header>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 sm:p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
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
