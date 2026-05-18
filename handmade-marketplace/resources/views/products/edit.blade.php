@extends('layouts.app')
@section('title', 'Edit ' . $product->title)

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="cn-page-header">Edit product</h1>
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="cn-card mt-8 space-y-5 p-6 sm:p-8">
        @csrf @method('PUT')
        <div>
            <label class="cn-label" for="title">Title</label>
            <input class="cn-input" id="title" name="title" value="{{ old('title', $product->title) }}" required>
        </div>
        <div>
            <label class="cn-label" for="description">Description</label>
            <textarea class="cn-input" id="description" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label class="cn-label" for="price">Price</label><input class="cn-input" id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required></div>
            <div><label class="cn-label" for="quantity">Quantity</label><input class="cn-input" id="quantity" name="quantity" type="number" value="{{ old('quantity', $product->quantity) }}" required></div>
        </div>
        <div>
            <label class="cn-label" for="category_id">Category</label>
            <select class="cn-input" id="category_id" name="category_id" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label class="cn-label" for="handmade_material">Material</label><input class="cn-input" name="handmade_material" value="{{ old('handmade_material', $product->handmade_material) }}"></div>
            <div><label class="cn-label" for="delivery_time">Delivery</label><input class="cn-input" name="delivery_time" value="{{ old('delivery_time', $product->delivery_time) }}"></div>
        </div>
        <div>
            <label class="cn-label" for="stock_status">Stock</label>
            <select class="cn-input" name="stock_status" required>
                @foreach (['in_stock', 'low_stock', 'out_of_stock'] as $s)
                    <option value="{{ $s }}" @selected(old('stock_status', $product->stock_status) === $s)>{{ str_replace('_', ' ', $s) }}</option>
                @endforeach
            </select>
        </div>
        @if ($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" class="h-32 w-32 rounded-2xl object-cover">
        @endif
        <div>
            <label class="cn-label" for="image">Replace image (optional)</label>
            <input class="cn-input" id="image" name="image" type="file" accept="image/*">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="cn-btn-primary">Save changes</button>
            <a href="{{ route('products.manage') }}" class="cn-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
