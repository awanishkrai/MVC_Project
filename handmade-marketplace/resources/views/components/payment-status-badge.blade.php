@props(['status'])

@php
    $map = [
        'pending' => 'bg-amber-100 text-amber-800',
        'paid' => 'bg-emerald-100 text-emerald-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize '.($map[$status] ?? $map['pending'])]) }}>
    {{ $status }}
</span>
