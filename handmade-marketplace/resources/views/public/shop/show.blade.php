@extends('layouts.public')
@section('title', $shop->shop_name . ' — CraftNest')

@section('content')
<div class="cn-container space-y-10 py-8 sm:py-10 lg:py-12">
    {{-- Storefront hero --}}
    <section class="cn-card overflow-hidden">
        <div class="relative min-h-[300px] cn-hero-gradient sm:min-h-[340px]">
            <div class="absolute inset-0 opacity-25" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.12\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            <div class="relative flex flex-col items-center gap-6 px-6 py-10 sm:flex-row sm:items-end sm:gap-8 sm:px-10 sm:pb-10 sm:pt-12">
                <x-shop-logo :shop="$shop" size="xl" class="shrink-0" />
                <div class="flex-1 text-center text-white sm:text-left">
                    <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur">✦ Artisan shop</span>
                    <h1 class="mt-3 font-display text-3xl font-bold sm:text-4xl lg:text-5xl">{{ $shop->shop_name }}</h1>
                    <p class="mt-2 text-craft-100">Curated by <strong>{{ $shop->user->name }}</strong></p>
                    @if ($shop->location)
                        <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-black/20 px-3 py-1 text-sm backdrop-blur">📍 {{ $shop->location }}</p>
                    @endif
                    @if ($shop->description)
                        <p class="mt-4 max-w-2xl text-sm leading-relaxed text-white/90 sm:text-base">{{ $shop->description }}</p>
                    @endif
                    <p class="mt-4 text-sm font-medium text-craft-200">{{ $productCount }} {{ Str::plural('product', $productCount) }} available</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-bold text-stone-900">Shop collection</h2>
                <p class="mt-1 text-sm text-stone-500">Handmade pieces from this maker</p>
            </div>
            @auth
                @if (auth()->id() === $shop->user_id)
                    <a href="{{ route('seller.shop.index') }}" class="cn-btn-secondary text-sm">Manage shop</a>
                @endif
            @endauth
        </div>

        @if ($products->isEmpty())
            <x-empty-state title="No products yet" description="This maker is preparing their collection. Check back soon!">
                <x-slot name="icon">🛍️</x-slot>
                @auth
                    @if (auth()->id() === $shop->user_id)
                        <x-slot name="action"><a href="{{ route('seller.products.create') }}" class="cn-btn-primary">Add your first product</a></x-slot>
                    @endif
                @endauth
            </x-empty-state>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
