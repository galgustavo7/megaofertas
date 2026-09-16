<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas — Tienda de afiliados
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/tienda', [StoreController::class, 'index'])->name('store');
Route::get('/producto/{slug}', [StoreController::class, 'show'])->name('product');
Route::get('/promociones', [StoreController::class, 'promotions'])->name('promotions');
Route::get('/resenas', [StoreController::class, 'reviews'])->name('reviews');
Route::get('/contacto', [ContactController::class, 'index'])->name('contact');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Rutas de administración (super usuario)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('admin.login')
    ->middleware('throttle:10,1');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.attempt')
    ->middleware('throttle:10,1');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('productos', ProductController::class)->except('show');
        Route::resource('categorias', CategoryController::class)->except('show');

        Route::get('compras', [PurchaseController::class, 'index'])->name('compras');
        Route::patch('compras/{purchase}/status', [PurchaseController::class, 'updateStatus'])->name('compras.status');
        Route::get('compras/exportar', [PurchaseController::class, 'export'])->name('compras.export');

        Route::get('ajustes', [SettingController::class, 'index'])->name('ajustes');
        Route::post('ajustes', [SettingController::class, 'update'])->name('ajustes.update');
        Route::post('ajustes/sincronizar', [SettingController::class, 'sync'])->name('ajustes.sync');
    });
