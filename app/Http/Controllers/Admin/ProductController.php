<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->when($request->input('q'), function ($q) use ($request) {
                $term = $request->input('q');
                $q->where(fn ($w) => $w->where('name', 'like', "%{$term}%")->orWhere('brand', 'like', "%{$term}%"));
            })
            ->when($request->input('categoria'), fn ($q) => $q->where('category_id', $request->input('categoria')))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        return view('admin.products.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $product = new Product($data);
        $product->slug = Product::uniqueSlug($product->name);
        $product->save();

        return redirect()
            ->route('admin.productos.index')
            ->with('status', 'Producto creado correctamente.');
    }

    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $data = $this->validated($request, $product->id);

        $product->fill($data);
        if ($data['name'] !== $product->name) {
            $product->slug = Product::uniqueSlug($data['name'], $product->id);
        }
        $product->save();

        return redirect()
            ->route('admin.productos.index')
            ->with('status', 'Producto actualizado.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('status', 'Producto eliminado.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'brand' => ['required', 'string', 'max:80'],
            'category_id' => ['required', 'exists:categories,id'],
            'asin' => ['required', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:999999'],
            'list_price' => ['nullable', 'numeric', 'min:0', 'max:999999'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'reviews_count' => ['nullable', 'integer', 'min:0'],
            'emoji' => ['nullable', 'string', 'max:8'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_featured' => ['boolean'],
            'is_new' => ['boolean'],
        ], [], [
            'name' => 'nombre',
            'brand' => 'marca',
            'category_id' => 'categoría',
            'asin' => 'ASIN',
            'price' => 'precio',
            'list_price' => 'precio de lista',
            'rating' => 'rating',
            'description' => 'descripción',
        ]);
    }
}
