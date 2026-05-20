<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAnalyticsService;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $analytics = new AdminAnalyticsService;

        return view('admin.analytics.index', [
            'stats' => $analytics->platformStats(),
            'topSellers' => $analytics->topSellers(),
            'topCategories' => $analytics->topCategories(),
            'mostSold' => $analytics->mostSoldProducts(),
            'mostWishlisted' => $analytics->mostWishlistedProducts(),
            'revenueChart' => $analytics->revenueGrowthChart(),
            'orderChart' => $analytics->orderTrendsChart(),
            'userChart' => $analytics->userGrowthChart(),
        ]);
    }
}
