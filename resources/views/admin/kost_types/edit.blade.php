@extends('layouts.admin')

@section('title', 'Edit Tipe Kost')
@section('header', 'Edit Tipe Kost')

@section('content')
<div class="bg-white w-full shadow rounded-lg max-w-2xl">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800"><i class="fas fa-layer-group text-primary mr-2"></i> Edit Tipe Kost</h3>
        <p class="text-sm text-gray-500 mt-1">Ubah nama tipe kost.</p>
    </div>
    
    <form action="{{ route('admin.kost_types.update', $kostType->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tipe</label>
                <input type="text" name="name" id="name" value="{{ old('name', $kostType->name) }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" required>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Slug (Otomatis)</label>
                <input type="text" value="{{ $kostType->slug }}" class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed" disabled>
                <p class="text-xs text-gray-400 mt-1">Slug dibuat otomatis dari nama tipe dan tidak dapat diubah secara manual.</p>
            </div>
        </div>
        
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 rounded-b-lg">
            <a href="{{ route('admin.kost_types.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded text-sm transition-colors">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded text-sm shadow-sm transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
