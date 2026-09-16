<?php

namespace App\Providers;

use App\Models\Category;
use App\Support\Price;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Directiva Blade: @price(123.45) → "$123.45"
        Blade::directive('price', fn ($value) => '<?php echo \App\Support\Price::format('.$value.'); ?>');

        // Categorías siempre disponibles para el menú del header y el footer
        View::composer(['layouts.app', 'store.index', 'store.promotions', 'store.reviews'], function ($view) {
            $view->with('navCategories', Category::withCount('products')->orderBy('name')->get());
        });
    }
}
