@extends('layouts.app')
@section('title', 'CraftNest — Handmade Marketplace')

@section('content')
<section class="cn-card mb-16 overflow-hidden">
    <div class="relative min-h-[420px] cn-hero-gradient">
        <div class="absolute inset-0 opacity-40" style="background: radial-gradient(ellipse at 30% 20%, rgba(255,255,255,0.2) 0%, transparent 50%);"></div>
        <div class="relative flex h-full flex-col items-center justify-center px-6 py-20 text-center">
            <p class="cn-eyebrow !text-craft-200">INT221 · Laravel MVC</p>
            <h1 class="max-w-3xl font-display text-5xl font-bold leading-tight text-white sm:text-6xl">
                Where handmade<br><span class="text-craft-200">finds its home</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg text-craft-100">CraftNest connects makers and lovers of unique goods — jewelry, pottery, art & more.</p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index') }}" class="cn-btn-primary !px-8 !py-3 shadow-craft-lg">Explore marketplace</a>
                @guest
                    <a href="{{ route('register') }}" class="cn-btn !rounded-2xl border-2 border-white/40 bg-white/10 px-8 py-3 text-white backdrop-blur hover:bg-white/20">Start selling</a>
                @endguest
            </div>
        </div>
    </div>
</section>

<section class="mb-16">
    <h2 class="text-center font-display text-3xl font-bold">Why CraftNest?</h2>
    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @foreach ([
            ['🎨', 'Authentic makers', 'Every shop is run by a real artisan.'],
            ['🌿', 'Sustainable craft', 'Materials and stories behind each piece.'],
            ['💛', 'Community first', 'Built for university MVC — clear & explainable.'],
        ] as [$icon, $title, $desc])
            <article class="cn-card-hover p-8 text-center">
                <span class="text-4xl">{{ $icon }}</span>
                <h3 class="mt-4 font-display text-xl font-semibold">{{ $title }}</h3>
                <p class="mt-2 text-sm text-stone-500">{{ $desc }}</p>
            </article>
        @endforeach
    </div>
</section>

<section class="cn-card cn-hero-gradient p-10 text-center text-white">
    <h2 class="font-display text-2xl font-bold">Ready to discover?</h2>
    <p class="mt-2 text-craft-100">Browse hundreds of handmade listings from our seller community.</p>
    <a href="{{ route('products.index') }}" class="cn-btn mt-6 inline-flex bg-white text-craft-800 hover:bg-craft-50">Shop now →</a>
</section>
@endsection
