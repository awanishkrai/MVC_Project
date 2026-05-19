<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC / BUYER — Marketplace (PublicLayout)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/dashboard', function () {
    $user = Auth::user();

    return redirect()->route(match ($user->role) {
        'admin' => 'admin.dashboard',
        'seller' => 'seller.dashboard',
        default => 'home',
    });
})->middleware('auth')->name('dashboard');

// Legacy buyer URL
Route::redirect('/buyer/home', '/')->name('buyer.home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::redirect('/profile/edit', '/profile')->name('profile.edit');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| SELLER PANEL (SellerLayout)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'seller'])->name('dashboard');

        Route::get('/shop', [ShopController::class, 'dashboard'])->name('shop.index');
        Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
        Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
        Route::get('/shop/edit', [ShopController::class, 'edit'])->name('shop.edit');
        Route::put('/shop', [ShopController::class, 'update'])->name('shop.update');

        Route::get('/products', [ProductController::class, 'manage'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Placeholders — future modules
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::view('/messages', 'seller.placeholders.coming-soon', ['title' => 'Messages', 'module' => 'Messaging'])->name('messages.index');
        Route::view('/analytics', 'seller.placeholders.coming-soon', ['title' => 'Analytics', 'module' => 'Analytics'])->name('analytics.index');
        Route::get('/settings', [ProfileController::class, 'show'])->name('settings');
    });

// Legacy URLs → seller panel
Route::middleware(['auth', 'seller'])->group(function () {
    Route::redirect('/shop/dashboard', '/seller/shop');
    Route::redirect('/shop/create', '/seller/shop/create');
    Route::redirect('/shop/edit', '/seller/shop/edit');
    Route::post('/shop', [ShopController::class, 'store'])->name('shop.store'); // legacy POST
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (AdminLayout)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('categories', CategoryController::class)->except(['show']);

        Route::view('/products', 'admin.placeholders.coming-soon', ['title' => 'Products', 'module' => 'Product moderation'])->name('products.index');
        Route::view('/users', 'admin.placeholders.coming-soon', ['title' => 'Users', 'module' => 'User management'])->name('users.index');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::view('/reports', 'admin.placeholders.coming-soon', ['title' => 'Reports', 'module' => 'Reports'])->name('reports.index');
        Route::get('/settings', [ProfileController::class, 'show'])->name('settings');
    });

require __DIR__.'/auth.php';
