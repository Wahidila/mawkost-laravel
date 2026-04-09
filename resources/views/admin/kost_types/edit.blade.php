@extends('layouts.admin')

@section('title', 'Edit Tipe Kost')
@section('header', 'Edit Tipe Kost')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50">
        <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
            <i class="fas fa-layer-group text-cta"></i> Edit Tipe Kost
        </h3>
        <p class="text-sm text-gray-500 mt-0.5">Ubah nama tipe kost.</p>
    </div>
    
    <form action="{{ route('admin.kost_types.update', $kostType->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 space-y-5">
            <div>
                <label for="name" class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Tipe</label>
                <input type="text" name="name" id="name" value="{{ old('name', $kostType->name) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-primary-lighter/10 transition-all placeholder:text-gray-400" required>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-1.5">Slug (Otomatis)</label>
                <input type="text" value="{{ $kostType->slug }}" class="w-full border border-primary-lighter/50 rounded-xl px-4 py-2.5 text-sm bg-primary-lighter/10 text-gray-400 cursor-not-allowed" disabled>
                <p class="text-xs text-gray-400 mt-1.5">Slug dibuat otomatis dari nama tipe dan tidak dapat diubah secara manual.</p>
            </div>
        </div>
        
        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.kost_types.index') }}" class="px-5 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
