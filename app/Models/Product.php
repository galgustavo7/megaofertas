<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'brand', 'asin', 'price', 'list_price',
        'rating', 'reviews_count', 'emoji', 'description', 'is_featured',
        'is_new', 'price_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'list_price' => 'decimal:2',
            'rating' => 'decimal:1',
            'reviews_count' => 'integer',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'price_updated_at' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('brand', 'like', "%{$term}%");
        });
    }

    public function scopeInCategory(Builder $query, ?string $slug): Builder
    {
        if (! $slug) {
            return $query;
        }

        return $query->whereHas('category', fn (Builder $q) => $q->where('slug', $slug));
    }

    public function scopeOnDiscount(Builder $query): Builder
    {
        return $query->whereNotNull('list_price')
            ->whereColumn('price', '<', 'list_price');
    }

    public function is_discounted(): bool
    {
        return $this->list_price !== null && (float) $this->list_price > (float) $this->price;
    }

    public function discount_pct(): int
    {
        if (! $this->is_discounted()) {
            return 0;
        }

        return (int) round((1 - (float) $this->price / (float) $this->list_price) * 100);
    }

    /**
     * Enlace de afiliado a Amazon. SIEMPRE con la tag asociada y rel
     * nofollow/sponsored (requisito de Amazon Associates).
     */
    public function amazonUrl(): string
    {
        $host = Setting::get('amazon_host', 'www.amazon.com');
        $tag = Setting::get('affiliate_tag');
        $url = 'https://'.trim($host, '/').'/dp/'.$this->asin;

        return $tag ? $url.'?tag='.$tag : $url;
    }

    public function priceNote(): string
    {
        $at = $this->price_updated_at?->translatedFormat('d M Y');

        return 'Precio de referencia'.($at ? " · verificado el {$at}" : '');
    }

    public function getImagePathAttribute(): string
    {
        return 'images/products/'.$this->slug.'.svg';
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::lower($name));
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
