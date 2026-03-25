@extends('layouts.user')

@section('title', 'Kost Saya')
@section('header', 'Kost Saya')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Kost yang Sudah Di-unlock</h3>

    @if($orders->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
            <h4 class="text-gray-500 font-medium">Belum ada kost yang di-unlock</h4>
            <p class="text-gray-400 text-sm mt-1">Cari kost impianmu dan unlock info kontaknya!</p>
            <a href="{{ route('kost.search') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition">
                <i class="fas fa-search mr-1"></i> Cari Kost
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kota</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $order->invoice_no }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $order->kost->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->kost->city->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->formatted_amount }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                <i class="fas fa-eye"></i> Lihat Info
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
