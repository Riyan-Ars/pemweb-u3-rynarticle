@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(147, 51, 234, 0.03) 100%);">
    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <span class="avatar-initial" style="width: 48px; height: 48px; font-size: 1.25rem;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </span>
        <div>
            <h2 style="margin: 0; font-size: 1.5rem;">Selamat Datang, {{ $user->name }}!</h2>
            <p class="muted" style="margin: 0.25rem 0 0;">Ringkasan dan analitik aktivitas publikasi artikelmu di Rynarticle.</p>
        </div>
    </div>
</section>

<section class="row">
    <div class="card" style="border-top: 3px solid #7c3aed;">
        <span class="muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Publikasi</span>
        <p class="stat">{{ $totalArticles }}</p>
        <p class="muted" style="font-size: 0.88rem; margin: 0;">Jumlah seluruh artikel aktif di sistem.</p>
    </div>

    <div class="card" style="border-top: 3px solid #a855f7;">
        <span class="muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Artikel Saya</span>
        <p class="stat">{{ $myArticles }}</p>
        <p class="muted" style="font-size: 0.88rem; margin: 0;">Artikel yang ditulis oleh akun Anda.</p>
    </div>

    <div class="card" style="border-top: 3px solid #3b82f6;">
        <span class="muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Menu Akselerasi</span>
        <ul style="margin: 0.75rem 0 0; padding-left: 1.15rem; display: flex; flex-direction: column; gap: 0.4rem;">
            <li><a href="{{ route('articles.create') }}"><strong>+ Tambah Artikel Baru</strong></a></li>
            <li><a href="{{ route('articles.index') }}">Lihat Semua Artikel</a></li>
            <li><a href="{{ route('home') }}">Kembali ke Beranda</a></li>
        </ul>
    </div>
</section>

<section class="card" style="margin-top: 1.5rem;">
    <div class="page-head" style="margin-bottom: 1rem;">
        <h3>Artikel Terbaru di Portal</h3>
        <a class="btn btn-outline btn-sm" href="{{ route('home') }}">Lihat di Beranda &rarr;</a>
    </div>

    @if ($latestArticles->isNotEmpty())
        <div class="row">
            @foreach ($latestArticles as $article)
                <article class="card" style="box-shadow: none; border-color: var(--border-light); background: var(--surface-hover);">
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <img src="{{ $article->image_url }}"
                             alt="Thumbnail {{ $article->title }}"
                             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
                             style="width: 110px; height: 75px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                        <div style="flex: 1; min-width: 180px;">
                            <h4 style="margin: 0 0 .25rem 0; font-size: 1rem;">
                                <a href="{{ route('articles.show', $article) }}">
                                    {{ $article->title }}
                                </a>
                            </h4>
                            <p class="meta" style="margin-bottom: 0.35rem;">
                                <span>{{ $article->user->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $article->created_at->format('d M Y') }}</span>
                            </p>
                            <p style="margin: 0; font-size: 0.88rem; color: var(--text-muted);">
                                {{ \Illuminate\Support\Str::limit($article->body, 90) }}
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <p class="muted" style="margin: 0;">Belum ada artikel yang bisa ditampilkan.</p>
    @endif
</section>

<section class="card" style="margin-top: 1.5rem;">
    <h3>Informasi Akun Penulis</h3>
    <ul style="margin: 0.5rem 0 0; padding-left: 1.25rem;">
        <li><strong>Nama Pengguna:</strong> {{ $user->name }}</li>
        <li><strong>Alamat Email:</strong> {{ $user->email }}</li>
    </ul>
    <p class="muted" style="margin-top: 0.75rem; font-size: 0.9rem;">
        Kamu memiliki akses penuh untuk membuat, memperbarui, dan menghapus artikel milikmu melalui panel ini.
    </p>
</section>
@endsection
