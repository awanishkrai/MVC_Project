@props(['title', 'description' => null])

<section class="flex flex-col items-center rounded-3xl border-2 border-dashed border-craft-200/80 bg-gradient-to-b from-white to-craft-50/50 px-8 py-16 text-center">
    <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-craft-100 text-4xl shadow-inner">
        {{ $icon ?? '✨' }}
    </div>
    <h3 class="font-display text-xl font-semibold text-stone-900">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 max-w-md text-sm leading-relaxed text-stone-500">{{ $description }}</p>
    @endif
    @if (isset($action))
        <div class="mt-6">{{ $action }}</div>
    @endif
</section>
