@extends('admin.layouts.app')

@section('title', 'Nuevo producto')
@section('topbar', 'Nuevo producto')

@section('content')
<div class="card card-narrow">
    <div class="card-head">
        <div>
            <h2>Crear producto</h2>
            <p>La imagen se genera automáticamente a partir del emoji y los colores de la categoría.</p>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.productos.store') }}" class="admin-form">
        @csrf
        @include('admin.products._form')
        <div class="form-actions">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">💾 Guardar producto</button>
        </div>
    </form>
</div>
@endsection
