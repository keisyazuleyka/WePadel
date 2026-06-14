<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6">
            
            @if(session('success'))
                <div class="mb-6 bg-brand/10 border border-brand/20 text-brand px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-padel-card rounded-2xl border border-padel-border/50 p-6 sm:p-8 shadow-2xl space-y-6">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">Upload Payment Proof</h1>
                    <p class="text-xs text-gray-400">Please complete the payment and upload the transaction receipt below to confirm your reservation.</p>
                </div>

                <!-- Booking Summary -->
                <div class="bg-padel-input/40 p-4 rounded-xl border border-padel-border/30 space-y-3">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-2">Booking Summary</h3>
                    <div class="flex justify-between text-xs text-gray-300">
                        <span>Court:</span>
                        <span class="text-white font-semibold">{{ $booking->court->name }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-300">
                        <span>Date:</span>
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-300">
                        <span>Time Slots:</span>
                        <span class="text-white font-semibold text-right">
                            @foreach($booking->details as $det)
                                {{ \Carbon\Carbon::parse($det->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($det->end_time)->format('H:i') }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                    <hr class="border-padel-border/30">
                    <div class="flex justify-between text-sm">
                        <span class="text-white font-bold">Total Amount Due:</span>
                        <span class="text-brand font-extrabold">Rp {{ number_format($booking->total_price, 0) }}</span>
                    </div>
                </div>

                <!-- Payment Details Instructions -->
                <div class="space-y-2 text-xs text-gray-400 leading-relaxed bg-[#0a1009] p-4 rounded-xl border border-padel-border/20">
                    <h3 class="font-semibold text-white mb-1 uppercase tracking-wide">Bank Transfer Details</h3>
                    <p><span class="text-white font-medium">Bank Name:</span> Bank Central Asia (BCA)</p>
                    <p><span class="text-white font-medium">Account Name:</span> PT WePadel Indonesia</p>
                    <p><span class="text-white font-medium">Account Number:</span> 8012 3456 78</p>
                    <p><span class="text-white font-medium">Reference:</span> WEPADEL-{{ $booking->id }}</p>
                </div>

                <!-- Proof Upload Form -->
                <form action="{{ route('user.bookings.payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Upload Receipt File</label>
                        <input type="file" name="payment_proof" accept="image/*" required
                               class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand file:cursor-pointer hover:file:bg-brand/20">
                        <p class="text-[10px] text-gray-500 mt-2">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl hover:bg-brand-dark transition duration-150 shadow-md">
                        Submit Payment Receipt
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
