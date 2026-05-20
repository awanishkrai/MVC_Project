<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seller Panel — CraftNest')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700|dm-sans:400,500,600,700&display=swap" rel="stylesheet">
    @include('partials.theme-script')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-100 font-sans text-stone-800 antialiased transition-colors duration-200 dark:bg-stone-950 dark:text-stone-200">
    <div class="flex min-h-screen">
        @include('partials.seller.sidebar')

        <div class="flex flex-1 flex-col lg:pl-64">
            @include('partials.seller.topbar')
            @include('partials.flash')

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
