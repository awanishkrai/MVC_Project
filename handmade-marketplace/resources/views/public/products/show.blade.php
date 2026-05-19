@extends('layouts.public')
@section('title', $product->title . ' — CraftNest')

@section('content')
<div class="cn-container py-8 sm:py-10 lg:py-12">
    <nav class="mb-6 text-sm text-stone-500">
        <a href="{{ route('products.index') }}" class="hover:text-craft-700">Marketplace</a>
        <span class="mx-2">/</span>
        @if ($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-craft-700">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
        @endif
        <span class="text-stone-800 line-clamp-1">{{ $product->title }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-12 lg:gap-12">
        {{-- Gallery --}}
        <div class="lg:col-span-6 xl:col-span-7">
            <div class="cn-card overflow-hidden">
                <div class="aspect-square max-h-[min(520px,70vh)] w-full overflow-hidden bg-craft-50">
                    <x-product-image :product="$product" img-class="h-full w-full object-cover" fallback-class="flex aspect-square max-h-[min(520px,70vh)] w-full items-center justify-center bg-gradient-to-br from-craft-100 to-stone-100" />
                </div>
            </div>
        </div>

        {{-- Product info --}}
        <div class="lg:col-span-6 xl:col-span-5">
            <div class="lg:sticky lg:top-24">
                @if ($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="inline-flex items-center gap-1 rounded-full bg-craft-100 px-3 py-1 text-sm font-semibold text-craft-800 transition hover:bg-craft-200">
                        {{ $product->category->icon }} {{ $product->category->name }}
                    </a>
                @endif

                <h1 class="mt-3 font-display text-3xl font-bold leading-tight text-stone-900 sm:text-4xl">{{ $product->title }}</h1>

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <p class="text-3xl font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>
                    <x-stock-badge :status="$product->stock_status" />
                </div>

                <p class="mt-6 leading-relaxed text-stone-600">{{ $product->description }}</p>

                <dl class="mt-8 grid gap-4 rounded-2xl border border-stone-100 bg-craft-50/60 p-5 text-sm sm:grid-cols-2">
                    @if ($product->handmade_material)
                        <div><dt class="font-semibold text-stone-700">Material</dt><dd class="mt-0.5 text-stone-600">{{ $product->handmade_material }}</dd></div>
                    @endif
                    @if ($product->delivery_time)
                        <div><dt class="font-semibold text-stone-700">Delivery</dt><dd class="mt-0.5 text-stone-600">{{ $product->delivery_time }}</dd></div>
                    @endif
                    <div><dt class="font-semibold text-stone-700">Available</dt><dd class="mt-0.5 capitalize text-stone-600">{{ str_replace('_', ' ', $product->stock_status) }} · {{ $product->quantity }} left</dd></div>
                </dl>

                <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    @if ($product->isInStock())
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                            @csrf
                            <div>
                                <label class="cn-label" for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="cn-input !w-24 !py-2.5 text-center">
                            </div>
                            <button type="submit" class="cn-btn-primary flex-1 sm:flex-none sm:px-8">Add to cart</button>
                        </form>
                    @else
                        <button type="button" class="cn-btn-primary w-full cursor-not-allowed opacity-60" disabled>Out of stock</button>
                    @endif
                    <a href="{{ route('shops.show', $product->shop) }}" class="cn-btn-secondary mt-3 w-full text-center">Visit {{ $product->shop->shop_name }}</a>
                </div>

                <div class="cn-card mt-6 flex items-center gap-4 p-5">
                    <x-shop-logo :shop="$product->shop" size="sm" />
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Sold by</p>
                        <p class="truncate font-display text-lg font-semibold text-stone-900">{{ $product->shop->shop_name }}</p>
                        <p class="text-sm text-stone-500">{{ $product->shop->user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($related->isNotEmpty())
    <section class="mt-16 border-t border-stone-200/80 pt-12">
        <h2 class="font-display text-2xl font-bold text-stone-900">You may also like</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($related as $item)
                <x-product-card :product="$item" />
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
