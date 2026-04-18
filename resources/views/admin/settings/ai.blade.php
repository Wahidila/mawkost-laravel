@extends('layouts.admin')

@section('title', 'Pengaturan AI Chat')
@section('header', 'Pengaturan AI Chat')

@section('content')
<div class="max-w-4xl">
    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-violet-50 to-purple-50 border border-violet-200 rounded-lg p-5 mb-6">
        <div class="flex items-start">
            <div class="p-3 bg-violet-100 rounded-full mr-4">
                <i class="fas fa-robot text-violet-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-violet-800 text-lg">AI Konsultasi Kost</h3>
                <p class="text-violet-700 text-sm mt-1">Asisten AI yang membantu pengunjung mencari kost ideal. Menggunakan data kost real-time dari database sebagai knowledge base. Mendukung provider OpenAI-compatible (OpenAI, Groq, Together, Ollama, dll).</p>
            </div>
        </div>
    </div>

    {{-- Knowledge Base Stats --}}
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800">
                <i class="fas fa-database text-violet-500 mr-2"></i>Knowledge Base (Data Kost)
            </h4>
            <p class="text-sm text-gray-500 mt-1">Data ini otomatis diambil dari database dan di-cache selama 5 menit.</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-violet-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-violet-700">{{ $summary['total_kost'] }}</div>
                    <div class="text-xs text-violet-600 mt-1">Total Kost</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-700">{{ count($summary['cities']) }}</div>
                    <div class="text-xs text-blue-600 mt-1">Kota</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-700">{{ count($summary['kost_types']) }}</div>
                    <div class="text-xs text-green-600 mt-1">Tipe Kost</div>
                </div>
                <div class="bg-orange-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-orange-700">{{ $summary['featured_count'] + $summary['recommended_count'] }}</div>
                    <div class="text-xs text-orange-600 mt-1">Unggulan & Rekomendasi</div>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs text-gray-400">Range harga: Rp {{ number_format($summary['price_range']['min'], 0, ',', '.') }} - Rp {{ number_format($summary['price_range']['max'], 0, ',', '.') }}/bulan</p>
                <form action="{{ route('admin.settings.ai.clearCache') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-violet-600 hover:text-violet-800 font-medium transition">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh Cache
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <form action="{{ route('admin.settings.ai.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg divide-y divide-gray-100">
            {{-- Toggle Enable --}}
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-800">Aktifkan AI Konsultasi</h4>
                        <p class="text-sm text-gray-500 mt-1">Halaman konsultasi AI akan tersedia di <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">/konsultasi</code></p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ai_enabled" value="1" class="sr-only peer" {{ $settings['ai_enabled'] === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-500"></div>
                    </label>
                </div>
            </div>

            {{-- API Key --}}
            <div class="p-6">
                <label for="ai_api_key" class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                <input type="password" name="ai_api_key" id="ai_api_key"
                    value="{{ old('ai_api_key', $settings['ai_api_key']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                    placeholder="sk-... atau API key dari provider">
                <p class="text-xs text-gray-400 mt-1">API Key dari provider AI (OpenAI, Groq, Together, dll)</p>
                @error('ai_api_key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Base URL --}}
            <div class="p-6">
                <label for="ai_base_url" class="block text-sm font-medium text-gray-700 mb-1">Base URL</label>
                <input type="url" name="ai_base_url" id="ai_base_url"
                    value="{{ old('ai_base_url', $settings['ai_base_url']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                    placeholder="https://api.openai.com/v1">
                <p class="text-xs text-gray-400 mt-1">Endpoint API yang OpenAI-compatible. Contoh: <code class="bg-gray-100 px-1 rounded">https://api.openai.com/v1</code>, <code class="bg-gray-100 px-1 rounded">https://api.groq.com/openai/v1</code>, <code class="bg-gray-100 px-1 rounded">https://api.together.xyz/v1</code></p>
                @error('ai_base_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Model --}}
            <div class="p-6">
                <label for="ai_model" class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                <input type="text" name="ai_model" id="ai_model"
                    value="{{ old('ai_model', $settings['ai_model']) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                    placeholder="gpt-4o-mini">
                <p class="text-xs text-gray-400 mt-1">Nama model AI. Contoh: <code class="bg-gray-100 px-1 rounded">gpt-4o-mini</code>, <code class="bg-gray-100 px-1 rounded">llama-3.1-70b-versatile</code>, <code class="bg-gray-100 px-1 rounded">mistralai/Mixtral-8x7B-Instruct-v0.1</code></p>
                @error('ai_model') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Max Tokens & Temperature --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ai_max_tokens" class="block text-sm font-medium text-gray-700 mb-1">Max Tokens</label>
                        <input type="number" name="ai_max_tokens" id="ai_max_tokens"
                            value="{{ old('ai_max_tokens', $settings['ai_max_tokens']) }}"
                            min="100" max="16000"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                            placeholder="1024">
                        <p class="text-xs text-gray-400 mt-1">Panjang maksimal respons AI (100-16000)</p>
                        @error('ai_max_tokens') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="ai_temperature" class="block text-sm font-medium text-gray-700 mb-1">Temperature</label>
                        <input type="number" name="ai_temperature" id="ai_temperature"
                            value="{{ old('ai_temperature', $settings['ai_temperature']) }}"
                            min="0" max="2" step="0.1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                            placeholder="0.7">
                        <p class="text-xs text-gray-400 mt-1">Kreativitas AI: 0 = deterministik, 2 = sangat kreatif. Rekomendasi: 0.7</p>
                        @error('ai_temperature') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- System Prompt --}}
            <div class="p-6">
                <label for="ai_system_prompt" class="block text-sm font-medium text-gray-700 mb-1">Instruksi Tambahan (Opsional)</label>
                <textarea name="ai_system_prompt" id="ai_system_prompt" rows="6"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition font-mono text-sm"
                    placeholder="Tambahkan instruksi khusus untuk AI di sini...">{{ old('ai_system_prompt', $settings['ai_system_prompt']) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Instruksi tambahan yang akan ditambahkan ke system prompt bawaan. Contoh: "Selalu promosikan kost unggulan terlebih dahulu", "Jangan rekomendasikan kost di bawah Rp 500.000", dll.</p>
                @error('ai_system_prompt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Save Button --}}
            <div class="p-6 bg-gray-50 rounded-b-lg">
                <button type="submit"
                    class="bg-violet-600 hover:bg-violet-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>

    {{-- Test Connection Section --}}
    <div class="bg-white shadow rounded-lg mt-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800">
                <i class="fas fa-plug text-blue-500 mr-2"></i>Test Koneksi AI
            </h4>
            <p class="text-sm text-gray-500 mt-1">Kirim pesan test untuk memastikan koneksi ke AI provider berfungsi.</p>
        </div>
        <form action="{{ route('admin.settings.ai.test') }}" method="POST" class="p-6">
            @csrf
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                <i class="fas fa-paper-plane mr-2"></i>Test Koneksi
            </button>
        </form>
    </div>

    {{-- Info Box --}}
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mt-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-amber-500 mt-0.5 mr-3"></i>
            <div class="text-sm text-amber-800">
                <p class="font-semibold mb-1">Cara Kerja AI Konsultasi:</p>
                <ol class="list-decimal list-inside space-y-1 text-amber-700">
                    <li>Sistem mengambil semua data kost dari database dan memformatnya sebagai knowledge base</li>
                    <li>Knowledge base di-cache selama 5 menit untuk performa optimal</li>
                    <li>Saat user mengirim pesan, sistem mengirim knowledge base + riwayat chat ke AI provider</li>
                    <li>AI merespons berdasarkan data kost yang ada dan kebutuhan user</li>
                    <li>Respons di-stream secara real-time ke browser user</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
