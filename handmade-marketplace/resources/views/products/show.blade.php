@extends('layouts.app')
@section('title', $product->title . ' — CraftNest')

@section('content')
<nav class="mb-6 text-sm text-stone-500">
    <a href="{{ route('products.index') }}" class="hover:text-craft-700">Marketplace</a>
    <span class="mx-2">/</span>
    <span class="text-stone-800">{{ $product->title }}</span>
</nav>

<div class="grid gap-10 lg:grid-cols-2">
    <div class="cn-card overflow-hidden">
        <div class="aspect-square overflow-hidden bg-craft-50">
            @if ($product->imageUrl())
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full items-center justify-center text-8xl opacity-30">🧵</div>
            @endif
        </div>
    </div>

    <div>
        @if ($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="inline-flex items-center gap-1 rounded-full bg-craft-100 px-3 py-1 text-sm font-semibold text-craft-800">
                {{ $product->category->icon }} {{ $product->category->name }}
            </a>
        @endif
        <h1 class="mt-3 font-display text-4xl font-bold text-stone-900">{{ $product->title }}</h1>
        <p class="mt-4 text-3xl font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>

        <p class="mt-6 leading-relaxed text-stone-600">{{ $product->description }}</p>

        <dl class="mt-8 grid gap-3 rounded-2xl bg-craft-50/80 p-5 text-sm sm:grid-cols-2">
            @if ($product->handmade_material)
                <div><dt class="font-semibold text-stone-700">Material</dt><dd class="text-stone-600">{{ $product->handmade_material }}</dd></div>
            @endif
            @if ($product->delivery_time)
                <div><dt class="font-semibold text-stone-700">Delivery</dt><dd class="text-stone-600">{{ $product->delivery_time }}</dd></div>
            @endif
            <div><dt class="font-semibold text-stone-700">Stock</dt><dd class="capitalize text-stone-600">{{ str_replace('_', ' ', $product->stock_status) }} ({{ $product->quantity }})</dd></div>
        </dl>

        <div class="mt-8 flex flex-wrap gap-3">
            <button type="button" class="cn-btn-primary cursor-not-allowed opacity-80" disabled title="Coming in Cart module">Add to cart (soon)</button>
            <a href="{{ route('shops.show', $product->shop) }}" class="cn-btn-secondary">Visit shop</a>
        </div>

        <div class="cn-card mt-8 p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Sold by</p>
            <p class="mt-1 font-display text-lg font-semibold">{{ $product->shop->shop_name }}</p>
            <p class="text-sm text-stone-500">{{ $product->shop->user->name }}</p>
        </div>
    </div>
</div>

@if ($related->isNotEmpty())
<section class="mt-16">
    <h2 class="font-display text-2xl font-bold text-stone-900">You may also like</h2>
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($related as $item)
            <x-product-card :product="$item" />
        @endforeach
    </div>
</section>
@endif

<section class="cn-card mt-12 border-dashed p-8 text-center">
    <p class="font-display text-lg font-semibold text-stone-700">Reviews</p>
    <p class="mt-2 text-sm text-stone-500">Customer reviews coming in a future module.</p>
</section>
@endsection
