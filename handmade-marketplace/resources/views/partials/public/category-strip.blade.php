@php
    $navCategories = \App\Models\Category::orderBy('name')->take(8)->get();
@endphp
@if ($navCategories->isNotEmpty() && !request()->routeIs('seller.*', 'admin.*'))
<nav class="border-b border-stone-100 bg-white/80">
    <div class="cn-container flex gap-2 overflow-x-auto py-2.5 scrollbar-hide">
        <a href="{{ route('products.index') }}" @class(['shrink-0 rounded-full px-3 py-1.5 text-xs font-semibold transition', 'bg-craft-700 text-white' => !request('category'), 'bg-stone-100 text-stone-600 hover:bg-craft-50' => request('category')])>All</a>
        @foreach ($navCategories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                @class(['shrink-0 rounded-full px-3 py-1.5 text-xs font-semibold transition', 'bg-craft-700 text-white' => request('category') === $cat->slug, 'bg-stone-100 text-stone-600 hover:bg-craft-50' => request('category') !== $cat->slug])>
                {{ $cat->icon }} {{ $cat->name }}
            </a>
        @endforeach
    </div>
</nav>
@endif
