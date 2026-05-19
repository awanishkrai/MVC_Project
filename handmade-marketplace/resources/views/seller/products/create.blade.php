@extends('layouts.seller')
@section('title', 'Add Product — CraftNest')

@section('page-title', 'Products')
@section('content')
<div class="mx-auto max-w-3xl">
    <p class="cn-eyebrow">New listing</p>
    <h1 class="cn-page-header">Add handmade product</h1>
    <p class="mt-2 text-stone-600">Listing in <strong>{{ auth()->user()->shop->shop_name }}</strong></p>

    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="cn-card mt-8 space-y-5 p-6 sm:p-8">
        @csrf
        <div>
            <label class="cn-label" for="title">Product title</label>
            <input class="cn-input" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="cn-label" for="description">Description</label>
            <textarea class="cn-input" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="cn-label" for="price">Price ($)</label>
                <input class="cn-input" id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required>
                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="quantity">Quantity</label>
                <input class="cn-input" id="quantity" name="quantity" type="number" value="{{ old('quantity', 1) }}" required>
            </div>
        </div>
        <div>
            <label class="cn-label" for="category_id">Category</label>
            <select class="cn-input" id="category_id" name="category_id" required>
                <option value="">Select category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="cn-label" for="handmade_material">Handmade material</label>
                <input class="cn-input" id="handmade_material" name="handmade_material" value="{{ old('handmade_material') }}" placeholder="e.g. Sterling silver, clay">
            </div>
            <div>
                <label class="cn-label" for="delivery_time">Delivery time</label>
                <input class="cn-input" id="delivery_time" name="delivery_time" value="{{ old('delivery_time', '3–5 business days') }}">
            </div>
        </div>
        <div>
            <label class="cn-label" for="stock_status">Stock status</label>
            <select class="cn-input" id="stock_status" name="stock_status" required>
                <option value="in_stock" @selected(old('stock_status') === 'in_stock')>In stock</option>
                <option value="low_stock" @selected(old('stock_status') === 'low_stock')>Low stock</option>
                <option value="out_of_stock" @selected(old('stock_status') === 'out_of_stock')>Out of stock</option>
            </select>
        </div>
        <div>
            <label class="cn-label" for="image">Product image</label>
            <input class="cn-input file:mr-4 file:rounded-xl file:border-0 file:bg-craft-600 file:px-4 file:py-2 file:text-white" id="image" name="image" type="file" accept="image/*" required>
            @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="cn-btn-primary">Publish product</button>
            <a href="{{ route('seller.products.index') }}" class="cn-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
