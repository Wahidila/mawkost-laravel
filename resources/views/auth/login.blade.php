<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — mawkost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-800">maw.kost</h2>
            <p class="text-gray-500 text-sm mt-1">Masuk ke akun Anda</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-4 text-sm">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3 text-gray-400 text-sm"></i>
                    <input type="email" name="email" id="email" class="shadow-sm border rounded-lg w-full py-2.5 pl-10 pr-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300" required autofocus value="{{ old('email') }}" placeholder="email@example.com">
                </div>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400 text-sm"></i>
                    <input type="password" name="password" id="password" class="shadow-sm border rounded-lg w-full py-2.5 pl-10 pr-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300" required placeholder="••••••••">
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 w-full text-white font-bold py-2.5 px-4 rounded-lg focus:outline-none focus:shadow-outline transition">
                <i class="fas fa-right-to-bracket mr-1"></i> Sign In
            </button>
            <div class="mt-4 text-center text-sm">
                <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>
</body>
</html>
