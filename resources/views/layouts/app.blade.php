<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Berita') - Rynarticle</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="container">
            @include('partials.nav')
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Rynarticle" class="footer-logo">
                <p class="muted" style="margin: 0; font-size: 0.9rem;">Ruang berbagi artikel, ide, wawasan, dan inspirasi.</p>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Rynarticle &bull; Articles &bull; Ideas &bull; Insights.</p>
            </div>
        </div>
    </footer>
</body>
</html>
