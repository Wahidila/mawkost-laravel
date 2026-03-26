<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mawkost Admin - @yield('title')</title>
    <!-- Tailwind CSS (CDN for admin only) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        secondary: '#FACC15',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased overflow-x-hidden">
    <div class="flex h-screen overflow-y-hidden">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-white shadow-xl">
            <div class="flex items-center justify-center p-6 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-primary">Mawkost<span class="text-secondary">Admin</span></a>
            </div>
            
            <div class="overflow-y-auto overflow-x-hidden flex-grow">
                <ul class="flex flex-col py-4 space-y-1">
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase border-b border-gray-200 pb-1 mb-2 w-full">Menu Utama</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kosts.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.kosts.*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-building"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Kelola Kost</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.cities.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.cities.*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-city"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Data Kota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.facilities.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.facilities.*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-wifi"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Fasilitas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.orders.*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Pesanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.contacts.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.contacts.*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Pesan Kontak</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-50 text-gray-600 hover:text-blue-800 border-l-4 {{ request()->routeIs('admin.users.*') ? 'border-primary text-blue-800 bg-blue-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fas fa-users-cog"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Pengguna</span>
                        </a>
                    </li>

                    <li class="px-5 mt-2">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase border-b border-gray-200 pb-1 mb-2 w-full">Pengaturan</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.whatsapp') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-green-50 text-gray-600 hover:text-green-800 border-l-4 {{ request()->routeIs('admin.settings.whatsapp*') ? 'border-green-500 text-green-800 bg-green-50' : 'border-transparent' }} pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class="fab fa-whatsapp text-green-500"></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Pengaturan WA</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Logout Button -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-150">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar (Header) -->
            <header class="bg-white shadow pr-6 pl-4 py-4 flex justify-between items-center z-10 sticky top-0">
                <div class="flex items-center">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-500 hover:text-primary cursor-pointer"><i class="fas fa-bell"></i></span>
                    <span class="font-bold text-gray-700">Admin</span>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=1E40AF&color=fff" alt="Avatar" class="h-10 w-10 rounded-full border-2 border-gray-200 shadow-sm cursor-pointer">
                    <a href="{{ route('home') }}" target="_blank" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded text-sm transition">Lihat Website</a>
                </div>
            </header>

            <!-- Scrollable Content View -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Notifications -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    @stack('modals')
    @stack('scripts')
</body>
</html>
