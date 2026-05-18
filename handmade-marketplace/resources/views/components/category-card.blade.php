@props(['category', 'active' => false])

<a href="{{ route('products.index', ['category' => $category->slug]) }}"
    @class([
        'group flex flex-col items-center rounded-3xl border p-5 text-center transition duration-300',
        'border-craft-400 bg-craft-50 shadow-craft ring-2 ring-craft-200' => $active,
        'border-stone-200/80 bg-white/90 hover:border-craft-300 hover:shadow-craft' => ! $active,
    ])>
    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-craft-100 text-3xl transition group-hover:scale-110">{{ $category->icon ?? '✨' }}</span>
    <h3 class="mt-3 font-display font-semibold text-stone-900">{{ $category->name }}</h3>
    <p class="mt-1 text-xs text-stone-500">{{ $category->products_count ?? 0 }} items</p>
</a>
