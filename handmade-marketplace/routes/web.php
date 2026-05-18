<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public marketplace
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/dashboard', function () {
    $user = Auth::user();

    return redirect()->route(match ($user->role) {
        'admin' => 'admin.dashboard',
        'seller' => 'seller.dashboard',
        default => 'buyer.home',
    });
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/buyer/home', [DashboardController::class, 'buyer'])->name('buyer.home');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::redirect('/profile/edit', '/profile')->name('profile.edit');

    Route::middleware('seller')->group(function () {
        Route::get('/seller/dashboard', [DashboardController::class, 'seller'])->name('seller.dashboard');

        Route::prefix('shop')->name('shop.')->group(function () {
            Route::get('/create', [ShopController::class, 'create'])->name('create');
            Route::post('/', [ShopController::class, 'store'])->name('store');
            Route::get('/dashboard', [ShopController::class, 'dashboard'])->name('dashboard');
            Route::get('/edit', [ShopController::class, 'edit'])->name('edit');
            Route::put('/', [ShopController::class, 'update'])->name('update');
        });

        Route::get('/seller/products', [ProductController::class, 'manage'])->name('products.manage');
        Route::get('/seller/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/seller/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/seller/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/seller/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/seller/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('categories', CategoryController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';
