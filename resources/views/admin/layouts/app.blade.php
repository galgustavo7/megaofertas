<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · Admin · MegaOfertas</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='24' fill='%234F46E5'/%3E%3Ctext x='50' y='72' font-size='62' text-anchor='middle'%3E%E2%9A%A1%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body class="admin-body">

<div class="admin-shell">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <a class="logo logo-admin" href="{{ route('admin.dashboard') }}">
            <span class="logo-badge">⚡</span>
            <span class="logo-text">Mega<em>Ofertas</em></span>
            <small class="logo-tag">ADMIN</small>
        </a>
        <nav class="admin-nav" aria-label="Panel">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="an-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.productos.index') }}" class="{{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                <span class="an-icon">📦</span> Productos
            </a>
            <a href="{{ route('admin.categorias.index') }}" class="{{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                <span class="an-icon">🗂️</span> Categorías
            </a>
            <a href="{{ route('admin.compras') }}" class="{{ request()->routeIs('admin.compras*') ? 'active' : '' }}">
                <span class="an-icon">🛒</span> Compras
            </a>
            <a href="{{ route('admin.ajustes') }}" class="{{ request()->routeIs('admin.ajustes*') ? 'active' : '' }}">
                <span class="an-icon">⚙️</span> Ajustes
            </a>
        </nav>
        <div class="admin-sidebar-foot">
            <a class="an-link" href="{{ route('home') }}" target="_blank">🌐 Ver tienda ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="an-link an-logout">🚪 Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <button class="btn btn-ghost sb-open" id="adminSbToggle" aria-label="Abrir menú">☰</button>
            <h1 class="topbar-title">@yield('topbar', 'Dashboard')</h1>
            <div class="topbar-user">
                <a class="topbar-store" href="{{ route('home') }}" target="_blank">Ver tienda ↗</a>
                <span class="topbar-avatar" title="{{ auth()->user()->name }}">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
        </header>

        <main class="admin-content">
            @if (session('status'))
                <div class="flash flash-success">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif
            @if ($errors->any() && !request()->routeIs('admin.login'))
                <div class="flash flash-error">
                    <strong>Corrige los siguientes errores:</strong>
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/chart.umd.min.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
