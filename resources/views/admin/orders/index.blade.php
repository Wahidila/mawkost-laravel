@extends('layouts.admin')

@section('title', 'Daftar Pesanan')
@section('header', 'Pesanan Kost')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-shopping-cart text-cta"></i> Daftar Transaksi
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua pesanan yang masuk ke sistem.</p>
        </div>
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition-colors shadow-sm">
            <i class="fas fa-file-csv text-xs"></i> Export CSV
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="px-6 py-3 border-b border-primary-lighter/30 bg-primary-lighter/5">
        <!-- Status Pills -->
        <div class="flex items-center gap-2 flex-wrap mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mr-1">Status:</span>
            <a href="{{ route('admin.orders.index', request()->except('status', 'page')) }}"
               class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ !($currentStatus ?? null) ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                Semua ({{ $stats['all'] }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}"
               class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ ($currentStatus ?? '') === 'pending' ? 'bg-yellow-500 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-yellow-50 hover:text-yellow-700' }}">
                Pending ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'paid'])) }}"
               class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ ($currentStatus ?? '') === 'paid' ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-green-50 hover:text-green-700' }}">
                Paid ({{ $stats['paid'] }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'expired'])) }}"
               class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ ($currentStatus ?? '') === 'expired' ? 'bg-red-500 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-red-50 hover:text-red-700' }}">
                Expired ({{ $stats['expired'] }})
            </a>
            @if($stats['refunded'] > 0)
            <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'refunded'])) }}"
               class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ ($currentStatus ?? '') === 'refunded' ? 'bg-purple-500 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-purple-50 hover:text-purple-700' }}">
                Refunded ({{ $stats['refunded'] }})
            </a>
            @endif
        </div>
        <!-- Search + Date Range -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice, nama, atau email..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dari</label>
                <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Sampai</label>
                <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-dark transition-colors">
                <i class="fas fa-search text-xs mr-1"></i> Cari
            </button>
            @if(request('search') || request('from') || request('to'))
                <a href="{{ route('admin.orders.index', request('status') ? ['status' => request('status')] : []) }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
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
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent divide-y divide-primary-lighter/20">
                @forelse($orders as $item)
                <tr class="hover:bg-primary-lighter/5 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-dark font-mono">{{ $item->invoice_no }}</td>
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
                        @elseif($item->status == 'refunded') bg-purple-50 text-purple-700 border-purple-200
                        @else bg-red-50 text-red-700 border-red-200 @endif uppercase tracking-wider">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ $item->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $item->id) }}" class="text-primary hover:text-white bg-primary-lighter/30 hover:bg-primary px-4 py-1.5 rounded-full transition-colors duration-200 inline-flex items-center gap-1.5 shadow-sm text-xs font-bold">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-receipt text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Tidak ada pesanan ditemukan</p>
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
