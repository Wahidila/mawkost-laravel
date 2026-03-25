@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('header', 'Edit Profil Pengguna')

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6 max-w-2xl">
    <div class="flex justify-between items-center border-b pb-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Form Edit Pengguna</h3>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm border border-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Email *</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">WhatsApp / No. HP</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Role Akses *</label>
            <select name="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Pembeli Kost)</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
            </select>
        </div>

        <!-- Bagian Password (Khusus Edit) -->
        <div class="mb-6 border-t pt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Password</label>
            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="••••••••" minlength="8">
            <p class="text-xs text-gray-500 mt-1">Kosongkan saja jika tidak ingin mengubah password.</p>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
