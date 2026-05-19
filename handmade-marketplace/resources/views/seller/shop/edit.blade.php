@extends('layouts.seller')
@section('title', 'Edit Shop — CraftNest')

@section('page-title', 'Shop')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium uppercase tracking-wider text-amber-700">Shop settings</p>
            <h1 class="mt-1 text-3xl font-bold text-stone-900">Edit your shop</h1>
        </div>
        <x-button href="{{ route('seller.shop.index') }}" variant="secondary">← Back to dashboard</x-button>
    </div>

    <x-card title="Update shop information">
        <form method="POST" action="{{ route('seller.shop.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form-input label="Shop name" name="shop_name" :value="old('shop_name', $shop->shop_name)" required />

            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-stone-700">Current logo</label>
                @if ($shop->logo_url)
                    <img src="{{ $shop->logoUrl() }}" alt="{{ $shop->shop_name }}" class="h-20 w-20 rounded-2xl border border-stone-200 object-cover shadow-sm">
                @else
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-100 text-2xl font-bold text-amber-800">
                        {{ strtoupper(substr($shop->shop_name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <label for="logo" class="mb-1.5 block text-sm font-medium text-stone-700">Replace logo (optional)</label>
                <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full rounded-xl border border-dashed border-stone-300 bg-stone-50 px-3 py-4 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-amber-700 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                @error('logo') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="mb-1.5 block text-sm font-medium text-stone-700">Description</label>
                <textarea id="description" name="description" rows="5"
                    class="w-full rounded-xl border border-stone-300 px-3.5 py-2.5 text-sm">{{ old('description', $shop->description) }}</textarea>
                @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <x-form-input label="Location / address" name="location" :value="old('location', $shop->location)" />

            <div class="flex gap-3">
                <x-button type="submit" variant="primary">Save changes</x-button>
                <x-button href="{{ route('shops.show', $shop) }}" variant="secondary">View public page</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
