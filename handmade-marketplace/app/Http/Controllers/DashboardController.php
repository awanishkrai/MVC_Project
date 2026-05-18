<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;

class DashboardController extends Controller
{
    public function buyer()
    {
        return view('dashboards.buyer', [
            'user' => auth()->user(),
            'categories' => Category::withCount(['products' => fn ($q) => $q->published()])->orderBy('name')->get(),
            'featuredProducts' => Product::published()->with(['shop', 'category'])->latest()->take(8)->get(),
            'shops' => Shop::with('user')->latest()->take(6)->get(),
        ]);
    }

    public function seller()
    {
        $user = auth()->user()->load('shop');
        $shop = $user->shop;

        return view('dashboards.seller', [
            'user' => $user,
            'productCount' => $shop ? $shop->products()->count() : 0,
            'publishedCount' => $shop ? $shop->products()->where('status', 'published')->count() : 0,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function admin()
    {
        return view('dashboards.admin', [
            'user' => auth()->user(),
            'stats' => [
                'users' => User::count(),
                'buyers' => User::where('role', 'buyer')->count(),
                'sellers' => User::where('role', 'seller')->count(),
                'shops' => Shop::count(),
                'products' => Product::count(),
                'categories' => Category::count(),
            ],
        ]);
    }
}
