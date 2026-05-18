<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CraftNest')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700|dm-sans:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="cn-pattern min-h-screen font-sans">
    @include('partials.navbar')
    @include('partials.flash')

    <main class="cn-container py-8 lg:py-10">
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-stone-200/80 bg-white/70 py-10 backdrop-blur-sm">
        <div class="cn-container flex flex-col items-center justify-between gap-4 sm:flex-row">
            <div class="flex items-center gap-2">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-craft-600 to-craft-800 text-sm font-bold text-white">CN</span>
                <div>
                    <p class="font-display font-semibold text-stone-900">CraftNest</p>
                    <p class="text-xs text-stone-500">Handmade with heart</p>
                </div>
            </div>
            <div class="flex gap-6 text-sm text-stone-600">
                <a href="{{ route('products.index') }}" class="hover:text-craft-700">Browse</a>
                <a href="{{ route('home') }}" class="hover:text-craft-700">Home</a>
            </div>
        </div>
    </footer>
</body>
</html>
