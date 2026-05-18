@extends('layouts.app')
@section('title', 'Buyer Home — CraftNest')

@section('content')
<section class="cn-card mb-10 overflow-hidden">
    <div class="cn-hero-gradient px-8 py-12">
        <p class="cn-eyebrow !text-craft-200">Discover handmade</p>
        <h1 class="font-display text-4xl font-bold text-white">Hello, {{ $user->name }}</h1>
        <p class="mt-3 max-w-lg text-craft-100">Explore unique crafts from independent makers.</p>
        <a href="{{ route('products.index') }}" class="cn-btn mt-6 inline-flex bg-white text-craft-800 hover:bg-craft-50">Browse marketplace →</a>
    </div>
</section>

@if ($categories->isNotEmpty())
<section class="mb-12">
    <h2 class="font-display text-2xl font-bold">Shop by category</h2>
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        @foreach ($categories as $category)
            <x-category-card :category="$category" />
        @endforeach
    </div>
</section>
@endif

@if ($featuredProducts->isNotEmpty())
<section class="mb-12">
    <div class="mb-6 flex items-end justify-between">
        <h2 class="font-display text-2xl font-bold">Fresh finds</h2>
        <a href="{{ route('products.index') }}" class="text-sm font-medium text-craft-700">View all →</a>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($featuredProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
@endif

@if ($shops->isNotEmpty())
<section>
    <h2 class="font-display text-2xl font-bold">Featured shops</h2>
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($shops as $shop)
            <a href="{{ route('shops.show', $shop) }}" class="cn-card-hover flex items-center gap-4 p-5">
                @if ($shop->logo_url)
                    <img src="{{ $shop->logoUrl() }}" class="h-14 w-14 rounded-2xl object-cover">
                @else
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-craft-100 text-xl font-bold text-craft-800">{{ strtoupper(substr($shop->shop_name, 0, 1)) }}</div>
                @endif
                <div>
                    <h3 class="font-display font-semibold">{{ $shop->shop_name }}</h3>
                    <p class="text-xs text-stone-500">by {{ $shop->user->name }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif
@endsection
