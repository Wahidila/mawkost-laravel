@extends('layouts.admin')

@section('title', 'Kelola Voucher')
@section('header', 'Kelola Voucher')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50">
        <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Daftar Voucher</h3>
        <p class="text-sm text-gray-500 mt-0.5">Buat dan kelola kode promo untuk diskon unlock kost.</p>
    </div>

    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="p-6 border-b border-primary-lighter/30 bg-primary-lighter/5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Kode Voucher</label>
                <input type="text" name="code" placeholder="MAWKOST50" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white uppercase" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Tipe Diskon</label>
                <select name="discount_type" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
                    <option value="fixed">Nominal (Rp)</option>
                    <option value="percentage">Persentase (%)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Nilai Diskon</label>
                <input type="number" name="discount_value" placeholder="10000 atau 50" min="1" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Maks Penggunaan</label>
                <input type="number" name="max_uses" placeholder="Kosong = unlimited" min="1" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Expired</label>
                <input type="datetime-local" name="expires_at" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
            </div>
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Min. Transaksi (Rp)</label>
                <input type="number" name="min_amount" placeholder="Kosong = tanpa minimum" min="0" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
            </div>
            <div>
                <label class="block text-xs font-semibold text-primary-dark mb-1">Deskripsi</label>
                <input type="text" name="description" placeholder="Promo launching, dll" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
            </div>
        </div>
        <button type="submit" class="bg-primary text-white hover:bg-primary-dark px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200">
            <i class="fas fa-plus text-xs mr-1"></i> Buat Voucher
        </button>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="text-red-500 text-xs mt-2">{{ $error }}</p>
            @endforeach
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kode</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Diskon</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Penggunaan</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Expired</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($vouchers as $v)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-5 py-4 whitespace-nowrap">
                        <code class="px-2.5 py-1 bg-primary-lighter/40 text-primary-dark rounded-lg text-sm font-bold font-mono tracking-wider">{{ $v->code }}</code>
                        @if($v->description)
                            <p class="text-xs text-gray-400 mt-1">{{ $v->description }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm font-semibold text-primary-dark">
                        {{ $v->formatted_discount }}
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm">
                        <span class="font-semibold text-primary-dark">{{ $v->used_count }}</span>
                        <span class="text-gray-400">/ {{ $v->max_uses ?? '∞' }}</span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                        @if($v->expires_at)
                            {{ $v->expires_at->format('d M Y H:i') }}
                            @if($v->expires_at->isPast())
                                <span class="text-red-500 font-semibold ml-1">Expired</span>
                            @endif
                        @else
                            <span class="text-gray-400">Tanpa batas</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-center">
                        @php
                            $isUsable = $v->is_active
                                && (!$v->expires_at || !$v->expires_at->isPast())
                                && (!$v->max_uses || $v->used_count < $v->max_uses);
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $isUsable ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $isUsable ? 'Aktif' : ($v->is_active ? 'Expired/Habis' : 'Nonaktif') }}
                        </span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.vouchers.edit', $v->id) }}" class="text-primary hover:text-cta transition-colors"><i class="fas fa-edit text-xs"></i> Edit</a>
                            <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus voucher ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors"><i class="fas fa-trash text-xs"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-sm text-center text-gray-400">
                        <i class="fas fa-ticket text-3xl text-primary-lighter mb-2 block"></i>
                        Belum ada voucher.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vouchers->hasPages())
    <div class="p-4 border-t border-primary-lighter/30">{{ $vouchers->links() }}</div>
    @endif
</div>
@endsection
