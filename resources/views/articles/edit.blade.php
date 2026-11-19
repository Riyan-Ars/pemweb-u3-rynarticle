@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<section class="card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <div style="margin-bottom: 1.5rem;">
        <h2 style="margin: 0 0 0.35rem 0; font-size: 1.6rem;">Edit Artikel</h2>
        <p class="muted" style="margin: 0;">Perbarui konten atau gambar sampul artikel tulisanmu.</p>
    </div>

    @if ($errors->any())
        <div class="error">
            <div>
                <strong>Perhatian:</strong>
                <ul style="margin: 0.25rem 0 0; padding-left: 1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Judul Artikel</label>
        <input type="text" id="title" name="title"
               value="{{ old('title', $article->title) }}"
               required placeholder="Masukkan judul berita">

        <label for="image">URL Gambar Sampul (Opsional)</label>
        <input type="url" id="image" name="image"
               value="{{ old('image', $article->image) }}"
               placeholder="https://example.com/gambar.jpg">

        <p class="muted" style="font-size: 0.85rem; margin: 0.5rem 0 0.25rem 0;">Pratinjau gambar sampul saat ini:</p>
        <div style="max-width: 420px; overflow: hidden; border-radius: 10px; background: #0f101a; margin-bottom: 1rem;">
            <img src="{{ $article->image_url }}" alt="Gambar artikel"
                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
                 style="width: 100%; max-height: 220px; object-fit: cover;">
        </div>

        <label for="body">Isi Berita / Artikel</label>
        <textarea id="body" name="body" rows="10"
                  required>{{ old('body', $article->body) }}</textarea>

        <div class="actions" style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Update Artikel</button>
            <a class="btn btn-outline" href="{{ route('articles.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
