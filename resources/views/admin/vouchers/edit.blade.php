@extends('layouts.admin')

@section('title', 'Edit Voucher')
@section('header', 'Edit Voucher: ' . $voucher->code)

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-ticket text-cta"></i> Edit Voucher
            </h3>
        </div>
        <a href="{{ route('admin.vouchers.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Kode Voucher</label>
                    <input type="text" name="code" value="{{ old('code', $voucher->code) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white uppercase font-mono font-bold" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Tipe Diskon</label>
                    <select name="discount_type" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
                        <option value="fixed" {{ $voucher->discount_type === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                        <option value="percentage" {{ $voucher->discount_type === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Nilai Diskon</label>
                    <input type="number" name="discount_value" value="{{ old('discount_value', $voucher->discount_value) }}" min="1" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Min. Transaksi (Rp)</label>
                    <input type="number" name="min_amount" value="{{ old('min_amount', $voucher->min_amount) }}" min="0" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Maks Penggunaan</label>
                    <input type="number" name="max_uses" value="{{ old('max_uses', $voucher->max_uses) }}" min="1" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Expired</label>
                    <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $voucher->expires_at?->format('Y-m-d\TH:i')) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Deskripsi</label>
                <input type="text" name="description" value="{{ old('description', $voucher->description) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
            </div>
            <div>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $voucher->is_active ? 'checked' : '' }} class="w-4 h-4 text-primary rounded focus:ring-primary">
                    <span class="text-sm font-medium text-primary-dark">Voucher Aktif</span>
                </label>
            </div>
            <div class="bg-primary-lighter/20 rounded-xl p-4 text-sm text-gray-600">
                <strong>Statistik:</strong> Digunakan <strong>{{ $voucher->used_count }}</strong> kali{{ $voucher->max_uses ? ' dari ' . $voucher->max_uses . ' kuota' : '' }}.
            </div>
        </div>

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.vouchers.index') }}" class="px-5 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200">
                <i class="fas fa-save text-xs mr-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
