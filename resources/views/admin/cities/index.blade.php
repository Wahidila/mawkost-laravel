@extends('layouts.admin')

@section('title', 'Data Kota')
@section('header', 'Data Kota')

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4 border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Kota</h3>
        <form action="{{ route('admin.cities.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nama Kota..." class="border rounded px-3 py-1 text-sm focus:outline-none focus:ring bg-gray-50" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-1 px-4 rounded text-sm whitespace-nowrap">
                <i class="fas fa-plus mr-1"></i> Tambah Kota
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kost Terdaftar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($cities as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->slug }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->kosts_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-4 w-full">
                        <a href="{{ route('admin.cities.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.cities.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kota ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Data belum tersedia</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $cities->links() }}
    </div>
</div>
@endsection
