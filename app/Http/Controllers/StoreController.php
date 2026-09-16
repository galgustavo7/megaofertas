<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $sortMap = [
            'popular' => fn ($q) => $q->orderByDesc('reviews_count'),
            'precio_asc' => fn ($q) => $q->orderBy('price'),
            'precio_desc' => fn ($q) => $q->orderByDesc('price'),
            'rating' => fn ($q) => $q->orderByDesc('rating')->orderByDesc('reviews_count'),
            'descuento' => fn ($q) => $q->onDiscount()->orderByRaw("(list_price - price) / list_price DESC"),
        ];

        $sort = $request->input('orden', 'popular');
        $categorySlug = $request->input('categoria');
        $onlyDeals = $request->boolean('ofertas');

        $applySort = $sortMap[$sort] ?? $sortMap['popular'];

        $products = Product::with('category')
            ->search($request->input('q'))
            ->inCategory($categorySlug)
            ->when($request->filled('min'), fn ($q) => $q->where('price', '>=', (float) $request->input('min')))
            ->when($request->filled('max'), fn ($q) => $q->where('price', '<=', (float) $request->input('max')))
            ->when($onlyDeals, fn ($q) => $q->onDiscount())
            ->when(true, $applySort)
            ->paginate(12)
            ->withQueryString();

        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('store.index', compact('products', 'categories', 'sort', 'categorySlug', 'onlyDeals'));
    }

    public function show(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        if ($related->count() < 4) {
            $extra = Product::with('category')
                ->whereNotIn('id', $related->pluck('id')->merge([$product->id]))
                ->limit(4 - $related->count())
                ->get();
            $related = $related->merge($extra);
        }

        return view('store.show', compact('product', 'related'));
    }

    public function promotions(): View
    {
        $products = Product::with('category')
            ->onDiscount()
            ->orderByRaw("(list_price - price) / list_price DESC")
            ->paginate(12);

        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('store.promotions', compact('products', 'categories'));
    }

    public function reviews(): View
    {
        $products = Product::with('category')
            ->where('rating', '>=', 4.4)
            ->orderByDesc('rating')
            ->orderByDesc('reviews_count')
            ->paginate(12);

        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('store.reviews', compact('products', 'categories'));
    }
}
