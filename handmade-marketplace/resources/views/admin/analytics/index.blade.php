@extends('layouts.admin')
@section('title', 'Analytics')
@section('page-title', 'Platform analytics')
@section('page-subtitle', 'Marketplace insights & exports')

@section('content')
@php
    $revenueDatasets = [[
        'label' => 'Revenue ($)',
        'data' => $revenueChart['values'],
        'borderColor' => '#34d399',
        'backgroundColor' => 'rgba(52, 211, 153, 0.1)',
        'fill' => true,
        'tension' => 0.3,
    ]];
    $orderDatasets = [[
        'label' => 'Orders',
        'data' => $orderChart['values'],
        'backgroundColor' => '#94a3b8',
    ]];
    $userDatasets = [[
        'label' => 'New users',
        'data' => $userChart['values'],
        'borderColor' => '#c66a38',
        'tension' => 0.3,
    ]];
@endphp

<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('admin.exports.orders') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs text-slate-300 hover:bg-slate-800">Export orders</a>
    <a href="{{ route('admin.exports.users') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs text-slate-300 hover:bg-slate-800">Export users</a>
    <a href="{{ route('admin.exports.reviews') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs text-slate-300 hover:bg-slate-800">Export reviews</a>
</div>

<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([
        ['Users', $stats['users']],
        ['Orders', $stats['orders']],
        ['Revenue', '$'.number_format($stats['revenue'], 0)],
        ['Products', $stats['products']],
    ] as [$label, $value])
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <p class="text-xs uppercase text-slate-500">{{ $label }}</p>
            <p class="mt-1 font-display text-2xl font-bold text-white">{{ $value }}</p>
        </article>
    @endforeach
</div>

<div class="mb-6 grid gap-6 lg:grid-cols-3">
    <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
        <h2 class="font-semibold text-white">Revenue growth</h2>
        <div class="mt-4 h-60"><x-chart id="admin-revenue-chart" type="line" :labels="$revenueChart['labels']" :datasets="$revenueDatasets" /></div>
    </article>
    <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <h2 class="font-semibold text-white">User growth</h2>
        <div class="mt-4 h-60"><x-chart id="admin-users-chart" type="line" :labels="$userChart['labels']" :datasets="$userDatasets" /></div>
    </article>
</div>

<article class="mb-6 rounded-2xl border border-slate-800 bg-slate-900 p-5">
    <h2 class="font-semibold text-white">Order trends (14 days)</h2>
    <div class="mt-4 h-56"><x-chart id="admin-orders-chart" type="bar" :labels="$orderChart['labels']" :datasets="$orderDatasets" /></div>
</article>

<div class="grid gap-6 lg:grid-cols-2">
    <section class="rounded-2xl border border-slate-800 bg-slate-900">
        <div class="border-b border-slate-800 px-5 py-4"><h2 class="font-semibold text-white">Top sellers</h2></div>
        <ul class="divide-y divide-slate-800 text-sm">
            @forelse ($topSellers as $seller)
                <li class="flex justify-between px-5 py-3 text-slate-300">
                    <span>{{ $seller['name'] }} <span class="text-slate-500">({{ $seller['shop'] ?? 'no shop' }})</span></span>
                    <span class="text-emerald-400">${{ number_format($seller['revenue'], 2) }}</span>
                </li>
            @empty
                <li class="px-5 py-6 text-center text-slate-500">No seller revenue yet.</li>
            @endforelse
        </ul>
    </section>
    <section class="rounded-2xl border border-slate-800 bg-slate-900">
        <div class="border-b border-slate-800 px-5 py-4"><h2 class="font-semibold text-white">Top categories</h2></div>
        <ul class="divide-y divide-slate-800 text-sm">
            @foreach ($topCategories as $category)
                <li class="flex justify-between px-5 py-3 text-slate-300">
                    <span>{{ $category->icon }} {{ $category->name }}</span>
                    <span class="text-slate-500">{{ $category->products_count }} products</span>
                </li>
            @endforeach
        </ul>
    </section>
</div>
@endsection
