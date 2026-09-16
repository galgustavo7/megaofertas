<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'emoji' => ['nullable', 'string', 'max:8'],
            'color_from' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_to' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        Category::create([
            ...$data,
            'slug' => Category::where('name', $data['name'])->value('slug')
                ?? Str::slug($data['name']),
            'emoji' => $data['emoji'] ?? '📦',
        ]);

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría creada.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'emoji' => ['nullable', 'string', 'max:8'],
            'color_from' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_to' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $category->update([
            ...$data,
            'slug' => Str::slug($data['name']),
            'emoji' => $data['emoji'] ?? '📦',
        ]);

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría actualizada.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()
                ->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar: la categoría tiene productos asociados.');
        }

        $category->delete();

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría eliminada.');
    }
}
