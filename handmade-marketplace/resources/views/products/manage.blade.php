@extends('layouts.app')
@section('title', 'My Products — CraftNest')

@section('content')
<div class="mb-8 flex flex-wrap items-center justify-between gap-4">
    <div>
        <p class="cn-eyebrow">Inventory</p>
        <h1 class="cn-page-header">My products</h1>
    </div>
    <a href="{{ route('products.create') }}" class="cn-btn-primary">+ Add product</a>
</div>

@if ($products->isEmpty())
    <x-empty-state title="No products yet" description="Create your first listing and reach buyers on CraftNest.">
        <x-slot name="icon">📦</x-slot>
        <x-slot name="action"><a href="{{ route('products.create') }}" class="cn-btn-primary">Add product</a></x-slot>
    </x-empty-state>
@else
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            <article class="cn-card overflow-hidden">
                <div class="aspect-video bg-craft-50">
                    @if ($product->imageUrl())
                        <img src="{{ $product->imageUrl() }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs text-craft-600">{{ $product->category?->name }}</p>
                    <h3 class="font-display font-semibold">{{ $product->title }}</h3>
                    <p class="mt-1 font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="cn-btn-ghost flex-1 text-center text-xs">View</a>
                        <a href="{{ route('products.edit', $product) }}" class="cn-btn-secondary flex-1 text-center text-xs">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-xl border border-red-200 px-3 py-2 text-xs text-red-600 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
    <div class="mt-8">{{ $products->links() }}</div>
@endif
@endsection
