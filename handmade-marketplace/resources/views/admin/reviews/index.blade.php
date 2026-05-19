@extends('layouts.admin')
@section('title', 'Reviews')
@section('page-title', 'Review moderation')
@section('page-subtitle', 'Manage customer feedback across the marketplace')

@section('content')
<form method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-2xl border border-slate-800 bg-slate-900 p-4">
    <div class="min-w-[140px] flex-1">
        <label class="mb-1 block text-xs text-slate-400">Product</label>
        <input type="text" name="product" value="{{ request('product') }}" placeholder="Product name" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
    </div>
    <div class="min-w-[120px]">
        <label class="mb-1 block text-xs text-slate-400">Rating</label>
        <select name="rating" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
            <option value="">All</option>
            @foreach ([5,4,3,2,1] as $r)
                <option value="{{ $r }}" @selected(request('rating') == (string) $r)>{{ $r }} stars</option>
            @endforeach
        </select>
    </div>
    <div class="min-w-[140px] flex-1">
        <label class="mb-1 block text-xs text-slate-400">User</label>
        <input type="text" name="user" value="{{ request('user') }}" placeholder="Name or email" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
    </div>
    <button type="submit" class="rounded-lg bg-craft-600 px-4 py-2 text-sm font-semibold text-white hover:bg-craft-500">Filter</button>
    <a href="{{ route('admin.reviews.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-sm text-slate-300 hover:bg-slate-800">Reset</a>
</form>

@if ($reviews->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 px-8 py-16 text-center">
        <p class="text-4xl">⭐</p>
        <h3 class="mt-4 font-display text-xl font-semibold text-white">No reviews found</h3>
        <p class="mt-2 text-sm text-slate-400">Reviews from verified buyers will appear here.</p>
    </div>
@else
    <div class="space-y-4">
        @foreach ($reviews as $review)
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-white">{{ $review->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $review->user->email }} · {{ $review->created_at->format('M j, Y') }}</p>
                        <a href="{{ route('products.show', $review->product) }}" class="mt-2 inline-block text-sm text-craft-400 hover:text-craft-300">{{ $review->product->title }}</a>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-rating-stars :rating="$review->rating" size="sm" />
                        @if ($review->is_verified_purchase)
                            <x-verified-badge />
                        @endif
                    </div>
                </div>
                @if ($review->title)
                    <p class="mt-3 font-medium text-slate-200">{{ $review->title }}</p>
                @endif
                <p class="mt-2 text-sm text-slate-400">{{ $review->comment }}</p>
                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="mt-4" onsubmit="return confirm('Remove this review?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-300">Delete review</button>
                </form>
            </article>
        @endforeach
    </div>
    <div class="mt-6">{{ $reviews->links() }}</div>
@endif
@endsection
