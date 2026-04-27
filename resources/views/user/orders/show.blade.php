@extends('layouts.user')

@section('title', 'Info Kost — ' . $order->kost->title)
@section('header', 'Detail Info Kost')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.orders') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-4 sm:space-y-6">
        <!-- Kost Header -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">{{ $order->kost->title }}</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-location-dot mr-1"></i> {{ $order->kost->area_label ?? $order->kost->city->name }}
                    </p>
                </div>
                <span class="self-start px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap
                    {{ $order->kost->type === 'putri' ? 'bg-pink-100 text-pink-700' : ($order->kost->type === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">
                    Kost {{ ucfirst($order->kost->type) }}
                </span>
            </div>
            <div class="flex flex-wrap gap-3 sm:gap-4 text-sm text-gray-600 mt-4 pt-4 border-t">
                <span><i class="fas fa-ticket text-blue-500 mr-1"></i> Kode: <strong>{{ $order->kost->kode }}</strong></span>
                <span><i class="fas fa-money-bill text-green-500 mr-1"></i> {{ $order->kost->formatted_price }}/bln</span>
                <span><i class="fas fa-door-open text-orange-500 mr-1"></i> {{ $order->kost->total_rooms ?? '-' }} Kamar</span>
            </div>
        </div>

        <!-- Unlocked Contact Info -->
        <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden">
            <div class="bg-green-50 px-4 sm:px-6 py-3 border-b border-green-200">
                <h3 class="text-green-800 font-bold flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-lock-open"></i> Info Kontak & Alamat (Unlocked)
                </h3>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-building text-green-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-gray-500">Nama Kost</p>
                        <p class="font-semibold text-gray-800">{{ $order->kost->name }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-green-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-gray-500">Nama Pemilik</p>
                        <p class="font-semibold text-gray-800">{{ $order->kost->owner_name ?? 'Bapak/Ibu Kost' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-green-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-gray-500">WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $order->kost->owner_contact)) }}" target="_blank" class="font-semibold text-green-700 hover:text-green-900 break-all">
                            {{ $order->kost->owner_contact ?? '-' }} <i class="fas fa-external-link-alt text-xs ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-gray-500">Alamat Lengkap</p>
                        <p class="font-semibold text-gray-800 break-words">{{ $order->kost->address ?? '-' }}</p>
                    </div>
                </div>
                @if($order->kost->maps_link)
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map text-green-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-gray-500">Google Maps</p>
                        <a href="{{ $order->kost->maps_link }}" target="_blank" class="font-semibold text-blue-600 hover:text-blue-800">
                            Buka di Maps <i class="fas fa-external-link-alt text-xs ml-1"></i>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Quick Action -->
                <div class="pt-4 border-t">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+62', '62', $order->kost->owner_contact)) }}?text={{ urlencode('Halo, saya ' . auth()->user()->name . '. Saya tertarik dengan ' . $order->kost->name . ' (Kode: ' . $order->kost->kode . '). Apakah kamar masih tersedia?') }}" 
                       target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-bold transition text-sm">
                        <i class="fab fa-whatsapp text-lg"></i> Hubungi Pemilik via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar: Order Details -->
    <div class="space-y-4 sm:space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Detail Transaksi</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between gap-2">
                    <span class="text-gray-500">No. Invoice</span>
                    <span class="font-mono text-gray-700 text-right break-all">{{ $order->invoice_no }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Beli</span>
                    <span class="text-gray-700">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode Bayar</span>
                    <span class="text-gray-700 uppercase">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between border-t pt-3 mt-3">
                    <span class="font-bold text-gray-800">Total</span>
                    <span class="font-bold text-green-700">{{ $order->formatted_amount }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">Lunas</span>
                </div>
            </div>
        </div>

        <!-- Link to public detail -->
        <a href="{{ route('kost.show', ['citySlug' => $order->kost->city->slug, 'slug' => $order->kost->slug]) }}" target="_blank"
           class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-lg text-sm font-medium transition">
            <i class="fas fa-building mr-1"></i> Lihat Halaman Kost
        </a>
    </div>
</div>
@endsection
