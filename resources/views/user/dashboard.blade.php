<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-brand/10 border border-brand/20 text-brand px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header Welcome Banner -->
            <div class="bg-gradient-to-r from-padel-card to-[#0d170c] rounded-2xl p-6 sm:p-10 border border-padel-border/50 mb-8 flex flex-col sm:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-xs text-gray-400 mt-1">Manage your court bookings, tournaments, and active memberships in one place.</p>
                </div>
                <a href="{{ route('courts.index') }}" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                    Book New Court
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content (Left 2 cols) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Upcoming Bookings -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                        <h2 class="text-lg font-bold text-white mb-6">Upcoming Bookings</h2>
                        @forelse($upcomingBookings as $booking)
                            <div class="bg-padel-input/30 p-5 rounded-xl border border-padel-border/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 last:mb-0">
                                <div>
                                    <div class="font-bold text-white text-base">{{ $booking->court->name }}</div>
                                    <div class="text-xs text-gray-400 mt-1 flex items-center gap-4">
                                        <span>Date: {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</span>
                                        <span>Times: 
                                            @foreach($booking->details as $det)
                                                {{ \Carbon\Carbon::parse($det->start_time)->format('H:i') }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="mt-2.5">
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                            {{ $booking->status === 'confirmed' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                                            {{ $booking->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
                                            {{ $booking->status === 'cancelled' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}
                                            {{ $booking->status === 'completed' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}
                                        ">
                                            {{ $booking->status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                    @if($booking->status === 'pending')
                                        @if(!$booking->payment)
                                            <a href="{{ route('user.bookings.payment', $booking->id) }}" class="bg-brand text-black font-semibold text-xs py-2 px-4 rounded-lg hover:bg-brand-dark transition text-center shrink-0">
                                                Pay Now
                                            </a>
                                        @endif
                                        <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                            @csrf
                                            <button type="submit" class="bg-red-500/10 hover:bg-red-500/25 text-red-400 font-semibold text-xs py-2 px-4 rounded-lg border border-red-500/20 transition">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500">No upcoming bookings. Get ready to hit the court!</p>
                        @endforelse
                    </div>

                    <!-- Booking History -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                        <h2 class="text-lg font-bold text-white mb-6">Booking History</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-padel-border/30">
                                <thead>
                                    <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider">
                                        <th class="pb-3">Court</th>
                                        <th class="pb-3">Date</th>
                                        <th class="pb-3 text-center">Total Price</th>
                                        <th class="pb-3 text-center">Status</th>
                                        <th class="pb-3 text-right">Payment</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-padel-border/20 text-xs">
                                    @forelse($bookingHistory as $bh)
                                        <tr class="text-gray-300 hover:bg-padel-input/10">
                                            <td class="py-3.5 font-bold text-white">{{ $bh->court->name }}</td>
                                            <td class="py-3.5">{{ \Carbon\Carbon::parse($bh->booking_date)->format('M d, Y') }}</td>
                                            <td class="py-3.5 text-center font-bold">Rp {{ number_format($bh->total_price, 0) }}</td>
                                            <td class="py-3.5 text-center">
                                                <span class="capitalize font-semibold">{{ $bh->status }}</span>
                                            </td>
                                            <td class="py-3.5 text-right">
                                                @if($bh->payment)
                                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider
                                                        {{ $bh->payment->status === 'approved' ? 'bg-green-500/10 text-green-400' : '' }}
                                                        {{ $bh->payment->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
                                                        {{ $bh->payment->status === 'rejected' ? 'bg-red-500/10 text-red-400' : '' }}
                                                    ">
                                                        {{ $bh->payment->status }}
                                                    </span>
                                                @else
                                                    @if($bh->status === 'pending')
                                                        <a href="{{ route('user.bookings.payment', $bh->id) }}" class="text-brand hover:underline">Upload Proof</a>
                                                    @else
                                                        <span class="text-gray-600">N/A</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-center text-gray-500">No booking logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $bookingHistory->links() }}
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Right 1 col) -->
                <div class="space-y-8">
                    <!-- Membership Status -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 relative overflow-hidden">
                        <h2 class="text-base font-bold text-white mb-4">Membership Tier</h2>
                        
                        @if($membershipDetails)
                            <div class="bg-gradient-to-r from-brand/10 to-[#0e1c0b] p-4 rounded-xl border border-brand/20 mb-4">
                                <div class="text-[10px] text-brand font-bold uppercase tracking-wider">ACTIVE MEMBERSHIP</div>
                                <div class="text-xl font-bold text-white mt-1">{{ $membershipDetails->name }}</div>
                                <div class="text-[10px] text-gray-400 mt-2">Expires on {{ \Carbon\Carbon::parse($membershipDetails->pivot->end_date)->format('M d, Y') }}</div>
                            </div>
                            
                            <h3 class="text-xs font-semibold text-white mb-2 uppercase tracking-wide">Your Tier Benefits</h3>
                            <ul class="space-y-2 text-[11px] text-gray-400">
                                @foreach($membershipDetails->benefits as $benefit)
                                    <li class="flex items-start space-x-1">
                                        <svg class="h-3.5 w-3.5 text-brand shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="bg-padel-input/30 p-4 rounded-xl border border-padel-border/20 mb-6 text-center">
                                <p class="text-xs text-gray-500 mb-4">You do not have an active membership plan.</p>
                                <a href="{{ route('memberships.index') }}" class="bg-brand text-black font-semibold text-xs py-2 px-4 rounded-lg hover:bg-brand-dark transition block w-full">
                                    Explore Plans
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Favorite Courts -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                        <h2 class="text-base font-bold text-white mb-4">Favorite Courts</h2>
                        <div class="space-y-4">
                            @foreach($favoriteCourts as $court)
                                <div class="flex items-center space-x-3 bg-padel-input/20 p-2.5 rounded-xl border border-padel-border/20">
                                    <img src="{{ $court->primaryImage() ? (str_starts_with($court->primaryImage()->image_path, 'http') ? $court->primaryImage()->image_path : asset('storage/' . $court->primaryImage()->image_path)) : 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop' }}" class="h-12 w-12 rounded-lg object-cover">
                                    <div class="flex-grow">
                                        <div class="text-xs font-bold text-white line-clamp-1">{{ $court->name }}</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">{{ $court->location }}</div>
                                    </div>
                                    <a href="{{ route('courts.show', $court->id) }}" class="text-brand hover:underline text-xs">&rarr;</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                        <h2 class="text-base font-bold text-white mb-4">Recent Activity</h2>
                        <div class="space-y-4">
                            @forelse($recentActivity as $act)
                                <div class="flex items-start space-x-2.5 text-xs">
                                    <div class="h-2 w-2 rounded-full mt-1.5 shrink-0
                                        {{ $act['type'] === 'booking' ? 'bg-brand' : 'bg-blue-400' }}">
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">{{ $act['title'] }}</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5 flex gap-2">
                                            <span>{{ \Carbon\Carbon::parse($act['date'])->diffForHumans() }}</span>
                                            <span class="capitalize text-brand">({{ $act['status'] }})</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-[11px] text-gray-500">No activity logged.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
