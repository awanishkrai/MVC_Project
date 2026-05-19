@props(['product', 'distribution'])

@php
    $total = max(1, (int) $product->reviews_count);
    $average = (float) ($product->average_rating ?? 0);
@endphp

<div {{ $attributes->merge(['class' => 'cn-card p-6 sm:p-8']) }}>
    <div class="grid gap-8 sm:grid-cols-2">
        <div class="text-center sm:text-left">
            <p class="font-display text-5xl font-bold text-stone-900">{{ number_format($average, 1) }}</p>
            <x-rating-stars :rating="$average" size="lg" class="mt-2 justify-center sm:justify-start" />
            <p class="mt-2 text-sm text-stone-500">{{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}</p>
        </div>

        <div class="space-y-2">
            @foreach ($distribution as $star => $count)
                @php $percent = $product->reviews_count > 0 ? ($count / $product->reviews_count) * 100 : 0; @endphp
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-8 shrink-0 text-stone-500">{{ $star }}★</span>
                    <div class="h-2 flex-1 overflow-hidden rounded-full bg-stone-100">
                        <div class="h-full rounded-full bg-amber-400 transition-all" style="width: {{ $percent }}%"></div>
                    </div>
                    <span class="w-8 shrink-0 text-right text-stone-400">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
