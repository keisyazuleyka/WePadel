<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WePadel') }} - Premium Padel Court Bookings</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-padel-bg text-gray-100 selection:bg-brand selection:text-black">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-padel-card border-b border-padel-border/50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Premium Footer -->
            <footer class="bg-[#050704] border-t border-padel-border/30 text-padel-muted py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <span class="text-2xl font-bold text-white tracking-wider">We<span class="text-brand">Padel</span></span>
                            <p class="mt-4 text-sm leading-relaxed text-gray-400">
                                Experience the finest padel venues, seamless court bookings, elite tournaments, and a premium community.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white tracking-wider uppercase">Platform</h3>
                            <ul class="mt-4 space-y-2 text-sm">
                                <li><a href="{{ route('courts.index') }}" class="hover:text-brand transition duration-150">Browse Courts</a></li>
                                <li><a href="{{ route('tournaments.index') }}" class="hover:text-brand transition duration-150">Tournaments</a></li>
                                <li><a href="{{ route('memberships.index') }}" class="hover:text-brand transition duration-150">Memberships</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white tracking-wider uppercase">Support</h3>
                            <ul class="mt-4 space-y-2 text-sm">
                                <li><a href="#" class="hover:text-brand transition duration-150">Contact Us</a></li>
                                <li><a href="#" class="hover:text-brand transition duration-150">Rules & Regulations</a></li>
                                <li><a href="#" class="hover:text-brand transition duration-150">FAQ</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white tracking-wider uppercase">Newsletter</h3>
                            <p class="mt-4 text-sm text-gray-400">Subscribe for tournament updates and exclusive offers.</p>
                            <form action="#" class="mt-4 flex max-w-md">
                                <input type="email" required placeholder="Email address" class="w-full min-w-0 appearance-none rounded-l-md border-0 bg-padel-input px-3 py-2 text-white placeholder-gray-500 shadow-sm focus:ring-1 focus:ring-brand focus:border-brand sm:text-sm">
                                <button type="submit" class="flex items-center justify-center rounded-r-md bg-brand px-4 py-2 text-sm font-semibold text-black hover:bg-brand-dark focus:outline-none transition">Join</button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-padel-border/20 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                        <p>&copy; {{ date('Y') }} WePadel. All rights reserved.</p>
                        <div class="flex space-x-6 mt-4 md:mt-0">
                            <a href="#" class="hover:text-brand">Privacy Policy</a>
                            <a href="#" class="hover:text-brand">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
