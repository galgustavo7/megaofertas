<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View
    {
        $featured = Product::with('category')
            ->where('is_featured', true)
            ->orderByDesc('reviews_count')
            ->limit(10)
            ->get();

        $deals = Product::with('category')
            ->onDiscount()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $topRated = Product::with('category')
            ->where('rating', '>=', 4.6)
            ->orderByDesc('reviews_count')
            ->limit(4)
            ->get();

        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        return view('home', compact('featured', 'deals', 'topRated', 'categories'));
    }
}
