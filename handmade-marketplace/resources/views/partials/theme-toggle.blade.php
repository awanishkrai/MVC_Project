@props(['variant' => 'light'])

<button type="button" data-theme-toggle
    @class([
        'inline-flex h-9 w-9 items-center justify-center rounded-full transition focus:outline-none focus:ring-2 focus:ring-offset-2',
        'border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 focus:ring-craft-300 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-300 dark:hover:bg-stone-700 dark:focus:ring-craft-600' => $variant === 'light',
        'border border-slate-700 bg-slate-800 text-slate-300 hover:bg-slate-700 focus:ring-craft-500' => $variant === 'dark',
        'border border-stone-200/80 bg-stone-100 text-stone-600 hover:bg-stone-200 focus:ring-craft-300 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-300' => $variant === 'panel',
    ])
    title="Toggle theme" aria-label="Toggle dark mode">
    <svg data-theme-icon="sun" class="h-4 w-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    <svg data-theme-icon="moon" class="hidden h-4 w-4 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
</button>
