<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SellerAnalyticsService
{
    public function __construct(private int $sellerId) {}

    public static function for(int $sellerId): self
    {
        return new self($sellerId);
    }

    /** @return array{total: float, monthly: float, weekly: float} */
    public function revenueStats(): array
    {
        $base = OrderItem::query()
            ->whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId))
            ->join('orders', 'orders.id', '=', 'order_items.order_id');

        $total = (float) (clone $base)->selectRaw('SUM(order_items.price * order_items.quantity) as revenue')->value('revenue') ?? 0;

        $monthly = (float) (clone $base)
            ->where('orders.created_at', '>=', now()->startOfMonth())
            ->selectRaw('SUM(order_items.price * order_items.quantity) as revenue')
            ->value('revenue') ?? 0;

        $weekly = (float) (clone $base)
            ->where('orders.created_at', '>=', now()->startOfWeek())
            ->selectRaw('SUM(order_items.price * order_items.quantity) as revenue')
            ->value('revenue') ?? 0;

        return compact('total', 'monthly', 'weekly');
    }

    /** @return array{total: int, pending: int, completed: int} */
    public function orderStats(): array
    {
        $orderIds = Order::whereHas('items.product', fn ($q) => $q->where('user_id', $this->sellerId));

        return [
            'total' => (clone $orderIds)->count(),
            'pending' => (clone $orderIds)->whereIn('order_status', ['pending', 'processing'])->count(),
            'completed' => (clone $orderIds)->where('order_status', 'delivered')->count(),
        ];
    }

    public function bestSellingProducts(int $limit = 5): Collection
    {
        return OrderItem::query()
            ->select('product_id', DB::raw('SUM(quantity) as units_sold'), DB::raw('SUM(price * quantity) as revenue'))
            ->whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId))
            ->groupBy('product_id')
            ->orderByDesc('units_sold')
            ->with('product')
            ->limit($limit)
            ->get();
    }

    public function lowStockProducts(int $limit = 5): Collection
    {
        return Product::where('user_id', $this->sellerId)
            ->whereIn('stock_status', ['low_stock', 'out_of_stock'])
            ->orderBy('quantity')
            ->limit($limit)
            ->get();
    }

    public function mostWishlistedProducts(int $limit = 5): Collection
    {
        return Product::where('user_id', $this->sellerId)
            ->withCount('wishlists')
            ->whereHas('wishlists')
            ->orderByDesc('wishlists_count')
            ->limit($limit)
            ->get();
    }

    public function bestRatedProducts(int $limit = 5): Collection
    {
        return Product::where('user_id', $this->sellerId)
            ->where('reviews_count', '>', 0)
            ->orderByDesc('average_rating')
            ->orderByDesc('reviews_count')
            ->limit($limit)
            ->get();
    }

    /** @return array{average: float|null, total: int, recent: Collection} */
    public function reviewStats(): array
    {
        $reviews = Review::whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId));

        return [
            'average' => (float) ($reviews->avg('rating') ?? 0) ?: null,
            'total' => (int) $reviews->count(),
            'recent' => Review::with(['user', 'product'])
                ->whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId))
                ->latest()
                ->take(3)
                ->get(),
        ];
    }

    /** @return array{labels: list<string>, values: list<float>} */
    public function monthlySalesChart(int $months = 6): array
    {
        $labels = [];
        $values = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $labels[] = $start->format('M Y');

            $values[] = (float) OrderItem::query()
                ->whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId))
                ->whereHas('order', fn ($q) => $q->whereBetween('created_at', [$start, $end]))
                ->selectRaw('SUM(price * quantity) as revenue')
                ->value('revenue') ?? 0;
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
            $values[] = Order::whereHas('items.product', fn ($q) => $q->where('user_id', $this->sellerId))
                ->whereDate('created_at', $date)
                ->count();
        }

        return compact('labels', 'values');
    }

    /** @return array{labels: list<string>, values: list<int>} */
    public function reviewTrendsChart(int $months = 6): array
    {
        $labels = [];
        $values = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $labels[] = $start->format('M Y');
            $values[] = Review::whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId))
                ->whereBetween('created_at', [$start, $end])
                ->count();
        }

        return compact('labels', 'values');
    }

    public function recentActivity(): array
    {
        $recentOrders = Order::with(['user', 'items.product'])
            ->whereHas('items.product', fn ($q) => $q->where('user_id', $this->sellerId))
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::with(['user', 'product'])
            ->whereHas('product', fn ($q) => $q->where('user_id', $this->sellerId))
            ->latest()
            ->take(5)
            ->get();

        $lowStock = $this->lowStockProducts(5);
        $recentProducts = Product::where('user_id', $this->sellerId)->latest()->take(5)->get();

        return compact('recentOrders', 'recentReviews', 'lowStock', 'recentProducts');
    }
}
