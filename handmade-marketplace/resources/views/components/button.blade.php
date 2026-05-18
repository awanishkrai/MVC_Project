@props(['variant' => 'primary', 'type' => 'button', 'href' => null])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2';
    $variants = [
        'primary' => 'bg-amber-700 text-white shadow-sm hover:bg-amber-800 focus:ring-amber-500',
        'secondary' => 'border border-stone-300 bg-white text-stone-700 hover:bg-stone-50 focus:ring-stone-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'ghost' => 'text-amber-800 hover:bg-amber-50 focus:ring-amber-400',
    ];
    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
