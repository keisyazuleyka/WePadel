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
                    <h1 class="text-3xl font-bold text-white">Tournament Management</h1>
                    <p class="text-xs text-gray-400 mt-1">Manage tournament schedules, registration caps, fee rates, and statuses.</p>
                </div>
                <a href="{{ route('admin.tournaments.create') }}" class="bg-brand text-black font-bold py-2.5 px-4 rounded-xl text-xs hover:bg-brand-dark transition">
                    Create Tournament
                </a>
            </div>

            <!-- Tournament List Table -->
            <div class="bg-padel-card rounded-2xl border border-padel-border/50 overflow-hidden">
                <table class="min-w-full divide-y divide-padel-border/30">
                    <thead>
                        <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider bg-[#0a1009]/50">
                            <th class="py-4 px-6">Tournament Name</th>
                            <th class="py-4 px-6">Start Date</th>
                            <th class="py-4 px-6">End Date</th>
                            <th class="py-4 px-6 text-center">Max Teams</th>
                            <th class="py-4 px-6 text-center">Fee</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-padel-border/20 text-sm">
                        @forelse($tournaments as $tournament)
                            <tr class="text-gray-300 hover:bg-padel-input/10">
                                <td class="py-4 px-6 font-bold text-white">{{ $tournament->name }}</td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}</td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}</td>
                                <td class="py-4 px-6 text-center">{{ $tournament->max_teams }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-white">Rp {{ number_format($tournament->registration_fee, 0) }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        {{ $tournament->status === 'upcoming' ? 'bg-brand/10 text-brand' : 'bg-gray-800 text-gray-400' }}">
                                        {{ $tournament->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="{{ route('admin.tournaments.edit', $tournament->id) }}" class="text-brand hover:underline font-semibold">Edit</a>
                                    <form action="{{ route('admin.tournaments.destroy', $tournament->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tournament?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline font-semibold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">No tournaments scheduled yet. Create one!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $tournaments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
