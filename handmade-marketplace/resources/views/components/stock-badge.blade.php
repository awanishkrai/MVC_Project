@props(['status'])

@php
    $map = [
        'in_stock' => 'bg-emerald-100 text-emerald-800',
        'low_stock' => 'bg-amber-100 text-amber-800',
        'out_of_stock' => 'bg-stone-200 text-stone-600',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase '.($map[$status] ?? $map['in_stock'])]) }}>
    {{ str_replace('_', ' ', $status) }}
</span>
