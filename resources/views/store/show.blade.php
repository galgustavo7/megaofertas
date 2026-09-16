@extends('layouts.app')

@section('title', $product->name.' — MegaOfertas')
@section('meta_description', $product->description)

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Ruta">
            <a href="{{ route('home') }}">Inicio</a> <span>/</span>
            <a href="{{ route('store') }}">Tienda</a> <span>/</span>
            @if ($product->category)
                <a href="{{ route('store', ['categoria' => $product->category->slug]) }}">{{ $product->category->name }}</a> <span>/</span>
            @endif
            <strong>{{ $product->name }}</strong>
        </nav>

        <div class="pdp-layout">
            <!-- Imagen -->
            <div class="pdp-media">
                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                <div class="pdp-badges">
                    @if ($product->is_discounted())<span class="badge-offer big">Ahorra {{ $product->discount_pct() }}%</span>@endif
                    @if ($product->is_new)<span class="badge-new">Llegó nuevo</span>@endif
                </div>
            </div>

            <!-- Info -->
            <div class="pdp-info">
                <span class="pc-cat pdp-cat">{{ $product->category?->emoji }} {{ $product->category?->name }} · <strong>{{ $product->brand }}</strong></span>
                <h1 class="pdp-title">{{ $product->name }}</h1>

                <div class="pdp-rating">
                    @include('parts.stars', ['rating' => $product->rating])
                    <strong>{{ $product->rating }}</strong>
                    <span class="pdp-rating-count">{{ number_format($product->reviews_count) }} valoraciones de clientes</span>
                </div>

                <div class="pdp-price-box">
                    <div class="pdp-price-row">
                        <span class="pdp-price">@price($product->price)</span>
                        @if ($product->is_discounted())
                            <span class="pdp-price-list">@price($product->list_price)</span>
                            <span class="pdp-save">Ahorras @price($product->list_price - $product->price)</span>
                        @endif
                    </div>
                    <p class="pdp-price-note">
                        🛡️ {{ $product->priceNote() }}.
                        {{ \App\Models\Setting::get('price_disclaimer', 'El precio final es el que muestre Amazon en el momento de la compra.') }}
                    </p>
                </div>

                <a class="btn btn-amazon btn-xl btn-block" href="{{ $product->amazonUrl() }}" target="_blank" rel="nofollow sponsored noopener">
                    🛒 Comprar en Amazon <span aria-hidden="true">↗</span>
                </a>
                <p class="pdp-trust">Pagos, envío y devoluciones 100% a través de Amazon · Tú pagas solo el precio que muestre Amazon</p>

                <dl class="pdp-meta">
                    <div><dt>Marca</dt><dd>{{ $product->brand }}</dd></div>
                    <div><dt>ASIN</dt><dd>{{ $product->asin }}</dd></div>
                    <div><dt>Condición</dt><dd>Nuevo (enviado por Amazon)</dd></div>
                    <div><dt>Precio verificado</dt><dd>{{ $product->price_updated_at?->translatedFormat('d F Y, H:i') ?? '—' }}</dd></div>
                </dl>

                <div class="pdp-description">
                    <h3>Sobre este producto</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="pdp-how">
                    <h3>ℹ️ ¿Cómo funcionan estos precios?</h3>
                    <p>
                        Amazon solo permite a los sitios de afiliados mostrar precios obtenidos de su API oficial
                        (Product Advertising API). Por eso mostramos un <strong>precio de referencia</strong> con su fecha de
                        verificación: el precio que pagarás es siempre el que aparece en Amazon al momento de comprar.
                        Así cumplimos sus condiciones y tú nunca pagas de más por información desactualizada.
                    </p>
                </div>
            </div>
        </div>

        <!-- Relacionados -->
        @if ($related->count())
            <div class="section-head related-head">
                <div><h2>También te puede interesar</h2></div>
            </div>
            <div class="grid-4">
                @foreach ($related as $rel)
                    @include('parts.product-card', ['product' => $rel])
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
