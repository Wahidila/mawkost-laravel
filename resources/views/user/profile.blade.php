@extends('layouts.user')

@section('title', 'Edit Profil')
@section('header', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Profile Info --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-4">
            <h3 class="text-white font-bold flex items-center gap-2">
                <i class="fas fa-user-circle"></i> Informasi Profil
            </h3>
        </div>
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
            @csrf
            @method('PUT')

            {{-- Avatar Section --}}
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-6 pb-6 border-b">
                <div class="relative group">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-blue-100 shadow-md">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=96&background=3B82F6&color=fff&font-size=0.4" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-blue-100 shadow-md">
                    @endif
                    <label for="avatar" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition">
                        <i class="fas fa-camera text-white text-xl"></i>
                    </label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-sm text-gray-500">Klik foto untuk mengganti</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP. Maks 2MB</p>
                    @if($user->avatar)
                        <button type="button" onclick="document.getElementById('delete-avatar-form').submit()" class="text-red-500 hover:text-red-700 text-xs mt-2 font-medium">
                            <i class="fas fa-trash mr-1"></i> Hapus Foto
                        </button>
                    @endif
                </div>
            </div>

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- WhatsApp --}}
            <div class="mb-6">
                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fab fa-whatsapp text-green-500"></i>
                    </span>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="082233386148"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                </div>
                @error('whatsapp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Delete Avatar Form (hidden) --}}
    <form id="delete-avatar-form" action="{{ route('user.profile.avatar.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- Change Password --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-orange-400 px-6 py-4">
            <h3 class="text-white font-bold flex items-center gap-2">
                <i class="fas fa-lock"></i> Ubah Password
            </h3>
        </div>
        <form action="{{ route('user.profile.password') }}" method="POST" class="p-4 sm:p-6">
            @csrf
            @method('PUT')



            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition text-sm">
                <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter</p>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition text-sm">
            </div>

            <button type="submit" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-8 rounded-lg transition text-sm">
                <i class="fas fa-key mr-1"></i> Ubah Password
            </button>
        </form>
    </div>

</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = event.target.closest('.relative').querySelector('img');
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
