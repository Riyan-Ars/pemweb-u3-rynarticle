@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <span class="hero-pill">Portal Berita &amp; Wawasan</span>
        <h1 class="hero-title">Jelajahi Berita & Wawasan Terbaru</h1>
        <p class="hero-subtitle">Platform publikasi artikel, ide kreatif, dan opini bermakna dari komunitas Rynarticle.</p>
        <div class="hero-actions">
            @guest
                <a class="btn btn-primary" href="{{ route('login') }}">Mulai Membaca</a>
                <a class="btn btn-outline" href="{{ route('register') }}">Daftar Penulis</a>
            @endguest
            @auth
                <a class="btn btn-primary" href="{{ route('articles.create') }}">+ Tulis Artikel Baru</a>
                <a class="btn btn-outline" href="{{ route('articles.index') }}">Kelola Artikel Saya</a>
            @endauth
        </div>
    </div>
</div>

<div class="section-header">
    <div>
        <h2>Berita Terbaru</h2>
        <p class="muted">Artikel dan tulisan segar yang baru saja dipublikasikan.</p>
    </div>
    @auth
        <a class="btn btn-sm btn-outline" href="{{ route('articles.create') }}">+ Tambah Artikel</a>
    @endauth
</div>

@if ($articles->isNotEmpty())
    <div class="article-grid">
        @foreach ($articles as $article)
            <article class="card article-card">
                <div class="thumb-wrapper">
                    <img class="thumb" src="{{ $article->image_url }}"
                         alt="Gambar {{ $article->title }}"
                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
                         loading="lazy">
                    <span class="thumb-badge">Artikel</span>
                </div>
                <div class="body">
                    <div class="meta-row">
                        <span class="meta-author">
                            <span class="mini-avatar">{{ strtoupper(substr($article->user->name, 0, 1)) }}</span>
                            {{ $article->user->name }}
                        </span>
                        <span class="meta-date">&bull; {{ $article->created_at->format('d M Y') }}</span>
                    </div>
                    <h3>
                        <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                    </h3>
                    <p class="article-excerpt">
                        {{ \Illuminate\Support\Str::limit($article->body, 120) }}
                    </p>
                    <div class="article-footer">
                        <a href="{{ route('articles.show', $article) }}" class="read-more">
                            Baca Selengkapnya
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@else
    <div class="card empty-state">
        <div class="empty-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
        </div>
        <h3>Belum Ada Berita</h3>
        <p class="muted">Belum ada berita yang tersedia saat ini. Jadilah yang pertama menulis!</p>
        @auth
            <a class="btn btn-primary" href="{{ route('articles.create') }}" style="margin-top: 1rem;">+ Tulis Artikel Baru</a>
        @endauth
    </div>
@endif
@endsection
