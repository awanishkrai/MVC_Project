@props(['title', 'subtitle' => null])

<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        @if (isset($eyebrow))
            <p class="cn-eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1 class="cn-page-header">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-stone-500">{{ $subtitle }}</p>
        @endif
    </div>
    @if (isset($actions))
        <div class="flex flex-wrap gap-2">{{ $actions }}</div>
    @endif
</div>
