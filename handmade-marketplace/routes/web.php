<?php

use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Seller\AnalyticsController as SellerAnalyticsController;
use App\Http\Controllers\Seller\ExportController as SellerExportController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ReviewController as SellerReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
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
Route::post('/chatbot/reply', [ChatbotController::class, 'reply'])->name('chatbot.reply');

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

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{product}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/products/{product}/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/products/{product}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
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
        Route::get('/reviews', [SellerReviewController::class, 'index'])->name('reviews.index');
        Route::get('/analytics', [SellerAnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/exports/orders', [SellerExportController::class, 'orders'])->name('exports.orders');
        Route::get('/exports/products', [SellerExportController::class, 'products'])->name('exports.products');
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

        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::patch('/products/{product}/status', [\App\Http\Controllers\Admin\ProductController::class, 'updateStatus'])->name('products.update-status');
        Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
        Route::redirect('/reports', '/admin/analytics')->name('reports.index');
        Route::get('/exports/orders', [AdminExportController::class, 'orders'])->name('exports.orders');
        Route::get('/exports/users', [AdminExportController::class, 'users'])->name('exports.users');
        Route::get('/exports/reviews', [AdminExportController::class, 'reviews'])->name('exports.reviews');
        Route::get('/settings', [ProfileController::class, 'show'])->name('settings');
    });

require __DIR__.'/auth.php';
