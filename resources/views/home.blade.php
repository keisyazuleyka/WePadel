<x-app-layout>
    <!-- Hero Section -->
    <div class="relative min-h-[85vh] flex items-center bg-cover bg-center" style="background-image: linear-gradient(rgba(8, 13, 7, 0.4), rgba(8, 13, 7, 0.95)), url('https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=1920&auto=format&fit=crop');">
        <!-- Radial Glow -->
        <div class="absolute inset-0 bg-radial-gradient from-transparent to-padel-bg pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10 py-16 text-center">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-brand/10 text-brand border border-brand/20 uppercase tracking-widest mb-6 animate-pulse">
                THE ULTIMATE PADEL EXPERIENCE
            </span>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-6 leading-none">
                Elevate Your Game at <span class="text-brand">WePadel</span>
            </h1>
            <p class="max-w-2xl mx-auto text-base sm:text-lg text-gray-300 mb-10 font-light leading-relaxed">
                Experience the finest courts, seamless real-time booking, professional tournaments, and a premium community for players who demand the best.
            </p>

            <!-- Search Widget -->
            <div class="max-w-4xl mx-auto bg-padel-card/85 backdrop-blur-md p-4 sm:p-6 rounded-2xl border border-padel-border shadow-2xl">
                <form action="{{ route('courts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div>
                        <label class="block text-left text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Location</label>
                        <select name="search" class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            <option value="">All Locations</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Bogor">Bogor</option>
                            <option value="Tangerang">Tangerang</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-left text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Date</label>
                        <input type="date" name="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>
                    <div>
                        <label class="block text-left text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Prefer Time</label>
                        <select class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            <option>Any Time</option>
                            <option>Morning (06:00 - 12:00)</option>
                            <option>Afternoon (12:00 - 17:00)</option>
                            <option>Evening (17:00 - 23:00)</option>
                        </select>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl hover:bg-brand-dark transition duration-150 shadow-md">
                            Search Court
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Play Padel in 3 Easy Steps Section -->
    <div class="bg-[#050704] py-24 border-t border-padel-border/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Play Padel in 3 Easy Steps</h2>
                <p class="mt-4 text-padel-muted max-w-xl mx-auto">Our reservation platform is built to get you on the court as quickly as possible.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-padel-card p-8 rounded-2xl border border-padel-border/40 hover:border-brand/40 transition duration-300">
                    <div class="h-12 w-12 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-brand text-xl font-bold mb-6">1</div>
                    <h3 class="text-lg font-semibold text-white mb-2">Find a Venue</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Browse our collection of premium indoor and outdoor courts. Filter by location and availability.</p>
                </div>
                <!-- Step 2 -->
                <div class="bg-padel-card p-8 rounded-2xl border border-padel-border/40 hover:border-brand/40 transition duration-300">
                    <div class="h-12 w-12 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-brand text-xl font-bold mb-6">2</div>
                    <h3 class="text-lg font-semibold text-white mb-2">Book Instantly</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Select your preferred date and time slot. Pay securely using our streamlined checkout.</p>
                </div>
                <!-- Step 3 -->
                <div class="bg-padel-card p-8 rounded-2xl border border-padel-border/40 hover:border-brand/40 transition duration-300">
                    <div class="h-12 w-12 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-brand text-xl font-bold mb-6">3</div>
                    <h3 class="text-lg font-semibold text-white mb-2">Hit the Court</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Arrive at the court. Present your booking confirmation code and start playing immediately.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Venues Section -->
    <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-tight">Featured Venues</h2>
                <p class="mt-2 text-padel-muted text-sm">Experience the top-rated venues as rated by our community.</p>
            </div>
            <a href="{{ route('courts.index') }}" class="text-brand hover:underline font-semibold text-sm">View All Courts &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($courts as $court)
                <div class="bg-padel-card rounded-2xl overflow-hidden border border-padel-border/45 group hover:shadow-xl transition duration-300">
                    <div class="relative h-48 bg-gray-800 overflow-hidden">
                        <img src="{{ $court->primaryImage() ? (str_starts_with($court->primaryImage()->image_path, 'http') ? $court->primaryImage()->image_path : asset('storage/' . $court->primaryImage()->image_path)) : 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop' }}" 
                             alt="{{ $court->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 left-4 bg-brand text-black text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                            Rp {{ number_format($court->price_per_hour, 0) }}/hr
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-white group-hover:text-brand transition text-base line-clamp-1">{{ $court->name }}</h3>
                        </div>
                        <p class="text-xs text-gray-400 flex items-center mb-4">
                            <svg class="h-4 w-4 text-brand mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $court->location }}
                        </p>
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-6">{{ $court->description }}</p>
                        <a href="{{ route('courts.show', $court->id) }}" class="block text-center w-full bg-padel-input text-white group-hover:bg-brand group-hover:text-black font-semibold py-2.5 px-4 rounded-xl text-xs transition duration-200">
                            Book Court
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Elite Tournaments Section -->
    <div class="bg-[#050704] py-24 border-t border-padel-border/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Elite Tournaments</h2>
                <p class="mt-4 text-padel-muted max-w-xl mx-auto">Compete with the best. Register your team for our upcoming premium tournaments.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($tournaments as $tournament)
                    <div class="bg-padel-card rounded-2xl border border-padel-border/50 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase {{ $tournament->status === 'upcoming' ? 'bg-brand/10 text-brand border border-brand/20' : 'bg-gray-800 text-gray-400' }}">
                                    {{ $tournament->status }}
                                </span>
                                <span class="text-xs text-gray-500 font-semibold">{{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ $tournament->name }}</h3>
                            <p class="text-xs text-gray-400 leading-relaxed mb-6 line-clamp-3">{{ $tournament->description }}</p>
                            
                            <div class="border-t border-padel-border/25 pt-4 space-y-2 text-xs text-gray-400 mb-6">
                                <div class="flex justify-between">
                                    <span>Team Capacity:</span>
                                    <span class="text-white font-medium">{{ $tournament->max_teams }} Teams</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Registration Fee:</span>
                                    <span class="text-brand font-medium">Rp {{ number_format($tournament->registration_fee, 0) }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('tournaments.show', $tournament->id) }}" class="block text-center w-full bg-brand text-black font-semibold py-3 px-4 rounded-xl text-xs hover:bg-brand-dark transition">
                            View Standings & Register
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Become a WePadel Member Section -->
    <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-padel-card to-[#0d170c] rounded-3xl p-8 sm:p-16 border border-padel-border/50 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="max-w-xl">
                <span class="text-xs font-bold text-brand uppercase tracking-widest">MEMBERSHIPS</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight mt-4 mb-6 leading-tight">Become a WePadel Member</h2>
                <p class="text-sm text-gray-300 leading-relaxed mb-8">
                    Unlock exclusive benefits, advanced court bookings, special discount rates, free racket rentals, and access to VIP tournaments. Elevate your status today.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-gray-400">
                    <div class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Up to 30% Booking Discount</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Advanced Bookings up to 30 days</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Priority Tournament Registration</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>VIP Lounge & Locker Services</span>
                    </div>
                </div>
                <div class="mt-8 flex gap-4">
                    <a href="{{ route('memberships.index') }}" class="bg-brand text-black font-bold py-3 px-8 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                        Explore Plans
                    </a>
                </div>
            </div>
            
            <!-- Elite Card Mockup -->
            <div class="bg-[#050704] border border-brand/20 p-8 rounded-2xl w-full max-w-sm shadow-2xl relative overflow-hidden group">
                <!-- Glowing effect -->
                <div class="absolute -top-16 -right-16 h-36 w-36 rounded-full bg-brand/10 filter blur-3xl"></div>
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <span class="text-[10px] text-brand tracking-widest font-bold uppercase">GOLD STATUS</span>
                        <h4 class="text-xl font-bold text-white mt-1">Elite Pro Plan</h4>
                    </div>
                    <span class="text-xs text-gray-500 font-semibold">WePadel</span>
                </div>
                <div class="mb-10">
                    <div class="text-xs text-gray-500 mb-1">Price / Month</div>
                    <div class="text-3xl font-extrabold text-white">Rp 1.200.000</div>
                </div>
                <div class="border-t border-padel-border/40 pt-6 flex justify-between items-center text-[10px] text-gray-400">
                    <div>MEMBER SINCE {{ date('Y') }}</div>
                    <div>PLATINUM CARD</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
