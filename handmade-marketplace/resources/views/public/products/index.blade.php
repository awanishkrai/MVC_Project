@extends('layouts.public')
@section('title', 'Marketplace — CraftNest')

@section('content')
<div class="cn-container pb-12">
<section class="cn-card mb-8 overflow-hidden">
    <div class="cn-hero-gradient px-8 py-12 text-center sm:px-12 sm:text-left">
        <p class="cn-eyebrow !text-craft-200">Discover handmade</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">The CraftNest Marketplace</h1>
        <p class="mt-3 max-w-xl text-craft-100">Unique pieces from independent makers — jewelry, pottery, art & more.</p>
    </div>
</section>

{{-- Categories --}}
@if ($categories->isNotEmpty())
<section class="mb-12">
    <h2 class="font-display text-2xl font-bold text-stone-900">Shop by category</h2>
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        @foreach ($categories as $category)
            <x-category-card :category="$category" :active="($filters['category'] ?? '') === $category->slug" />
        @endforeach
    </div>
</section>
@endif

{{-- Filters --}}
<section class="cn-card mb-8 p-4 sm:p-6">
    <form method="GET" action="{{ route('products.index') }}" class="grid gap-4 lg:grid-cols-12 lg:items-end">
        <div class="lg:col-span-4">
            <label class="cn-label" for="search">Search</label>
            <input class="cn-input" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search handmade treasures...">
        </div>
        <div class="lg:col-span-2">
            <label class="cn-label" for="category">Category</label>
            <select class="cn-input" id="category" name="category">
                <option value="">All</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(($filters['category'] ?? '') === $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="lg:col-span-2">
            <label class="cn-label" for="stock">Stock</label>
            <select class="cn-input" id="stock" name="stock">
                <option value="">Any</option>
                <option value="in_stock" @selected(($filters['stock'] ?? '') === 'in_stock')>In stock</option>
                <option value="low_stock" @selected(($filters['stock'] ?? '') === 'low_stock')>Low stock</option>
            </select>
        </div>
        <div class="lg:col-span-2">
            <label class="cn-label" for="sort">Sort</label>
            <select class="cn-input" id="sort" name="sort">
                <option value="">Latest</option>
                <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price ↑</option>
                <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price ↓</option>
            </select>
        </div>
        <div class="flex gap-2 lg:col-span-2">
            <button type="submit" class="cn-btn-primary flex-1">Filter</button>
            <a href="{{ route('products.index') }}" class="cn-btn-secondary">Reset</a>
        </div>
    </form>
</section>

{{-- Grid --}}
@if ($products->isEmpty())
    <x-empty-state title="No products found" description="Try different filters or check back soon for new handmade listings.">
        <x-slot name="icon">🔍</x-slot>
        <x-slot name="action"><a href="{{ route('products.index') }}" class="cn-btn-primary">View all</a></x-slot>
    </x-empty-state>
@else
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($products as $product)
            <x-product-card :product="$product" class="animate-fade-up" style="animation-delay: {{ $loop->index * 50 }}ms" />
        @endforeach
    </div>
    <div class="mt-10">{{ $products->links() }}</div>
@endif
</div>
@endsection
