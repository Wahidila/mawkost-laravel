@extends('layouts.admin')

@section('title', 'Data Tipe Kost')
@section('header', 'Data Tipe Kost')

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4 border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Tipe Kost</h3>
        <form action="{{ route('admin.kost_types.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nama Tipe... (Misal: Eksklusif)" class="border rounded px-3 py-1 text-sm focus:outline-none focus:ring bg-gray-50 flex-1 min-w-[200px]" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-1 px-4 rounded text-sm whitespace-nowrap">
                <i class="fas fa-plus mr-1"></i> Tambah Tipe
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kost Terdaftar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($kostTypes as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->slug }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $item->kosts_count }} Kost
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-4 w-full">
                        <a href="{{ route('admin.kost_types.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.kost_types.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tipe kost ini? Semua kost dengan tipe ini mungkin kehilangan klasifikasinya.');">
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
        {{ $kostTypes->links() }}
    </div>
</div>
@endsection
