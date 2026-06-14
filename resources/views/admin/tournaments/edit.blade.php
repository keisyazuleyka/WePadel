<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Edit Tournament</h1>
                    <p class="text-xs text-gray-400 mt-1">Modify configurations and description logs.</p>
                </div>
                <a href="{{ route('admin.tournaments.index') }}" class="text-xs text-brand hover:underline font-semibold">&larr; Back to Tournaments</a>
            </div>

            <div class="bg-padel-card rounded-2xl p-6 sm:p-8 border border-padel-border/50">
                <form action="{{ route('admin.tournaments.update', $tournament->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST') <!-- We mapped updating to POST/PUT depending on routes, in web.php it was Route::post('/tournaments/{tournament}/update') so POST is correct! -->

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Tournament Name</label>
                        <input type="text" name="name" value="{{ old('name', $tournament->name) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $tournament->start_date) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $tournament->end_date) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Maximum Teams Capacity</label>
                        <input type="number" name="max_teams" value="{{ old('max_teams', $tournament->max_teams) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Registration Fee (Rp)</label>
                        <input type="number" step="0.01" name="registration_fee" value="{{ old('registration_fee', $tournament->registration_fee) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Tournament Status</label>
                        <select name="status" class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            <option value="upcoming" {{ $tournament->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="ongoing" {{ $tournament->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ $tournament->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="4" required
                                  class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">{{ old('description', $tournament->description) }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-padel-border/30">
                        <button type="submit" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                            Update Tournament
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
