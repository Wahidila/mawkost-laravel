@extends('layouts.admin')

@section('title', 'Daftar Pesanan')
@section('header', 'Pesanan Kost')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="flex justify-between items-center p-6 border-b border-primary-lighter/40 bg-white/50">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-shopping-cart text-cta"></i> Daftar Transaksi
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua pesanan sewa kost yang masuk ke sistem.</p>
        </div>
    </div>
    
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-primary-lighter/30">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Invoice</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Pembeli / Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Kost Tujuan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Nominal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent divide-y divide-primary-lighter/20">
                @forelse($orders as $item)
                <tr class="hover:bg-primary-lighter/5 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $item->invoice_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                        {{ $item->customer_name }} 
                        <br><span class="text-gray-500 text-xs font-normal">{{ $item->customer_email }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $item->kost->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-dark font-bold">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-full shadow-sm border
                        @if($item->status == 'paid') bg-green-50 text-green-700 border-green-200
                        @elseif($item->status == 'pending') bg-yellow-50 text-yellow-700 border-yellow-200
                        @else bg-red-50 text-red-700 border-red-200 @endif uppercase tracking-wider">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $item->id) }}" class="text-primary hover:text-white bg-primary-lighter/30 hover:bg-primary px-4 py-1.5 rounded-full transition-colors duration-200 inline-flex items-center gap-1.5 shadow-sm text-xs font-bold">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-receipt text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Belum ada data pesanan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-primary-lighter/30 bg-primary-lighter/5">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
