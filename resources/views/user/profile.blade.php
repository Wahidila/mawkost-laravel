@extends('layouts.user')

@section('title', 'Edit Profil')
@section('header', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Profile Info --}}
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-primary-lighter/40 bg-white/50">
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-user-circle text-cta"></i> Informasi Profil
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Perbarui data profil dan foto kamu.</p>
        </div>
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6">
            @csrf
            @method('PUT')

            {{-- Avatar Section --}}
            <div class="flex flex-col sm:flex-row items-center gap-5 mb-6 pb-6 border-b border-primary-lighter/30">
                <div class="relative group">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-primary-lighter shadow-[0_4px_12px_rgba(92,61,46,0.1)]">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=96&background=8B5E3C&color=fff&font-size=0.4" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-primary-lighter shadow-[0_4px_12px_rgba(92,61,46,0.1)]">
                    @endif
                    <label for="avatar" class="absolute inset-0 flex items-center justify-center bg-primary-dark/50 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-200">
                        <i class="fas fa-camera text-white text-xl"></i>
                    </label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-sm font-semibold text-primary-dark">Foto Profil</p>
                    <p class="text-xs text-gray-500 mt-1">Klik foto untuk mengganti. JPG, PNG, WebP. Maks 2MB.</p>
                    @if($user->avatar)
                        <button type="button" onclick="document.getElementById('delete-avatar-form').submit()" class="text-red-500 hover:text-red-700 text-xs mt-2 font-semibold transition-colors">
                            <i class="fas fa-trash mr-1"></i> Hapus Foto
                        </button>
                    @endif
                </div>
            </div>

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2.5 border border-primary-lighter rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-sm">
                @error('name')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-primary-dark mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2.5 border border-primary-lighter rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-sm">
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- WhatsApp --}}
            <div class="mb-6">
                <label for="whatsapp" class="block text-sm font-semibold text-primary-dark mb-1.5">Nomor WhatsApp</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2">
                        <i class="fab fa-whatsapp text-green-500"></i>
                    </span>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="082233386148"
                           class="w-full pl-10 pr-4 py-2.5 border border-primary-lighter rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-sm">
                </div>
                @error('whatsapp')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full sm:w-auto bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-8 py-2.5 rounded-full text-sm font-bold font-display transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-save text-sm"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Delete Avatar Form (hidden) --}}
    <form id="delete-avatar-form" action="{{ route('user.profile.avatar.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- Change Password --}}
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-primary-lighter/40 bg-white/50">
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-lock text-cta"></i> Ubah Password
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Pastikan menggunakan password yang kuat dan unik.</p>
        </div>
        <form action="{{ route('user.profile.password') }}" method="POST" class="p-5 sm:p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-primary-dark mb-1.5">Password Baru</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2.5 border border-primary-lighter rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-sm">
                <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1"><i class="fas fa-info-circle"></i> Minimal 8 karakter</p>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-primary-dark mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-4 py-2.5 border border-primary-lighter rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-sm">
            </div>

            <button type="submit" class="w-full sm:w-auto bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-8 py-2.5 rounded-full text-sm font-bold font-display transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-key text-sm"></i> Ubah Password
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
