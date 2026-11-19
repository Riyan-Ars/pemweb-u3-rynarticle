@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<section class="card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <div style="margin-bottom: 1.5rem;">
        <h2 style="margin: 0 0 0.35rem 0; font-size: 1.6rem;">Tulis Artikel Baru</h2>
        <p class="muted" style="margin: 0;">Bagikan opini, ide, atau berita terbaru kepada pembaca Rynarticle.</p>
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

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <label for="title">Judul Artikel</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}"
               required placeholder="Tuliskan judul yang menarik...">

        <label for="image">URL Gambar Sampul (Opsional)</label>
        <input type="url" id="image" name="image" value="{{ old('image') }}"
               placeholder="https://images.unsplash.com/... atau https://example.com/gambar.jpg">
        <p class="muted" style="font-size: 0.85rem; margin: 0.35rem 0 0;">
            Kosongkan jika ingin sistem menggunakan placeholder gambar otomatis.
        </p>

        <label for="body">Isi Artikel / Berita</label>
        <textarea id="body" name="body" rows="10" required
                  placeholder="Mulai tuliskan isi artikelmu di sini...">{{ old('body') }}</textarea>

        <div class="actions" style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">Simpan & Publikasikan</button>
            <a class="btn btn-outline" href="{{ route('articles.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
