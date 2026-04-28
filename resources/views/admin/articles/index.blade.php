@extends('layouts.admin')

@section('title', 'Kelola Artikel')
@section('header', 'Kelola Artikel Blog')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="p-6 border-b border-primary-lighter/40 bg-white/50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight">Daftar Artikel</h3>
            <p class="text-sm text-gray-500 mt-0.5">Tulis dan kelola artikel blog untuk SEO dan edukasi user.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-plus text-xs"></i> Tulis Artikel
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-primary-lighter/50">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Artikel</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Penulis</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-primary-dark uppercase tracking-wider font-display">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-lighter/30">
                @forelse($articles as $article)
                <tr class="hover:bg-primary-lighter/10 transition-colors duration-150">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if($article->thumbnail_url)
                                <img src="{{ $article->thumbnail_url }}" alt="" class="w-12 h-12 rounded-lg object-cover border border-primary-lighter/50">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-primary-lighter/50 flex items-center justify-center text-primary">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-primary-dark truncate max-w-xs">{{ $article->title }}</p>
                                <p class="text-xs text-gray-400">{{ $article->reading_time }} min read</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ $article->author }}</td>
                    <td class="px-5 py-4 whitespace-nowrap text-center">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $article->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                        {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-3">
                            @if($article->is_published)
                                <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="text-blue-500 hover:text-blue-700 transition-colors"><i class="fas fa-external-link-alt text-xs"></i></a>
                            @endif
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-primary hover:text-cta transition-colors"><i class="fas fa-edit text-xs"></i> Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors"><i class="fas fa-trash text-xs"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-sm text-center text-gray-400">
                        <i class="fas fa-newspaper text-3xl text-primary-lighter mb-2 block"></i>
                        Belum ada artikel. Mulai tulis artikel pertamamu!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div class="p-4 border-t border-primary-lighter/30">{{ $articles->links() }}</div>
    @endif
</div>
@endsection
