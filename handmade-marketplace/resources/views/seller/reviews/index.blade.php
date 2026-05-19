@extends('layouts.seller')
@section('title', 'Reviews')
@section('page-title', 'Customer reviews')
@section('page-subtitle', 'Feedback on your handmade products')

@section('content')
<div class="mb-8 grid gap-4 sm:grid-cols-3">
    <article class="cn-card p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Shop average</p>
        <p class="mt-1 font-display text-3xl font-bold text-amber-600">
            {{ $shopAverage ? number_format($shopAverage, 1) : '—' }}
            @if ($shopAverage)<span class="text-lg">★</span>@endif
        </p>
    </article>
    <article class="cn-card p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total reviews</p>
        <p class="mt-1 font-display text-3xl font-bold text-stone-900">{{ $totalReviews }}</p>
    </article>
    <article class="cn-card p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Best rated</p>
        <p class="mt-1 font-display text-lg font-bold text-stone-900">{{ $bestRatedProducts->first()?->title ?? '—' }}</p>
    </article>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <section class="cn-card">
        <div class="border-b border-stone-100 px-5 py-4">
            <h2 class="font-display font-semibold text-stone-900">Recent reviews</h2>
        </div>
        @if ($recentReviews->isEmpty())
            <p class="p-8 text-center text-sm text-stone-500">No reviews yet. Encourage buyers to share feedback after purchase.</p>
        @else
            <ul class="divide-y divide-stone-100">
                @foreach ($recentReviews as $review)
                    <li class="p-5">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-medium text-stone-900">{{ $review->user->name }}</p>
                                <p class="text-xs text-stone-400">{{ $review->product->title }}</p>
                            </div>
                            <x-rating-stars :rating="$review->rating" size="sm" />
                        </div>
                        @if ($review->title)
                            <p class="mt-2 text-sm font-medium text-stone-800">{{ $review->title }}</p>
                        @endif
                        <p class="mt-1 text-sm text-stone-600 line-clamp-3">{{ $review->comment }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="cn-card">
        <div class="border-b border-stone-100 px-5 py-4">
            <h2 class="font-display font-semibold text-stone-900">Best rated products</h2>
        </div>
        @if ($bestRatedProducts->isEmpty())
            <p class="p-8 text-center text-sm text-stone-500">Rated products will appear here.</p>
        @else
            <ul class="divide-y divide-stone-100">
                @foreach ($bestRatedProducts as $product)
                    <li class="flex items-center justify-between gap-4 px-5 py-4">
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-medium text-stone-900">{{ $product->title }}</p>
                            <p class="text-xs text-stone-500">{{ $product->reviews_count }} reviews</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-amber-600">{{ number_format($product->average_rating, 1) }} ★</p>
                            <a href="{{ route('products.show', $product) }}" class="text-xs text-craft-700 hover:underline" target="_blank">View</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</div>
@endsection
