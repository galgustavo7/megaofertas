<div class="form-grid">
    <div class="field span-2">
        <label>Nombre del producto *</label>
        <input name="name" type="text" required value="{{ old('name', $product->name ?? '') }}" placeholder="Ej: Audífonos Inalámbricos ProSound X9">
        @error('name')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>Marca *</label>
        <input name="brand" type="text" required value="{{ old('brand', $product->brand ?? '') }}" placeholder="Ej: Sony">
        @error('brand')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>Categoría *</label>
        <select name="category_id" required>
            <option value="">— Selecciona —</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>ASIN de Amazon *</label>
        <input name="asin" type="text" required value="{{ old('asin', $product->asin ?? '') }}" placeholder="B0XXXXXXXXX">
        <small class="field-hint">El identificador único del producto en Amazon (va en la URL /dp/ASIN)</small>
        @error('asin')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>Emoji de la imagen</label>
        <input name="emoji" type="text" value="{{ old('emoji', $product->emoji ?? '📦') }}" placeholder="📦">
    </div>

    <div class="field">
        <label>Precio de referencia (USD) *</label>
        <input name="price" type="number" step="0.01" min="0.01" required value="{{ old('price', $product->price ?? '') }}">
        <small class="field-hint">Se muestra siempre con el aviso “precio de referencia”</small>
        @error('price')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>Precio de lista (opcional)</label>
        <input name="list_price" type="number" step="0.01" min="0" value="{{ old('list_price', $product->list_price ?? '') }}">
        <small class="field-hint">Si es mayor que el precio, se calcula el % de descuento</small>
        @error('list_price')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>Rating (1–5)</label>
        <input name="rating" type="number" step="0.1" min="1" max="5" required value="{{ old('rating', $product->rating ?? '4.5') }}">
        @error('rating')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field">
        <label>Nº de reseñas</label>
        <input name="reviews_count" type="number" min="0" value="{{ old('reviews_count', $product->reviews_count ?? 0) }}">
    </div>

    <div class="field span-2">
        <label>Descripción</label>
        <textarea name="description" rows="3" placeholder="¿Por qué vale la pena este producto?">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="field span-2 check-row">
        <label class="fcheck"><input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))> ⭐ Destacado en el home</label>
        <label class="fcheck"><input type="hidden" name="is_new" value="0">
            <input type="checkbox" name="is_new" value="1" @checked(old('is_new', $product->is_new ?? false))> 🆕 Marcar como nuevo</label>
    </div>
</div>
