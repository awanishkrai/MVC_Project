@extends('layouts.app')
@section('title', 'Categories — Admin')

@section('content')
<div class="mb-8 flex flex-wrap items-center justify-between gap-4">
    <div>
        <p class="cn-eyebrow">Module 4</p>
        <h1 class="cn-page-header">Categories</h1>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="cn-btn-primary">+ Add category</a>
</div>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($categories as $category)
        <article class="cn-card-hover p-6">
            <span class="text-4xl">{{ $category->icon ?? '✨' }}</span>
            <h2 class="mt-3 font-display text-xl font-semibold">{{ $category->name }}</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $category->products_count }} products</p>
            <p class="mt-2 text-xs text-stone-400">/{{ $category->slug }}</p>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="cn-btn-secondary text-xs">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete category?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="rounded-xl border border-red-200 px-3 py-2 text-xs text-red-600">Delete</button>
                </form>
            </div>
        </article>
    @empty
        <x-empty-state title="No categories" class="col-span-full">
            <x-slot name="action"><a href="{{ route('admin.categories.create') }}" class="cn-btn-primary">Create first</a></x-slot>
        </x-empty-state>
    @endforelse
</div>
@endsection
