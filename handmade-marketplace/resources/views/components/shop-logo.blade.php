@props([
    'shop',
    'size' => 'md',
])

@php
    $url = $shop->logoUrl();
    $name = $shop->shop_name ?? 'Shop';
    $sizes = [
        'sm' => 'h-11 w-11 rounded-lg text-lg',
        'md' => 'h-24 w-24 rounded-2xl text-3xl',
        'lg' => 'h-32 w-32 rounded-3xl text-5xl',
        'xl' => 'h-36 w-36 rounded-3xl text-5xl border-4 border-white/30 shadow-2xl ring-4 ring-white/20',
    ];
    $box = $sizes[$size] ?? $sizes['md'];
@endphp

@if ($url)
    <img src="{{ $url }}" alt="{{ $name }} logo" {{ $attributes->merge(['class' => $box.' object-cover']) }} loading="lazy">
@else
    <div {{ $attributes->merge(['class' => $box.' flex shrink-0 items-center justify-center bg-gradient-to-br from-craft-200 to-craft-400 font-bold text-white']) }} aria-hidden="true">
        {{ strtoupper(substr($name, 0, 1)) }}
    </div>
@endif
