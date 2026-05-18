<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Legacy Breeze dashboard URL → role-based dashboard
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

    Route::middleware('seller')->group(function () {
        Route::get('/seller/dashboard', [DashboardController::class, 'seller'])->name('seller.dashboard');

        Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
        Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
        Route::get('/shop/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');
        Route::resource('products', ProductController::class)->only(['create', 'store']);
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
