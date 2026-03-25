@extends('layouts.user')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Greeting -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Halo, {{ $user->name }}! 👋</h1>
    <p class="text-gray-500 mt-1">Berikut ringkasan akun dan kost yang sudah Anda unlock.</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-key fa-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Unlock</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-wallet fa-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-user-check fa-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Member Sejak</p>
                <p class="text-lg font-bold text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Unlocked Kost -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Kost yang Sudah Di-unlock</h3>
        @if($recentOrders->count() > 0)
            <a href="{{ route('user.orders') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua →</a>
        @endif
    </div>

    @if($recentOrders->isEmpty())
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $order->invoice_no }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $order->kost->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->kost->city->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-eye mr-1"></i> Lihat Info
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
