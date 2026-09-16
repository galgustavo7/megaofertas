@extends('layouts.app')

@section('title', 'MegaOfertas — Las mejores ofertas de Amazon en un solo lugar')

@section('content')

<!-- ═══════════ HERO ═══════════ -->
<section class="hero">
    <div class="hero-blobs" aria-hidden="true">
        <span class="blob blob-1"></span>
        <span class="blob blob-2"></span>
        <span class="blob blob-3"></span>
    </div>
    <div class="container hero-inner">
        <span class="hero-badge">🏆 Más de 12.000 ofertas verificadas este mes</span>
        <h1>Encuentra las <span class="grad-text">mejores ofertas</span> de Amazon sin perder el tiempo</h1>
        <p class="hero-sub">
            Curamos a mano los chollos con mejor precio y mejor valor: tecnología, hogar, cocina,
            deportes y más. Tú eliges, <strong>Amazon</strong> lo envía.
        </p>
        <form class="hero-search" action="{{ route('store') }}" method="get" role="search">
            <span class="hs-icon">🔍</span>
            <input type="search" name="q" placeholder="Ej: audífonos, freidora de aire, smartwatch…" aria-label="Buscar en la tienda">
            <button type="submit">Buscar ofertas</button>
        </form>
        <div class="hero-stats">
            <div class="hstat"><strong>30+</strong><span>productos curados</span></div>
            <div class="hstat"><strong>4.7★</strong><span>valoración media</span></div>
            <div class="hstat"><strong>-38%</strong><span>ahorro medio vs lista</span></div>
            <div class="hstat"><strong>24/7</strong><span>envío y soporte de Amazon</div></div>
        </div>
    </div>
</section>

<!-- ═══════════ CATEGORÍAS ═══════════ -->
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>Compra por categoría</h2>
                <p>Explora nuestras colecciones con los productos mejor valorados</p>
            </div>
            <a class="link-arrow" href="{{ route('store') }}">Ver todo <span>→</span></a>
        </div>
        <div class="cat-grid">
            @foreach ($categories as $cat)
                <a class="cat-card" href="{{ route('store', ['categoria' => $cat->slug]) }}">
                    <span class="cat-emoji" style="background: {{ $cat->gradient_style }}">{{ $cat->emoji }}</span>
                    <span class="cat-name">{{ $cat->name }}</span>
                    <small>{{ $cat->products_count }} productos</small>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════ DESTACADOS (carrusel) ═══════════ -->
<section class="section section-tint">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>⭐ Destacados de la semana</h2>
                <p>Selección de la editorial, actualizada cada semana</p>
            </div>
            <div class="carousel-controls">
                <button class="car-btn" data-carousel="featured" data-dir="-1" aria-label="Anterior">←</button>
                <button class="car-btn" data-carousel="featured" data-dir="1" aria-label="Siguiente">→</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="carousel" id="carousel-featured" data-carousel-track>
            @foreach ($featured as $product)
                <div class="carousel-item">
                    @include('parts.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════ TOP DESCUENTOS ═══════════ -->
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>🔥 Los descuentos más fuertes</h2>
                <p>Precios de referencia con el mayor % de ahorro actual</p>
            </div>
            <a class="link-arrow" href="{{ route('promotions') }}>Todas las promociones <span>→</span></a>
        </div>
        <div class="grid-4">
            @foreach ($deals as $product)
                @include('parts.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════ POR QUÉ NOSOTROS ═══════════ -->
<section class="section section-tint">
    <div class="container">
        <div class="section-head center">
            <div>
                <h2>¿Por qué comprar en MegaOfertas?</h2>
                <p>No somos Amazon: somos tu filtro de confianza</p>
            </div>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <span class="value-icon">🛡️</span>
                <h3>Precios verificados</h3>
                <p>Cada precio es un precio de referencia con fecha de verificación. Nunca inventamos descuentos: el precio final siempre es el de Amazon.</p>
            </div>
            <div class="value-card">
                <span class="value-icon">✂️</span>
                <h3>Selección curada</h3>
                <p>Analizamos miles de productos y solo publicamos los que combinan precio, calidad y buenas reseñas reales de compradores.</p>
            </div>
            <div class="value-card">
                <span class="value-icon">🚚</span>
                <h3>Compra 100% con Amazon</h3>
                <p>Pagas, recibes y devuelves directamente en Amazon. Envíos, garantía y devoluciones: todo bajo las condiciones de Amazon.</p>
            </div>
            <div class="value-card">
                <span class="value-icon">💬</span>
                <h3>Consejo real</h3>
                <p>¿Dudas entre dos modelos? Escríbenos y te ayudamos a elegir el que mejor se ajuste a lo que necesitas.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ MEJOR VALORADOS ═══════════ -->
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>💯 Calificados al 4.6★ o más</h2>
                <p>Lo que a la comunidad le funcionó</p>
            </div>
            <a class="link-arrow" href="{{ route('reviews') }}">Ver reseñas <span>→</span></a>
        </div>
        <div class="grid-4">
            @foreach ($topRated as $product)
                @include('parts.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════ TESTIMONIOS ═══════════ -->
<section class="section section-tint">
    <div class="container">
        <div class="section-head center">
            <div>
                <h2>Lo que dicen nuestros lectores</h2>
            </div>
        </div>
        <div class="testi-grid">
            <figure class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <blockquote>“Ahorre $110 en la freidora de aire que recomendaron. El precio de referencia era exactamente el que marqué en Amazon.”</blockquote>
                <figcaption><span class="testi-avatar" style="background:#4F46E5">MG</span><div><strong>María G.</strong><small>Lara, Venezuela</small></div></figcaption>
            </figure>
            <figure class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <blockquote>“Me encanta que sean honestos con los precios: te dicen que es referencial y que el final lo marca Amazon. Cero sorpresas.”</blockquote>
                <figcaption><span class="testi-avatar" style="background:#10B981">JR</span><div><strong>Juan R.</strong><small>Miranda, Venezuela</small></div></figcaption>
            </figure>
            <figure class="testi-card">
                <div class="testi-stars">★★★★☆</div>
                <blockquote>“Encontré el smartwatch para mi papá en 5 minutos. El filtro por categoría y el rating me ahorraron horas de búsqueda.”</blockquote>
                <figcaption><span class="testi-avatar" style="background:#F59E0B">CV</span><div><strong>Carla V.</strong><small>Maracay, Venezuela</small></div></figcaption>
            </figure>
        </div>
    </div>
</section>

<!-- ═══════════ NEWSLETTER ═══════════ -->
<section class="section">
    <div class="container">
        <div class="newsletter">
            <div class="nl-text">
                <h2>📬 Chollos antes que nadie</h2>
                <p>Recibe cada semana las 10 mejores ofertas. Sin spam, date de baja cuando quieras.</p>
            </div>
            <form class="nl-form" id="newsletterForm">
                <input type="email" required placeholder="tu@correo.com" aria-label="Correo electrónico">
                <button type="submit" class="btn btn-primary">Suscribirme</button>
            </form>
        </div>
    </div>
</section>

@endsection
