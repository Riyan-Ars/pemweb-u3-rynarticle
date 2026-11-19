<nav class="nav" aria-label="Main Navigation">
    <a href="{{ route('home') }}" class="brand-link" aria-label="Rynarticle Home">
        <img src="{{ asset('images/logo.png') }}" alt="Rynarticle" class="brand-logo">
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

        @auth
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('articles.index') }}"
               class="{{ request()->routeIs('articles.*') ? 'active' : '' }}">Artikel</a>
        @endauth
    </div>

    <div class="right">
        @auth
            <span class="user-badge">
                <span class="avatar-initial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}"
               class="btn-nav-login {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}"
               class="btn btn-sm btn-nav-register {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
        @endguest
    </div>
</nav>
