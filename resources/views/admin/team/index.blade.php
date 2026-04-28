@extends('layouts.admin')

@section('title', 'Tim Kami')
@section('header', 'Kelola Tim')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Anggota Tim</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola data tim yang tampil di halaman Tentang Kami.</p>
        </div>
    </div>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="p-6 border-b border-primary-lighter/30 bg-primary-lighter/5">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-primary-dark mb-1">Nama</label>
                <input type="text" name="name" placeholder="Nama lengkap..." class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400" required>
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-primary-dark mb-1">Posisi</label>
                <input type="text" name="position" placeholder="CEO, CTO, Designer..." class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400" required>
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-primary-dark mb-1">Foto (Opsional)</label>
                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full border border-primary-lighter rounded-xl px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 transition-all file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-lighter file:text-primary-dark">
            </div>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-plus text-xs"></i> Tambah
            </button>
        </div>
        @if($errors->any())
            <div class="mt-2">
                @foreach($errors->all() as $error)
                    <p class="text-red-500 text-xs font-medium">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Foto</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Posisi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($members as $member)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($member->photo_url)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-full object-cover border border-primary-lighter">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary-lighter flex items-center justify-center text-primary font-bold font-display text-sm">{{ $member->initials }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $member->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $member->position }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.team.edit', $member->id) }}" class="text-primary hover:text-cta transition-colors flex items-center gap-1.5">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota tim ini?');">
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
                            <i class="fa-solid fa-users text-3xl mb-3 text-primary-light"></i>
                            <p class="text-gray-500">Belum ada anggota tim.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($members->hasPages())
    <div class="p-4 border-t border-primary-lighter/30">
        {{ $members->links() }}
    </div>
    @endif
</div>
@endsection
