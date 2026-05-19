@props(['href', 'active' => false, 'icon' => '•', 'badge' => null, 'theme' => 'light'])

@php
    $light = $theme === 'light';
    $classes = $active
        ? ($light ? 'bg-craft-100 text-craft-900 font-semibold' : 'bg-slate-800 text-white font-semibold')
        : ($light ? 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' : 'text-slate-400 hover:bg-slate-800 hover:text-white');
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "flex items-center justify-between gap-3 rounded-xl px-3 py-2.5 text-sm transition {$classes}"]) }}>
    <span class="flex items-center gap-3">
        <span class="text-base">{{ $icon }}</span>
        <span>{{ $slot }}</span>
    </span>
    @if ($badge)
        <span class="rounded-full bg-stone-200 px-2 py-0.5 text-[10px] font-bold uppercase {{ $light ? 'text-stone-500' : 'bg-slate-700 text-slate-400' }}">{{ $badge }}</span>
    @endif
</a>
