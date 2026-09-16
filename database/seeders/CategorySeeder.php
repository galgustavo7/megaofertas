<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tecnología', 'slug' => 'tecnologia', 'emoji' => '📱', 'color_from' => '#4F46E5', 'color_to' => '#06B6D4', 'description' => 'Audio, wearables, smart home y accesorios'],
            ['name' => 'Hogar', 'slug' => 'hogar', 'emoji' => '🛋️', 'color_from' => '#8B5CF6', 'color_to' => '#EC4899', 'description' => 'Ambientación, iluminación y electrodomésticos'],
            ['name' => 'Cocina', 'slug' => 'cocina', 'emoji' => '🍳', 'color_from' => '#10B981', 'color_to' => '#84CC16', 'description' => 'Freidoras, licuadoras, café y utensilios'],
            ['name' => 'Deportes y Fitness', 'slug' => 'deportes', 'emoji' => '⚽', 'color_from' => '#EF4444', 'color_to' => '#F97316', 'description' => 'Entrena en casa o al aire libre'],
            ['name' => 'Belleza y Cuidado', 'slug' => 'belleza', 'emoji' => '💄', 'color_from' => '#EC4899', 'color_to' => '#A855F7', 'description' => 'Secadores, skincare y cuidado personal'],
            ['name' => 'Oficina y Productividad', 'slug' => 'oficina', 'emoji' => '🖥️', 'color_from' => '#0EA5E9', 'color_to' => '#6366F1', 'description' => 'Ergonomía, soporte y periféricos'],
            ['name' => 'Juguetes y Niños', 'slug' => 'juguetes', 'emoji' => '🧸', 'color_from' => '#F43F5E', 'color_to' => '#FBBF24', 'description' => 'Regalos, construcción y diversión'],
            ['name' => 'Libros', 'slug' => 'libros', 'emoji' => '📚', 'color_from' => '#14B8A6', 'color_to' => '#22C55E', 'description' => 'Best-sellers y papel de calidad'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
