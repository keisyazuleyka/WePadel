<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Tournament Info & Registered Teams (Left 2 cols) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Banner Info -->
                    <div class="bg-padel-card rounded-2xl p-8 border border-padel-border/50">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand/10 text-brand border border-brand/20 uppercase tracking-wider">
                                {{ $tournament->status }}
                            </span>
                            <span class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">{{ $tournament->name }}</h1>
                        <p class="text-sm text-gray-300 leading-relaxed">{{ $tournament->description }}</p>
                    </div>

                    <!-- Leaderboard / Standings -->
                    <div class="bg-padel-card rounded-2xl p-8 border border-padel-border/50">
                        <h2 class="text-xl font-bold text-white mb-6">Tournament Standings & Leaderboard</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-padel-border/30">
                                <thead>
                                    <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider">
                                        <th class="pb-3">Rank</th>
                                        <th class="pb-3">Team Name</th>
                                        <th class="pb-3 text-center">Played</th>
                                        <th class="pb-3 text-center">Won</th>
                                        <th class="pb-3 text-center">Lost</th>
                                        <th class="pb-3 text-right">Points</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-padel-border/20 text-sm">
                                    @foreach($standings as $team)
                                        <tr class="text-gray-300 hover:bg-padel-input/20">
                                            <td class="py-3.5 font-bold text-brand">{{ $team['rank'] }}</td>
                                            <td class="py-3.5 font-semibold text-white">{{ $team['team'] }}</td>
                                            <td class="py-3.5 text-center text-gray-400">{{ $team['played'] }}</td>
                                            <td class="py-3.5 text-center text-green-400 font-semibold">{{ $team['won'] }}</td>
                                            <td class="py-3.5 text-center text-red-400">{{ $team['lost'] }}</td>
                                            <td class="py-3.5 text-right font-bold text-white">{{ $team['points'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Registered Teams Log -->
                    <div class="bg-padel-card rounded-2xl p-8 border border-padel-border/50">
                        <h2 class="text-xl font-bold text-white mb-6">Registered Teams ({{ $tournament->registrations->count() }} / {{ $tournament->max_teams }})</h2>
                        @if($tournament->registrations->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($tournament->registrations as $reg)
                                    <div class="bg-padel-input/30 p-4 rounded-xl border border-padel-border/20 flex justify-between items-center">
                                        <div>
                                            <div class="font-bold text-white text-sm">{{ $reg->team_name }}</div>
                                            <div class="text-[10px] text-gray-400 mt-1">Captain: {{ $reg->user->name }}</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-green-500/10 text-green-400 border border-green-500/25">Confirmed</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-500">No teams registered yet. Be the first to join!</p>
                        @endif
                    </div>
                </div>

                <!-- Registration Sidebar (Right 1 col) -->
                <div>
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 sticky top-6 shadow-2xl space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-4">Tournament Details</h3>
                            <div class="space-y-3 text-xs text-gray-400">
                                <div class="flex justify-between">
                                    <span>Entry Fee:</span>
                                    <span class="text-brand font-bold">Rp {{ number_format($tournament->registration_fee, 0) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Team Limit:</span>
                                    <span class="text-white font-medium">{{ $tournament->max_teams }} Teams max</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Status:</span>
                                    <span class="text-white font-medium capitalize">{{ $tournament->status }}</span>
                                </div>
                            </div>
                        </div>

                        <hr class="border-padel-border/30">

                        @if($tournament->status === 'upcoming')
                            @auth
                                <form action="{{ route('user.tournaments.register', $tournament->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-[10px] font-bold text-padel-muted uppercase tracking-wider mb-2">Team Name</label>
                                        <input type="text" name="team_name" placeholder="Enter your team name..." required
                                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                                    </div>
                                    <button type="submit" class="w-full bg-brand text-black font-bold py-3.5 px-6 rounded-xl hover:bg-brand-dark transition shadow-md">
                                        Register Team & Join
                                    </button>
                                </form>
                            @else
                                <div class="text-center space-y-4">
                                    <p class="text-xs text-gray-400">Please sign in to register a team for this tournament.</p>
                                    <a href="{{ route('login') }}" class="block text-center w-full bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition">
                                        Sign In to Register
                                    </a>
                                </div>
                            @endauth
                        @else
                            <div class="text-center py-4 bg-padel-input/20 rounded-xl">
                                <p class="text-xs text-gray-500 font-semibold">Registrations are closed</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
