<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $sellerId = auth()->id();

        $recentReviews = Review::with(['user', 'product'])
            ->whereHas('product', fn ($q) => $q->where('user_id', $sellerId))
            ->latest()
            ->take(10)
            ->get();

        $totalReviews = Review::whereHas('product', fn ($q) => $q->where('user_id', $sellerId))->count();

        $shopAverage = Review::whereHas('product', fn ($q) => $q->where('user_id', $sellerId))
            ->avg('rating');

        $bestRatedProducts = Product::query()
            ->where('user_id', $sellerId)
            ->where('reviews_count', '>', 0)
            ->orderByDesc('average_rating')
            ->orderByDesc('reviews_count')
            ->take(5)
            ->get();

        return view('seller.reviews.index', compact(
            'recentReviews',
            'totalReviews',
            'shopAverage',
            'bestRatedProducts'
        ));
    }
}
