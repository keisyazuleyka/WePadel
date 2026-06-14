<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WePadel') }} - Premium Booking</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-padel-bg selection:bg-brand selection:text-black">
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="text-3xl font-bold tracking-wider">
                    We<span class="text-brand">Padel</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-padel-card border border-padel-border/50 shadow-2xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
