<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\SellerAnalyticsService;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $analytics = SellerAnalyticsService::for(auth()->id());

        return view('seller.analytics.index', [
            'revenue' => $analytics->revenueStats(),
            'orders' => $analytics->orderStats(),
            'bestSelling' => $analytics->bestSellingProducts(),
            'lowStock' => $analytics->lowStockProducts(),
            'mostWishlisted' => $analytics->mostWishlistedProducts(),
            'bestRated' => $analytics->bestRatedProducts(),
            'reviews' => $analytics->reviewStats(),
            'monthlySalesChart' => $analytics->monthlySalesChart(),
            'orderTrendsChart' => $analytics->orderTrendsChart(),
            'reviewTrendsChart' => $analytics->reviewTrendsChart(),
        ]);
    }
}
