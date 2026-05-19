@props(['status'])

@php
    $map = [
        'pending' => 'bg-amber-100 text-amber-800 ring-amber-200',
        'processing' => 'bg-blue-100 text-blue-800 ring-blue-200',
        'shipped' => 'bg-violet-100 text-violet-800 ring-violet-200',
        'delivered' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize ring-1 ring-inset '.($map[$status] ?? $map['pending'])]) }}>
    {{ str_replace('_', ' ', $status) }}
</span>
