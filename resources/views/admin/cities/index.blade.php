@extends('layouts.admin')

@section('title', 'Data Kota')
@section('header', 'Data Kota')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Daftar Kota</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola wilayah kota yang tersedia di platform.</p>
        </div>
        <form action="{{ route('admin.cities.store') }}" method="POST" class="flex gap-2 w-full sm:w-auto">
            @csrf
            <input type="text" name="name" placeholder="Nama Kota Baru..." class="border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-primary-lighter/10 flex-1 min-w-[180px] transition-all placeholder:text-gray-400" required>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-plus text-xs"></i> Tambah
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Nama Kota</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Slug</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kost Terdaftar</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($cities as $item)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $item->name }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        <code class="px-2 py-0.5 bg-primary-lighter/30 text-primary rounded text-xs font-mono">{{ $item->slug }}</code>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                            {{ $item->kosts_count }} Kost
                        </span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.cities.edit', $item->id) }}" class="text-primary hover:text-cta transition-colors flex items-center gap-1.5">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.cities.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kota ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-1.5">
                                    <i class="fas fa-trash text-xs"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 whitespace-nowrap text-sm text-center font-medium bg-gray-50/30">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-city text-3xl mb-3 text-primary-light"></i>
                            <p class="text-gray-500">Belum ada data kota.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($cities->hasPages())
    <div class="p-4 border-t border-primary-lighter/30">
        {{ $cities->links() }}
    </div>
    @endif
</div>
@endsection
