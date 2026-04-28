@extends('layouts.app')

@section('title', $article->title . ' — Blog mawkost')
@section('meta_description', $article->meta_description ?: $article->short_excerpt)
@section('og_title', $article->title . ' — Blog mawkost')
@section('og_description', $article->meta_description ?: $article->short_excerpt)
@section('og_image', $article->thumbnail_url ?: asset('assets/img/logo.png'))

@section('content')
@push('styles')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ $article->title }}",
    "description": "{{ $article->meta_description ?: $article->short_excerpt }}",
    @if($article->thumbnail_url)
    "image": "{{ $article->thumbnail_url }}",
    @endif
    "author": {
        "@type": "Person",
        "name": "{{ $article->author }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "mawkost",
        "logo": { "@type": "ImageObject", "url": "{{ asset('assets/img/logo.png') }}" }
    },
    "datePublished": "{{ $article->published_at->toIso8601String() }}",
    "dateModified": "{{ $article->updated_at->toIso8601String() }}",
    "mainEntityOfPage": "{{ url()->current() }}"
}
</script>
@endpush

<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('blog.index') }}">Blog</a>
            <span class="sep">/</span>
            <span class="current">{{ Str::limit($article->title, 40) }}</span>
        </div>
    </div>
</div>

<article class="section" style="padding-top: 32px; padding-bottom: 60px;">
    <div class="container">
        <div class="blog-article-layout">
            <div class="blog-article fade-in">
                <header class="blog-article-header">
                    <h1>{{ $article->title }}</h1>
                    <div class="blog-article-meta">
                        <span><i class="fa-solid fa-user"></i> {{ $article->author }}</span>
                        <span><i class="fa-regular fa-calendar"></i> {{ $article->published_at->translatedFormat('d F Y') }}</span>
                        <span><i class="fa-regular fa-clock"></i> {{ $article->reading_time }} min read</span>
                    </div>
                </header>

                @if($article->thumbnail_url)
                <div class="blog-article-thumbnail">
                    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy">
                </div>
                @endif

                <div class="blog-article-content">
                    {!! $article->content !!}
                </div>

                <footer class="blog-article-footer">
                    <div class="share-bar" style="justify-content: flex-start;">
                        <span class="share-label"><i class="fa-solid fa-share-nodes"></i> Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($article->title . "\n👉 " . url()->current()) }}" target="_blank" rel="noopener" class="share-btn share-wa"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="share-btn share-twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="share-btn share-fb"><i class="fa-brands fa-facebook-f"></i></a>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ url()->current() }}');this.innerHTML='<i class=\'fa-solid fa-check\'></i>';setTimeout(()=>this.innerHTML='<i class=\'fa-solid fa-link\'></i>',1500)" class="share-btn share-copy"><i class="fa-solid fa-link"></i></button>
                    </div>
                </footer>
            </div>

            @if($relatedArticles->count() > 0)
            <aside class="blog-sidebar fade-in">
                <h4 style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--primary-dark);margin-bottom:16px;font-size:1rem;">Artikel Lainnya</h4>
                @foreach($relatedArticles as $related)
                <a href="{{ route('blog.show', $related->slug) }}" class="blog-sidebar-card">
                    @if($related->thumbnail_url)
                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}" loading="lazy">
                    @endif
                    <div>
                        <h5>{{ Str::limit($related->title, 60) }}</h5>
                        <span>{{ $related->published_at->format('d M Y') }}</span>
                    </div>
                </a>
                @endforeach
            </aside>
            @endif
        </div>
    </div>
</article>
@endsection
