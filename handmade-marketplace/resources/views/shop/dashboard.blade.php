@extends('layouts.app')
@section('title', $shop->name . ' — Shop')

@section('content')
<div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-amber-700">My Shop</p>
            <h1 class="text-3xl font-bold text-stone-900">{{ $shop->name }}</h1>
            <p class="mt-2 text-stone-600">{{ $shop->description ?? 'No description yet.' }}</p>
            @if ($shop->location)
                <p class="mt-1 text-sm text-stone-500">📍 {{ $shop->location }}</p>
            @endif
        </div>
        <a href="{{ route('products.create') }}" class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
            + Add product
        </a>
    </div>

    <h2 class="mt-10 text-lg font-semibold text-stone-800">Your products ({{ $products->count() }})</h2>

    @if ($products->isEmpty())
        <p class="mt-4 text-sm text-stone-500">No products yet. Add your first handmade item!</p>
    @else
        <ul class="mt-4 divide-y divide-stone-100">
            @foreach ($products as $product)
                <li class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-medium text-stone-800">{{ $product->title }}</p>
                        <p class="text-sm text-stone-500">${{ number_format($product->price, 2) }} · Qty: {{ $product->quantity }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
