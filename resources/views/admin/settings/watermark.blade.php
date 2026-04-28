@extends('layouts.admin')

@section('title', 'Pengaturan Watermark')
@section('header', 'Pengaturan Watermark')

@section('content')
<div class="max-w-4xl">
    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-5 mb-6">
        <div class="flex items-start">
            <div class="p-3 bg-blue-100 rounded-full mr-4">
                <i class="fas fa-stamp text-blue-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 text-lg">Watermark Otomatis</h3>
                <p class="text-blue-700 text-sm mt-1">Tambahkan watermark secara otomatis ke setiap gambar kost yang diupload. Upload gambar watermark (disarankan format PNG dengan transparansi) dan atur opacity serta ukurannya.</p>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <form action="{{ route('admin.settings.watermark.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg divide-y divide-gray-100">
            {{-- Toggle Enable --}}
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-800">Aktifkan Watermark</h4>
                        <p class="text-sm text-gray-500 mt-1">Watermark akan otomatis diterapkan ke setiap gambar kost yang diupload.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="watermark_enabled" value="1" class="sr-only peer" {{ $settings['watermark_enabled'] === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500"></div>
                    </label>
                </div>
            </div>

            {{-- Watermark Image Upload --}}
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Gambar Watermark</label>

                @if($settings['watermark_image'])
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2 font-medium">Watermark saat ini:</p>
                        <div class="flex items-center gap-4">
                            <div class="bg-[repeating-conic-gradient(#e5e7eb_0%_25%,transparent_0%_50%)] bg-[length:16px_16px] rounded-lg p-2 border border-gray-200">
                                <img src="{{ asset($settings['watermark_image']) }}" alt="Current Watermark" class="max-h-24 max-w-xs object-contain">
                            </div>
                            <div>
                                <label class="inline-flex items-center gap-2 text-sm text-red-600 hover:text-red-700 cursor-pointer">
                                    <input type="checkbox" name="remove_watermark_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>Hapus watermark ini</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="watermark_image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                            <p class="text-xs text-gray-400">PNG atau WebP (Maks. 2MB). Disarankan PNG dengan transparansi.</p>
                        </div>
                        <input id="watermark_image" name="watermark_image" type="file" class="hidden" accept="image/png,image/webp">
                    </label>
                </div>

                {{-- Preview --}}
                <div id="preview-container" class="mt-3 hidden">
                    <p class="text-xs text-gray-500 mb-1 font-medium">Preview:</p>
                    <div class="bg-[repeating-conic-gradient(#e5e7eb_0%_25%,transparent_0%_50%)] bg-[length:16px_16px] rounded-lg p-2 border border-gray-200 inline-block">
                        <img id="preview-image" src="" alt="Preview" class="max-h-24 max-w-xs object-contain">
                    </div>
                </div>

                @error('watermark_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Opacity --}}
            <div class="p-6">
                <label for="watermark_opacity" class="block text-sm font-medium text-gray-700 mb-1">Opacity (Transparansi)</label>
                <div class="flex items-center gap-4">
                    <input type="range" name="watermark_opacity" id="watermark_opacity"
                        min="0" max="100" step="5"
                        value="{{ old('watermark_opacity', $settings['watermark_opacity']) }}"
                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-500"
                        oninput="document.getElementById('opacity-value').textContent = this.value + '%'">
                    <span id="opacity-value" class="text-sm font-semibold text-gray-700 w-12 text-right">{{ $settings['watermark_opacity'] }}%</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">0% = transparan penuh, 100% = tidak transparan. Disarankan: 30-60%</p>
                @error('watermark_opacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Size --}}
            <div class="p-6">
                <label for="watermark_size" class="block text-sm font-medium text-gray-700 mb-1">Ukuran Watermark</label>
                <div class="flex items-center gap-4">
                    <input type="range" name="watermark_size" id="watermark_size"
                        min="10" max="80" step="5"
                        value="{{ old('watermark_size', $settings['watermark_size']) }}"
                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-500"
                        oninput="document.getElementById('size-value').textContent = this.value + '%'">
                    <span id="size-value" class="text-sm font-semibold text-gray-700 w-12 text-right">{{ $settings['watermark_size'] }}%</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">Persentase lebar watermark terhadap lebar gambar. Disarankan: 20-40%</p>
                @error('watermark_size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

    {{-- Bulk Apply Section --}}
    <div class="bg-white shadow rounded-lg mt-6">
        <div class="p-6 border-b border-gray-100">
            <h4 class="font-semibold text-gray-800">
                <i class="fas fa-images text-amber-500 mr-2"></i>Terapkan ke Semua Gambar
            </h4>
            <p class="text-sm text-gray-500 mt-1">Terapkan watermark ke semua gambar kost yang sudah diupload. Gambar original akan di-backup sebelum diproses.</p>
        </div>
        <div class="p-6">
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5 mr-3"></i>
                    <div class="text-sm text-amber-700">
                        <p class="font-semibold">Perhatian!</p>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            <li>Proses ini akan menerapkan watermark ke <strong>semua</strong> gambar kost yang sudah diupload.</li>
                            <li>Gambar original akan di-backup otomatis.</li>
                            <li>Pastikan pengaturan watermark sudah benar sebelum melanjutkan.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="wm-progress" class="hidden mb-4">
                <div class="flex items-center justify-between mb-2">
                    <span id="wm-status" class="text-sm font-medium text-gray-700">Memproses...</span>
                    <span id="wm-count" class="text-sm font-semibold text-primary-dark">0/0</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div id="wm-bar" class="bg-amber-500 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="wm-detail" class="text-xs text-gray-400 mt-1.5"></p>
            </div>

            <div id="wm-result" class="hidden mb-4 p-4 rounded-lg"></div>

            <button type="button" id="wm-start-btn" onclick="startBulkWatermark()"
                class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                <i class="fas fa-stamp mr-2"></i>Terapkan Watermark ke Semua Gambar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('watermark_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const container = document.getElementById('preview-container');
    const img = document.getElementById('preview-image');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) { img.src = e.target.result; container.classList.remove('hidden'); };
        reader.readAsDataURL(file);
    } else {
        container.classList.add('hidden');
    }
});

const BATCH_SIZE = 3;
const csrfToken = '{{ csrf_token() }}';

async function startBulkWatermark() {
    if (!confirm('Terapkan watermark ke semua gambar kost?\n\nGambar original akan di-backup otomatis.')) return;

    const btn = document.getElementById('wm-start-btn');
    const progress = document.getElementById('wm-progress');
    const bar = document.getElementById('wm-bar');
    const status = document.getElementById('wm-status');
    const count = document.getElementById('wm-count');
    const detail = document.getElementById('wm-detail');
    const resultDiv = document.getElementById('wm-result');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    btn.classList.add('opacity-50', 'cursor-not-allowed');
    progress.classList.remove('hidden');
    resultDiv.classList.add('hidden');
    bar.style.width = '0%';

    try {
        const idsRes = await fetch('{{ route("admin.settings.watermark.image-ids") }}');
        const idsData = await idsRes.json();

        if (idsData.error) {
            showResult('error', idsData.error);
            resetBtn();
            return;
        }

        const allIds = idsData.ids;
        const total = allIds.length;

        if (total === 0) {
            showResult('warning', 'Tidak ada gambar kost yang perlu diproses.');
            resetBtn();
            return;
        }

        let processed = 0, failed = 0, skipped = 0;
        count.textContent = '0/' + total;

        for (let i = 0; i < total; i += BATCH_SIZE) {
            const batchIds = allIds.slice(i, i + BATCH_SIZE);
            status.textContent = 'Memproses batch ' + (Math.floor(i / BATCH_SIZE) + 1) + '...';
            detail.textContent = 'Gambar ID: ' + batchIds.join(', ');

            const res = await fetch('{{ route("admin.settings.watermark.apply-batch") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ ids: batchIds })
            });

            const data = await res.json();
            processed += data.processed || 0;
            failed += data.failed || 0;
            skipped += data.skipped || 0;

            const done = Math.min(i + BATCH_SIZE, total);
            const pct = Math.round((done / total) * 100);
            bar.style.width = pct + '%';
            count.textContent = done + '/' + total;
        }

        status.textContent = 'Selesai!';
        bar.style.width = '100%';
        bar.classList.remove('bg-amber-500');
        bar.classList.add('bg-green-500');
        detail.textContent = '';

        let msg = processed + ' gambar berhasil diproses.';
        if (failed > 0) msg += ' ' + failed + ' gagal.';
        if (skipped > 0) msg += ' ' + skipped + ' dilewati.';
        showResult('success', msg);

    } catch (err) {
        showResult('error', 'Terjadi kesalahan: ' + err.message);
    }

    resetBtn();
}

function showResult(type, msg) {
    const div = document.getElementById('wm-result');
    div.classList.remove('hidden', 'bg-green-50', 'border-green-200', 'text-green-800', 'bg-red-50', 'border-red-200', 'text-red-800', 'bg-amber-50', 'border-amber-200', 'text-amber-800');
    const styles = {
        success: 'bg-green-50 border border-green-200 text-green-800',
        error: 'bg-red-50 border border-red-200 text-red-800',
        warning: 'bg-amber-50 border border-amber-200 text-amber-800',
    };
    div.className = 'mb-4 p-4 rounded-lg text-sm font-medium ' + (styles[type] || styles.warning);
    const icons = { success: 'fa-check-circle', error: 'fa-times-circle', warning: 'fa-info-circle' };
    div.innerHTML = '<i class="fas ' + (icons[type] || icons.warning) + ' mr-2"></i>' + msg;
}

function resetBtn() {
    const btn = document.getElementById('wm-start-btn');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-stamp mr-2"></i>Terapkan Watermark ke Semua Gambar';
    btn.classList.remove('opacity-50', 'cursor-not-allowed');
}
</script>
@endpush
