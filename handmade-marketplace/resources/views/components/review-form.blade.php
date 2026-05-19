@props(['product', 'review' => null, 'formId' => 'review-form'])

@php
    $isEdit = $review !== null;
    $action = $isEdit
        ? route('reviews.update', [$product, $review])
        : route('reviews.store', $product);
@endphp

<form id="{{ $formId }}" action="{{ $action }}" method="POST" {{ $attributes->merge(['class' => 'cn-card space-y-4 p-6']) }}>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <h3 class="font-display text-lg font-bold text-stone-900">{{ $isEdit ? 'Edit your review' : 'Write a review' }}</h3>
    <p class="text-sm text-stone-500">Share your experience with this handmade piece.</p>

    <div>
        <span class="cn-label">Your rating</span>
        <x-rating-stars interactive name="rating" :value="old('rating', $review?->rating ?? 5)" class="mt-1" />
        @error('rating')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="cn-label" for="{{ $formId }}-title">Title (optional)</label>
        <input type="text" id="{{ $formId }}-title" name="title" value="{{ old('title', $review?->title) }}" class="cn-input" maxlength="120" placeholder="Summarize your experience">
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="cn-label" for="{{ $formId }}-comment">Your review</label>
        <textarea id="{{ $formId }}-comment" name="comment" rows="4" class="cn-input" required placeholder="What did you love about this product?">{{ old('comment', $review?->comment) }}</textarea>
        @error('comment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex flex-wrap gap-2">
        <button type="submit" class="cn-btn-primary">{{ $isEdit ? 'Update review' : 'Submit review' }}</button>
        @if ($isEdit)
            <button type="button" class="cn-btn-secondary" onclick="document.getElementById('{{ $formId }}').classList.add('hidden')">Cancel</button>
        @endif
    </div>
</form>
