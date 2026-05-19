@extends('layouts.seller')
@section('title', 'Products')
@section('page-title', 'Products')
@section('page-subtitle', 'Manage your handmade inventory')

@section('content')
@if ($products->isEmpty())
    <x-empty-state title="No products in your shop" description="List your first handmade item to appear on the marketplace.">
        <x-slot name="icon">📦</x-slot>
        <x-slot name="action"><a href="{{ route('seller.products.create') }}" class="cn-btn-primary">Add product</a></x-slot>
    </x-empty-state>
@else
    <div class="cn-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Stock</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($products as $product)
                        <tr class="hover:bg-craft-50/40">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" class="h-11 w-11 rounded-lg object-cover" alt="">
                                    @else
                                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-craft-100 text-lg">🧵</div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-stone-900">{{ $product->title }}</p>
                                        <p class="text-xs text-stone-400">Qty: {{ $product->quantity }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-stone-600">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-5 py-4 font-semibold text-craft-700">${{ number_format($product->price, 2) }}</td>
                            <td class="px-5 py-4"><x-stock-badge :status="$product->stock_status" /></td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800">{{ $product->status }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.show', $product) }}" target="_blank" class="cn-btn-ghost !py-1.5 !text-xs">View</a>
                                    <a href="{{ route('seller.products.edit', $product) }}" class="cn-btn-secondary !py-1.5 !text-xs">Edit</a>
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="rounded-lg px-2 py-1.5 text-xs text-red-600 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
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
