@props(['product'])
<article class="product-card">
    <a href="{{ route('product', $product->slug) }}" class="pc-media" tabindex="-1" aria-hidden="true">
        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" loading="lazy">
        <div class="pc-badges">
            @if ($product->is_discounted())
                <span class="badge-offer">-{{ $product->discount_pct() }}%</span>
            @endif
            @if ($product->is_new)
                <span class="badge-new">Nuevo</span>
            @endif
        </div>
        <span class="pc-quick">Ver oferta</span>
    </a>
    <div class="pc-body">
        <span class="pc-cat">{{ $product->category?->emoji }} {{ $product->category?->name }}</span>
        <h3 class="pc-name">
            <a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a>
        </h3>
        <span class="pc-brand">{{ $product->brand }}</span>
        <div class="pc-rating">
            @include('parts.stars', ['rating' => $product->rating])
            <span class="pc-rating-count">({{ number_format($product->reviews_count) }})</span>
        </div>
        <div class="pc-price">
            <span class="pc-price-now">@price($product->price)</span>
            @if ($product->is_discounted())
                <span class="pc-price-list">@price($product->list_price)</span>
            @endif
        </div>
        <p class="pc-note">🛡️ {{ $product->priceNote() }} · el precio final es el de Amazon</p>
        <a class="btn btn-amazon" href="{{ $product->amazonUrl() }}" target="_blank" rel="nofollow sponsored noopener">
            Ir a Amazon <span aria-hidden="true">↗</span>
        </a>
    </div>
</article>
