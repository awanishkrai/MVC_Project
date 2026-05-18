@props(['color' => 'amber'])

@php
    $colors = [
        'amber' => 'bg-amber-100 text-amber-900 ring-amber-200',
        'green' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
        'blue' => 'bg-sky-100 text-sky-800 ring-sky-200',
        'stone' => 'bg-stone-100 text-stone-700 ring-stone-200',
        'red' => 'bg-red-100 text-red-800 ring-red-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset '.($colors[$color] ?? $colors['amber'])]) }}>
    {{ $slot }}
</span>
