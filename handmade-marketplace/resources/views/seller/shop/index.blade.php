@extends('layouts.seller')
@section('title', 'My Shop')
@section('page-title', $shop->shop_name)
@section('page-subtitle', 'Manage your storefront')

@section('content')
<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div class="flex items-center gap-4">
        <x-shop-logo :shop="$shop" size="md" class="shadow-craft ring-2 ring-white" />
        <div>
            <p class="cn-eyebrow">Seller panel</p>
            <h1 class="cn-page-header !text-2xl sm:!text-3xl">{{ $shop->shop_name }}</h1>
        </div>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('shops.show', $shop) }}" class="cn-btn-secondary">View storefront</a>
        <a href="{{ route('seller.shop.edit') }}" class="cn-btn-secondary">Edit shop</a>
        <a href="{{ route('seller.products.create') }}" class="cn-btn-primary">+ Add product</a>
    </div>
</div>

<div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Products</p><p class="mt-1 font-display text-3xl font-bold text-craft-700">{{ $productCount }}</p></article>
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Published</p><p class="mt-1 font-display text-3xl font-bold text-emerald-600">{{ $products->where('status', 'published')->count() }}</p></article>
    <article class="cn-card p-5"><p class="text-sm text-stone-500">In stock</p><p class="mt-1 font-display text-3xl font-bold text-stone-800">{{ $products->where('stock_status', 'in_stock')->count() }}</p></article>
    <article class="cn-card p-5"><p class="text-sm text-stone-500">Since</p><p class="mt-1 font-display text-xl font-bold text-stone-800">{{ $shop->created_at->format('M Y') }}</p></article>
</div>

<div class="cn-card overflow-hidden">
    <div class="flex items-center justify-between border-b border-stone-100 px-6 py-4">
        <h2 class="font-display text-lg font-semibold">Your products</h2>
        <a href="{{ route('seller.products.index') }}" class="text-sm font-medium text-craft-700 hover:underline">View all →</a>
    </div>
    @if ($products->isEmpty())
        <div class="p-8">
            <x-empty-state title="Start your collection" description="Add handmade products for buyers to discover.">
                <x-slot name="icon">✨</x-slot>
                <x-slot name="action"><a href="{{ route('seller.products.create') }}" class="cn-btn-primary">Add first product</a></x-slot>
            </x-empty-state>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-craft-50/80 text-xs uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Stock</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($products->take(5) as $product)
                        <tr class="hover:bg-craft-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" class="h-12 w-12 rounded-xl object-cover">
                                    @endif
                                    <span class="font-medium">{{ $product->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-6 py-4 font-semibold text-craft-700">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $product->stock_status) }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('seller.products.edit', $product) }}" class="text-craft-700 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
