@extends('layouts.public')
@section('title', 'Your Cart — CraftNest')

@section('content')
<div class="cn-container py-10">
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="cn-eyebrow">Shopping cart</p>
            <h1 class="font-display text-4xl font-bold text-stone-900">Your cart</h1>
            @if ($itemCount > 0)
                <p class="mt-2 text-stone-500">{{ $itemCount }} {{ Str::plural('item', $itemCount) }} ready for checkout</p>
            @endif
        </div>
        @if ($items->isNotEmpty())
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-medium text-stone-500 transition hover:text-red-600">Clear cart</button>
            </form>
        @endif
    </div>

    @if ($items->isEmpty())
        <x-empty-state title="Your cart is empty" description="Discover unique handmade pieces from independent makers across CraftNest." icon="🛒">
            <x-slot:action>
                <a href="{{ route('products.index') }}" class="cn-btn-primary">Browse marketplace</a>
            </x-slot:action>
        </x-empty-state>
    @else
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-4 lg:col-span-2">
                @foreach ($items as $item)
                    <x-cart-item-card :item="$item" />
                @endforeach
            </div>

            <x-checkout-summary
                :items="$items"
                :subtotal="$subtotal"
                :shipping="$shipping"
                :total="$total"
                :item-count="$itemCount"
            />
        </div>
    @endif
</div>
@endsection
