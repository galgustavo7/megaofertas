@extends('layouts.app')

@section('title', 'Tienda — MegaOfertas')

@section('content')
<section class="page-head">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Ruta">
            <a href="{{ route('home') }}">Inicio</a> <span>/</span> <strong>Tienda</strong>
            @if ($categorySlug)
                <span>/</span> <strong>{{ \App\Models\Category::where('slug', $categorySlug)->value('name') }}</strong>
            @endif
        </nav>
        <h1>{{ $categorySlug ? \App\Models\Category::where('slug', $categorySlug)->value('name') : 'Todos los productos' }}</h1>
        <p>{{ $products->total() }} productos · precios de referencia verificados</p>
    </div>
</section>

<section class="section store-section">
    <div class="container store-layout">

        <!-- Filtros -->
        <aside class="store-sidebar" id="storeSidebar">
            <div class="sb-head">
                <h3>Filtros</h3>
                <button class="sb-close" id="sbClose" aria-label="Cerrar filtros">✕</button>
            </div>
            <form method="get" action="{{ route('store') }}" class="filter-form" id="filterForm">
                @if (request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif

                <div class="fgroup">
                    <label class="flabel">Categoría</label>
                    <label class="fradio {{ $categorySlug === null ? 'on' : '' }}">
                        <input type="radio" name="categoria" value="" {{ $categorySlug === null ? 'checked' : '' }}> Todas
                    </label>
                    @foreach ($categories as $cat)
                        <label class="fradio {{ $categorySlug === $cat->slug ? 'on' : '' }}">
                            <input type="radio" name="categoria" value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'checked' : '' }}>
                            {{ $cat->emoji }} {{ $cat->name }} <small>({{ $cat->products_count }})</small>
                        </label>
                    @endforeach
                </div>

                <div class="fgroup">
                    <label class="flabel">Precio (referencia)</label>
                    <div class="price-inputs">
                        <input type="number" name="min" step="0.01" min="0" placeholder="Mín" value="{{ request('min') }}">
                        <span>—</span>
                        <input type="number" name="max" step="0.01" min="0" placeholder="Máx" value="{{ request('max') }}">
                    </div>
                </div>

                <div class="fgroup">
                    <label class="flabel">Ordenar por</label>
                    @foreach (['popular' => 'Más populares', 'precio_asc' => 'Precio: menor a mayor', 'precio_desc' => 'Precio: mayor a menor', 'rating' => 'Mejor valorados', 'descuento' => 'Mayor descuento'] as $key => $label)
                        <label class="fradio {{ $sort === $key ? 'on' : '' }}">
                            <input type="radio" name="orden" value="{{ $key }}" {{ $sort === $key ? 'checked' : '' }}> {{ $label }}
                        </label>
                    @endforeach
                </div>

                <div class="fgroup">
                    <label class="fcheck {{ $onlyDeals ? 'on' : '' }}">
                        <input type="checkbox" name="ofertas" value="1" {{ $onlyDeals ? 'checked' : '' }}> 🔥 Solo con descuento
                    </label>
                </div>

                <div class="fgroup fgroup-actions">
                    <button type="submit" class="btn btn-primary btn-block">Aplicar filtros</button>
                    <a href="{{ route('store') }}" class="btn btn-ghost btn-block">Limpiar</a>
                </div>
            </form>
        </aside>

        <!-- Resultados -->
        <div class="store-main">
            <div class="store-toolbar">
                <button class="btn btn-ghost sb-open" id="sbOpen">☰ Filtrar</button>
                <span class="toolbar-count">{{ $products->total() }} resultados</span>
                @if (request('q'))
                    <span class="toolbar-q">“{{ request('q') }}” <a href="{{ route('store') }}">✕</a></span>
                @endif
            </div>

            @if ($products->isEmpty())
                <div class="empty-state">
                    <span class="empty-icon">🔎</span>
                    <h3>No encontramos productos</h3>
                    <p>Prueba con otra búsqueda o quita algún filtro.</p>
                    <a href="{{ route('store') }}" class="btn btn-primary">Ver todos</a>
                </div>
            @else
                <div class="grid-products">
                    @foreach ($products as $product)
                        @include('parts.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="pagination-wrap">
                    {{ $products->links('pagination.default') }}
                </div>
            @endif

            <p class="disclaimer-line">
                🛡️ {{ \App\Models\Setting::get('price_disclaimer', 'Los precios y la disponibilidad pueden variar. El precio final es el que muestre Amazon en el momento de la compra.') }}
            </p>
        </div>
    </div>
</section>
@endsection
