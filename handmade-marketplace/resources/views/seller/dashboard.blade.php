@extends('layouts.seller')
@section('title', 'Seller Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your handmade business')

@section('content')
<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="cn-card border-l-4 border-l-craft-500 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total products</p>
        <p class="mt-1 font-display text-3xl font-bold text-stone-900">{{ $productCount }}</p>
    </article>
    <article class="cn-card border-l-4 border-l-emerald-500 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Revenue (all time)</p>
        <p class="mt-1 font-display text-3xl font-bold text-emerald-700">${{ number_format($revenue['total'], 0) }}</p>
    </article>
    <article class="cn-card border-l-4 border-l-amber-500 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Orders · pending</p>
        <p class="mt-1 font-display text-3xl font-bold text-amber-700">{{ $orderStats['total'] }} <span class="text-base font-normal text-stone-500">/ {{ $orderStats['pending'] }}</span></p>
    </article>
    <article class="cn-card border-l-4 border-l-stone-400 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Low stock</p>
        <p class="mt-1 font-display text-3xl font-bold text-stone-800">{{ $lowStockCount }}</p>
    </article>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <section class="cn-card lg:col-span-2">
        <div class="flex items-center justify-between border-b border-stone-100 px-5 py-4">
            <h2 class="font-display font-semibold text-stone-900">Recent activity</h2>
            <a href="{{ route('seller.analytics.index') }}" class="text-sm text-craft-700 hover:underline">Full analytics →</a>
        </div>
        <div class="grid gap-0 md:grid-cols-2">
            <div class="border-b border-stone-100 p-5 md:border-b-0 md:border-r">
                <h3 class="text-xs font-semibold uppercase text-stone-500">Recent orders</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    @forelse ($activity['recentOrders'] as $order)
                        <li class="flex justify-between gap-2">
                            <span class="truncate font-medium">{{ $order->formattedId() }} · {{ $order->user->name }}</span>
                            <span class="shrink-0 capitalize text-stone-400">{{ $order->order_status }}</span>
                        </li>
                    @empty
                        <li class="text-stone-400">No orders yet.</li>
                    @endforelse
                </ul>
                <a href="{{ route('seller.orders.index') }}" class="mt-3 inline-block text-xs font-medium text-craft-700">Manage orders →</a>
            </div>
            <div class="p-5">
                <h3 class="text-xs font-semibold uppercase text-stone-500">Recent reviews</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    @forelse ($activity['recentReviews'] as $review)
                        <li>
                            <span class="font-medium">{{ $review->user->name }}</span>
                            <span class="text-amber-600">{{ $review->rating }}★</span>
                            <span class="text-stone-400">on {{ Str::limit($review->product->title, 28) }}</span>
                        </li>
                    @empty
                        <li class="text-stone-400">No reviews yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        @if ($activity['lowStock']->isNotEmpty())
            <div class="border-t border-stone-100 bg-amber-50/50 px-5 py-4">
                <h3 class="text-xs font-semibold uppercase text-amber-800">Low stock alerts</h3>
                <ul class="mt-2 flex flex-wrap gap-2 text-xs">
                    @foreach ($activity['lowStock'] as $product)
                        <li class="rounded-full bg-white px-3 py-1 ring-1 ring-amber-200">{{ $product->title }} ({{ $product->quantity }})</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>

    <section class="space-y-4">
        <article class="cn-card p-5">
            <h2 class="font-display font-semibold text-stone-900">Quick actions</h2>
            <div class="mt-4 space-y-2">
                <a href="{{ route('seller.products.create') }}" class="flex w-full items-center gap-2 rounded-xl bg-craft-50 px-4 py-3 text-sm font-medium text-craft-900 hover:bg-craft-100">➕ Add product</a>
                <a href="{{ route('seller.orders.index') }}" class="flex w-full items-center gap-2 rounded-xl border border-stone-200 px-4 py-3 text-sm hover:bg-stone-50">🛒 View orders</a>
                <a href="{{ route('seller.analytics.index') }}" class="flex w-full items-center gap-2 rounded-xl border border-stone-200 px-4 py-3 text-sm hover:bg-stone-50">📈 Analytics</a>
            </div>
        </article>
        <article class="cn-card p-5">
            <h2 class="font-display font-semibold text-stone-900">Recent products</h2>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($activity['recentProducts'] as $product)
                    <li class="flex justify-between"><span class="truncate">{{ $product->title }}</span><x-stock-badge :status="$product->stock_status" /></li>
                @endforeach
            </ul>
        </article>
    </section>
</div>
@endsection
