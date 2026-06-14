<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white">Our Premium Padel Courts</h1>
                <p class="mt-4 text-padel-muted max-w-xl mx-auto">Explore top-class indoor and outdoor courts located across prime venues.</p>
            </div>

            <!-- Search Filter Bar -->
            <div class="max-w-xl mx-auto mb-12">
                <form action="{{ route('courts.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by court name or location..." 
                           class="w-full bg-padel-card border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    <button type="submit" class="bg-brand text-black hover:bg-brand-dark px-6 py-3 rounded-xl font-bold transition text-sm">
                        Search
                    </button>
                </form>
            </div>

            <!-- Courts Grid -->
            @if($courts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($courts as $court)
                        <div class="bg-padel-card rounded-2xl overflow-hidden border border-padel-border/50 hover:border-brand/30 transition duration-300 flex flex-col justify-between">
                            <div class="relative h-56 bg-gray-800">
                                <img src="{{ $court->primaryImage() ? (str_starts_with($court->primaryImage()->image_path, 'http') ? $court->primaryImage()->image_path : asset('storage/' . $court->primaryImage()->image_path)) : 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop' }}" 
                                     alt="{{ $court->name }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-brand text-black text-xs font-bold px-3 py-1 rounded-md">
                                    Rp {{ number_format($court->price_per_hour, 0) }}/hr
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <h2 class="text-xl font-bold text-white">{{ $court->name }}</h2>
                                    </div>
                                    <p class="text-xs text-gray-400 flex items-center mb-3">
                                        <svg class="h-4 w-4 text-brand mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $court->location }}
                                    </p>
                                    <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed mb-6">{{ $court->description }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-auto">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-brand font-bold text-sm">{{ $court->averageRating() }}</span>
                                        <svg class="h-4 w-4 text-brand fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <a href="{{ route('courts.show', $court->id) }}" class="bg-brand text-black hover:bg-brand-dark px-5 py-2.5 rounded-xl text-xs font-bold transition">
                                        View Availability
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $courts->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-padel-card rounded-2xl border border-padel-border/30">
                    <p class="text-gray-400 text-sm">No courts found matching your search criteria.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
