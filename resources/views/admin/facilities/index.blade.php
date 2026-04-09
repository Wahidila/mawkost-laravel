@extends('layouts.admin')

@section('title', 'Fasilitas')
@section('header', 'Fasilitas Kost & Kamar')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Daftar Fasilitas</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola fasilitas kamar dan fasilitas bersama.</p>
        </div>
        <button type="button" onclick="openFacilityModal()" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-plus text-xs"></i> Tambah Fasilitas
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Ikon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Nama Fasilitas</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($facilities as $item)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        <div class="w-9 h-9 rounded-lg bg-primary-lighter/50 flex items-center justify-center text-primary">
                            <i class="{{ $item->icon }}"></i>
                        </div>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold text-primary-dark">{{ $item->name }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                        @if($item->category === 'kamar')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-primary-lighter/50 text-primary-dark border border-primary-lighter">
                                <i class="fas fa-bed mr-1.5 text-[0.6rem] self-center"></i> Kamar
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-cta/10 text-cta border border-cta/20">
                                <i class="fas fa-users mr-1.5 text-[0.6rem] self-center"></i> Bersama
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-3">
                            {{-- Hidden DELETE form --}}
                            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.facilities.destroy', $item->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button"
                                onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->name) }}')"
                                class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-1.5">
                                <i class="fas fa-trash text-xs"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 whitespace-nowrap text-sm text-center font-medium bg-gray-50/30">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-wifi text-3xl mb-3 text-primary-light"></i>
                            <p class="text-gray-500">Belum ada data fasilitas.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($facilities->hasPages())
    <div class="p-4 border-t border-primary-lighter/30">
        {{ $facilities->links() }}
    </div>
    @endif
</div>
@include('admin.kosts._facility_modal')
@endsection

@push('modals')
{{-- Custom Confirm Delete Modal --}}
<div id="confirmModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-2xl shadow-[0_16px_48px_rgba(92,61,46,0.15)] p-6 w-full max-w-sm mx-4 border border-primary-lighter/30">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-trash text-red-500"></i>
            </div>
            <div>
                <h3 class="font-bold font-display text-primary-dark">Hapus Fasilitas</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <p class="text-sm text-gray-700 mb-5">Apakah Anda yakin ingin menghapus fasilitas <strong id="confirm-name" class="text-primary-dark"></strong>?</p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeConfirmModal()" class="px-4 py-2 rounded-full bg-primary-lighter/40 hover:bg-primary-lighter text-primary-dark text-sm font-medium transition-colors">
                Batal
            </button>
            <button id="confirm-delete-btn" onclick="executeDelete()" class="px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-sm font-bold flex items-center gap-2 transition-colors shadow-sm">
                <i class="fas fa-trash text-xs"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    let pendingDeleteId = null;

    function confirmDelete(id, name) {
        pendingDeleteId = id;
        document.getElementById('confirm-name').textContent = name;
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function closeConfirmModal() {
        pendingDeleteId = null;
        document.getElementById('confirmModal').style.display = 'none';
    }

    function executeDelete() {
        if (!pendingDeleteId) return;
        const form = document.getElementById('delete-form-' + pendingDeleteId);
        if (form) {
            const btn = document.getElementById('confirm-delete-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
            btn.disabled = true;
            form.submit();
        }
    }

    // Close modal on background click
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmModal();
    });
</script>
@endpush
