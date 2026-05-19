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
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Published</p>
        <p class="mt-1 font-display text-3xl font-bold text-emerald-700">{{ $publishedCount }}</p>
    </article>
    <article class="cn-card border-l-4 border-l-amber-500 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Low stock</p>
        <p class="mt-1 font-display text-3xl font-bold text-amber-700">{{ $lowStockCount }}</p>
    </article>
    <article class="cn-card border-l-4 border-l-stone-400 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Shop status</p>
        <p class="mt-1 font-display text-lg font-bold">{{ $shop ? 'Active' : 'Not set up' }}</p>
    </article>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <section class="cn-card lg:col-span-2">
        <div class="flex items-center justify-between border-b border-stone-100 px-5 py-4">
            <h2 class="font-display font-semibold text-stone-900">Recent products</h2>
            <a href="{{ route('seller.products.index') }}" class="text-sm text-craft-700 hover:underline">View all</a>
        </div>
        @if ($recentProducts->isEmpty())
            <div class="p-8 text-center text-sm text-stone-500">
                No products yet. <a href="{{ route('seller.products.create') }}" class="font-medium text-craft-700">Add your first →</a>
            </div>
        @else
            <div class="divide-y divide-stone-100">
                @foreach ($recentProducts as $product)
                    <div class="flex items-center gap-4 px-5 py-3">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" class="h-12 w-12 rounded-xl object-cover" alt="">
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-medium text-stone-900">{{ $product->title }}</p>
                            <p class="text-xs text-stone-500">{{ $product->category?->name }} · ${{ number_format($product->price, 2) }}</p>
                        </div>
                        <x-stock-badge :status="$product->stock_status" />
                        <a href="{{ route('seller.products.edit', $product) }}" class="text-sm text-craft-700">Edit</a>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="space-y-4">
        <article class="cn-card p-5">
            <h2 class="font-display font-semibold text-stone-900">Quick actions</h2>
            <div class="mt-4 space-y-2">
                <a href="{{ route('seller.products.create') }}" class="flex w-full items-center gap-2 rounded-xl bg-craft-50 px-4 py-3 text-sm font-medium text-craft-900 hover:bg-craft-100">➕ Add product</a>
                <a href="{{ route('seller.shop.index') }}" class="flex w-full items-center gap-2 rounded-xl border border-stone-200 px-4 py-3 text-sm hover:bg-stone-50">🏪 Manage shop</a>
                @if ($shop)
                    <a href="{{ route('shops.show', $shop) }}" target="_blank" class="flex w-full items-center gap-2 rounded-xl border border-stone-200 px-4 py-3 text-sm hover:bg-stone-50">🌐 Preview storefront</a>
                @endif
            </div>
        </article>
        <article class="cn-card border-dashed p-5">
            <p class="text-xs font-semibold uppercase text-stone-400">Coming soon</p>
            <ul class="mt-2 space-y-1 text-sm text-stone-500">
                <li>· Order management</li>
                <li>· Buyer messages</li>
                <li>· Sales analytics</li>
            </ul>
        </article>
    </section>
</div>
@endsection
