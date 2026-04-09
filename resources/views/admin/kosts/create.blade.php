@extends('layouts.admin')

@section('title', 'Tambah Kost')
@section('header', 'Tambah Kost Baru')

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6">
    <form action="{{ route('admin.kosts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Info Dasar -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Informasi Dasar</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kost</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required>
                    @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kota</label>
                        <select name="city_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="">Pilih Kota...</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipe</label>
                        <select name="kost_type_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="">Pilih Tipe...</option>
                            @foreach($kostTypes as $type)
                                <option value="{{ $type->id }}" {{ old('kost_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Bulan)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga Buka Kontak</label>
                    <input type="number" name="unlock_price" value="{{ old('unlock_price', 35000) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="penuh" {{ old('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                    </select>
                </div>
            </div>

            <!-- Detail & Fasilitas -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Detail & Fasilitas</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>{{ old('description') }}</textarea>
                </div>
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Total Kamar</label>
                        <input type="number" name="total_rooms" value="{{ old('total_rooms') }}" class="shadow border rounded w-full py-2 px-3" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kamar Tersedia</label>
                        <input type="number" name="available_rooms" value="{{ old('available_rooms') }}" class="shadow border rounded w-full py-2 px-3" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Total Kamar Mandi</label>
                        <input type="number" name="total_bathrooms" value="{{ old('total_bathrooms') }}" class="shadow border rounded w-full py-2 px-3">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jml Lantai / Parkir</label>
                        <input type="text" name="floor_count" value="{{ old('floor_count') }}" placeholder="2 Lantai" class="shadow border rounded w-full py-2 px-3 mb-1">
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-gray-700 text-sm font-bold">Fasilitas (Centang)</label>
                        <button type="button" onclick="openFacilityModal()" class="text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1 rounded">
                            <i class="fas fa-plus"></i> Tambah Fasilitas Baru
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-4 border rounded p-3 h-48 overflow-y-auto">
                        <div>
                            <p class="font-bold text-xs text-gray-500 mb-2 uppercase border-b pb-1">Fasilitas Kamar</p>
                            <div id="facilities-kamar-container">
                                @foreach($facilities->where('category', 'kamar') as $f)
                                    <div class="mb-1 facility-checkbox-wrapper">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="facilities[]" value="{{ $f->id }}" class="form-checkbox text-blue-600" {{ is_array(old('facilities')) && in_array($f->id, old('facilities')) ? 'checked' : '' }}>
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
                                            <input type="checkbox" name="facilities[]" value="{{ $f->id }}" class="form-checkbox text-blue-600" {{ is_array(old('facilities')) && in_array($f->id, old('facilities')) ? 'checked' : '' }}>
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
                    <label class="block text-gray-700 text-sm font-bold mb-2">Label Area (Misal: Suhat, Malang)</label>
                    <input type="text" name="area_label" value="{{ old('area_label') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>{{ old('address') }}</textarea>
                </div>
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pemilik</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" class="shadow border rounded w-full py-2 px-3">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kontak (WhatsApp)</label>
                        <input type="text" name="owner_contact" value="{{ old('owner_contact') }}" placeholder="081xxx" class="shadow border rounded w-full py-2 px-3" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Google Maps</label>
                    <input type="text" name="maps_link" value="{{ old('maps_link') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>
            </div>

            <!-- Media & Ekstra -->
            <div>
                <h4 class="text-md font-bold mb-4 border-b pb-2">Tempat Sekitar & Media</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tempat Terdekat (1 per baris)</label>
                    <textarea name="nearby_places" rows="4" placeholder="5 Menit ke UB&#10;Dekat Alfamart" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ old('nearby_places') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload Foto (Bisa pilih banyak)</label>
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
                <div class="mb-4 mt-6">
                    <label class="inline-flex items-center mr-4 mt-2">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="form-checkbox text-blue-600">
                        <span class="ml-2">Tandai Featured (Premium)</span>
                    </label>
                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" name="is_recommended" value="1" {{ old('is_recommended') ? 'checked' : '' }} class="form-checkbox text-blue-600">
                        <span class="ml-2">Rekomendasi</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 border-t pt-4 flex justify-end">
            <a href="{{ route('admin.kosts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-save mr-2"></i> Simpan Kost
            </button>
        </div>
    </form>
</div>

@include('admin.kosts._facility_modal')

@push('scripts')
<script>
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
</script>
@endpush
@endsection
