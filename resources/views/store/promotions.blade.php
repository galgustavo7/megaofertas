@extends('layouts.app')

@section('title', 'Promociones y descuentos — MegaOfertas')

@section('content')
<section class="page-head page-head-hot">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Ruta">
            <a href="{{ route('home') }}">Inicio</a> <span>/</span> <strong>Promociones</strong>
        </nav>
        <h1>🔥 Promociones y descuentos</h1>
        <p>Los precios de referencia con el mayor porcentaje de ahorro vs. precio de lista, ordenados del mayor al menor descuento.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="store-toolbar">
            <span class="toolbar-count">{{ $products->total() }} ofertas activas</span>
        </div>
        <div class="grid-products">
            @foreach ($products as $product)
                @include('parts.product-card', ['product' => $product])
            @endforeach
        </div>
        @if ($products->hasPages())
            <div class="pagination-wrap">{{ $products->links('pagination.default') }}</div>
        @endif
        <p class="disclaimer-line">🛡️ {{ \App\Models\Setting::get('price_disclaimer') }}</p>
    </div>
</section>
@endsection
