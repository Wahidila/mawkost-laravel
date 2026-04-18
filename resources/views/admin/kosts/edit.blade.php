@extends('layouts.admin')

@section('title', 'Edit Kost')
@section('header', 'Edit Kost: ' . $kost->name)

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-building text-cta"></i> Edit Data Kost
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi detail kost ini.</p>
        </div>
        <a href="{{ route('admin.kosts.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.kosts.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Kolom Kiri: Info Dasar & Kontak -->
            <div class="space-y-6">
                <!-- Section: Info Dasar -->
                <div class="bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50">
                    <h4 class="text-md font-bold font-display text-primary-dark mb-4 pb-2 border-b border-primary-lighter/50 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary"></i> Informasi Dasar
                    </h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Kode Kost (Auto Generated)</label>
                            <input type="text" name="kode" value="{{ $kost->kode }}" class="w-full border border-primary-lighter/50 rounded-xl px-4 py-2.5 text-sm bg-primary-lighter/10 text-gray-400 cursor-not-allowed font-mono" readonly>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Kost</label>
                            <input type="text" name="name" value="{{ old('name', $kost->name) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Kota</label>
                                <select name="city_id" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-gray-700" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $kost->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Tipe</label>
                                <select name="kost_type_id" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-gray-700" required>
                                    <option value="">Pilih Tipe...</option>
                                    @foreach($kostTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('kost_type_id', $kost->kost_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Harga (Bulan)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-400 text-sm font-medium">Rp</span>
                                    <input type="number" name="price" value="{{ old('price', $kost->price) }}" class="w-full border border-primary-lighter rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Harga Buka Kontak</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-400 text-sm font-medium">Rp</span>
                                    <input type="number" name="unlock_price" value="{{ old('unlock_price', $kost->unlock_price) }}" class="w-full border border-primary-lighter rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Status</label>
                            <select name="status" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-gray-700" required>
                                <option value="tersedia" {{ old('status', $kost->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="penuh" {{ old('status', $kost->status) == 'penuh' ? 'selected' : '' }}>Penuh</option>
                            </select>
                        </div>
                        
                        <div class="pt-2 flex flex-col gap-3">
                            <label class="inline-flex items-center group cursor-pointer bg-white border border-primary-lighter rounded-xl py-2.5 px-4 hover:bg-amber-50 hover:border-amber-200 transition-colors">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $kost->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-amber-500 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 focus:ring-2">
                                <span class="ml-3 text-sm font-medium text-primary-dark"><i class="fas fa-crown text-amber-500 mr-1.5"></i> Tandai Featured (Premium)</span>
                            </label>
                            <label class="inline-flex items-center group cursor-pointer bg-white border border-primary-lighter rounded-xl py-2.5 px-4 hover:bg-blue-50 hover:border-blue-200 transition-colors">
                                <input type="checkbox" name="is_recommended" value="1" {{ old('is_recommended', $kost->is_recommended) ? 'checked' : '' }} class="w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-sm font-medium text-primary-dark"><i class="fas fa-thumbs-up text-blue-500 mr-1.5"></i> Rekomendasi Mawkost</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Section: Kontak & Lokasi -->
                <div class="bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50">
                    <h4 class="text-md font-bold font-display text-primary-dark mb-4 pb-2 border-b border-primary-lighter/50 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-primary"></i> Kontak & Lokasi
                    </h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Label Area</label>
                            <input type="text" name="area_label" placeholder="Contoh: Dekat UGM, Seturan, dll" value="{{ old('area_label', $kost->area_label) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all placeholder:text-gray-400" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Alamat Lengkap</label>
                            <textarea name="address" rows="2" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all resize-none" required>{{ old('address', $kost->address) }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Nama Pemilik</label>
                                <input type="text" name="owner_name" value="{{ old('owner_name', $kost->owner_name) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Kontak (WhatsApp)</label>
                                <input type="text" name="owner_contact" placeholder="08..." value="{{ old('owner_contact', $kost->owner_contact) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Link Google Maps (Opsional)</label>
                            <input type="text" name="maps_link" placeholder="https://maps.app.goo.gl/..." value="{{ old('maps_link', $kost->maps_link) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all text-blue-600">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Tempat Terdekat (1 per baris)</label>
                            <textarea name="nearby_places" rows="3" placeholder="Minimarket&#10;Kampus&#10;Masjid" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all resize-none">{{ old('nearby_places', $nearbyPlacesStr) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail, Fasilitas & Foto -->
            <div class="space-y-6">
                <!-- Section: Detail Detail & Fasilitas -->
                <div class="bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50">
                    <h4 class="text-md font-bold font-display text-primary-dark mb-4 pb-2 border-b border-primary-lighter/50 flex items-center gap-2">
                        <i class="fas fa-list-ul text-primary"></i> Detail & Fasilitas
                    </h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Deskripsi Kost</label>
                            <textarea name="description" rows="3" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all resize-none" required>{{ old('description', $kost->description) }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Total Kamar</label>
                                <input type="number" name="total_rooms" value="{{ old('total_rooms', $kost->total_rooms) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Kamar Tersedia</label>
                                <input type="number" name="available_rooms" value="{{ old('available_rooms', $kost->available_rooms) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all border-l-4 border-l-cta" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Total Kamar Mandi</label>
                                <input type="number" name="total_bathrooms" value="{{ old('total_bathrooms', $kost->total_bathrooms) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Info Parkir / Lantai</label>
                                <input type="text" name="floor_count" placeholder="Contoh: 2 Lantai, Parkir Luas" value="{{ old('floor_count', $kost->floor_count) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-semibold text-primary-dark">Fasilitas (Centang)</label>
                                <button type="button" onclick="openFacilityModal()" class="text-xs bg-primary-lighter/30 text-primary hover:bg-primary hover:text-white px-3 py-1.5 rounded-full font-semibold transition-colors duration-200">
                                    <i class="fas fa-plus mr-1"></i> Buat Baru
                                </button>
                            </div>
                            @php $kfac = $kost->facilities->pluck('id')->toArray() @endphp
                            
                            <div class="bg-white border border-primary-lighter rounded-xl p-4 max-h-[220px] overflow-y-auto custom-scrollbar">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <!-- Kolom Kamar -->
                                    <div>
                                        <p class="font-bold text-[11px] text-primary mb-3 uppercase tracking-wider border-b border-primary-lighter pb-1.5">
                                            <i class="fas fa-bed mr-1"></i> Fasilitas Kamar
                                        </p>
                                        <div id="facilities-kamar-container" class="space-y-2">
                                            @foreach($facilities->where('category', 'kamar') as $f)
                                                <label class="flex items-start gap-2.5 cursor-pointer group">
                                                    <input type="checkbox" name="facilities[]" value="{{ $f->id }}" 
                                                        class="mt-0.5 w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2" 
                                                        {{ (is_array(old('facilities')) && in_array($f->id, old('facilities'))) || (!old('facilities') && in_array($f->id, $kfac)) ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-700 group-hover:text-primary-dark font-medium transition-colors flex items-center">
                                                        <i class="{{ $f->icon }} text-primary-light w-5 text-center mr-1"></i> 
                                                        {{ $f->name }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <!-- Kolom Bersama -->
                                    <div>
                                        <p class="font-bold text-[11px] text-primary mb-3 uppercase tracking-wider border-b border-primary-lighter pb-1.5">
                                            <i class="fas fa-users mr-1"></i> Fasilitas Bersama
                                        </p>
                                        <div id="facilities-bersama-container" class="space-y-2">
                                            @foreach($facilities->where('category', 'bersama') as $f)
                                                <label class="flex items-start gap-2.5 cursor-pointer group">
                                                    <input type="checkbox" name="facilities[]" value="{{ $f->id }}" 
                                                        class="mt-0.5 w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2" 
                                                        {{ (is_array(old('facilities')) && in_array($f->id, old('facilities'))) || (!old('facilities') && in_array($f->id, $kfac)) ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-700 group-hover:text-primary-dark font-medium transition-colors flex items-center">
                                                        <i class="{{ $f->icon }} text-primary-light w-5 text-center mr-1"></i> 
                                                        {{ $f->name }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Media Preview & Upload -->
                <div class="bg-primary-lighter/10 p-5 rounded-2xl border border-primary-lighter/50">
                    <h4 class="text-md font-bold font-display text-primary-dark mb-4 pb-2 border-b border-primary-lighter/50 flex items-center gap-2">
                        <i class="fas fa-image text-primary"></i> Foto Kost
                    </h4>
                    
                    <div class="space-y-4">
                        <!-- Foto Saat Ini -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-semibold text-primary-dark">Foto Tersimpan ({{ $kost->images->count() }})</label>
                            </div>
                            
                            @if($kost->images->count() > 0)
                                <div class="flex flex-wrap gap-3">
                                    @foreach($kost->images as $img)
                                        <div class="relative group w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden shadow-sm border border-primary-lighter/50">
                                            <img src="{{ asset($img->image_path) }}" alt="Foto" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            <!-- Overlay Delete -->
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center backdrop-blur-[2px]">
                                                <button type="button"
                                                    onclick="confirmDeleteImage({{ $img->id }}, '{{ $img->image_path }}')"
                                                    class="bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transition-transform hover:scale-110"
                                                    title="Hapus gambar ini">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-white border border-dashed border-gray-300 rounded-xl p-4 text-center">
                                    <p class="text-gray-400 text-sm font-medium"><i class="fas fa-camera-slash mb-1 block text-lg"></i>Belum ada foto</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Upload Foto Baru -->
                        <div class="pt-2">
                            <label class="block text-sm font-semibold text-primary-dark mb-1.5">Tambah Foto Beru</label>
                            <input type="file" name="images[]" multiple id="imageInput" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all file:mr-3 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-lighter/50 file:text-primary-dark hover:file:bg-primary-lighter" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1"><i class="fas fa-info-circle"></i> Dapat memilih lebih dari 1 file skaligus.</p>
                            @error('images') <p class="text-red-500 text-xs italic mt-1 font-medium">{{ $message }}</p> @enderror
                            
                            <!-- Area Preview Upload Baru -->
                            <div id="imagePreview" class="flex flex-wrap gap-2 mt-3 empty:hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.kosts.index') }}" class="px-6 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-8 py-2.5 rounded-full text-sm font-bold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-save text-sm"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@include('admin.kosts._facility_modal')

@push('modals')
<!-- Delete Image Confirmation Modal -->
<div id="deleteImageModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteImageModal()"></div>
    <div class="relative bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_16px_48px_rgba(92,61,46,0.15)] border border-primary-lighter/30 p-6 w-[360px] max-w-[90vw] animate-fade-in text-center">
        <!-- Close button inside modal -->
        <button type="button" onclick="closeDeleteImageModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100">
            <i class="fas fa-times"></i>
        </button>

        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-trash-alt text-red-500 text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold font-display text-primary-dark tracking-tight mb-2">Hapus Foto?</h3>
        <p class="text-gray-500 text-sm mb-5">Foto ini akan dihapus secara permanen dari server. Tindakan ini tidak dapat dikembalikan.</p>
        
        <div class="mb-6 flex justify-center">
            <div class="w-24 h-24 rounded-xl border-2 border-red-100 overflow-hidden shadow-sm">
                <img id="deleteImagePreview" src="" alt="Preview" class="w-full h-full object-cover">
            </div>
        </div>
        
        <form id="deleteImageForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeDeleteImageModal()" class="px-5 py-2.5 rounded-full bg-primary-lighter/40 hover:bg-primary-lighter text-primary-dark text-sm font-medium transition-colors flex-1">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm font-bold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 flex-1">
                    <i class="fas fa-trash text-xs"></i> Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
// Image preview for new uploads
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    preview.classList.remove('hidden');
    
    if (this.files && this.files.length > 0) {
        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'w-16 h-16 sm:w-20 sm:h-20 border border-primary-lighter rounded-xl overflow-hidden shadow-sm shadow-primary/5';
                div.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" alt="Preview">';
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        preview.classList.add('hidden');
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
