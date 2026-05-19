<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;

class DashboardController extends Controller
{
    /** Public homepage — marketplace entry */
    public function home()
    {
        return view('public.home', [
            'categories' => Category::withCount(['products' => fn ($q) => $q->published()])->orderBy('name')->get(),
            'featuredProducts' => Product::published()->with(['shop', 'category'])->latest()->take(8)->get(),
            'shops' => Shop::with('user')->latest()->take(6)->get(),
        ]);
    }

    public function seller()
    {
        $user = auth()->user()->load('shop');
        $shop = $user->shop;

        return view('seller.dashboard', [
            'user' => $user,
            'shop' => $shop,
            'productCount' => $shop ? $shop->products()->count() : 0,
            'publishedCount' => $shop ? $shop->products()->where('status', 'published')->count() : 0,
            'lowStockCount' => $shop ? $shop->products()->where('stock_status', 'low_stock')->count() : 0,
            'recentProducts' => $shop
                ? $shop->products()->with('category')->latest()->take(5)->get()
                : collect(),
        ]);
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'user' => auth()->user(),
            'stats' => [
                'users' => User::count(),
                'buyers' => User::where('role', 'buyer')->count(),
                'sellers' => User::where('role', 'seller')->count(),
                'shops' => Shop::count(),
                'products' => Product::count(),
                'categories' => Category::count(),
            ],
            'recentUsers' => User::latest()->take(5)->get(),
            'recentProducts' => Product::with(['shop', 'category'])->latest()->take(5)->get(),
        ]);
    }
}
