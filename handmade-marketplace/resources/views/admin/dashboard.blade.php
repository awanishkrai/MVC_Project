@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Platform overview')
@section('page-subtitle', 'CraftNest administration')

@section('content')
<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([
        ['Users', $stats['users'], '👥'],
        ['Orders', $stats['orders'], '🛒'],
        ['Revenue', '$'.number_format($stats['revenue'], 0), '💰'],
        ['Reviews', $stats['reviews'], '⭐'],
    ] as [$label, $value, $icon])
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $icon }}</span>
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-500">{{ $label }}</p>
                    <p class="font-display text-2xl font-bold text-white">{{ $value }}</p>
                </div>
            </div>
        </article>
    @endforeach
</div>

@if ($activity['lowStockCount'] >= 5)
    <div class="mb-6 rounded-2xl border border-amber-800/50 bg-amber-950/30 px-5 py-4 text-sm text-amber-200">
        ⚠ {{ $activity['lowStockCount'] }} products are low on stock across the marketplace.
        <a href="{{ route('admin.analytics.index') }}" class="ml-2 font-semibold underline">View analytics</a>
    </div>
@endif

<section class="mb-6 rounded-2xl border border-slate-800 bg-slate-900">
    <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4">
        <h2 class="font-semibold text-white">Recent platform activity</h2>
        <a href="{{ route('admin.analytics.index') }}" class="text-sm text-craft-400 hover:text-craft-300">Analytics & exports →</a>
    </div>
    <div class="grid gap-0 lg:grid-cols-2">
        <div class="border-b border-slate-800 p-5 lg:border-b-0 lg:border-r">
            <h3 class="text-xs uppercase text-slate-500">Latest orders</h3>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($activity['orders'] as $order)
                    <li class="flex justify-between text-slate-300">
                        <span>{{ $order->formattedId() }} · {{ $order->user->name }}</span>
                        <span class="text-emerald-400">${{ number_format($order->total_amount, 0) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="p-5">
            <h3 class="text-xs uppercase text-slate-500">Latest reviews</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                @foreach ($activity['reviews'] as $review)
                    <li>{{ $review->user->name }} · {{ $review->rating }}★ on {{ Str::limit($review->product->title, 24) }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="grid gap-0 border-t border-slate-800 lg:grid-cols-2">
        <div class="border-b border-slate-800 p-5 lg:border-b-0 lg:border-r">
            <h3 class="text-xs uppercase text-slate-500">New sellers</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                @foreach ($activity['shops'] as $shop)
                    <li>{{ $shop->shop_name }} · {{ $shop->user->name }}</li>
                @endforeach
            </ul>
        </div>
        <div class="p-5">
            <h3 class="text-xs uppercase text-slate-500">New registrations</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                @foreach ($activity['users'] as $u)
                    <li>{{ $u->name }} <span class="text-slate-500">({{ $u->role }})</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<div class="grid gap-6 lg:grid-cols-2">
    <section class="rounded-2xl border border-slate-800 bg-slate-900">
        <div class="border-b border-slate-800 px-5 py-4"><h2 class="font-semibold text-white">Recent products</h2></div>
        <ul class="divide-y divide-slate-800">
            @foreach ($recentProducts as $p)
                <li class="px-5 py-3 text-sm">
                    <p class="text-slate-200">{{ $p->title }}</p>
                    <p class="text-xs text-slate-500">{{ $p->shop?->shop_name }} · ${{ number_format($p->price, 2) }}</p>
                </li>
            @endforeach
        </ul>
    </section>
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <h2 class="font-semibold text-white">Quick links</h2>
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.orders.index') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-slate-200 hover:bg-slate-700">Orders</a>
            <a href="{{ route('admin.reviews.index') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-slate-200 hover:bg-slate-700">Reviews</a>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-slate-200 hover:bg-slate-700">Categories</a>
        </div>
    </section>
</div>
@endsection
