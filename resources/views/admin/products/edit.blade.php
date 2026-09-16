@extends('admin.layouts.app')

@section('title', 'Editar producto')
@section('topbar', 'Editar producto')

@section('content')
<div class="card card-narrow">
    <div class="card-head">
        <div>
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->brand }} · {{ $product->asin }} · <a href="{{ route('product', $product->slug) }}" target="_blank">ver en tienda ↗</a></p>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.productos.update', $product->id) }}" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.products._form')
        <div class="form-actions">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
