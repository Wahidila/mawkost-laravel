@extends('layouts.app')

@section('title', $article->title . ' — Blog mawkost')
@section('meta_description', $article->meta_description ?: $article->short_excerpt)
@section('og_title', $article->title . ' — Blog mawkost')
@section('og_description', $article->meta_description ?: $article->short_excerpt)
@section('og_image', $article->thumbnail_url ?: asset('assets/img/logo.png'))
@section('og_type', 'article')

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

                <div class="blog-inline-cta">
                    <div class="blog-inline-cta-icon">
                        <i class="fa-solid fa-magnifying-glass-location"></i>
                    </div>
                    <div class="blog-inline-cta-body">
                        <h4>Sudah siap cari kost?</h4>
                        <p>Temukan kost terbaik sesuai budget dan lokasimu. Harga transparan, langsung dari pemilik!</p>
                    </div>
                    <a href="{{ route('kost.search') }}" class="blog-inline-cta-btn">Cari Kost Sekarang <i class="fa-solid fa-arrow-right"></i></a>
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
                <div class="blog-cta-ai">
                    <div class="blog-cta-glow"></div>
                    <div class="blog-cta-particles">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <div class="blog-cta-icon">
                        <i class="fa-solid fa-robot"></i>
                        <div class="blog-cta-pulse"></div>
                    </div>
                    <h4>Cari Kost dengan AI</h4>
                    <p>Sesuai kebutuhanmu — kota, budget, tipe, fasilitas. Tanya langsung!</p>
                    <a href="{{ route('chat.index') }}" class="blog-cta-btn">
                        <span class="blog-cta-btn-text"><i class="fa-solid fa-wand-magic-sparkles"></i> Konsultasi AI</span>
                        <span class="blog-cta-btn-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    <div class="blog-cta-badge">
                        <i class="fa-solid fa-bolt"></i> Gratis
                    </div>
                </div>

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
        @if($recommendedKosts->count() > 0)
        <div style="margin-top: 40px;">
            <div class="section-header fade-in" style="padding: 0 0 24px;">
                <h2>Rekomendasi Kost</h2>
                <p>Kost pilihan yang mungkin cocok untukmu</p>
            </div>
            <div class="listing-grid fade-in">
                @foreach($recommendedKosts as $kost)
                    <x-kost-card :kost="$kost" />
                @endforeach
            </div>
        </div>
        @endif
    </div>
</article>
@endsection
