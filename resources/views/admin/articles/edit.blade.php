@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('header', 'Edit: ' . $article->title)

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-4xl">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-pen-fancy text-cta"></i> Edit Artikel
            </h3>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Ringkasan / Excerpt</label>
                <textarea name="excerpt" rows="2" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all resize-none">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Konten Artikel</label>
                <textarea name="content" rows="15" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all" required>{{ old('content', $article->content) }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Thumbnail</label>
                    @if($article->thumbnail_url)
                        <div class="border border-primary-lighter rounded-xl p-3 mb-3 bg-primary-lighter/10 flex items-center gap-4">
                            <img src="{{ $article->thumbnail_url }}" alt="" class="h-16 w-auto object-cover rounded-lg">
                            <label class="inline-flex items-center gap-2 text-xs text-red-600 cursor-pointer">
                                <input type="checkbox" name="remove_thumbnail" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span>Hapus</span>
                            </label>
                        </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full border border-primary-lighter rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 transition-all file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-lighter file:text-primary-dark">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary-dark mb-1.5">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', $article->author) }}" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary-dark mb-1.5">Meta Description (SEO)</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $article->meta_description) }}" maxlength="160" class="w-full border border-primary-lighter rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all">
            </div>

            @if($article->published_at)
            <p class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i> Dipublish {{ $article->published_at->format('d M Y, H:i') }}</p>
            @endif
        </div>

        <input type="hidden" name="is_published" id="publish_flag" value="{{ $article->is_published ? '1' : '0' }}">

        <div class="p-6 bg-primary-lighter/10 border-t border-primary-lighter/30 flex justify-end gap-3 rounded-b-2xl">
            <a href="{{ route('admin.articles.index') }}" class="px-5 py-2.5 rounded-full bg-white border border-primary-lighter text-primary-dark hover:bg-primary-lighter/30 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" onclick="document.getElementById('publish_flag').value='0'" class="px-6 py-2.5 rounded-full bg-gray-100 border border-gray-300 text-gray-700 hover:bg-gray-200 text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-file-pen text-xs"></i> Simpan Draft
            </button>
            <button type="submit" onclick="document.getElementById('publish_flag').value='1'" class="bg-green-600 text-white hover:bg-green-700 hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(22,163,74,0.3)] px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-globe text-xs"></i> {{ $article->is_published ? 'Update & Publish' : 'Publish Now' }}
            </button>
        </div>
    </form>
</div>
@endsection
