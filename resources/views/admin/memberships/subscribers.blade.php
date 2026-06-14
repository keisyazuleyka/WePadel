<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Subscribers Log</h1>
                    <p class="text-xs text-gray-400 mt-1">Track active membership subscriptions, start/end dates, and expiration status.</p>
                </div>
                <a href="{{ route('admin.memberships.index') }}" class="text-xs text-brand hover:underline font-semibold">&larr; Back to Plans</a>
            </div>

            <!-- Subscribers List Table -->
            <div class="bg-padel-card rounded-2xl border border-padel-border/50 overflow-hidden">
                <table class="min-w-full divide-y divide-padel-border/30">
                    <thead>
                        <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider bg-[#0a1009]/50">
                            <th class="py-4 px-6">User</th>
                            <th class="py-4 px-6">Plan Tier</th>
                            <th class="py-4 px-6">Start Date</th>
                            <th class="py-4 px-6">End Date</th>
                            <th class="py-4 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-padel-border/20 text-sm">
                        @forelse($subscribers as $sub)
                            <tr class="text-gray-300 hover:bg-padel-input/10">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-white">{{ $sub->user->name }}</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">{{ $sub->user->email }}</div>
                                </td>
                                <td class="py-4 px-6 font-semibold text-white">{{ $sub->membership->name }}</td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($sub->start_date)->format('M d, Y') }}</td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($sub->end_date)->format('M d, Y') }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        {{ $sub->status === 'active' ? 'bg-green-500/10 text-green-400' : '' }}
                                        {{ $sub->status === 'expired' ? 'bg-gray-800 text-gray-400' : '' }}
                                        {{ $sub->status === 'cancelled' ? 'bg-red-500/10 text-red-400' : '' }}
                                    ">
                                        {{ $sub->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">No subscribers log found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
