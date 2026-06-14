<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Booking Management</h1>
                    <p class="text-xs text-gray-400 mt-1">Review user reservations, inspect bank transfer receipts, and authorize bookings.</p>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-2 mb-6 text-xs font-semibold">
                <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2.5 rounded-xl border transition
                    {{ !$status ? 'bg-brand text-black border-brand' : 'bg-padel-card text-gray-300 border-padel-border/50 hover:border-brand/40' }}">
                    All Bookings
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="px-4 py-2.5 rounded-xl border transition
                    {{ $status === 'pending' ? 'bg-brand text-black border-brand' : 'bg-padel-card text-gray-300 border-padel-border/50 hover:border-brand/40' }}">
                    Pending Approval
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="px-4 py-2.5 rounded-xl border transition
                    {{ $status === 'confirmed' ? 'bg-brand text-black border-brand' : 'bg-padel-card text-gray-300 border-padel-border/50 hover:border-brand/40' }}">
                    Confirmed
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="px-4 py-2.5 rounded-xl border transition
                    {{ $status === 'cancelled' ? 'bg-brand text-black border-brand' : 'bg-padel-card text-gray-300 border-padel-border/50 hover:border-brand/40' }}">
                    Cancelled
                </a>
            </div>

            <!-- Bookings List Table -->
            <div class="bg-padel-card rounded-2xl border border-padel-border/50 overflow-hidden">
                <table class="min-w-full divide-y divide-padel-border/30">
                    <thead>
                        <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider bg-[#0a1009]/50">
                            <th class="py-4 px-6">User</th>
                            <th class="py-4 px-6">Court</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6 text-center">Amount Due</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Receipt Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-padel-border/20 text-sm">
                        @forelse($bookings as $booking)
                            <tr class="text-gray-300 hover:bg-padel-input/10">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-white">{{ $booking->user->name }}</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">{{ $booking->user->email }}</div>
                                </td>
                                <td class="py-4 px-6 font-semibold">{{ $booking->court->name }}</td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                                <td class="py-4 px-6 text-center font-bold text-white">Rp {{ number_format($booking->total_price, 0) }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="capitalize font-semibold">{{ $booking->status }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($booking->payment)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                            {{ $booking->payment->status === 'approved' ? 'bg-green-500/10 text-green-400' : '' }}
                                            {{ $booking->payment->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
                                            {{ $booking->payment->status === 'rejected' ? 'bg-red-500/10 text-red-400' : '' }}
                                        ">
                                            {{ $booking->payment->status }}
                                        </span>
                                    @else
                                        <span class="text-gray-600">Unsubmitted</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-brand hover:underline font-semibold">Inspect &rarr;</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
