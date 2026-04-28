@extends('layouts.admin')

@section('title', 'Tulis Artikel')
@section('header', 'Tulis Artikel Baru')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-4xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-pen-fancy text-cta"></i> Tulis Artikel Baru
            </h3>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" placeholder="Tips Memilih Kost untuk Mahasiswa Baru" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Ringkasan / Excerpt</label>
                <textarea name="excerpt" rows="2" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all resize-none" placeholder="Ringkasan singkat artikel (maks 500 karakter)">{{ old('excerpt') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Tampil di halaman blog index dan meta description.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Konten Artikel</label>
                <textarea name="content" id="content-editor" rows="15" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" placeholder="Tulis konten artikel di sini... (mendukung HTML)" required>{{ old('content') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Mendukung HTML. Gunakan tag &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;strong&gt;, &lt;img&gt; untuk format.</p>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 transition-all file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-lighter file:text-primary-dark">
                    <p class="text-xs text-gray-400 mt-1">Gambar utama artikel. Rasio 16:9 disarankan.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', 'Tim Mawkost') }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Meta Description (SEO)</label>
                <input type="text" name="meta_description" value="{{ old('meta_description') }}" maxlength="160" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" placeholder="Deskripsi untuk Google (maks 160 karakter)">
                <p class="text-xs text-gray-400 mt-1">Jika kosong, akan menggunakan excerpt.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Status</label>
                <select name="is_published" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
                    <option value="0" {{ old('is_published', '0') === '0' ? 'selected' : '' }}>Draft</option>
                    <option value="1" {{ old('is_published') === '1' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>
        </div>

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.articles.index') }}" class="px-5 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-save text-xs"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
