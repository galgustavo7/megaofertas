@extends('layouts.app')

@section('title', 'Reseñas Top — Los mejor valorados de Amazon')

@section('content')
<section class="page-head">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Ruta">
            <a href="{{ route('home') }}">Inicio</a> <span>/</span> <strong>Reseñas Top</strong>
        </nav>
        <h1>⭐ Reseñas Top: los mejor valorados</h1>
        <p>Productos con al menos 4.4★ ordenados por calificación y volumen de reseñas reales de compradores de Amazon.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="store-toolbar">
            <span class="toolbar-count">{{ $products->total() }} productos destacados</span>
        </div>
        <div class="grid-products">
            @foreach ($products as $product)
                @include('parts.product-card', ['product' => $product])
            @endforeach
        </div>
        @if ($products->hasPages())
            <div class="pagination-wrap">{{ $products->links('pagination.default') }}</div>
        @endif
    </div>
</section>
@endsection
