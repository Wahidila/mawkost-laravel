@extends('layouts.user')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Greeting -->
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold font-display text-primary-dark">Halo, {{ $user->name }}! 👋</h1>
    <p class="text-text-muted mt-2 text-sm sm:text-base">Berikut ringkasan akun dan kost yang sudah Anda unlock.</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-10">
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 sm:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-primary-lighter/80 text-primary-dark mr-4">
                <i class="fas fa-key text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Total Unlock</p>
                <p class="text-3xl font-bold font-display text-primary-dark">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 sm:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-[rgba(232,115,74,0.15)] text-cta mr-4">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Pengeluaran</p>
                <p class="text-2xl sm:text-3xl font-bold font-display text-primary-dark tracking-tight">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    @if($pendingOrders > 0)
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-yellow-200 p-5 sm:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Menunggu Bayar</p>
                <p class="text-3xl font-bold font-display text-yellow-600">{{ $pendingOrders }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/50 p-5 sm:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(92,61,46,0.12)]">
        <div class="flex items-center">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-primary-lighter/80 text-primary-dark mr-4">
                <i class="fas fa-user-check text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-text-muted font-medium mb-1">Member Sejak</p>
                <p class="text-lg font-bold font-display text-primary-dark">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Unlocked Kost -->
<div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-primary-lighter/40 bg-white/50 flex justify-between items-center">
        <h3 class="text-lg sm:text-xl font-bold font-display text-primary-dark tracking-tight">Riwayat Pesanan</h3>
        @if($recentOrders->count() > 0)
            <a href="{{ route('user.orders') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors">Lihat Semua <i class="fa-solid fa-arrow-right text-xs ml-1"></i></a>
        @endif
    </div>

    @if($recentOrders->isEmpty())
        <div class="text-center py-16 px-4">
            <div class="w-20 h-20 bg-primary-lighter rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-box-open text-3xl text-primary-light"></i>
            </div>
            <h4 class="text-lg font-bold font-display text-primary-dark mb-2">Belum ada kost yang di-unlock</h4>
            <p class="text-text-muted text-sm sm:text-base max-w-sm mx-auto">Cari kost impianmu dan unlock info kontaknya untuk mulai berkomunikasi dengan pemilik!</p>
            <a href="{{ route('kost.search') }}" class="inline-flex mt-6 bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-full text-sm font-bold font-display transition-all duration-200 shadow-md hover:shadow-[0_8px_24px_rgba(139,94,60,0.25)] hover:-translate-y-1">
                <i class="fas fa-search mr-2 mt-[2px]"></i> Mulai Cari Kost
            </a>
        </div>
    @else
        {{-- Desktop: Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-primary-lighter/50">
                <thead class="bg-primary-lighter/20">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Nama Kost</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kota</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-lighter/30">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                        <td class="px-6 py-5 text-sm font-semibold text-primary-dark">{{ $order->invoice_no }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-gray-700">{{ $order->kost->name ?? '-' }}</td>
                        <td class="px-6 py-5 text-sm text-text-muted">{{ $order->kost->city->name ?? '-' }}</td>
                        <td class="px-6 py-5 text-sm">
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
                        <td class="px-6 py-5 text-sm text-text-muted">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-5 text-sm">
                            @if($order->status === 'paid')
                                <a href="{{ route('user.orders.show', $order->id) }}" class="inline-flex items-center text-primary font-bold bg-primary-lighter px-4 py-2 rounded-full hover:bg-primary hover:text-white transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i> Info
                                </a>
                            @elseif($order->status === 'pending' && $order->xendit_invoice_url)
                                <a href="{{ $order->xendit_invoice_url }}" target="_blank" class="inline-flex items-center text-yellow-700 font-bold bg-yellow-100 px-4 py-2 rounded-full hover:bg-yellow-200 transition-colors duration-200">
                                    <i class="fas fa-credit-card mr-2"></i> Bayar
                                </a>
                            @elseif($order->status === 'expired')
                                <form action="{{ route('user.orders.retry', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center text-cta font-bold bg-orange-100 px-4 py-2 rounded-full hover:bg-orange-200 transition-colors duration-200">
                                        <i class="fas fa-redo mr-2"></i> Bayar Ulang
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
        <div class="md:hidden p-4 space-y-4">
            @foreach($recentOrders as $order)
            <div class="border border-primary-lighter/50 bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-3">
                    <h4 class="font-bold font-display text-primary-dark text-base">{{ $order->kost->name ?? '-' }}</h4>
                    @if($order->status === 'paid')
                        <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full border border-green-200">Lunas</span>
                    @elseif($order->status === 'pending')
                        <span class="text-[10px] font-bold bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full border border-yellow-200">Menunggu</span>
                    @elseif($order->status === 'expired')
                        <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full border border-gray-200">Kedaluwarsa</span>
                    @elseif($order->status === 'refunded')
                        <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full border border-purple-200">Dikembalikan</span>
                    @endif
                </div>
                <div class="flex items-center gap-2 text-xs text-text-muted mb-4">
                    <i class="fas fa-location-dot text-primary-light"></i>
                    <span>{{ $order->kost->city->name ?? '-' }}</span>
                    <span class="text-border mx-1">|</span>
                    <span class="font-medium">{{ $order->invoice_no }}</span>
                </div>
                @if($order->status === 'paid')
                    <a href="{{ route('user.orders.show', $order->id) }}" class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-full text-sm font-bold font-display transition-colors w-full">
                        <i class="fas fa-eye"></i> Lihat Info Kontak
                    </a>
                @elseif($order->status === 'pending' && $order->xendit_invoice_url)
                    <a href="{{ $order->xendit_invoice_url }}" target="_blank" class="flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2.5 rounded-full text-sm font-bold font-display transition-colors w-full">
                        <i class="fas fa-credit-card"></i> Lanjutkan Pembayaran
                    </a>
                @elseif($order->status === 'expired')
                    <form action="{{ route('user.orders.retry', $order->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 bg-cta hover:bg-cta-hover text-white px-4 py-2.5 rounded-full text-sm font-bold font-display transition-colors w-full">
                            <i class="fas fa-redo"></i> Bayar Ulang
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
