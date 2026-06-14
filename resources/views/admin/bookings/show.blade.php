<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Inspect Booking</h1>
                    <p class="text-xs text-gray-400 mt-1">Verify bank transfer screenshots and authorize user time slots.</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs text-brand hover:underline font-semibold">&larr; Back to Bookings</a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-brand/10 border border-brand/20 text-brand px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Details Summary (Left 2 cols) -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Booking details -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 space-y-4 text-xs text-gray-300">
                        <h2 class="text-base font-bold text-white mb-2">Reservation Info</h2>
                        <div class="flex justify-between">
                            <span>User:</span>
                            <span class="text-white font-medium">{{ $booking->user->name }} ({{ $booking->user->email }})</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Court:</span>
                            <span class="text-white font-medium">{{ $booking->court->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Booking Date:</span>
                            <span class="text-white font-medium">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Time Slots:</span>
                            <span class="text-white font-medium">
                                @foreach($booking->details as $det)
                                    {{ \Carbon\Carbon::parse($det->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($det->end_time)->format('H:i') }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                        <hr class="border-padel-border/30">
                        <div class="flex justify-between text-sm">
                            <span class="text-white font-bold">Total Price:</span>
                            <span class="text-brand font-extrabold">Rp {{ number_format($booking->total_price, 0) }}</span>
                        </div>
                    </div>

                    <!-- Payment Proof Image viewer -->
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 space-y-4">
                        <h2 class="text-base font-bold text-white">Uploaded Payment Proof</h2>
                        @if($booking->payment)
                            <div class="rounded-xl overflow-hidden border border-padel-border/50 max-h-96 bg-gray-900 flex justify-center">
                                <img src="{{ asset('storage/' . $booking->payment->payment_proof) }}" 
                                     alt="Payment Proof Receipt" 
                                     class="object-contain max-h-96">
                            </div>
                            <div class="text-xs text-gray-400 space-y-1">
                                <p><span class="text-white font-medium">Transaction ID:</span> {{ $booking->payment->transaction_id }}</p>
                                <p><span class="text-white font-medium">Submitted at:</span> {{ $booking->payment->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        @else
                            <div class="py-12 bg-padel-input/20 border border-padel-border/20 rounded-xl text-center">
                                <p class="text-xs text-gray-500 font-semibold">User has not uploaded a payment proof receipt yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Action Sidebar (Right 1 col) -->
                <div>
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 sticky top-6 shadow-2xl space-y-4">
                        <h3 class="text-base font-bold text-white mb-2">Process Authorization</h3>
                        
                        <div class="text-xs text-gray-400">
                            Current Booking Status: <span class="capitalize text-white font-semibold">{{ $booking->status }}</span>
                        </div>
                        <div class="text-xs text-gray-400">
                            Current Receipt Status: <span class="capitalize text-white font-semibold">{{ $booking->payment ? $booking->payment->status : 'None' }}</span>
                        </div>

                        <hr class="border-padel-border/30">

                        @if($booking->status === 'pending' && $booking->payment && $booking->payment->status === 'pending')
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md mb-2">
                                    Approve & Confirm
                                </button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this payment and cancel the booking?')">
                                @csrf
                                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold py-3 px-6 rounded-xl text-xs border border-red-500/20 transition">
                                    Reject & Cancel
                                </button>
                            </form>
                        @else
                            <div class="py-4 bg-padel-input/20 rounded-xl text-center">
                                <p class="text-xs text-gray-500 font-semibold">No pending processing actions available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
