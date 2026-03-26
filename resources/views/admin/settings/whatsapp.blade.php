@extends('layouts.admin')

@section('title', 'Pengaturan WhatsApp')
@section('header', 'Pengaturan WhatsApp API')

@section('content')
<div class="max-w-4xl">
    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-5 mb-6">
        <div class="flex items-start">
            <div class="p-3 bg-green-100 rounded-full mr-4">
                <i class="fab fa-whatsapp text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-green-800 text-lg">Integrasi XSender WhatsApp</h3>
                <p class="text-green-700 text-sm mt-1">Kirim notifikasi detail kost ke customer via WhatsApp secara otomatis setelah checkout berhasil. Dibutuhkan akun <a href="https://xsender.id" target="_blank" class="underline font-semibold">XSender.id</a>.</p>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <form action="{{ route('admin.settings.whatsapp.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg divide-y divide-gray-100">
            {{-- Toggle Enable --}}
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-800">Aktifkan WhatsApp Notifikasi</h4>
                        <p class="text-sm text-gray-500 mt-1">Sistem akan mengirim pesan WA otomatis ke customer setelah checkout.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="wa_enabled" value="1" class="sr-only peer" {{ $settings['wa_enabled'] === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </div>
            </div>

            {{-- API Key --}}
            <div class="p-6">
                <label for="wa_api_key" class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                <input type="password" name="wa_api_key" id="wa_api_key"
                    value="{{ old('wa_api_key', $settings['wa_api_key']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="Masukkan API Key dari XSender">
                <p class="text-xs text-gray-400 mt-1">Dapatkan API Key dari dashboard XSender.id</p>
                @error('wa_api_key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Sender Number --}}
            <div class="p-6">
                <label for="wa_sender" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp Pengirim</label>
                <input type="text" name="wa_sender" id="wa_sender"
                    value="{{ old('wa_sender', $settings['wa_sender']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="Contoh: 6281234567890">
                <p class="text-xs text-gray-400 mt-1">Nomor WhatsApp yang terhubung di XSender (format 628xxx)</p>
                @error('wa_sender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Endpoint --}}
            <div class="p-6">
                <label for="wa_endpoint" class="block text-sm font-medium text-gray-700 mb-1">Endpoint API</label>
                <input type="url" name="wa_endpoint" id="wa_endpoint"
                    value="{{ old('wa_endpoint', $settings['wa_endpoint']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="https://xsender.id/id/send-message">
                <p class="text-xs text-gray-400 mt-1">Default: https://xsender.id/id/send-message</p>
                @error('wa_endpoint') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Message Template --}}
            <div class="p-6">
                <label for="wa_template" class="block text-sm font-medium text-gray-700 mb-1">Template Pesan</label>
                <textarea name="wa_template" id="wa_template" rows="18"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition font-mono text-sm"
                    placeholder="Template pesan WhatsApp...">{{ old('wa_template', $settings['wa_template']) }}</textarea>
                <div class="mt-2">
                    <p class="text-xs text-gray-500 font-medium mb-1">Placeholder yang tersedia:</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach([
                            '{customer_name}' => 'Nama Pembeli',
                            '{invoice_no}' => 'No. Invoice',
                            '{amount}' => 'Jumlah Bayar',
                            '{kost_name}' => 'Nama Kost',
                            '{kost_code}' => 'Kode Kost',
                            '{kost_type}' => 'Tipe Kost',
                            '{kost_price}' => 'Harga Kost',
                            '{kost_address}' => 'Alamat',
                            '{kost_city}' => 'Kota',
                            '{kost_area}' => 'Area',
                            '{owner_name}' => 'Pemilik',
                            '{owner_contact}' => 'Kontak Pemilik',
                            '{maps_link}' => 'Google Maps',
                            '{facilities}' => 'Fasilitas',
                            '{available_rooms}' => 'Kamar Tersedia',
                        ] as $placeholder => $label)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600 font-mono cursor-pointer hover:bg-green-100 hover:text-green-700 transition" onclick="insertPlaceholder('{{ $placeholder }}')" title="{{ $label }}">{{ $placeholder }}</span>
                        @endforeach
                    </div>
                </div>
                @error('wa_template') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Save Button --}}
            <div class="p-6 bg-gray-50 rounded-b-lg">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>

    {{-- Test Send Section --}}
    <div class="bg-white shadow rounded-lg mt-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800">
                <i class="fas fa-paper-plane text-blue-500 mr-2"></i>Test Kirim Pesan
            </h4>
            <p class="text-sm text-gray-500 mt-1">Kirim pesan test untuk memastikan koneksi WhatsApp API berfungsi.</p>
        </div>
        <form action="{{ route('admin.settings.whatsapp.test') }}" method="POST" class="p-6">
            @csrf
            <div class="flex gap-3">
                <input type="text" name="test_number"
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Nomor WhatsApp tujuan (contoh: 6281234567890)"
                    required>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
                    <i class="fab fa-whatsapp mr-2"></i>Kirim Test
                </button>
            </div>
            @error('test_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function insertPlaceholder(text) {
    const textarea = document.getElementById('wa_template');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const value = textarea.value;
    textarea.value = value.substring(0, start) + text + value.substring(end);
    textarea.selectionStart = textarea.selectionEnd = start + text.length;
    textarea.focus();
}
</script>
@endpush
