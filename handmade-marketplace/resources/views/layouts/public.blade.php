<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CraftNest — Handmade Marketplace')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700|dm-sans:400,500,600,700&display=swap" rel="stylesheet">
    @include('partials.theme-script')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="cn-pattern flex min-h-screen flex-col font-sans transition-colors duration-200 dark:bg-stone-950 dark:text-stone-200">
    @include('partials.public.navbar')
    @yield('category-strip')
    @include('partials.flash')

    <main class="flex-1 @yield('main-class')">
        @yield('content')
    </main>

    @include('partials.public.footer')
    <x-chatbot />
    @stack('scripts')
</body>
</html>
