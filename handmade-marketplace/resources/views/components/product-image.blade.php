@props([
    'product',
    'placeholder' => '🧵',
    'imgClass' => 'h-full w-full object-cover',
    'fallbackClass' => 'flex h-full w-full items-center justify-center bg-gradient-to-br from-craft-100 to-stone-100',
])

@php
    $url = $product->imageUrl();
    $alt = $product->title ?? 'Product';
@endphp

@if ($url)
    <img src="{{ $url }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $imgClass]) }} loading="lazy">
@else
    <div {{ $attributes->merge(['class' => $fallbackClass]) }} aria-hidden="true">
        <span class="select-none text-4xl opacity-40 sm:text-5xl">{{ $placeholder }}</span>
    </div>
@endif
