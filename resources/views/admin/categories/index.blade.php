@extends('admin.layouts.app')

@section('title', 'Categorías')
@section('topbar', 'Categorías')

@section('content')
<div class="cat-admin-grid">
    <div class="card">
        <div class="card-head"><div><h2>Todas las categorías</h2><p>{{ $categories->count() }} categorías activas</p></div></div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Categoría</th><th>Productos</th><th colspan="2">Acciones</th></tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr>
                            <td>
                                <div class="td-product">
                                    <span class="cat-chip" style="background: {{ $cat->gradient_style }}">{{ $cat->emoji }}</span>
                                    <div><strong>{{ $cat->name }}</strong><small>/{{ $cat->slug }}</small></div>
                                </div>
                            </td>
                            <td>{{ $cat->products_count }}</td>
                            <td class="td-actions">
                                <button type="button" class="btn btn-mini" data-edit-cat="{{ $cat->id }}"
                                        data-update-url="{{ route('admin.categorias.update', $cat->id) }}"
                                        data-name="{{ $cat->name }}" data-emoji="{{ $cat->emoji }}"
                                        data-from="{{ $cat->color_from }}" data-to="{{ $cat->color_to }}"
                                        data-desc="{{ $cat->description }}">✏️ Editar</button>
                            </td>
                            <td class="td-actions">
                                <form method="POST" action="{{ route('admin.categorias.destroy', $cat->id) }}"
                                      data-confirm="¿Eliminar la categoría “{{ $cat->name }}”?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-mini btn-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-head"><div><h2 id="catFormTitle">Nueva categoría</h2></div></div>
        <form method="POST" action="{{ route('admin.categorias.store') }}" id="catForm" class="admin-form" data-id="">
            @csrf
            <input type="hidden" name="_method" value="POST" id="catMethod">
            <div class="field">
                <label>Nombre *</label>
                <input name="name" type="text" required id="catName" placeholder="Ej: Mascotas">
            </div>
            <div class="field">
                <label>Emoji</label>
                <input name="emoji" type="text" id="catEmoji" value="📦" placeholder="🐾">
            </div>
            <div class="form-row-2">
                <div class="field">
                    <label>Color inicio</label>
                    <input type="color" name="color_from" id="catFrom" value="#6366F1">
                </div>
                <div class="field">
                    <label>Color fin</label>
                    <input type="color" name="color_to" id="catTo" value="#8B5CF6">
                </div>
            </div>
            <div class="field">
                <label>Descripción corta</label>
                <input name="description" type="text" id="catDesc" placeholder="Ej: Alimentación y cuidado">
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-ghost" id="catReset">Limpiar</button>
                <button type="submit" class="btn btn-primary" id="catSubmit">💾 Guardar categoría</button>
            </div>
        </form>
    </div>
</div>
@endsection
