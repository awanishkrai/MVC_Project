@extends('layouts.app')
@section('title', 'Seller Dashboard — CraftNest')

@section('content')
<div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
    <p class="text-sm font-medium text-amber-700">Seller Dashboard</p>
    <h1 class="mt-1 text-3xl font-bold text-stone-900">Hello, {{ $user->name }}!</h1>
    <p class="mt-3 text-stone-600">
        Manage your handmade shop and products from here.
    </p>

    <div class="mt-6 flex flex-wrap gap-3">
        @if ($user->shop)
            <a href="{{ route('shop.dashboard') }}" class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
                Manage my shop
            </a>
            <a href="{{ route('products.create') }}" class="rounded-lg border border-amber-700 px-4 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-50">
                Add product
            </a>
        @else
            <a href="{{ route('shop.create') }}" class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
                Create your shop
            </a>
        @endif
    </div>

    <div class="mt-6 rounded-lg bg-amber-50 p-4 text-sm text-amber-900">
        <strong>Your role:</strong> Seller &nbsp;|&nbsp;
        <strong>Shop:</strong> {{ $user->shop?->name ?? 'Not created yet' }}
    </div>
</div>
@endsection
