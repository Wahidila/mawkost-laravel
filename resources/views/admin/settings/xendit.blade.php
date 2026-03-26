@extends('layouts.admin')

@section('title', 'Pengaturan Xendit')
@section('header', 'Pengaturan Payment Gateway Xendit')

@section('content')
<div class="max-w-4xl">
    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-5 mb-6">
        <div class="flex items-start">
            <div class="p-3 bg-blue-100 rounded-full mr-4">
                <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 text-lg">Payment Gateway Xendit</h3>
                <p class="text-blue-700 text-sm mt-1">Terima pembayaran real via QRIS, e-Wallet, dan Virtual Account. Daftar gratis di <a href="https://dashboard.xendit.co" target="_blank" class="underline font-semibold">dashboard.xendit.co</a>.</p>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <form action="{{ route('admin.settings.xendit.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg divide-y divide-gray-100">
            {{-- Toggle Enable --}}
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-800">Aktifkan Pembayaran Xendit</h4>
                        <p class="text-sm text-gray-500 mt-1">Saat aktif, checkout akan redirect ke halaman pembayaran Xendit. Saat nonaktif, pembayaran disimulasikan langsung lunas.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="xendit_enabled" value="1" class="sr-only peer" {{ $settings['xendit_enabled'] === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            {{-- Secret API Key --}}
            <div class="p-6">
                <label for="xendit_secret_key" class="block text-sm font-medium text-gray-700 mb-1">Secret API Key</label>
                <input type="password" name="xendit_secret_key" id="xendit_secret_key"
                    value="{{ old('xendit_secret_key', $settings['xendit_secret_key']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="xnd_development_xxxxxxxxxxxx">
                <p class="text-xs text-gray-400 mt-1">Dapatkan dari Xendit Dashboard → Settings → API Keys → Secret Key</p>
                @error('xendit_secret_key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Webhook Verification Token --}}
            <div class="p-6">
                <label for="xendit_webhook_token" class="block text-sm font-medium text-gray-700 mb-1">Webhook Verification Token</label>
                <input type="password" name="xendit_webhook_token" id="xendit_webhook_token"
                    value="{{ old('xendit_webhook_token', $settings['xendit_webhook_token']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="xxxxxxxxxxxxxxxxxxxxxxxx">
                <p class="text-xs text-gray-400 mt-1">Xendit Dashboard → Settings → Webhooks → Verification Token</p>
                @error('xendit_webhook_token') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mode --}}
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mode</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 px-4 py-2.5 border rounded-lg cursor-pointer transition {{ $settings['xendit_is_production'] !== '1' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                        <input type="radio" name="xendit_is_production" value="0" {{ $settings['xendit_is_production'] !== '1' ? 'checked' : '' }} class="text-blue-600">
                        <div>
                            <span class="font-medium">Development</span>
                            <p class="text-xs text-gray-400">Testing, tanpa uang asli</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-2.5 border rounded-lg cursor-pointer transition {{ $settings['xendit_is_production'] === '1' ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                        <input type="radio" name="xendit_is_production" value="1" {{ $settings['xendit_is_production'] === '1' ? 'checked' : '' }} class="text-green-600">
                        <div>
                            <span class="font-medium">Production</span>
                            <p class="text-xs text-gray-400">Pembayaran real, uang asli</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Invoice Duration --}}
            <div class="p-6">
                <label for="xendit_invoice_duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi Invoice (jam)</label>
                <input type="number" name="xendit_invoice_duration" id="xendit_invoice_duration"
                    value="{{ old('xendit_invoice_duration', $settings['xendit_invoice_duration']) }}"
                    min="1" max="720"
                    class="w-48 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="24">
                <p class="text-xs text-gray-400 mt-1">Berapa lama invoice aktif sebelum expired. Default: 24 jam</p>
                @error('xendit_invoice_duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Webhook URL Info --}}
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Webhook URL (set di Xendit Dashboard)</label>
                <div class="flex items-center gap-2">
                    <code class="flex-1 bg-gray-100 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 font-mono">{{ url('/payment/callback') }}</code>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ url('/payment/callback') }}')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2.5 rounded-lg transition text-sm" title="Copy">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Paste URL ini di Xendit Dashboard → Settings → Webhooks → Invoice paid</p>
            </div>

            {{-- Save Button --}}
            <div class="p-6 bg-gray-50 rounded-b-lg">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>

    {{-- Test Connection Section --}}
    <div class="bg-white shadow rounded-lg mt-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800">
                <i class="fas fa-plug text-indigo-500 mr-2"></i>Test Koneksi API
            </h4>
            <p class="text-sm text-gray-500 mt-1">Verifikasi Secret API Key Anda valid dan terhubung ke Xendit.</p>
        </div>
        <form action="{{ route('admin.settings.xendit.test') }}" method="POST" class="p-6">
            @csrf
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                <i class="fas fa-bolt mr-2"></i>Test Koneksi Xendit
            </button>
        </form>
    </div>
</div>
@endsection
