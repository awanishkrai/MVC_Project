@props(['title' => null, 'subtitle' => null, 'padding' => true])

<article {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm shadow-stone-200/50']) }}>
    @if ($title || $subtitle)
        <header class="border-b border-stone-100 px-6 py-4">
            @if ($title)
                <h2 class="text-lg font-semibold text-stone-900">{{ $title }}</h2>
            @endif
            @if ($subtitle)
                <p class="mt-0.5 text-sm text-stone-500">{{ $subtitle }}</p>
            @endif
        </header>
    @endif
    <section @class(['px-6 py-5' => $padding])>
        {{ $slot }}
    </section>
</article>
