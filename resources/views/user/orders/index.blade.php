@extends('layouts.user')

@section('title', 'Kost Saya')
@section('header', 'Kost Saya')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Riwayat Pesanan</h3>

    @if($orders->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
            <h4 class="text-gray-500 font-medium">Belum ada pesanan</h4>
            <p class="text-gray-400 text-sm mt-1">Cari kost impianmu dan unlock info kontaknya!</p>
            <a href="{{ route('kost.search') }}" class="inline-block mt-4 bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg text-sm font-bold transition">
                <i class="fas fa-search mr-1"></i> Cari Kost
            </a>
        </div>
    @else
        {{-- Desktop: Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kota</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $order->invoice_no }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $order->kost->title ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->kost->city->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->formatted_amount }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($order->status === 'paid')
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-green-100 text-green-700 border border-green-200">Lunas</span>
                            @elseif($order->status === 'pending')
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">Menunggu</span>
                            @elseif($order->status === 'expired')
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-gray-100 text-gray-600 border border-gray-200">Kedaluwarsa</span>
                            @elseif($order->status === 'refunded')
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-purple-100 text-purple-700 border border-purple-200">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($order->status === 'paid')
                                <a href="{{ route('user.orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-primary hover:bg-primary-dark text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    <i class="fas fa-eye"></i> Info
                                </a>
                            @elseif($order->status === 'pending' && $order->xendit_invoice_url)
                                <a href="{{ $order->xendit_invoice_url }}" target="_blank" class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    <i class="fas fa-credit-card"></i> Bayar
                                </a>
                            @elseif($order->status === 'expired')
                                <form action="{{ route('user.orders.retry', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 bg-cta hover:bg-cta-hover text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fas fa-redo"></i> Ulang
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile: Cards --}}
        <div class="md:hidden space-y-3">
            @foreach($orders as $order)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-1">
                    <h4 class="font-medium text-gray-900 text-sm flex-1 pr-2">{{ $order->kost->title ?? '-' }}</h4>
                    @if($order->status === 'paid')
                        <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full border border-green-200">Lunas</span>
                    @elseif($order->status === 'pending')
                        <span class="text-[10px] font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full border border-yellow-200">Menunggu</span>
                    @elseif($order->status === 'expired')
                        <span class="text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded-full border border-gray-200">Kedaluwarsa</span>
                    @elseif($order->status === 'refunded')
                        <span class="text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full border border-purple-200">Dikembalikan</span>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-500 mb-3">
                    <span><i class="fas fa-location-dot mr-0.5"></i> {{ $order->kost->city->name ?? '-' }}</span>
                    <span class="text-gray-300">|</span>
                    <span class="font-mono">{{ $order->invoice_no }}</span>
                    <span class="text-gray-300">|</span>
                    <span>{{ $order->formatted_amount }}</span>
                </div>
                @if($order->status === 'paid')
                    <a href="{{ route('user.orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-primary hover:bg-primary-dark text-white px-3 py-2 rounded-lg text-xs font-bold transition w-full justify-center">
                        <i class="fas fa-eye"></i> Lihat Info Kontak
                    </a>
                @elseif($order->status === 'pending' && $order->xendit_invoice_url)
                    <a href="{{ $order->xendit_invoice_url }}" target="_blank" class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs font-bold transition w-full justify-center">
                        <i class="fas fa-credit-card"></i> Lanjutkan Pembayaran
                    </a>
                @elseif($order->status === 'expired')
                    <form action="{{ route('user.orders.retry', $order->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 bg-cta hover:bg-cta-hover text-white px-3 py-2 rounded-lg text-xs font-bold transition w-full justify-center">
                            <i class="fas fa-redo"></i> Bayar Ulang
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
