<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-brand/10 border border-brand/20 text-brand px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Membership Management</h1>
                    <p class="text-xs text-gray-400 mt-1">Manage subscription tiers, benefits list, discounts, and view subscribers log.</p>
                </div>
                <a href="{{ route('admin.memberships.subscribers') }}" class="bg-brand text-black font-bold py-2.5 px-4 rounded-xl text-xs hover:bg-brand-dark transition">
                    View Subscribers
                </a>
            </div>

            <!-- Membership Plan List Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($memberships as $membership)
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-white mb-2">{{ $membership->name }}</h2>
                            <div class="text-3xl font-extrabold text-brand mb-4">Rp {{ number_format($membership->price, 0) }}<span class="text-xs text-gray-500 font-normal"> / month</span></div>
                            <div class="text-xs text-gray-400 space-y-2 mb-6">
                                <p><span class="text-white font-medium">Discount Rate:</span> {{ number_format($membership->discount_percentage, 0) }}% Off Bookings</p>
                                <p><span class="text-white font-medium">Duration:</span> {{ $membership->duration_in_days }} Days</p>
                            </div>
                            
                            <h3 class="text-xs font-semibold text-white mb-2 uppercase tracking-wider">Benefits</h3>
                            <ul class="space-y-2 text-xs text-gray-400 mb-6">
                                @foreach($membership->benefits as $benefit)
                                    <li class="flex items-start space-x-1.5">
                                        <svg class="h-4 w-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <a href="{{ route('admin.memberships.edit', $membership->id) }}" class="block text-center w-full bg-padel-input hover:bg-brand hover:text-black font-bold py-2.5 px-4 rounded-xl text-xs transition">
                            Edit Plan Tiers
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
