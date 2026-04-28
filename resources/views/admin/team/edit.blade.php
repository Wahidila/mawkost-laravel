@extends('layouts.admin')

@section('title', 'Edit Anggota Tim')
@section('header', 'Edit: ' . $member->name)

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-user-edit text-cta"></i> Edit Anggota Tim
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi anggota tim.</p>
        </div>
        <a href="{{ route('admin.team.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.team.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Posisi / Jabatan</label>
                <input type="text" name="position" value="{{ old('position', $member->position) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Foto Profil</label>
                @if($member->photo_url)
                    <div class="border border-primary-lighter rounded-xl p-3 mb-3 bg-primary-lighter/10 flex items-center gap-4">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-14 h-14 rounded-full object-cover border border-primary-lighter shadow-sm">
                        <div>
                            <p class="text-xs text-gray-500 font-medium mb-1">Foto saat ini</p>
                            <label class="inline-flex items-center gap-2 text-xs text-red-600 hover:text-red-700 cursor-pointer">
                                <input type="checkbox" name="remove_photo" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span>Hapus foto</span>
                            </label>
                        </div>
                    </div>
                @else
                    <div class="border border-primary-lighter rounded-xl p-3 mb-3 bg-primary-lighter/10 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-primary-lighter flex items-center justify-center text-primary font-bold font-display text-lg">{{ $member->initials }}</div>
                        <p class="text-xs text-gray-500 font-medium">Belum ada foto — menampilkan inisial.</p>
                    </div>
                @endif
                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 transition-all file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-lighter file:text-primary-dark hover:file:bg-primary-light">
                <p class="text-xs text-gray-400 mt-1.5"><i class="fas fa-info-circle mr-1"></i>Format: JPG, PNG, WEBP. Maks: 2MB. Biarkan kosong jika tidak ingin mengubah.</p>
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.team.index') }}" class="px-5 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-save text-xs"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
