@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('header', 'Tambah Pengguna Baru')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-user-plus text-cta"></i> Tambah Pengguna Baru
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Buat akun pengguna baru untuk platform mawkost.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mx-6 mt-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 text-sm flex items-start gap-3">
            <i class="fas fa-exclamation-circle mt-0.5 text-red-400"></i>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="p-6 space-y-6">
            <!-- Section: Informasi Akun -->
            <div class="bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50">
                <h4 class="text-md font-bold font-display text-primary-dark mb-4 pb-2 border-b border-primary-lighter/50 flex items-center gap-2">
                    <i class="fas fa-user text-primary"></i> Informasi Akun
                </h4>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-primary-dark mb-1.5">Alamat Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-primary-dark mb-1.5">WhatsApp / No. HP</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2">
                                <i class="fab fa-whatsapp text-green-500"></i>
                            </span>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08123456789" class="w-full pl-10 pr-4 py-2.5 border border-primary-lighter rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-primary-dark mb-1.5">Role Akses <span class="text-red-400">*</span></label>
                        <select name="role" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-gray-700" required>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Pembeli Kost)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section: Keamanan -->
            <div class="bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50">
                <h4 class="text-md font-bold font-display text-primary-dark mb-4 pb-2 border-b border-primary-lighter/50 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-primary"></i> Keamanan
                </h4>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-primary-dark mb-1.5">Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" minlength="8" required>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1"><i class="fas fa-info-circle"></i> Gunakan minimal 8 karakter.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-8 py-2.5 rounded-full text-sm font-bold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-save text-sm"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
