<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Create New Court</h1>
                    <p class="text-xs text-gray-400 mt-1">Populate details and upload images for a new padel venue.</p>
                </div>
                <a href="{{ route('admin.courts.index') }}" class="text-xs text-brand hover:underline font-semibold">&larr; Back to Courts</a>
            </div>

            <div class="bg-padel-card rounded-2xl p-6 sm:p-8 border border-padel-border/50">
                <form action="{{ route('admin.courts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Court Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. WePadel Sky Terrace"
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}" required placeholder="e.g. Kuningan, Jakarta"
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Hourly Price (Rp)</label>
                        <input type="number" step="0.01" name="price_per_hour" value="{{ old('price_per_hour') }}" required placeholder="e.g. 250000.00"
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="4" required placeholder="Describe the court specs, turf condition, floodlighting, views, amenities..."
                                  class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex items-center space-x-3 bg-padel-input/20 p-4 rounded-xl border border-padel-border/20">
                        <input type="checkbox" name="is_available" id="is_available" value="1" checked
                               class="rounded bg-padel-card border-padel-border text-brand focus:ring-1 focus:ring-brand focus:ring-offset-padel-bg">
                        <label for="is_available" class="text-sm font-semibold text-white select-none">Make Court Available for Bookings Immediately</label>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Primary Banner Image</label>
                        <input type="file" name="primary_image" accept="image/*" required
                               class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand file:cursor-pointer hover:file:bg-brand/20">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Gallery Images (Optional)</label>
                        <input type="file" name="gallery_images[]" accept="image/*" multiple
                               class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand file:cursor-pointer hover:file:bg-brand/20">
                    </div>

                    <div class="pt-4 border-t border-padel-border/30">
                        <button type="submit" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                            Create Court
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
