@extends('layouts.admin')

@section('title', 'Pengaturan Footer')
@section('header', 'Pengaturan Footer Website')

@section('content')
<div class="max-w-4xl">
    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-lg p-5 mb-6">
        <div class="flex items-start">
            <div class="p-3 bg-amber-100 rounded-full mr-4">
                <i class="fas fa-columns text-amber-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-amber-800 text-lg">Kelola Link Footer</h3>
                <p class="text-amber-700 text-sm mt-1">Atur daftar link yang tampil di bagian footer website untuk kolom <strong>Kota</strong>, <strong>Layanan</strong>, dan <strong>Kontak</strong>. Setiap item terdiri dari label dan URL tujuan.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.footer.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ============ KOTA ============ --}}
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800"><i class="fas fa-city text-primary mr-2"></i>Kolom Kota</h4>
                    <p class="text-sm text-gray-500 mt-1">Daftar kota yang ditampilkan di footer (max 6 item).</p>
                </div>
                <button type="button" onclick="addRow('kota')" class="bg-primary hover:bg-primary-dark text-white font-semibold py-1.5 px-4 rounded-lg text-sm transition">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
            <div class="p-6" id="kota-container">
                @foreach($footerKota as $i => $item)
                <div class="flex gap-3 items-center mb-3 link-row">
                    <input type="text" name="kota[{{ $i }}][label]" value="{{ $item['label'] }}" placeholder="Label (contoh: Malang)" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                    <input type="text" name="kota[{{ $i }}][url]" value="{{ $item['url'] }}" placeholder="URL (contoh: /kost/malang)" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                    <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 transition p-2"><i class="fas fa-trash"></i></button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ============ LAYANAN ============ --}}
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800"><i class="fas fa-concierge-bell text-primary mr-2"></i>Kolom Layanan</h4>
                    <p class="text-sm text-gray-500 mt-1">Daftar layanan yang ditampilkan di footer (max 6 item).</p>
                </div>
                <button type="button" onclick="addRow('layanan')" class="bg-primary hover:bg-primary-dark text-white font-semibold py-1.5 px-4 rounded-lg text-sm transition">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
            <div class="p-6" id="layanan-container">
                @foreach($footerLayanan as $i => $item)
                <div class="flex gap-3 items-center mb-3 link-row">
                    <input type="text" name="layanan[{{ $i }}][label]" value="{{ $item['label'] }}" placeholder="Label (contoh: Cariin Kost)" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                    <input type="text" name="layanan[{{ $i }}][url]" value="{{ $item['url'] }}" placeholder="URL (contoh: /cari-kost)" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                    <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 transition p-2"><i class="fas fa-trash"></i></button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ============ KONTAK ============ --}}
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800"><i class="fas fa-address-book text-primary mr-2"></i>Kolom Kontak</h4>
                    <p class="text-sm text-gray-500 mt-1">Daftar kontak yang ditampilkan di footer (max 6 item).</p>
                </div>
                <button type="button" onclick="addRow('kontak')" class="bg-primary hover:bg-primary-dark text-white font-semibold py-1.5 px-4 rounded-lg text-sm transition">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
            <div class="p-6" id="kontak-container">
                @foreach($footerKontak as $i => $item)
                <div class="flex gap-3 items-center mb-3 link-row">
                    <input type="text" name="kontak[{{ $i }}][label]" value="{{ $item['label'] }}" placeholder="Label (contoh: admin@mawkost.id)" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                    <input type="text" name="kontak[{{ $i }}][url]" value="{{ $item['url'] }}" placeholder="URL (contoh: mailto:admin@mawkost.id)" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                    <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 transition p-2"><i class="fas fa-trash"></i></button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Save Button --}}
        <div class="bg-white shadow rounded-lg p-6">
            <button type="submit" class="bg-cta hover:bg-cta-hover text-white font-semibold py-2.5 px-6 rounded-lg transition duration-150 shadow-sm">
                <i class="fas fa-save mr-2"></i>Simpan Pengaturan Footer
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let counters = {
    kota: {{ count($footerKota) }},
    layanan: {{ count($footerLayanan) }},
    kontak: {{ count($footerKontak) }}
};

function addRow(section) {
    const container = document.getElementById(section + '-container');
    const idx = counters[section]++;
    const row = document.createElement('div');
    row.className = 'flex gap-3 items-center mb-3 link-row';
    row.innerHTML = `
        <input type="text" name="${section}[${idx}][label]" placeholder="Label" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
        <input type="text" name="${section}[${idx}][url]" placeholder="URL" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition" required>
        <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 transition p-2"><i class="fas fa-trash"></i></button>
    `;
    container.appendChild(row);
}

function removeRow(btn) {
    btn.closest('.link-row').remove();
}
</script>
@endpush
