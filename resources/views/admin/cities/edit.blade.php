@extends('layouts.admin')

@section('title', 'Edit Kota')
@section('header', 'Edit Kota: ' . $city->name)

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-city text-cta"></i> Edit Data Kota
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Ubah informasi kota.</p>
        </div>
        <a href="{{ route('admin.cities.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Kota</label>
                <input type="text" name="name" value="{{ old('name', $city->name) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-primary-lighter/10 transition-all placeholder:text-gray-400" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Upload Gambar Kota (Opsional)</label>
                @if($city->image)
                    <div class="border border-primary-lighter rounded-xl p-3 mb-3 bg-primary-lighter/10 flex items-center gap-4 w-full max-w-sm">
                        <img src="{{ asset($city->image) }}" alt="Preview" class="h-16 w-auto object-cover rounded-lg shadow-sm">
                        <span class="text-xs text-gray-500 font-medium">Gambar Saat Ini</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-lighter file:text-primary-dark hover:file:bg-primary-light">
                <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1"><i class="fas fa-info-circle"></i> Format: JPG, JPEG, PNG, WEBP (Maks: 2MB). Biarkan kosong jika tidak ingin mengubah gambar.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Jumlah Kost Terdaftar</label>
                <input type="text" value="{{ $city->kosts()->count() }}" class="w-full border border-primary-lighter/50 rounded-xl px-4 py-2.5 text-sm bg-primary-lighter/10 text-gray-400 cursor-not-allowed" readonly disabled>
                <p class="text-xs text-gray-400 mt-1.5">Jumlah ini dihitung otomatis dari data Kost.</p>
            </div>
        </div>

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.cities.index') }}" class="px-5 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-save text-xs"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
