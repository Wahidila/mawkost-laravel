@extends('layouts.admin')

@section('title', 'Kelola Kost')
@section('header', 'Kelola Kost')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Daftar Kost</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua data kost yang terdaftar di platform.</p>
        </div>
        <a href="{{ route('admin.kosts.create') }}" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-plus text-xs"></i> Tambah Kost
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="px-6 py-3 border-b border-primary-lighter/30 bg-primary-lighter/5 flex items-center gap-2 flex-wrap">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mr-1">Filter:</span>
        <a href="{{ route('admin.kosts.index') }}" 
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ !isset($currentFilter) || !$currentFilter ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.kosts.index', ['filter' => 'featured']) }}" 
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 flex items-center gap-1.5 {{ ($currentFilter ?? '') === 'featured' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-amber-50 hover:border-amber-200 hover:text-amber-700' }}">
            <i class="fas fa-crown text-[10px]"></i> Featured
        </a>
        <a href="{{ route('admin.kosts.index', ['filter' => 'recommended']) }}" 
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 flex items-center gap-1.5 {{ ($currentFilter ?? '') === 'recommended' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700' }}">
            <i class="fas fa-thumbs-up text-[10px]"></i> Rekomendasi
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Nama Kost</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kota</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Label</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($kosts as $item)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $item->name }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">{{ $item->city->name ?? '-' }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-cta/10 text-cta border border-cta/20">
                            {{ $item->kostType->name ?? ucfirst($item->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold text-primary-dark">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        @if($item->status == 'tersedia')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                Tersedia
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                Penuh
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-center">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Toggle Featured --}}
                            <form action="{{ route('admin.kosts.toggleFeatured', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="{{ $item->is_featured ? 'Nonaktifkan Featured' : 'Aktifkan Featured' }}"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 {{ $item->is_featured ? 'bg-amber-100 text-amber-600 border border-amber-200 hover:bg-amber-200 shadow-sm' : 'bg-gray-50 text-gray-300 border border-gray-200 hover:bg-amber-50 hover:text-amber-400 hover:border-amber-200' }}">
                                    <i class="fas fa-crown text-xs"></i>
                                </button>
                            </form>
                            {{-- Toggle Rekomendasi --}}
                            <form action="{{ route('admin.kosts.toggleRecommended', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="{{ $item->is_recommended ? 'Nonaktifkan Rekomendasi' : 'Aktifkan Rekomendasi' }}"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 {{ $item->is_recommended ? 'bg-blue-100 text-blue-600 border border-blue-200 hover:bg-blue-200 shadow-sm' : 'bg-gray-50 text-gray-300 border border-gray-200 hover:bg-blue-50 hover:text-blue-400 hover:border-blue-200' }}">
                                    <i class="fas fa-thumbs-up text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.kosts.edit', $item->id) }}" class="text-primary hover:text-cta transition-colors flex items-center gap-1.5">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.kosts.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kost ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-1.5">
                                    <i class="fas fa-trash text-xs"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 whitespace-nowrap text-sm text-center font-medium bg-gray-50/30">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-building text-3xl mb-3 text-primary-light"></i>
                            <p class="text-gray-500">Belum ada data kost.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kosts->hasPages())
    <div class="p-4 border-t border-primary-lighter/30">
        {{ $kosts->links() }}
    </div>
    @endif
</div>
@endsection
