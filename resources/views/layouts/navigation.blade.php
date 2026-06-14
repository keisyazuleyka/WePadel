<nav class="bg-[#050704] border-b border-padel-border/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wider text-white">
                        We<span class="text-brand">Padel</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('courts.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-brand hover:border-brand transition duration-150 ease-in-out {{ request()->routeIs('courts.*') ? 'text-white border-brand' : '' }}">
                        Courts
                    </a>
                    <a href="{{ route('tournaments.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-brand hover:border-brand transition duration-150 ease-in-out {{ request()->routeIs('tournaments.*') ? 'text-white border-brand' : '' }}">
                        Tournaments
                    </a>
                    <a href="{{ route('memberships.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-brand hover:border-brand transition duration-150 ease-in-out {{ request()->routeIs('memberships.*') ? 'text-white border-brand' : '' }}">
                        Memberships
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown / Auth Actions -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @auth
                    <!-- Notifications Indicator (Real-Time notification preview) -->
                    <div class="relative">
                        <button class="p-1 text-gray-400 hover:text-brand transition duration-150 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-padel-bg"></span>
                            @endif
                        </button>
                    </div>

                    <!-- Portal Link -->
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-brand transition">Admin Dashboard</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-brand transition">My Dashboard</a>
                    @endif

                    <!-- Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-padel-card hover:text-white transition duration-150 ease-in-out">
                            <!-- Avatar or User Name -->
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="h-8 w-8 rounded-full mr-2 object-cover border border-brand/50">
                            @endif
                            <div>{{ auth()->user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-padel-card border border-padel-border/50 z-50">
                            <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-padel-input hover:text-brand">My Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-padel-input hover:text-brand">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-brand transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-brand text-black hover:bg-brand-dark px-4 py-2 rounded-md text-sm font-semibold transition">Book Court</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-brand hover:bg-padel-card transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
