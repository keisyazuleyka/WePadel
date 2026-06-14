<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                    <p class="text-xs text-gray-400 mt-1">Real-time booking stats, utilization analytics, and user activity.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.courts.index') }}" class="bg-padel-card hover:bg-padel-input text-white font-bold py-2.5 px-4 rounded-xl text-xs border border-padel-border/50 transition">
                        Manage Courts
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="bg-brand text-black font-bold py-2.5 px-4 rounded-xl text-xs hover:bg-brand-dark transition">
                        Verify Payments
                    </a>
                </div>
            </div>

            <!-- KPI Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <!-- Total Users -->
                <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                    <div class="text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Total Users</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-extrabold text-white">{{ $totalUsers }}</div>
                        <span class="text-[10px] text-brand bg-brand/10 px-2 py-0.5 rounded-full font-bold">Active</span>
                    </div>
                </div>
                <!-- Total Bookings -->
                <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                    <div class="text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Total Bookings</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-extrabold text-white">{{ $totalBookings }}</div>
                        <span class="text-[10px] text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full font-bold">Overall</span>
                    </div>
                </div>
                <!-- Total Revenue -->
                <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                    <div class="text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Total Revenue</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-extrabold text-white">Rp {{ number_format($totalRevenue, 0) }}</div>
                        <span class="text-[10px] text-green-400 bg-green-500/10 px-2 py-0.5 rounded-full font-bold">Earnings</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Court Utilization Analytics (Left 1 col) -->
                <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 space-y-6 h-fit">
                    <div>
                        <h2 class="text-lg font-bold text-white">Court Utilization</h2>
                        <p class="text-xs text-gray-400 mt-1">Based on hours booked over the past 30 days.</p>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($courtAnalytics as $court)
                            <div>
                                <div class="flex justify-between text-xs text-gray-300 font-semibold mb-1.5">
                                    <span class="line-clamp-1">{{ $court['name'] }}</span>
                                    <span>{{ $court['utilization_rate'] }}%</span>
                                </div>
                                <div class="w-full bg-padel-input h-2 rounded-full overflow-hidden">
                                    <div class="bg-brand h-full rounded-full" style="width: {{ $court['utilization_rate'] }}%;"></div>
                                </div>
                                <div class="text-[10px] text-gray-500 mt-1">{{ $court['booked_hours'] }} hours occupied</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Latest Bookings Table (Right 2 cols) -->
                <div class="lg:col-span-2 bg-padel-card rounded-2xl p-6 border border-padel-border/50">
                    <h2 class="text-lg font-bold text-white mb-6">Latest Bookings Log</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-padel-border/30">
                            <thead>
                                <tr class="text-left text-[10px] font-bold text-padel-muted uppercase tracking-wider">
                                    <th class="pb-3">User</th>
                                    <th class="pb-3">Court</th>
                                    <th class="pb-3">Date</th>
                                    <th class="pb-3 text-center">Amount</th>
                                    <th class="pb-3 text-center">Status</th>
                                    <th class="pb-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-padel-border/20 text-xs">
                                @forelse($latestBookings as $bk)
                                    <tr class="text-gray-300 hover:bg-padel-input/10">
                                        <td class="py-3.5 font-semibold text-white">{{ $bk->user->name }}</td>
                                        <td class="py-3.5 font-medium">{{ $bk->court->name }}</td>
                                        <td class="py-3.5">{{ \Carbon\Carbon::parse($bk->booking_date)->format('M d, Y') }}</td>
                                        <td class="py-3.5 text-center font-bold text-white">Rp {{ number_format($bk->total_price, 0) }}</td>
                                        <td class="py-3.5 text-center">
                                            <span class="capitalize font-medium">{{ $bk->status }}</span>
                                        </td>
                                        <td class="py-3.5 text-right">
                                            <a href="{{ route('admin.bookings.show', $bk->id) }}" class="text-brand hover:underline">Manage</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">No booking records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
