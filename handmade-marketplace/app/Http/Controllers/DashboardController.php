<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Services\AdminAnalyticsService;
use App\Services\SellerAnalyticsService;
use Illuminate\View\View;

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

    public function seller(): View
    {
        $user = auth()->user()->load('shop');
        $shop = $user->shop;
        $analytics = $shop ? SellerAnalyticsService::for($user->id) : null;

        return view('seller.dashboard', [
            'user' => $user,
            'shop' => $shop,
            'productCount' => $shop ? $shop->products()->count() : 0,
            'publishedCount' => $shop ? $shop->products()->where('status', 'published')->count() : 0,
            'lowStockCount' => $shop ? $shop->products()->where('stock_status', 'low_stock')->count() : 0,
            'recentProducts' => $shop
                ? $shop->products()->with('category')->latest()->take(5)->get()
                : collect(),
            'activity' => $analytics?->recentActivity() ?? [
                'recentOrders' => collect(),
                'recentReviews' => collect(),
                'lowStock' => collect(),
                'recentProducts' => collect(),
            ],
            'revenue' => $analytics?->revenueStats() ?? ['total' => 0, 'monthly' => 0, 'weekly' => 0],
            'orderStats' => $analytics?->orderStats() ?? ['total' => 0, 'pending' => 0, 'completed' => 0],
        ]);
    }

    public function admin(): View
    {
        $analytics = new AdminAnalyticsService;

        return view('admin.dashboard', [
            'user' => auth()->user(),
            'stats' => $analytics->platformStats(),
            'activity' => $analytics->recentActivity(),
            'recentUsers' => $analytics->recentActivity()['users'],
            'recentProducts' => Product::with(['shop', 'category'])->latest()->take(5)->get(),
        ]);
    }
}
