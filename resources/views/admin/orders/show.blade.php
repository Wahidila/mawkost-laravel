@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('header', 'Detail Pesanan: ' . $order->invoice_no)

@section('content')
<!-- Status Banner -->
<div class="mb-6 p-4 rounded-2xl border flex items-center justify-between flex-wrap gap-4
    @if($order->status == 'paid') bg-green-50 border-green-200
    @elseif($order->status == 'pending') bg-yellow-50 border-yellow-200
    @elseif($order->status == 'refunded') bg-purple-50 border-purple-200
    @else bg-red-50 border-red-200 @endif">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center
            @if($order->status == 'paid') bg-green-100 text-green-600
            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-600
            @elseif($order->status == 'refunded') bg-purple-100 text-purple-600
            @else bg-red-100 text-red-600 @endif">
            @if($order->status == 'paid') <i class="fas fa-check"></i>
            @elseif($order->status == 'pending') <i class="fas fa-clock"></i>
            @elseif($order->status == 'refunded') <i class="fas fa-undo"></i>
            @else <i class="fas fa-times"></i> @endif
        </div>
        <div>
            <span class="text-sm font-bold uppercase tracking-wider
                @if($order->status == 'paid') text-green-700
                @elseif($order->status == 'pending') text-yellow-700
                @elseif($order->status == 'refunded') text-purple-700
                @else text-red-700 @endif">
                {{ $order->status == 'paid' ? 'Lunas' : ($order->status == 'pending' ? 'Menunggu Pembayaran' : ($order->status == 'refunded' ? 'Dikembalikan' : 'Kedaluwarsa')) }}
            </span>
            <p class="text-xs text-gray-500 mt-0.5">{{ $order->invoice_no }} &middot; {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 bg-white px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- LEFT: Customer & Kost Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Customer Info -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
            <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
                <h3 class="text-base font-bold font-display text-primary-dark flex items-center gap-2">
                    <i class="fas fa-user text-primary text-sm"></i> Informasi Pembeli
                </h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-user text-xs"></i></span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Nama</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $order->customer_name }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fab fa-whatsapp text-xs"></i></span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_whatsapp) }}" target="_blank" class="text-sm font-semibold text-green-600 hover:underline">{{ $order->customer_whatsapp }}</a>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-envelope text-xs"></i></span>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Email</p>
                        <p class="text-sm text-gray-800">{{ $order->customer_email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kost Info -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
            <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
                <h3 class="text-base font-bold font-display text-primary-dark flex items-center gap-2">
                    <i class="fas fa-building text-primary text-sm"></i> Kost Tujuan
                </h3>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base font-bold text-primary-dark">{{ $order->kost->title ?? 'Kost tidak ditemukan' }}</p>
                        <p class="text-sm text-gray-500 mt-1"><i class="fas fa-location-dot mr-1"></i> {{ $order->kost->city->name ?? '-' }}</p>
                    </div>
                    @if($order->kost)
                    <a href="{{ route('kost.show', [$order->kost->city->slug ?? 'city', $order->kost->slug]) }}" target="_blank" class="text-xs font-semibold text-primary bg-primary-lighter/50 hover:bg-primary hover:text-white px-3 py-1.5 rounded-full transition-colors">
                        <i class="fas fa-external-link-alt mr-1"></i> Lihat
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Xendit Info (if available) -->
        @if($order->xendit_invoice_id)
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
            <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
                <h3 class="text-base font-bold font-display text-primary-dark flex items-center gap-2">
                    <i class="fas fa-credit-card text-primary text-sm"></i> Info Xendit
                </h3>
            </div>
            <div class="p-5 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Invoice ID</span>
                    <span class="font-mono text-gray-800 text-xs">{{ $order->xendit_invoice_id }}</span>
                </div>
                @if($order->xendit_payment_method)
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment Method</span>
                    <span class="font-semibold text-gray-800 uppercase">{{ $order->xendit_payment_method }}</span>
                </div>
                @endif
                @if($order->xendit_payment_channel)
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment Channel</span>
                    <span class="font-semibold text-gray-800 uppercase">{{ $order->xendit_payment_channel }}</span>
                </div>
                @endif
                @if($order->xendit_invoice_url)
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Payment URL</span>
                    <a href="{{ $order->xendit_invoice_url }}" target="_blank" class="text-blue-600 hover:underline text-xs">Buka Link <i class="fas fa-external-link-alt ml-1"></i></a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- RIGHT: Transaction Info + Actions -->
    <div class="space-y-6">
        <!-- Transaction Details -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
            <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
                <h3 class="text-base font-bold font-display text-primary-dark flex items-center gap-2">
                    <i class="fas fa-receipt text-primary text-sm"></i> Detail Transaksi
                </h3>
            </div>
            <div class="p-5 space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Invoice</span>
                    <span class="font-mono font-bold text-primary-dark">{{ $order->invoice_no }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Nominal</span>
                    <span class="font-bold text-primary-dark text-base">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode Bayar</span>
                    <span class="font-semibold text-gray-800 uppercase">{{ $order->payment_method ?? '-' }}</span>
                </div>
                <hr class="border-primary-lighter/30">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Order</span>
                    <span class="text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Bayar</span>
                    <span class="text-gray-800">{{ $order->paid_at ? $order->paid_at->format('d M Y, H:i') : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        @if($order->status !== 'paid' || $order->status === 'paid')
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
            <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
                <h3 class="text-base font-bold font-display text-primary-dark flex items-center gap-2">
                    <i class="fas fa-edit text-primary text-sm"></i> Update Status
                </h3>
            </div>
            <div class="p-5">
                <form id="updateStatusForm" action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" id="statusSelect" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-primary/20 focus:border-primary mb-3">
                        @if($order->status === 'pending')
                            <option value="paid">Tandai Lunas (Paid)</option>
                            <option value="expired">Tandai Kedaluwarsa (Expired)</option>
                        @elseif($order->status === 'paid')
                            <option value="refunded">Tandai Dikembalikan (Refunded)</option>
                        @elseif($order->status === 'expired')
                            <option value="paid">Tandai Lunas (Paid)</option>
                        @elseif($order->status === 'refunded')
                            <option value="paid">Tandai Lunas (Paid)</option>
                        @endif
                    </select>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-lg text-sm font-bold transition-colors">
                        <i class="fas fa-save mr-1"></i> Update Status
                    </button>
                </form>
                <script>
                document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
                    var status = document.getElementById('statusSelect').value;
                    if (status === 'refunded') {
                        e.preventDefault();
                        var input = prompt('Anda akan menandai pesanan ini sebagai REFUNDED.\nKetik "REFUND" untuk konfirmasi:');
                        if (input === 'REFUND') {
                            this.submit();
                        }
                    } else {
                        if (!confirm('Yakin ingin mengubah status pesanan ini?')) {
                            e.preventDefault();
                        }
                    }
                });
                </script>
                @if($order->status === 'pending')
                    <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle mr-1"></i> Tandai lunas akan mengirim notifikasi ke customer.</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_4px_12px_rgba(92,61,46,0.08)] border border-primary-lighter/30 overflow-hidden">
            <div class="p-5 border-b border-primary-lighter/40 bg-white/50">
                <h3 class="text-base font-bold font-display text-primary-dark flex items-center gap-2">
                    <i class="fas fa-bolt text-primary text-sm"></i> Aksi Cepat
                </h3>
            </div>
            <div class="p-5 space-y-2">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_whatsapp) }}" target="_blank" class="flex items-center gap-2 w-full px-4 py-2.5 bg-green-50 text-green-700 rounded-lg text-sm font-semibold hover:bg-green-100 transition-colors border border-green-200">
                    <i class="fab fa-whatsapp"></i> Chat WhatsApp Customer
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
