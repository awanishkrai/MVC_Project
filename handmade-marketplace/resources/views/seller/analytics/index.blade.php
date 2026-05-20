@extends('layouts.seller')
@section('title', 'Analytics')
@section('page-title', 'Analytics & reports')
@section('page-subtitle', 'Insights for your handmade business')

@section('content')
@php
    $salesDatasets = [[
        'label' => 'Revenue ($)',
        'data' => $monthlySalesChart['values'],
        'borderColor' => '#c66a38',
        'backgroundColor' => 'rgba(198, 106, 56, 0.1)',
        'fill' => true,
        'tension' => 0.3,
    ]];
    $orderDatasets = [[
        'label' => 'Orders',
        'data' => $orderTrendsChart['values'],
        'backgroundColor' => '#78716c',
    ]];
    $reviewDatasets = [[
        'label' => 'Reviews',
        'data' => $reviewTrendsChart['values'],
        'borderColor' => '#d97706',
        'tension' => 0.3,
    ]];
@endphp

<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('seller.exports.orders') }}" class="cn-btn-secondary !text-xs">Export orders CSV</a>
    <a href="{{ route('seller.exports.products') }}" class="cn-btn-secondary !text-xs">Export products CSV</a>
</div>

<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="cn-card p-5"><p class="text-xs uppercase text-stone-500">Total revenue</p><p class="mt-1 font-display text-2xl font-bold text-craft-700">${{ number_format($revenue['total'], 2) }}</p></article>
    <article class="cn-card p-5"><p class="text-xs uppercase text-stone-500">This month</p><p class="mt-1 font-display text-2xl font-bold text-stone-900">${{ number_format($revenue['monthly'], 2) }}</p></article>
    <article class="cn-card p-5"><p class="text-xs uppercase text-stone-500">This week</p><p class="mt-1 font-display text-2xl font-bold text-stone-900">${{ number_format($revenue['weekly'], 2) }}</p></article>
    <article class="cn-card p-5"><p class="text-xs uppercase text-stone-500">Orders</p><p class="mt-1 font-display text-2xl font-bold text-stone-900">{{ $orders['total'] }} <span class="text-sm font-normal text-stone-500">({{ $orders['pending'] }} pending)</span></p></article>
</div>

<div class="mb-6 grid gap-6 lg:grid-cols-2">
    <article class="cn-card p-5">
        <h2 class="font-display font-semibold text-stone-900">Monthly sales</h2>
        <div class="mt-4 h-60"><x-chart id="seller-sales-chart" type="line" :labels="$monthlySalesChart['labels']" :datasets="$salesDatasets" /></div>
    </article>
    <article class="cn-card p-5">
        <h2 class="font-display font-semibold text-stone-900">Order trends (14 days)</h2>
        <div class="mt-4 h-60"><x-chart id="seller-orders-chart" type="bar" :labels="$orderTrendsChart['labels']" :datasets="$orderDatasets" /></div>
    </article>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <section class="cn-card lg:col-span-2">
        <div class="border-b border-stone-100 px-5 py-4"><h2 class="font-display font-semibold">Best selling products</h2></div>
        <ul class="divide-y divide-stone-100">
            @forelse ($bestSelling as $row)
                <li class="flex justify-between px-5 py-3 text-sm">
                    <span class="font-medium">{{ $row->product?->title ?? 'Product' }}</span>
                    <span class="text-stone-500">{{ $row->units_sold }} sold · ${{ number_format($row->revenue, 2) }}</span>
                </li>
            @empty
                <li class="px-5 py-8 text-center text-sm text-stone-500">No sales data yet.</li>
            @endforelse
        </ul>
    </section>
    <section class="cn-card p-5">
        <h2 class="font-display font-semibold">Review analytics</h2>
        <p class="mt-2 text-3xl font-bold text-amber-600">{{ $reviews['average'] ? number_format($reviews['average'], 1).' ★' : '—' }}</p>
        <p class="text-sm text-stone-500">{{ $reviews['total'] }} total reviews</p>
        <div class="mt-4 h-40"><x-chart id="seller-reviews-chart" type="line" :labels="$reviewTrendsChart['labels']" :datasets="$reviewDatasets" /></div>
    </section>
</div>

<div class="mt-6 grid gap-6 md:grid-cols-2">
    <section class="cn-card">
        <div class="border-b border-stone-100 px-5 py-4"><h2 class="font-semibold">Low stock</h2></div>
        <ul class="divide-y divide-stone-100 text-sm">
            @forelse ($lowStock as $product)
                <li class="flex justify-between px-5 py-3"><span>{{ $product->title }}</span><x-stock-badge :status="$product->stock_status" /></li>
            @empty
                <li class="px-5 py-6 text-center text-stone-500">All products well stocked.</li>
            @endforelse
        </ul>
    </section>
    <section class="cn-card">
        <div class="border-b border-stone-100 px-5 py-4"><h2 class="font-semibold">Most wishlisted</h2></div>
        <ul class="divide-y divide-stone-100 text-sm">
            @forelse ($mostWishlisted as $product)
                <li class="flex justify-between px-5 py-3"><span>{{ $product->title }}</span><span class="text-stone-500">♡ {{ $product->wishlists_count }}</span></li>
            @empty
                <li class="px-5 py-6 text-center text-stone-500">No wishlist data yet.</li>
            @endforelse
        </ul>
    </section>
</div>
@endsection
