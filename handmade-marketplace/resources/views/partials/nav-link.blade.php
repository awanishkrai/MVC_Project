<a href="{{ $href }}"
    @class([
        'rounded-lg px-3 py-2 text-sm font-medium transition',
        'bg-amber-100 text-amber-900' => $active,
        'text-stone-600 hover:bg-stone-100 hover:text-amber-800' => ! $active,
    ])>
    {{ $label }}
</a>
