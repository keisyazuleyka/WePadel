<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Court Details & Reviews (Left 2 cols) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Court Gallery / Primary Image -->
                    <div class="bg-padel-card rounded-2xl overflow-hidden border border-padel-border/50">
                        <div class="relative h-96 bg-gray-800">
                            <img src="{{ $court->primaryImage() ? (str_starts_with($court->primaryImage()->image_path, 'http') ? $court->primaryImage()->image_path : asset('storage/' . $court->primaryImage()->image_path)) : 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop' }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Thumbnail Gallery if multiple images -->
                        @if($court->images->count() > 1)
                            <div class="p-4 bg-[#0a1009] flex gap-2 border-t border-padel-border/30 overflow-x-auto">
                                @foreach($court->images as $image)
                                    <div class="h-16 w-24 shrink-0 rounded-lg overflow-hidden border border-padel-border/50">
                                        <img src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : asset('storage/' . $image->image_path) }}" class="h-full w-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="bg-padel-card rounded-2xl p-8 border border-padel-border/50">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-white">{{ $court->name }}</h1>
                                <p class="text-sm text-brand mt-1 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $court->location }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-white">Rp {{ number_format($court->price_per_hour, 0) }}</span>
                                <span class="text-xs text-gray-500 block">per hour</span>
                            </div>
                        </div>
                        <hr class="border-padel-border/30 my-6">
                        <h2 class="text-lg font-semibold text-white mb-3">About this venue</h2>
                        <p class="text-sm text-gray-300 leading-relaxed">{{ $court->description }}</p>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-padel-card rounded-2xl p-8 border border-padel-border/50 space-y-6">
                        <h2 class="text-xl font-bold text-white">Reviews ({{ $court->reviews->count() }})</h2>
                        
                        @auth
                            <!-- Write Review -->
                            <form action="{{ route('user.reviews.store', $court->id) }}" method="POST" class="bg-padel-input p-4 rounded-xl border border-padel-border/40">
                                @csrf
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Leave your rating</label>
                                <div class="flex items-center space-x-1 mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" {{ $i == 5 ? 'checked' : '' }}>
                                            <svg class="h-6 w-6 text-brand hover:scale-110 transition duration-100 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                                <textarea name="comment" rows="2" placeholder="Tell other players about your experience..." class="w-full bg-padel-card border border-padel-border rounded-lg text-sm text-white px-3 py-2 focus:ring-1 focus:ring-brand focus:border-brand mb-4"></textarea>
                                <button type="submit" class="bg-brand text-black font-semibold text-xs py-2 px-4 rounded-lg hover:bg-brand-dark transition">Submit Review</button>
                            </form>
                        @endauth

                        <div class="space-y-4">
                            @forelse($court->reviews as $review)
                                <div class="bg-padel-input/30 p-4 rounded-xl border border-padel-border/20">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="font-semibold text-white text-sm">{{ $review->user->name }}</div>
                                        <div class="flex text-brand">
                                            @for($i = 1; $i <= $review->rating; $i++)
                                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-300 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500">No reviews yet. Be the first to review!</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Booking Widget (Right 1 col) -->
                <div>
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 sticky top-6 shadow-2xl">
                        <h2 class="text-xl font-bold text-white mb-6">Select Date & Time</h2>

                        <!-- Date Selector Form (reloads page) -->
                        <form action="{{ route('courts.show', $court->id) }}" method="GET" class="mb-6">
                            <label class="block text-[10px] font-bold text-padel-muted uppercase tracking-wider mb-2">Booking Date</label>
                            <input type="date" name="date" min="{{ date('Y-m-d') }}" value="{{ $dateStr }}" 
                                   onchange="this.form.submit()" 
                                   class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                        </form>

                        <!-- Time Slots Form -->
                        <form action="{{ route('user.bookings.store') }}" method="POST" id="booking-form">
                            @csrf
                            <input type="hidden" name="court_id" value="{{ $court->id }}">
                            <input type="hidden" name="booking_date" value="{{ $dateStr }}">

                            <label class="block text-[10px] font-bold text-padel-muted uppercase tracking-wider mb-2">Available Slots</label>
                            
                            <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto mb-6 pr-1 custom-scrollbar">
                                @foreach($slots as $slot)
                                    <label class="relative flex items-center justify-center p-3 rounded-xl border text-xs font-semibold cursor-pointer transition duration-150
                                        {{ $slot['is_booked'] || $slot['is_past']
                                            ? 'bg-padel-input/10 border-padel-border/30 text-gray-600 cursor-not-allowed' 
                                            : 'bg-padel-input border-padel-border/60 text-gray-300 hover:border-brand' }}">
                                        
                                        <input type="checkbox" name="slots[]" value="{{ $slot['start'] }}" 
                                               {{ $slot['is_booked'] || $slot['is_past'] ? 'disabled' : '' }}
                                               class="sr-only slot-checkbox"
                                               onchange="calculateTotal()">
                                        
                                        <span>{{ $slot['start'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Calculations Box -->
                            <div class="border-t border-padel-border/30 pt-4 space-y-2 text-xs mb-6 text-gray-400">
                                <div class="flex justify-between">
                                    <span>Rate:</span>
                                    <span class="text-white font-medium">Rp {{ number_format($court->price_per_hour, 0) }}/hr</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Selected Hours:</span>
                                    <span id="selected-hours" class="text-white font-medium">0 hrs</span>
                                </div>
                                @auth
                                    @php
                                        $activeMem = auth()->user()->activeMembership();
                                    @endphp
                                    @if($activeMem)
                                        <div class="flex justify-between text-brand">
                                            <span>Member Discount ({{ $activeMem->name }}):</span>
                                            <span>-{{ $activeMem->discount_percentage }}%</span>
                                        </div>
                                    @endif
                                @endauth
                                <div class="flex justify-between border-t border-padel-border/30 pt-2 text-sm">
                                    <span class="text-white font-semibold">Total Price:</span>
                                    <span id="total-price" class="text-brand font-bold">Rp 0</span>
                                </div>
                            </div>

                            @auth
                                <button type="submit" class="w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl hover:bg-brand-dark transition duration-150 shadow-md">
                                    Book Now & Pay
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="block text-center w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl hover:bg-brand-dark transition duration-150 shadow-md">
                                    Login to Book Court
                                </a>
                            @endauth
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to update booking price total live -->
    <script>
        const hourlyRate = {{ $court->price_per_hour }};
        const discountPercentage = @auth {{ auth()->user()->activeMembership()->discount_percentage ?? 0 }} @else 0 @endauth;

        function calculateTotal() {
            const checkedBoxes = document.querySelectorAll('.slot-checkbox:checked');
            const hours = checkedBoxes.length;

            document.getElementById('selected-hours').textContent = hours + ' hr' + (hours !== 1 ? 's' : '');

            const basePrice = hours * hourlyRate;
            const finalPrice = basePrice - ((basePrice * discountPercentage) / 100);

            document.getElementById('total-price').textContent = 'Rp ' + finalPrice.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
        }
    </script>
</x-app-layout>
