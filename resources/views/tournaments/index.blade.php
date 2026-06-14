<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white">Elite Tournaments</h1>
                <p class="mt-4 text-padel-muted max-w-xl mx-auto">Join the competition, build your team, and claim your victory on the court.</p>
            </div>

            @if($tournaments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($tournaments as $tournament)
                        <div class="bg-padel-card rounded-2xl overflow-hidden border border-padel-border/50 hover:border-brand/35 transition duration-300 flex flex-col justify-between p-6">
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase {{ $tournament->status === 'upcoming' ? 'bg-brand/10 text-brand border border-brand/20' : 'bg-gray-800 text-gray-400' }}">
                                        {{ $tournament->status }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-semibold">{{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}</span>
                                </div>
                                <h2 class="text-2xl font-bold text-white mb-3">{{ $tournament->name }}</h2>
                                <p class="text-xs text-gray-400 leading-relaxed mb-6">{{ $tournament->description }}</p>

                                <div class="border-t border-padel-border/20 pt-4 space-y-2 text-xs text-gray-400 mb-6">
                                    <div class="flex justify-between">
                                        <span>Duration:</span>
                                        <span class="text-white font-medium">{{ \Carbon\Carbon::parse($tournament->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($tournament->end_date)->format('d M, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Max Teams:</span>
                                        <span class="text-white font-medium">{{ $tournament->max_teams }} Teams</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Entry Fee:</span>
                                        <span class="text-brand font-bold">Rp {{ number_format($tournament->registration_fee, 0) }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('tournaments.show', $tournament->id) }}" class="block text-center w-full bg-brand text-black hover:bg-brand-dark font-bold py-3 px-4 rounded-xl text-xs transition">
                                View Leaderboard & Join &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $tournaments->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-padel-card rounded-2xl border border-padel-border/30">
                    <p class="text-gray-400 text-sm">No tournaments scheduled at the moment. Check back soon!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
