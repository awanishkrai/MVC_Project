@props(['review', 'editable' => false])

<article {{ $attributes->merge(['class' => 'cn-card p-5 sm:p-6']) }}>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <p class="font-semibold text-stone-900">{{ $review->user->name }}</p>
            <p class="text-xs text-stone-400">{{ $review->created_at->format('M j, Y') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <x-rating-stars :rating="$review->rating" size="sm" />
            @if ($review->is_verified_purchase)
                <x-verified-badge />
            @endif
        </div>
    </div>

    @if ($review->title)
        <h3 class="mt-3 font-display font-semibold text-stone-900">{{ $review->title }}</h3>
    @endif

    <p class="mt-2 text-sm leading-relaxed text-stone-600">{{ $review->comment }}</p>

    @if ($editable)
        <div class="mt-4 flex flex-wrap gap-2 border-t border-stone-100 pt-4">
            <button type="button" class="text-sm font-medium text-craft-700 hover:underline" onclick="document.getElementById('edit-review-form').classList.toggle('hidden')">Edit review</button>
            <form action="{{ route('reviews.destroy', [$review->product, $review]) }}" method="POST" onsubmit="return confirm('Delete your review?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Delete</button>
            </form>
        </div>
    @endif
</article>
