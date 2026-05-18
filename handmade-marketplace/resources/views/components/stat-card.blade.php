@props(['label', 'value'])

<article class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm transition hover:shadow-md">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-stone-500">{{ $label }}</p>
            <p class="mt-1 text-2xl font-bold text-stone-900">{{ $value }}</p>
        </div>
        @isset($icon)
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                {{ $icon }}
            </div>
        @endisset
    </div>
</article>
