@extends('layouts.admin')

@section('title', 'Edit Kota')
@section('header', 'Edit Kota: ' . $city->name)

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6 max-w-2xl">
    <div class="flex justify-between items-center border-b pb-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Edit Data Kota</h3>
        <a href="{{ route('admin.cities.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kota</label>
            <input type="text" name="name" value="{{ old('name', $city->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Upload Gambar Kota (Opsional)</label>
            @if($city->image)
                <div class="border rounded p-2 mb-3 bg-gray-50 flex items-center justify-between w-full max-w-sm">
                    <img src="{{ asset($city->image) }}" alt="Preview" class="h-16 w-auto object-cover rounded shadow-sm">
                    <span class="text-xs text-gray-500">Gambar Saat Ini</span>
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-white leading-tight focus:outline-none focus:shadow-outline">
            <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Format yang diizinkan: JPG, JPEG, PNG, WEBP (Maks: 2MB). Biarkan kosong jika tidak ingin mengubah gambar.</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kost Terdaftar</label>
            <input type="text" value="{{ $city->kosts()->count() }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 bg-gray-100 cursor-not-allowed" readonly disabled>
            <p class="text-xs text-gray-500 mt-1">Jumlah ini dihitung otomatis dari data Kost.</p>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
