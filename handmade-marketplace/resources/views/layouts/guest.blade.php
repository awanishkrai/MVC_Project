<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CraftNest')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-stone-50 to-orange-50 font-sans text-stone-800 antialiased">
    @include('partials.flash')

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6">
        <a href="{{ route('home') }}" class="mb-8 text-center">
            <span class="text-3xl font-bold text-amber-800">CraftNest</span>
            <p class="mt-1 text-sm text-stone-500">Handmade marketplace</p>
        </a>

        <div class="w-full max-w-md rounded-2xl border border-stone-200 bg-white p-8 shadow-lg">
            @yield('content')
        </div>
    </div>
</body>
</html>
