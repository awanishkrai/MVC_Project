<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CraftNest')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700|dm-sans:400,500,600,700&display=swap" rel="stylesheet">
    @include('partials.theme-script')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-stone-50 font-sans text-stone-800 antialiased dark:bg-stone-950 dark:text-stone-200">
    @include('partials.flash')

    <div class="relative flex min-h-screen">
        {{-- Hero panel --}}
        <div class="relative hidden w-1/2 overflow-hidden lg:flex lg:flex-col">
            <div class="absolute inset-0 bg-gradient-to-br from-craft-800 via-craft-700 to-amber-900"></div>
            <div class="absolute inset-0 opacity-40" style="background: radial-gradient(ellipse at 30% 20%, rgba(255,255,255,0.2) 0%, transparent 55%);"></div>
            <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -bottom-16 left-10 h-64 w-64 rounded-full bg-amber-400/20 blur-3xl"></div>

            <div class="relative flex flex-1 flex-col justify-between p-12">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-lg font-bold text-white backdrop-blur-md">CN</span>
                    <span class="font-display text-2xl font-bold text-white">Craft<span class="text-craft-200">Nest</span></span>
                </a>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-craft-200">Handmade marketplace</p>
                    <h2 class="mt-4 max-w-md font-display text-4xl font-bold leading-tight text-white">
                        Where makers meet buyers who care about craft.
                    </h2>
                    <p class="mt-4 max-w-sm text-craft-100/90">Discover unique jewelry, pottery, art, and gifts from independent artisans — curated like Etsy, built for real sellers.</p>
                </div>

                <p class="text-sm text-craft-200/70">&copy; {{ date('Y') }} CraftNest. All rights reserved.</p>
            </div>
        </div>

        {{-- Form panel --}}
        <div class="flex flex-1 flex-col">
            <div class="flex items-center justify-between px-6 py-5 sm:px-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 lg:hidden">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-craft-500 to-craft-800 text-sm font-bold text-white shadow-md">CN</span>
                    <span class="font-display text-xl font-bold text-stone-900 dark:text-white">Craft<span class="text-craft-600">Nest</span></span>
                </a>
                <div class="ml-auto flex items-center gap-3">
                    @include('partials.theme-toggle')
                    <a href="{{ route('home') }}" class="hidden text-sm font-medium text-stone-500 hover:text-craft-700 dark:text-stone-400 dark:hover:text-craft-300 sm:inline">Back to shop</a>
                </div>
            </div>

            <div class="flex flex-1 items-center justify-center px-6 pb-12 sm:px-10">
                <div class="w-full max-w-md">
                    <div class="rounded-3xl border border-stone-200/80 bg-white/80 p-8 shadow-craft backdrop-blur-xl dark:border-stone-700/80 dark:bg-stone-900/80 dark:shadow-none sm:p-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
