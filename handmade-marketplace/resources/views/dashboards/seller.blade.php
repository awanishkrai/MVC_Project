@extends('layouts.app')
@section('title', 'Seller Dashboard — CraftNest')

@section('content')
<div class="cn-card mb-8 overflow-hidden">
    <div class="cn-hero-gradient px-8 py-10">
        <p class="cn-eyebrow !text-craft-200">Seller hub</p>
        <h1 class="font-display text-3xl font-bold text-white sm:text-4xl">Welcome, {{ $user->name }}</h1>
        <p class="mt-2 text-craft-100">Your creative business command center</p>
    </div>
</div>

<div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Products</p><p class="mt-1 font-display text-3xl font-bold text-craft-700">{{ $productCount }}</p></article>
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Published</p><p class="mt-1 font-display text-3xl font-bold text-emerald-600">{{ $publishedCount }}</p></article>
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Shop</p><p class="mt-1 font-display text-lg font-bold">{{ $user->shop?->shop_name ?? '—' }}</p></article>
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Categories</p><p class="mt-1 font-display text-3xl font-bold text-stone-700">{{ $categories->count() }}</p></article>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <section class="cn-card p-6 lg:col-span-2">
        <h2 class="font-display text-lg font-semibold">Quick actions</h2>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            @if ($user->shop)
                <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 rounded-2xl border border-stone-200 p-4 transition hover:border-craft-300 hover:bg-craft-50">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-craft-100 text-lg">🏪</span>
                    <span class="font-medium">Manage shop</span>
                </a>
                <a href="{{ route('products.create') }}" class="flex items-center gap-3 rounded-2xl border border-stone-200 p-4 transition hover:border-craft-300 hover:bg-craft-50">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-craft-100 text-lg">➕</span>
                    <span class="font-medium">Add product</span>
                </a>
                <a href="{{ route('products.manage') }}" class="flex items-center gap-3 rounded-2xl border border-stone-200 p-4 transition hover:border-craft-300 hover:bg-craft-50">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-craft-100 text-lg">📦</span>
                    <span class="font-medium">My products</span>
                </a>
                <a href="{{ route('shops.show', $user->shop) }}" class="flex items-center gap-3 rounded-2xl border border-stone-200 p-4 transition hover:border-craft-300 hover:bg-craft-50">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-craft-100 text-lg">🌐</span>
                    <span class="font-medium">Public storefront</span>
                </a>
            @else
                <div class="col-span-2">
                    <x-empty-state title="Open your shop" description="One shop per seller — set up your brand storefront.">
                        <x-slot name="icon">🏪</x-slot>
                        <x-slot name="action"><a href="{{ route('shop.create') }}" class="cn-btn-primary">Create shop</a></x-slot>
                    </x-empty-state>
                </div>
            @endif
        </div>
    </section>
    <section class="cn-card p-6">
        <h2 class="font-display text-lg font-semibold">Categories</h2>
        <p class="mt-1 text-sm text-stone-500">Use when listing products</p>
        <ul class="mt-4 space-y-2">
            @foreach ($categories->take(6) as $cat)
                <li class="flex items-center gap-2 text-sm"><span>{{ $cat->icon }}</span>{{ $cat->name }}</li>
            @endforeach
        </ul>
    </section>
</div>
@endsection
