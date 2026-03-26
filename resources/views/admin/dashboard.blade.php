@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-2">
    <!-- Stat Cards -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-primary-lighter/80 text-primary-dark mr-4">
                <i class="fas fa-building text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Total Kost</p>
                <p class="text-3xl font-bold font-display text-primary-dark">{{ \App\Models\Kost::count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-[rgba(232,115,74,0.15)] text-cta mr-4">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold font-display text-primary-dark">{{ \App\Models\Order::count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-primary-lighter/80 text-primary-dark mr-4">
                <i class="fas fa-city text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Total Kota</p>
                <p class="text-3xl font-bold font-display text-primary-dark">{{ \App\Models\City::count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100/50 text-[#166534] mr-4">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Pendapatan</p>
                <p class="text-2xl font-bold font-display text-primary-dark tracking-tight">Rp {{ number_format(\App\Models\Order::where('status', 'paid')->sum('amount'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Pesanan Terbaru</h3>
        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors">Lihat Semua <i class="fa-solid fa-arrow-right text-xs ml-1"></i></a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Invoice</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Pembeli</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kost</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse(\App\Models\Order::latest()->take(5)->get() as $order)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $order->invoice_no }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $order->customer_name }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">{{ $order->kost->name ?? '-' }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                        @if($order->status == 'paid') bg-green-100 text-green-800 
                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800 
                        @else bg-red-100 text-red-800 @endif border 
                        @if($order->status == 'paid') border-green-200
                        @elseif($order->status == 'pending') border-yellow-200
                        @else border-red-200 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 whitespace-nowrap text-sm text-center text-text-muted font-medium bg-gray-50/30">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-inbox text-3xl mb-3 text-primary-light"></i>
                            <p>Belum ada pesanan terbaru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
