@extends('admin.layouts.app')

@section('title', 'Productos')
@section('topbar', 'Productos')

@section('content')
<div class="card">
    <div class="card-head">
        <form class="filter-inline" method="get" action="{{ route('admin.productos.index') }}">
            <input type="search" name="q" placeholder="Buscar por nombre o marca…" value="{{ request('q') }}">
            <select name="categoria">
                <option value="">Todas las categorías</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('categoria') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ghost">Filtrar</button>
        </form>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">+ Nuevo producto</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th><th>Categoría</th><th>Precio ref.</th><th>Rating</th>
                    <th>Verif. precio</th><th>Flags</th><th class="th-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $p)
                    <tr>
                        <td>
                            <div class="td-product">
                                <img src="{{ asset($p->image_path) }}" alt="" width="40" height="40">
                                <div>
                                    <strong>{{ $p->name }}</strong>
                                    <small>{{ $p->brand }} · {{ $p->asin }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $p->category?->name ?? '—' }}</td>
                        <td class="td-strong">
                            @price($p->price)
                            @if ($p->is_discounted())<small class="td-muted"> <s>@price($p->list_price)</s></small>@endif
                        </td>
                        <td>⭐ {{ $p->rating }}</td>
                        <td class="td-muted">{{ $p->price_updated_at?->format('d M Y') ?? '—' }}</td>
                        <td>
                            @if ($p->is_featured)<span class="pill pill-violet">Destacado</span>@endif
                            @if ($p->is_new)<span class="pill pill-green">Nuevo</span>@endif
                        </td>
                        <td class="td-actions">
                            <a class="btn btn-mini" href="{{ route('admin.productos.edit', $p->id) }}">✏️ Editar</a>
                            <form method="POST" action="{{ route('admin.productos.destroy', $p->id) }}" data-confirm="¿Eliminar “{{ $p->name }}”?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-mini btn-danger">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="td-empty">No hay productos con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $products->links('pagination.default') }}</div>
</div>
@endsection
