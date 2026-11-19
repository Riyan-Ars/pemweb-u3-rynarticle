@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="card" style="max-width: 440px; margin: 1.5rem auto; padding: 2rem;">
    <div style="text-align: center; margin-bottom: 1.5rem;">
        <div style="background: #090a12; padding: 0.65rem 1.4rem; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.85rem; border: 1px solid rgba(139, 92, 246, 0.25); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
            <img src="{{ asset('images/logo.png') }}" alt="Rynarticle" style="height: 38px; width: auto; object-fit: contain;">
        </div>
        <h2 style="margin: 0; font-size: 1.45rem;">Masuk ke Akun Anda</h2>
        <p class="muted" style="margin: 0.35rem 0 0; font-size: 0.9rem;">Kelola artikel dan inspirasi Anda di Rynarticle.</p>
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

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}" required autofocus
               placeholder="nama@email.com">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required
               placeholder="••••••••">

        <div style="margin-top: 1rem; display: flex; align-items: center; justify-content: space-between;">
            <label style="margin: 0; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500; font-size: 0.88rem; cursor: pointer;">
                <input type="checkbox" name="remember" value="1" style="width: auto; margin: 0;"> Ingat saya
            </label>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1.25rem;">Masuk Sekarang</button>
    </form>

    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); text-align: center;">
        <p class="muted" style="margin: 0; font-size: 0.9rem;">
            Belum punya akun? <a href="{{ route('register') }}" style="font-weight: 600;">Daftar akun baru</a>
        </p>
    </div>
</section>
@endsection
