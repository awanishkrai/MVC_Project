@extends('layouts.app')
@section('title', $shop->shop_name . ' — CraftNest')

@section('content')
{{-- Storefront hero --}}
<section class="cn-card mb-10 overflow-hidden">
    <div class="relative min-h-[280px] cn-hero-gradient sm:min-h-[320px]">
        <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.15\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="relative flex flex-col items-center gap-6 px-6 py-12 sm:flex-row sm:items-end sm:px-10 sm:pb-10">
            @if ($shop->logo_url)
                <img src="{{ $shop->logoUrl() }}" alt="{{ $shop->shop_name }}" class="h-32 w-32 rounded-3xl border-4 border-white/30 object-cover shadow-2xl ring-4 ring-white/20">
            @else
                <div class="flex h-32 w-32 items-center justify-center rounded-3xl border-4 border-white/30 bg-white/10 text-5xl font-bold text-white backdrop-blur">{{ strtoupper(substr($shop->shop_name, 0, 1)) }}</div>
            @endif
            <div class="flex-1 text-center text-white sm:text-left">
                <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur">✦ Artisan shop</span>
                <h1 class="mt-3 font-display text-4xl font-bold sm:text-5xl">{{ $shop->shop_name }}</h1>
                <p class="mt-2 text-craft-100">Curated by <strong>{{ $shop->user->name }}</strong></p>
                @if ($shop->location)
                    <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-black/20 px-3 py-1 text-sm backdrop-blur">📍 {{ $shop->location }}</p>
                @endif
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-white/90">{{ $shop->description }}</p>
                <p class="mt-4 text-sm font-medium text-craft-200">{{ $productCount }} {{ Str::plural('product', $productCount) }} available</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="mb-8 flex items-center justify-between">
        <h2 class="font-display text-2xl font-bold text-stone-900">Shop collection</h2>
        @auth
            @if (auth()->id() === $shop->user_id)
                <a href="{{ route('shop.dashboard') }}" class="cn-btn-secondary text-sm">Manage shop</a>
            @endif
        @endauth
    </div>

    @if ($products->isEmpty())
        <x-empty-state title="No products yet" description="This maker is preparing their collection. Follow the shop and check back soon!">
            <x-slot name="icon">🛍️</x-slot>
            @auth
                @if (auth()->id() === $shop->user_id)
                    <x-slot name="action"><a href="{{ route('products.create') }}" class="cn-btn-primary">Add your first product</a></x-slot>
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
@endsection
