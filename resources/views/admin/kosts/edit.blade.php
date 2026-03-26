@extends('layouts.admin')

@section('title', 'Edit Kost')
@section('header', 'Edit Kost: ' . $kost->name)

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6">
    <form action="{{ route('admin.kosts.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Info Dasar -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Informasi Dasar</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kode Kost (Auto Generated)</label>
                    <input type="text" name="kode" value="{{ $kost->kode }}" class="shadow border rounded w-full py-2 px-3 text-gray-400 bg-gray-100" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kost</label>
                    <input type="text" name="name" value="{{ old('name', $kost->name) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kota</label>
                        <select name="city_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $kost->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipe</label>
                        <select name="type" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="putra" {{ old('type', $kost->type) == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ old('type', $kost->type) == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ old('type', $kost->type) == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Bulan)</label>
                    <input type="number" name="price" value="{{ old('price', $kost->price) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga Buka Kontak</label>
                    <input type="number" name="unlock_price" value="{{ old('unlock_price', $kost->unlock_price) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        <option value="tersedia" {{ old('status', $kost->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="penuh" {{ old('status', $kost->status) == 'penuh' ? 'selected' : '' }}>Penuh</option>
                    </select>
                </div>
            </div>

            <!-- Detail & Fasilitas -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Detail & Fasilitas</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>{{ old('description', $kost->description) }}</textarea>
                </div>
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Total Kamar</label>
                        <input type="number" name="total_rooms" value="{{ old('total_rooms', $kost->total_rooms) }}" class="shadow border rounded w-full py-2 px-3" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kamar Tersedia</label>
                        <input type="number" name="available_rooms" value="{{ old('available_rooms', $kost->available_rooms) }}" class="shadow border rounded w-full py-2 px-3" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Total Kamar Mandi</label>
                        <input type="number" name="total_bathrooms" value="{{ old('total_bathrooms', $kost->total_bathrooms) }}" class="shadow border rounded w-full py-2 px-3">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jml Lantai / Parkir</label>
                        <input type="text" name="floor_count" value="{{ old('floor_count', $kost->floor_count) }}" class="shadow border rounded w-full py-2 px-3 mb-1">
                    </div>
                </div>
                <div class="mb-4 text-sm">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-gray-700 text-sm font-bold">Fasilitas (Centang)</label>
                        <button type="button" onclick="openFacilityModal()" class="text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1 rounded">
                            <i class="fas fa-plus"></i> Tambah Fasilitas Baru
                        </button>
                    </div>
                    @php $kfac = $kost->facilities->pluck('id')->toArray() @endphp
                    <div class="grid grid-cols-2 gap-4 border rounded p-3 h-48 overflow-y-auto">
                        <div>
                            <p class="font-bold text-xs text-gray-500 mb-2 uppercase border-b pb-1">Fasilitas Kamar</p>
                            <div id="facilities-kamar-container">
                                @foreach($facilities->where('category', 'kamar') as $f)
                                    <div class="mb-1 facility-checkbox-wrapper">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="facilities[]" value="{{ $f->id }}" class="form-checkbox text-blue-600" {{ (is_array(old('facilities')) && in_array($f->id, old('facilities'))) || (!old('facilities') && in_array($f->id, $kfac)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm"><i class="{{ $f->icon }} text-gray-500 w-4 inline-block text-center mr-1"></i> {{ $f->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-gray-500 mb-2 uppercase border-b pb-1">Fasilitas Bersama</p>
                            <div id="facilities-bersama-container">
                                @foreach($facilities->where('category', 'bersama') as $f)
                                    <div class="mb-1 facility-checkbox-wrapper">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="facilities[]" value="{{ $f->id }}" class="form-checkbox text-blue-600" {{ (is_array(old('facilities')) && in_array($f->id, old('facilities'))) || (!old('facilities') && in_array($f->id, $kfac)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm"><i class="{{ $f->icon }} text-gray-500 w-4 inline-block text-center mr-1"></i> {{ $f->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak & Lokasi -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Kontak & Lokasi</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Label Area</label>
                    <input type="text" name="area_label" value="{{ old('area_label', $kost->area_label) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>{{ old('address', $kost->address) }}</textarea>
                </div>
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pemilik</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', $kost->owner_name) }}" class="shadow border rounded w-full py-2 px-3">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kontak (WhatsApp)</label>
                        <input type="text" name="owner_contact" value="{{ old('owner_contact', $kost->owner_contact) }}" class="shadow border rounded w-full py-2 px-3" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Google Maps</label>
                    <input type="text" name="maps_link" value="{{ old('maps_link', $kost->maps_link) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>
            </div>

            <!-- Media & Ekstra -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Tempat Sekitar & Media</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tempat Terdekat (1 per baris)</label>
                    <textarea name="nearby_places" rows="4" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ old('nearby_places', $nearbyPlacesStr) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload Foto Tambahan (Akan ditambahkan ke koleksi)</label>
                    <input type="file" name="images[]" multiple id="imageInput" class="shadow border rounded w-full py-2 px-3 text-gray-700" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG, JPG, WEBP. Maks: 2MB per gambar.</p>
                    @error('images')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <div id="imagePreview" class="flex flex-wrap gap-2 mt-3"></div>
                </div>
                <!-- Foto Saat ini -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto Saat Ini ({{ $kost->images->count() }} foto)</label>
                    @if($kost->images->count() > 0)
                        <div class="flex flex-wrap gap-3">
                            @foreach($kost->images as $img)
                                <div class="relative group w-28 h-28 border rounded overflow-hidden shadow-sm">
                                    <img src="{{ asset($img->image_path) }}" alt="Foto" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 flex items-center justify-center">
                                        <button type="button"
                                            onclick="confirmDeleteImage({{ $img->id }}, '{{ $img->image_path }}')"
                                            class="opacity-0 group-hover:opacity-100 bg-red-600 hover:bg-red-700 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transition-all duration-200"
                                            title="Hapus gambar ini">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm italic">Belum ada foto.</p>
                    @endif
                </div>

                <div class="mb-4 mt-6">
                    <label class="inline-flex items-center mr-4 mt-2">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $kost->is_featured) ? 'checked' : '' }} class="form-checkbox text-blue-600">
                        <span class="ml-2">Tandai Featured (Premium)</span>
                    </label>
                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" name="is_recommended" value="1" {{ old('is_recommended', $kost->is_recommended) ? 'checked' : '' }} class="form-checkbox text-blue-600">
                        <span class="ml-2">Rekomendasi</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 border-t pt-4 flex justify-end">
            <a href="{{ route('admin.kosts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-save mr-2"></i> Update Kost
            </button>
        </div>
    </form>
</div>

@include('admin.kosts._facility_modal')

@push('modals')
<!-- Delete Image Confirmation Modal -->
<div id="deleteImageModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeDeleteImageModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 w-96 max-w-[90vw]">
        <div class="text-center">
            <div class="mx-auto w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-trash-alt text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Gambar?</h3>
            <p class="text-gray-500 text-sm mb-4">Gambar ini akan dihapus secara permanen dan tidak bisa dikembalikan.</p>
            <div class="mb-4">
                <img id="deleteImagePreview" src="" alt="Preview" class="w-20 h-20 object-cover rounded mx-auto border">
            </div>
            <form id="deleteImageForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeDeleteImageModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded font-medium transition">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
// Image preview for new uploads
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    if (this.files) {
        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'w-24 h-24 border rounded overflow-hidden';
                div.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" alt="Preview">';
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
});

// Delete image confirmation
function confirmDeleteImage(imageId, imagePath) {
    const modal = document.getElementById('deleteImageModal');
    const form = document.getElementById('deleteImageForm');
    const preview = document.getElementById('deleteImagePreview');

    form.action = '{{ url("admin/kosts") }}/{{ $kost->id }}/images/' + imageId;
    preview.src = '{{ asset("") }}' + imagePath;

    modal.classList.remove('hidden');
}

function closeDeleteImageModal() {
    document.getElementById('deleteImageModal').classList.add('hidden');
}
</script>
@endpush
@endsection
