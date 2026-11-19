@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section class="card" style="max-width: 480px; margin: 1.5rem auto; padding: 2rem;">
    <div style="text-align: center; margin-bottom: 1.5rem;">
        <div style="background: #090a12; padding: 0.65rem 1.4rem; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.85rem; border: 1px solid rgba(139, 92, 246, 0.25); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
            <img src="{{ asset('images/logo.png') }}" alt="Rynarticle" style="height: 38px; width: auto; object-fit: contain;">
        </div>
        <h2 style="margin: 0; font-size: 1.45rem;">Buat Akun Penulis</h2>
        <p class="muted" style="margin: 0.35rem 0 0; font-size: 0.9rem;">Bergabunglah dengan komunitas penulis Rynarticle.</p>
    </div>

    @if ($errors->any())
        <div class="error">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name"
               value="{{ old('name') }}" required autofocus
               placeholder="Contoh: Ryan Pratama">

        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}" required
               placeholder="nama@email.com">

        <label for="password">Password (minimal 8 karakter)</label>
        <input type="password" id="password" name="password" required
               placeholder="••••••••">

        <label for="password_confirmation">Ulangi Password</label>
        <input type="password" id="password_confirmation"
               name="password_confirmation" required
               placeholder="••••••••">

        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1.5rem;">Daftar Akun Penulis</button>
    </form>

    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); text-align: center;">
        <p class="muted" style="margin: 0; font-size: 0.9rem;">
            Sudah memiliki akun? <a href="{{ route('login') }}" style="font-weight: 600;">Masuk di sini</a>
        </p>
    </div>
</section>
@endsection
