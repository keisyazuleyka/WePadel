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
                    <h1 class="text-3xl font-bold text-white">Court Management</h1>
                    <p class="text-xs text-gray-400 mt-1">Manage venues, availability toggles, hourly rates, and upload gallery images.</p>
                </div>
                <a href="{{ route('admin.courts.create') }}" class="bg-brand text-black font-bold py-2.5 px-4 rounded-xl text-xs hover:bg-brand-dark transition">
                    Create Court
                </a>
            </div>

            <!-- Court List Table -->
            <div class="bg-padel-card rounded-2xl border border-padel-border/50 overflow-hidden">
                <table class="min-w-full divide-y divide-padel-border/30">
                    <thead>
                        <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider bg-[#0a1009]/50">
                            <th class="py-4 px-6">Image</th>
                            <th class="py-4 px-6">Name</th>
                            <th class="py-4 px-6">Location</th>
                            <th class="py-4 px-6 text-center">Price / Hour</th>
                            <th class="py-4 px-6 text-center">Available</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-padel-border/20 text-sm">
                        @forelse($courts as $court)
                            <tr class="text-gray-300 hover:bg-padel-input/10">
                                <td class="py-4 px-6">
                                    <img src="{{ $court->primaryImage() ? (str_starts_with($court->primaryImage()->image_path, 'http') ? $court->primaryImage()->image_path : asset('storage/' . $court->primaryImage()->image_path)) : 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop' }}" 
                                         class="h-10 w-16 rounded object-cover">
                                </td>
                                <td class="py-4 px-6 font-bold text-white">{{ $court->name }}</td>
                                <td class="py-4 px-6">{{ $court->location }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-white">Rp {{ number_format($court->price_per_hour, 0) }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold
                                        {{ $court->is_available ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                                        {{ $court->is_available ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="{{ route('admin.courts.edit', $court->id) }}" class="text-brand hover:underline font-semibold">Edit</a>
                                    <form action="{{ route('admin.courts.destroy', $court->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this court?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline font-semibold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-500">No courts listed. Create your first court now!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $courts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
