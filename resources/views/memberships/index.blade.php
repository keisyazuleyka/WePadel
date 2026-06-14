<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white">WePadel Memberships</h1>
                <p class="mt-4 text-padel-muted max-w-xl mx-auto">Elevate your play with exclusive benefits, priority court bookings, and heavy reservation discounts.</p>
            </div>

            <!-- Pricing Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch max-w-5xl mx-auto">
                @foreach($memberships as $membership)
                    @php
                        // Check if user currently has this plan
                        $isCurrent = auth()->check() && auth()->user()->activeMembership() && auth()->user()->activeMembership()->id === $membership->id;
                    @endphp
                    <div class="bg-padel-card rounded-3xl p-8 border flex flex-col justify-between transition duration-300 shadow-xl relative overflow-hidden
                        {{ $isCurrent ? 'border-brand ring-2 ring-brand/35' : 'border-padel-border/60 hover:border-brand/40' }}">
                        
                        @if($isCurrent)
                            <div class="absolute top-0 right-0 bg-brand text-black text-[9px] font-extrabold px-3 py-1.5 rounded-bl-xl uppercase tracking-wider">
                                Current Active Plan
                            </div>
                        @endif

                        <div>
                            <!-- Header -->
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-white mb-2">{{ $membership->name }}</h2>
                                <p class="text-xs text-gray-400">Recurring 30-day membership access</p>
                            </div>

                            <!-- Price -->
                            <div class="mb-8">
                                <span class="text-4xl font-extrabold text-white">Rp {{ number_format($membership->price, 0) }}</span>
                                <span class="text-xs text-padel-muted">/ month</span>
                                @if($membership->discount_percentage > 0)
                                    <span class="block text-brand text-xs font-semibold mt-2">{{ number_format($membership->discount_percentage, 0) }}% Off Court Bookings</span>
                                @endif
                            </div>

                            <hr class="border-padel-border/30 my-6">

                            <!-- Benefits List -->
                            <ul class="space-y-4 mb-8 text-xs text-gray-300">
                                @foreach($membership->benefits as $benefit)
                                    <li class="flex items-start space-x-2">
                                        <svg class="h-4 w-4 text-brand shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Purchase Button -->
                        <div>
                            @auth
                                @if($isCurrent)
                                    <button disabled class="w-full bg-padel-border/20 text-gray-500 font-bold py-3.5 px-6 rounded-xl text-xs cursor-not-allowed">
                                        Active
                                    </button>
                                @else
                                    <form action="{{ route('user.memberships.purchase', $membership->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl text-xs hover:bg-brand-dark transition duration-150 shadow-md">
                                            Choose Plan
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block text-center w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl text-xs hover:bg-brand-dark transition duration-150 shadow-md">
                                    Sign In to Subscribe
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
