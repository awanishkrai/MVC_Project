@extends('layouts.app')
@section('title', 'Create Shop — CraftNest')

@section('content')
<div class="mx-auto max-w-lg rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
    <h1 class="text-2xl font-bold text-stone-900">Open your shop</h1>
    <p class="mt-2 text-sm text-stone-500">Tell buyers about your handmade brand.</p>

    <form method="POST" action="{{ route('shop.store') }}" class="mt-6">
        @csrf
        @include('partials.input', ['label' => 'Shop Name', 'name' => 'name', 'required' => true])

        <div class="mb-4">
            <label for="description" class="mb-1 block text-sm font-medium text-stone-700">Description</label>
            <textarea id="description" name="description" rows="4"
                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm">{{ old('description') }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        @include('partials.input', ['label' => 'Location', 'name' => 'location'])

        <button type="submit" class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
            Create shop
        </button>
    </form>
</div>
@endsection
