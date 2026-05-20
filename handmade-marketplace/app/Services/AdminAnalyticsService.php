<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsService
{
    /** @return array<string, int|float> */
    public function platformStats(): array
    {
        return [
            'users' => User::count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'sellers' => User::where('role', 'seller')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'shops' => Shop::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => (float) Order::sum('total_amount'),
            'reviews' => Review::count(),
        ];
    }

    public function topSellers(int $limit = 5): Collection
    {
        return User::where('role', 'seller')
            ->with('shop')
            ->get()
            ->map(function (User $user) {
                $revenue = (float) OrderItem::query()
                    ->whereHas('product', fn ($q) => $q->where('user_id', $user->id))
                    ->selectRaw('SUM(price * quantity) as total')
                    ->value('total');

                return [
                    'name' => $user->name,
                    'shop' => $user->shop?->shop_name,
                    'revenue' => $revenue,
                ];
            })
            ->sortByDesc('revenue')
            ->take($limit)
            ->values();
    }

    public function topCategories(int $limit = 5): Collection
    {
        return Category::query()
            ->withCount(['products' => fn ($q) => $q->where('status', 'published')])
            ->orderByDesc('products_count')
            ->limit($limit)
            ->get();
    }

    public function mostSoldProducts(int $limit = 5): Collection
    {
        return OrderItem::query()
            ->select('product_id', DB::raw('SUM(quantity) as units'))
            ->groupBy('product_id')
            ->orderByDesc('units')
            ->with('product.shop')
            ->limit($limit)
            ->get();
    }

    public function mostWishlistedProducts(int $limit = 5): Collection
    {
        return Product::published()
            ->withCount('wishlists')
            ->whereHas('wishlists')
            ->orderByDesc('wishlists_count')
            ->limit($limit)
            ->get();
    }

    /** @return array{labels: list<string>, values: list<float>} */
    public function revenueGrowthChart(int $months = 6): array
    {
        $labels = [];
        $values = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $labels[] = $start->format('M Y');
            $values[] = (float) Order::whereBetween('created_at', [$start, $end])->sum('total_amount');
        }

        return compact('labels', 'values');
    }

    /** @return array{labels: list<string>, values: list<int>} */
    public function orderTrendsChart(int $days = 14): array
    {
        $labels = [];
        $values = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $labels[] = $date->format('M j');
            $values[] = Order::whereDate('created_at', $date)->count();
        }

        return compact('labels', 'values');
    }

    /** @return array{labels: list<string>, values: list<int>} */
    public function userGrowthChart(int $months = 6): array
    {
        $labels = [];
        $values = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $labels[] = $start->format('M Y');
            $values[] = User::whereBetween('created_at', [$start, $end])->count();
        }

        return compact('labels', 'values');
    }

    public function lowStockCount(): int
    {
        return Product::where('stock_status', 'low_stock')->count();
    }

    public function recentActivity(): array
    {
        return [
            'users' => User::latest()->take(5)->get(),
            'orders' => Order::with('user')->latest()->take(5)->get(),
            'reviews' => Review::with(['user', 'product'])->latest()->take(5)->get(),
            'shops' => Shop::with('user')->latest()->take(5)->get(),
            'lowStockCount' => $this->lowStockCount(),
        ];
    }
}
