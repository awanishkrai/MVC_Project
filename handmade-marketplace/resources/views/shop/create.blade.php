@extends('layouts.app')
@section('title', 'Create Shop — CraftNest')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-8 text-center sm:text-left">
        <p class="text-sm font-medium uppercase tracking-wider text-amber-700">Seller setup</p>
        <h1 class="mt-1 text-3xl font-bold text-stone-900">Open your handmade shop</h1>
        <p class="mt-2 text-stone-600">You can create one shop per account. Add your brand details below.</p>
    </div>

    <x-card title="Shop details" subtitle="This information appears on your public shop page.">
        <form method="POST" action="{{ route('shop.store') }}" enctype="multipart/form-data">
            @csrf

            <x-form-input label="Shop name" name="shop_name" :value="old('shop_name')" required />

            <div class="mb-4">
                <label for="logo" class="mb-1.5 block text-sm font-medium text-stone-700">Shop logo</label>
                <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full rounded-xl border border-dashed border-stone-300 bg-stone-50 px-3 py-4 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-amber-700 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-amber-800">
                <p class="mt-1 text-xs text-stone-500">JPEG, PNG or WebP. Max 2MB.</p>
                @error('logo') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="mb-1.5 block text-sm font-medium text-stone-700">Description</label>
                <textarea id="description" name="description" rows="5"
                    class="w-full rounded-xl border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <x-form-input label="Location / address" name="location" :value="old('location')" hint="City or region where your shop is based." />

            <x-button type="submit" variant="primary">Create shop</x-button>
        </form>
    </x-card>
</div>
@endsection
