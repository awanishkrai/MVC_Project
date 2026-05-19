@props([
    'rating' => 0,
    'max' => 5,
    'size' => 'md',
    'interactive' => false,
    'name' => 'rating',
    'value' => null,
])

@php
    $sizes = [
        'sm' => 'text-sm gap-0.5',
        'md' => 'text-lg gap-0.5',
        'lg' => 'text-2xl gap-1',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $displayRating = (float) $rating;
    $selected = (int) ($value ?? round($displayRating));
@endphp

@if ($interactive)
    <div {{ $attributes->merge(['class' => 'flex flex-wrap '.$sizeClass]) }}>
        @for ($star = 1; $star <= $max; $star++)
            <label class="cursor-pointer transition hover:scale-110">
                <input type="radio" name="{{ $name }}" value="{{ $star }}" class="peer sr-only" @checked(old($name, $selected) == $star) @required($loop->first)>
                <span class="text-amber-300 peer-checked:text-amber-500 hover:text-amber-400">★</span>
            </label>
        @endfor
    </div>
@else
    <div {{ $attributes->merge(['class' => 'inline-flex items-center '.$sizeClass]) }} aria-label="{{ number_format($displayRating, 1) }} out of {{ $max }} stars">
        @for ($star = 1; $star <= $max; $star++)
            <span @class($displayRating >= $star - 0.25 ? 'text-amber-400' : 'text-stone-300')>
                {{ $displayRating >= $star ? '★' : '☆' }}
            </span>
        @endfor
    </div>
@endif
