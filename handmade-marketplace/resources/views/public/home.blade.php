@extends('layouts.public')
@section('title', 'CraftNest — Handmade Marketplace')

@section('category-strip')
    @include('partials.public.category-strip')
@endsection

@section('content')
<section class="cn-card mx-auto mb-10 max-w-7xl overflow-hidden">
    <div class="relative min-h-[380px] cn-hero-gradient sm:min-h-[440px]">
        <div class="absolute inset-0 opacity-30" style="background: radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.15) 0%, transparent 60%);"></div>
        <div class="relative flex flex-col items-center justify-center px-6 py-16 text-center sm:py-24">
            <p class="cn-eyebrow !text-craft-200">Handmade marketplace</p>
            <h1 class="max-w-3xl font-display text-4xl font-bold leading-tight text-white sm:text-6xl">
                Discover crafts made with <span class="text-craft-200">heart</span>
            </h1>
            <p class="mt-5 max-w-lg text-lg text-craft-100">Jewelry, pottery, art & gifts from independent makers — curated for people who love handmade.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('products.index') }}" class="cn-btn-primary !px-8 !py-3 shadow-craft-lg">Browse marketplace</a>
                @guest
                    <a href="{{ route('register') }}" class="cn-btn !rounded-2xl border-2 border-white/30 bg-white/10 px-8 py-3 text-white hover:bg-white/20">Become a seller</a>
                @else
                    @if (auth()->user()->isBuyer())
                        <span class="rounded-2xl bg-white/20 px-4 py-3 text-sm text-white backdrop-blur">Welcome back, {{ auth()->user()->name }}</span>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</section>

<div class="cn-container space-y-14 pb-16">
    @if ($categories->isNotEmpty())
    <section>
        <div class="mb-6 flex items-end justify-between">
            <h2 class="font-display text-2xl font-bold text-stone-900">Shop by category</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-craft-700 hover:underline">View all →</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($categories as $category)
                <x-category-card :category="$category" />
            @endforeach
        </div>
    </section>
    @endif

    @if ($featuredProducts->isNotEmpty())
    <section>
        <div class="mb-6 flex items-end justify-between">
            <h2 class="font-display text-2xl font-bold text-stone-900">Fresh finds</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-craft-700">See more →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
    @endif

    @if ($shops->isNotEmpty())
    <section>
        <h2 class="mb-6 font-display text-2xl font-bold text-stone-900">Featured artisan shops</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($shops as $shop)
                <a href="{{ route('shops.show', $shop) }}" class="cn-card-hover flex items-center gap-4 p-5">
                    @if ($shop->logo_url)
                        <img src="{{ $shop->logoUrl() }}" class="h-14 w-14 rounded-2xl object-cover" alt="">
                    @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-craft-100 text-xl font-bold text-craft-800">{{ strtoupper(substr($shop->shop_name, 0, 1)) }}</div>
                    @endif
                    <div>
                        <h3 class="font-display font-semibold text-stone-900">{{ $shop->shop_name }}</h3>
                        <p class="text-xs text-stone-500">by {{ $shop->user->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
