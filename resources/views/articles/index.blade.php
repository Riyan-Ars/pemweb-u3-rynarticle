@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<div class="page-head">
    <div>
        <h2>Daftar Artikel</h2>
        <p class="muted" style="margin: 0.25rem 0 0;">Kelola dan publikasikan artikel tulisanmu di Rynarticle.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('articles.create') }}">+ Tulis Artikel Baru</a>
</div>

@if (session('success'))
    <div class="flash">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<section class="card">
    @if ($articles->isNotEmpty())
        <ul class="list">
            @foreach ($articles as $article)
                <li>
                    <img src="{{ $article->image_url }}" alt="" loading="lazy"
                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
                         style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                    <div class="grow">
                        <a href="{{ route('articles.show', $article) }}">
                            <strong>{{ $article->title }}</strong>
                        </a>
                        <p class="meta" style="margin-top: 0.25rem;">
                            <span class="mini-avatar" style="width: 18px; height: 18px; font-size: 0.65rem;">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </span>
                            <span>{{ $article->user->name }} &bull; {{ $article->created_at->format('d M Y') }}</span>
                        </p>
                    </div>

                    @if ($article->user_id === auth()->id())
                        <div class="actions" style="margin: 0;">
                            <a class="btn btn-outline btn-sm"
                               href="{{ route('articles.edit', $article) }}">Edit</a>
                            <form action="{{ route('articles.destroy', $article) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        {{ $articles->links('vendor.pagination.custom') }}
    @else
        <div class="empty-state">
            <div class="empty-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
        </div>
            <h3>Belum Ada Artikel</h3>
            <p class="muted">Kamu belum mempublikasikan artikel apapun.</p>
            <a class="btn btn-primary" href="{{ route('articles.create') }}" style="margin-top: 1rem;">+ Buat Artikel Pertama</a>
        </div>
    @endif
</section>
@endsection
