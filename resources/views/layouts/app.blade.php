<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MegaOfertas — Las mejores ofertas de Amazon en un solo lugar')</title>
    <meta name="description" content="@yield('meta_description', 'Descubre las mejores ofertas de Amazon: tecnología, hogar, cocina, deportes y más. Precios de referencia verificados y envío por Amazon.')">
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='24' fill='%234F46E5'/%3E%3Ctext x='50' y='72' font-size='62' text-anchor='middle'%3E%E2%9A%A1%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body>

<!-- Barra superior -->
<div class="topbar">
    <div class="container topbar-inner">
        <p>⚡ Precios de referencia verificados · El precio final es el que muestra <strong>Amazon</strong> al comprar</p>
        <div class="topbar-right">
            <a href="{{ route('contact') }}">¿Ayuda?</a>
            <span class="dot">·</span>
            <a href="{{ route('admin.login') }}">👤 Acceso admin</a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="site-header" id="top">
    <div class="container header-inner">
        <a class="logo" href="{{ route('home') }}" aria-label="MegaOfertas inicio">
            <span class="logo-badge">⚡</span>
            <span class="logo-text">Mega<em>Ofertas</em></span>
        </a>

        <nav class="main-nav" id="mainNav" aria-label="Navegación principal">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
            <a href="{{ route('store') }}" class="{{ request()->routeIs('store.*') && !request()->routeIs('product.*') ? 'active' : '' }}">Tienda</a>
            <a href="{{ route('promotions') }}" class="{{ request()->routeIs('promotions') ? 'active' : '' }} nav-hot">🔥 Promociones</a>
            <a href="{{ route('reviews') }}" class="{{ request()->routeIs('reviews') ? 'active' : '' }}">Reseñas Top</a>
            <div class="nav-dropdown">
                <a href="{{ route('store') }}" class="{{ request()->routeIs('store.*') && request('categoria') ? 'active' : '' }}">Categorías <span class="caret">▾</span></a>
                <div class="dropdown-menu">
                    @foreach ($navCategories as $nc)
                        <a href="{{ route('store', ['categoria' => $nc->slug]) }}">
                            <span class="dd-emoji" style="background: linear-gradient(135deg, {{ $nc->color_from }}, {{ $nc->color_to }})">{{ $nc->emoji }}</span>
                            <span>{{ $nc->name }}</span>
                            <small>{{ $nc->products_count }} productos</small>
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact*') ? 'active' : '' }}">Contacto</a>
        </nav>

        <form class="header-search" action="{{ route('store') }}" method="get" role="search">
            <input type="search" name="q" placeholder="Buscar productos o marcas…" value="{{ request('q') }}" aria-label="Buscar">
            <button type="submit" aria-label="Buscar">🔍</button>
        </form>

        <button class="nav-toggle" id="navToggle" aria-label="Abrir menú" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

@if (session('status'))
    <div class="flash flash-success container">{{ session('status') }}</div>
@endif
@if (session('error'))
    <div class="flash flash-error container">{{ session('error') }}</div>
@endif

<main>
@yield('content')
</main>

<!-- Footer -->
<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col footer-brand">
            <a class="logo logo-footer" href="{{ route('home') }}">
                <span class="logo-badge">⚡</span>
                <span class="logo-text">Mega<em>Ofertas</em></span>
            </a>
            <p>Curamos los mejores chollos de Amazon para que compres mejor y ahorres más. Selección editorial, sin spam.</p>
            <div class="social-row">
                <a href="#" aria-label="Instagram">📸</a>
                <a href="#" aria-label="X">𝕏</a>
                <a href="#" aria-label="YouTube">▶️</a>
                <a href="#" aria-label="TikTok">🎵</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Compra</h4>
            <a href="{{ route('store') }}">Todos los productos</a>
            <a href="{{ route('promotions') }}">🔥 Promociones</a>
            <a href="{{ route('reviews') }}">Reseñas Top</a>
            <a href="{{ route('store', ['orden' => 'precio_asc']) }}">Menor precio</a>
        </div>
        <div class="footer-col">
            <h4>Categorías</h4>
            @foreach ($navCategories->take(5) as $nc)
                <a href="{{ route('store', ['categoria' => $nc->slug]) }}">{{ $nc->emoji }} {{ $nc->name }}</a>
            @endforeach
        </div>
        <div class="footer-col">
            <h4>Ayuda</h4>
            <a href="{{ route('contact') }}">Contacto</a>
            <a href="{{ route('contact') }}">Preguntas frecuentes</a>
            <a href="#top">Método de selección</a>
            <a href="{{ route('admin.login') }}">Área de administración</a>
        </div>
    </div>
    <div class="container">
        <div class="footer-legal">
            <p class="disclosure">
                <strong>Aviso de afiliado:</strong>
                {{ \App\Models\Setting::get('footer_disclosure', 'Como Asociado de Amazon, obtenemos ingresos por las compras adscritas que cumplen los requisitos aplicables.') }}
            </p>
            <p class="disclosure">
                {{ \App\Models\Setting::get('price_disclaimer', 'Los precios y la disponibilidad pueden variar. El precio final es el que muestre Amazon en el momento de la compra.') }}
            </p>
            <p class="copyright">© {{ date('Y') }} MegaOfertas · Sitio de afiliados independiente. No somos Amazon ni actuamos en su nombre.</p>
        </div>
    </div>
</footer>

<!-- Bottom nav tipo app (solo móvil) -->
<nav class="bottom-nav" aria-label="Navegación rápida">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <span class="bn-icon">🏠</span><span class="bn-label">Inicio</span>
    </a>
    <a href="{{ route('store') }}" class="{{ request()->routeIs('store.*') ? 'active' : '' }}">
        <span class="bn-icon">🛍️</span><span class="bn-label">Tienda</span>
    </a>
    <a href="{{ route('promotions') }}" class="{{ request()->routeIs('promotions') ? 'active' : '' }}">
        <span class="bn-icon">🔥</span><span class="bn-label">Ofertas</span>
    </a>
    <a href="{{ route('reviews') }}" class="{{ request()->routeIs('reviews') ? 'active' : '' }}">
        <span class="bn-icon">⭐</span><span class="bn-label">Reseñas</span>
    </a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact*') ? 'active' : '' }}">
        <span class="bn-icon">✉️</span><span class="bn-label">Contacto</span>
    </a>
</nav>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
