@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Product moderation')
@section('page-subtitle', 'Manage all marketplace products')

@section('content')
<form method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-2xl border border-slate-800 bg-slate-900 p-4">
    <div class="min-w-[140px] flex-1">
        <label class="mb-1 block text-xs text-slate-400">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Product or shop name" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
    </div>
    <div class="min-w-[120px]">
        <label class="mb-1 block text-xs text-slate-400">Category</label>
        <select name="category" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
            <option value="">All categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="min-w-[120px]">
        <label class="mb-1 block text-xs text-slate-400">Status</label>
        <select name="status" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
            <option value="">All</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
        </select>
    </div>
    <div class="min-w-[120px]">
        <label class="mb-1 block text-xs text-slate-400">Stock</label>
        <select name="stock" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
            <option value="">All</option>
            <option value="in_stock" @selected(request('stock') === 'in_stock')>In Stock</option>
            <option value="low_stock" @selected(request('stock') === 'low_stock')>Low Stock</option>
            <option value="out_of_stock" @selected(request('stock') === 'out_of_stock')>Out of Stock</option>
        </select>
    </div>
    <button type="submit" class="rounded-lg bg-craft-600 px-4 py-2 text-sm font-semibold text-white hover:bg-craft-500">Filter</button>
    <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-sm text-slate-300 hover:bg-slate-800">Reset</a>
</form>

@if ($products->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 px-8 py-16 text-center">
        <p class="text-4xl">📦</p>
        <h3 class="mt-4 font-display text-xl font-semibold text-white">No products found</h3>
        <p class="mt-2 text-sm text-slate-400">Try adjusting your filters or wait for sellers to add products.</p>
    </div>
@else
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="border-b border-slate-800 bg-slate-950/50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-5 py-4">Product</th>
                        <th class="px-5 py-4">Shop</th>
                        <th class="px-5 py-4">Category</th>
                        <th class="px-5 py-4">Price / Stock</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach ($products as $product)
                        <tr class="hover:bg-slate-800/30">
                            <td class="px-5 py-4">
                                <a href="{{ route('products.show', $product) }}" target="_blank" class="font-semibold text-craft-400 hover:text-craft-300">{{ $product->title }}</a>
                                <p class="text-xs text-slate-500">#{{ $product->id }} · {{ $product->created_at->format('M j, Y') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-slate-200">{{ $product->shop->shop_name ?? 'Unknown Shop' }}</p>
                                <p class="text-xs text-slate-500">{{ $product->shop->user->name ?? '' }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-300">{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-emerald-400">${{ number_format($product->price, 2) }}</p>
                                <p class="text-xs text-slate-500">{{ $product->quantity }} in stock</p>
                            </td>
                            <td class="px-5 py-4">
                                <form action="{{ route('admin.products.update-status', $product) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded-lg border border-slate-700 bg-slate-800 px-2 py-1 text-xs text-white" onchange="this.form.submit()">
                                        <option value="published" @selected($product->status === 'published')>Published</option>
                                        <option value="draft" @selected($product->status === 'draft')>Draft</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
@endif
@endsection
