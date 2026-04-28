@extends('layouts.user')

@section('title', 'Alert Kost')
@section('header', 'Alert Kost Baru')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <div class="p-2.5 bg-amber-100 rounded-full">
                <i class="fas fa-bell text-amber-600 text-lg"></i>
            </div>
            <div>
                <h3 class="font-semibold text-amber-800">Notifikasi Kost Baru</h3>
                <p class="text-amber-700 text-sm mt-1">Buat alert agar kamu otomatis diberitahu saat ada kost baru yang sesuai kriteriamu. Maksimal 5 alert per akun.</p>
            </div>
        </div>
    </div>

    @if(\App\Services\KostAlertService::isEnabled())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-plus-circle text-green-600"></i> Buat Alert Baru
            </h4>
        </div>
        <form action="{{ route('user.alerts.store') }}" method="POST" class="p-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kota</label>
                    <select name="city_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 bg-white">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tipe Kost</label>
                    <select name="kost_type_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 bg-white">
                        <option value="">Semua Tipe</option>
                        @foreach($kostTypes as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Budget Maks</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400 text-sm">Rp</span>
                        <input type="number" name="max_price" placeholder="Kosongkan = tanpa batas" min="50000" step="50000" class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 bg-white">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kirim Via</label>
                    <select name="channel" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 bg-white">
                        <option value="email">Email</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="both">Email + WhatsApp</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 px-6 rounded-lg text-sm transition shadow-sm">
                <i class="fas fa-bell mr-1.5"></i> Buat Alert
            </button>
        </form>
    </div>

    @if($alerts->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list text-blue-600"></i> Alert Aktif ({{ $alerts->count() }})
            </h4>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($alerts as $alert)
            <div class="p-5 flex flex-col sm:flex-row sm:items-center gap-4 {{ !$alert->is_active ? 'opacity-50' : '' }}">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        @if($alert->city)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                <i class="fas fa-map-marker-alt text-[10px]"></i> {{ $alert->city->name }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Semua Kota</span>
                        @endif

                        @if($alert->kostType)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">{{ $alert->kostType->name }}</span>
                        @endif

                        @if($alert->max_price)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <i class="fas fa-tag text-[10px]"></i> &le; Rp {{ number_format($alert->max_price, 0, ',', '.') }}
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $alert->channel === 'email' ? 'bg-purple-100 text-purple-700' : ($alert->channel === 'whatsapp' ? 'bg-emerald-100 text-emerald-700' : 'bg-indigo-100 text-indigo-700') }}">
                            <i class="fas {{ $alert->channel === 'email' ? 'fa-envelope' : ($alert->channel === 'whatsapp' ? 'fa-brands fa-whatsapp' : 'fa-paper-plane') }} text-[10px]"></i>
                            {{ $alert->channel === 'both' ? 'Email + WA' : ucfirst($alert->channel) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400">
                        Dibuat {{ $alert->created_at->diffForHumans() }}
                        @if($alert->last_notified_at)
                            · Terakhir notif {{ $alert->last_notified_at->diffForHumans() }}
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('user.alerts.toggle', $alert->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $alert->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                            <i class="fas {{ $alert->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                            {{ $alert->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                    <form action="{{ route('user.alerts.destroy', $alert->id) }}" method="POST" onsubmit="return confirm('Hapus alert ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 text-red-600 hover:bg-red-200 transition">
                            <i class="fas fa-trash text-[10px] mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
        <i class="fas fa-bell-slash text-4xl text-gray-300 mb-3"></i>
        <h4 class="font-semibold text-gray-600 mb-1">Fitur Alert Tidak Aktif</h4>
        <p class="text-sm text-gray-400">Fitur notifikasi kost baru sedang dinonaktifkan oleh admin.</p>
    </div>
    @endif
</div>
@endsection
