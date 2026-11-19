@extends('layouts.app')

@section('title', $article->title)

@section('content')
<article class="card" style="max-width: 820px; margin: 0 auto; padding: 2.25rem;">
    <div style="margin-bottom: 1.5rem;">
        <div class="meta-row" style="margin-bottom: 0.85rem;">
            <span class="meta-author" style="font-size: 0.95rem;">
                <span class="avatar-initial" style="width: 28px; height: 28px; font-size: 0.8rem;">
                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                </span>
                {{ $article->user->name }}
            </span>
            <span class="meta-date" style="font-size: 0.9rem;">&bull; Dipublikasikan pada {{ $article->created_at->format('d M Y') }}</span>
        </div>

        <h1 style="font-size: 2.2rem; margin: 0 0 1rem 0; line-height: 1.3;">{{ $article->title }}</h1>
    </div>

    <div style="margin: 1.5rem 0 2rem 0; overflow: hidden; border-radius: var(--radius); background: #0f101a;">
        <img src="{{ $article->image_url }}"
             alt="Gambar untuk {{ $article->title }}"
             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
             style="width: 100%; max-height: 420px; object-fit: cover;">
    </div>

    <div style="font-size: 1.1rem; line-height: 1.85; color: var(--text); margin-bottom: 2.5rem; word-break: break-word;">
        {!! nl2br(e($article->body)) !!}
    </div>

    <div style="padding-top: 1.5rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a class="btn btn-outline btn-sm" href="{{ route('home') }}">&larr; Kembali ke Home</a>
            @auth
                <a class="btn btn-outline btn-sm" href="{{ route('articles.index') }}">Daftar Artikel</a>
            @endauth
        </div>

        @auth
            @if ($article->user_id === auth()->id())
                <a class="btn btn-sm btn-primary" href="{{ route('articles.edit', $article) }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    Edit Artikel
                </a>
            @endif
        @endauth
    </div>
</article>
@endsection
