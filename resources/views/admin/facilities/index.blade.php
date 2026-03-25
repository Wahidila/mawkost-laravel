@extends('layouts.admin')

@section('title', 'Fasilitas')
@section('header', 'Fasilitas Kost & Kamar')

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4 border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-800 tracking-tight">Daftar Fasilitas</h3>
        <button type="button" onclick="openFacilityModal()" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm whitespace-nowrap">
            <i class="fas fa-plus mr-1"></i> Tambah Fasilitas Baru
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded border border-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ikon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Fasilitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($facilities as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><i class="{{ $item->icon }} fa-lg"></i></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($item->category) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                        {{-- Hidden DELETE form --}}
                        <form id="delete-form-{{ $item->id }}" action="{{ route('admin.facilities.destroy', $item->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button"
                            onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->name) }}')"
                            class="text-red-600 hover:text-red-900 inline-flex items-center gap-1">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Data belum tersedia</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $facilities->links() }}
    </div>
</div>
@include('admin.kosts._facility_modal')
@endsection

@push('modals')
{{-- Custom Confirm Delete Modal --}}
<div id="confirmModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm mx-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-trash text-red-500"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Hapus Fasilitas</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <p class="text-sm text-gray-700 mb-5">Apakah Anda yakin ingin menghapus fasilitas <strong id="confirm-name" class="text-gray-900"></strong>?</p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeConfirmModal()" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium">
                Batal
            </button>
            <button id="confirm-delete-btn" onclick="executeDelete()" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-bold flex items-center gap-2">
                <i class="fas fa-trash"></i> Ya, Hapus
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
