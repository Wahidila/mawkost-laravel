@extends('layouts.admin')

@section('title', 'Pengaturan Alert Kost')
@section('header', 'Pengaturan Alert Kost')

@section('content')
<div class="max-w-4xl">
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-lg p-5 mb-6">
        <div class="flex items-start">
            <div class="p-3 bg-amber-100 rounded-full mr-4">
                <i class="fas fa-bell text-amber-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-amber-800 text-lg">Notifikasi Kost Baru</h3>
                <p class="text-amber-700 text-sm mt-1">Saat fitur ini aktif, user bisa membuat alert dan akan otomatis diberitahu via Email/WhatsApp saat ada kost baru yang sesuai kriteria mereka.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.alerts.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg divide-y divide-gray-100 mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-800">Aktifkan Fitur Alert</h4>
                        <p class="text-sm text-gray-500 mt-1">User dapat membuat alert kost baru di dashboard mereka.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="kost_alerts_enabled" value="1" class="sr-only peer" {{ $settings['kost_alerts_enabled'] === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    </label>
                </div>
            </div>

            <div class="p-6 bg-gray-50 rounded-b-lg">
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>

    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary"></i> Statistik Alert
            </h4>
        </div>
        <div class="p-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-blue-700">{{ $stats['total_alerts'] }}</p>
                <p class="text-xs text-blue-600 font-medium mt-1">Total Alert</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-green-700">{{ $stats['active_alerts'] }}</p>
                <p class="text-xs text-green-600 font-medium mt-1">Alert Aktif</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-purple-700">{{ $stats['users_with_alerts'] }}</p>
                <p class="text-xs text-purple-600 font-medium mt-1">User Berlangganan</p>
            </div>
            <div class="bg-amber-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-amber-700">{{ $stats['pending_kosts'] }}</p>
                <p class="text-xs text-amber-600 font-medium mt-1">Kost Belum Dikirim</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-paper-plane text-green-600"></i> Kirim Notifikasi Kost Baru
            </h4>
            <p class="text-sm text-gray-500 mt-1">Kirim notifikasi ke semua user yang punya alert aktif untuk kost yang belum dikirim.</p>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold mb-1">Bagaimana cara kerjanya?</p>
                        <ul class="list-disc list-inside space-y-1 text-blue-600">
                            <li><strong>Otomatis:</strong> Sistem mengirim notifikasi <strong>setiap 1 jam</strong> via cron job untuk kost baru yang belum dikirim.</li>
                            <li><strong>Manual:</strong> Klik tombol di bawah untuk langsung mengirim notifikasi tanpa menunggu cron.</li>
                            <li>Hanya kost dengan <code class="bg-blue-100 px-1 rounded text-xs">notified_at = NULL</code> yang akan diproses.</li>
                            <li>Setiap kost hanya dikirim <strong>1 kali</strong> — tidak akan double.</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if($stats['pending_kosts'] > 0)
            <form action="{{ route('admin.settings.alerts.send-now') }}" method="POST" onsubmit="return confirm('Kirim notifikasi untuk {{ $stats['pending_kosts'] }} kost baru ke semua user yang match?');">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-lg text-sm transition shadow-sm">
                    <i class="fas fa-bell mr-2"></i> Kirim Sekarang ({{ $stats['pending_kosts'] }} kost pending)
                </button>
            </form>
            @else
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <i class="fas fa-check-circle text-green-400"></i>
                Semua kost sudah dikirim notifikasinya. Tidak ada yang pending.
            </div>
            @endif
        </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-flask text-cta"></i> Test Notifikasi
            </h4>
            <p class="text-sm text-gray-500 mt-1">Kirim notifikasi test untuk memastikan Email/WhatsApp berfungsi.</p>
        </div>
        <div class="p-6 space-y-4">
            <form action="{{ route('admin.settings.alerts.test') }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end">
                @csrf
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Channel</label>
                    <select name="channel" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                        <option value="email">Email</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tujuan (email / no. HP)</label>
                    <input type="text" name="target" placeholder="admin@mawkost.com atau 08123456789" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400" required>
                </div>
                <button type="submit" class="bg-cta hover:bg-cta-hover text-white font-semibold py-2 px-5 rounded-lg text-sm transition shadow-sm whitespace-nowrap">
                    <i class="fas fa-paper-plane mr-1.5"></i> Kirim Test
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
