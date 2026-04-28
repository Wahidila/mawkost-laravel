@extends('layouts.app')

@section('title', 'Blog — mawkost')
@section('meta_description', 'Tips, panduan, dan informasi seputar kost untuk mahasiswa dan anak rantau di Indonesia.')
@section('og_title', 'Blog mawkost — Tips & Info Kost')
@section('og_description', 'Tips, panduan, dan informasi seputar kost untuk mahasiswa dan anak rantau di Indonesia.')

@section('content')
<div style="background: var(--surface); border-bottom: 1px solid var(--border-light); padding-top: var(--nav-h);">
    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Blog</span>
        </div>
        <div class="fade-in" style="padding-bottom: 32px;">
            <h1 style="font-size: 2rem;">Blog Mawkost</h1>
            <p class="text-muted" style="margin-top: 8px;">Tips, panduan, dan informasi seputar kost untuk mahasiswa dan anak rantau.</p>
        </div>
    </div>
</div>

<section class="section" style="padding-top: 40px;">
    <div class="container">
        @if($articles->isEmpty())
            <div style="text-align: center; padding: 60px 0;">
                <i class="fa-solid fa-newspaper" style="font-size: 48px; color: var(--border-light); margin-bottom: 16px;"></i>
                <h3 class="text-muted">Belum ada artikel</h3>
                <p class="text-muted">Kami sedang menyiapkan konten menarik untukmu.</p>
            </div>
        @else
            <div class="blog-grid">
                @foreach($articles as $article)
                <a href="{{ route('blog.show', $article->slug) }}" class="blog-card fade-in">
                    <div class="blog-card-img">
                        @if($article->thumbnail_url)
                            <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy">
                        @else
                            <div class="blog-card-placeholder">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                        @endif
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span><i class="fa-solid fa-user"></i> {{ $article->author }}</span>
                            <span><i class="fa-regular fa-calendar"></i> {{ $article->published_at->format('d M Y') }}</span>
                            <span><i class="fa-regular fa-clock"></i> {{ $article->reading_time }} min</span>
                        </div>
                        <h3 class="blog-card-title">{{ $article->title }}</h3>
                        <p class="blog-card-excerpt">{{ $article->short_excerpt }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            <div style="margin-top: 40px;">
                {{ $articles->links('vendor.pagination.mawkost') }}
            </div>
        @endif
    </div>
</section>
@endsection
