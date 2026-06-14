<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Edit Court</h1>
                    <p class="text-xs text-gray-400 mt-1">Update specifications and view/manage uploaded assets.</p>
                </div>
                <a href="{{ route('admin.courts.index') }}" class="text-xs text-brand hover:underline font-semibold">&larr; Back to Courts</a>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <!-- Main Form Card -->
                <div class="bg-padel-card rounded-2xl p-6 sm:p-8 border border-padel-border/50">
                    <form action="{{ route('admin.courts.update', $court->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Court Name</label>
                            <input type="text" name="name" value="{{ old('name', $court->name) }}" required
                                   class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $court->location) }}" required
                                   class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Hourly Price (Rp)</label>
                            <input type="number" step="0.01" name="price_per_hour" value="{{ old('price_per_hour', $court->price_per_hour) }}" required
                                   class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Description</label>
                            <textarea name="description" rows="4" required
                                      class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">{{ old('description', $court->description) }}</textarea>
                        </div>

                        <div class="flex items-center space-x-3 bg-padel-input/20 p-4 rounded-xl border border-padel-border/20">
                            <input type="checkbox" name="is_available" id="is_available" value="1" {{ $court->is_available ? 'checked' : '' }}
                                   class="rounded bg-padel-card border-padel-border text-brand focus:ring-1 focus:ring-brand focus:ring-offset-padel-bg">
                            <label for="is_available" class="text-sm font-semibold text-white select-none">Make Court Available for Bookings</label>
                        </div>

                        <!-- Current Image Previews -->
                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-3">Current Gallery Assets</label>
                            <div class="grid grid-cols-4 gap-4 p-4 bg-[#0a1009]/50 rounded-xl border border-padel-border/30 overflow-x-auto">
                                @foreach($court->images as $image)
                                    <div class="relative rounded-lg overflow-hidden border {{ $image->is_primary ? 'border-brand' : 'border-padel-border/60' }} group h-20">
                                        <img src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : asset('storage/' . $image->image_path) }}" class="h-full w-full object-cover">
                                        @if($image->is_primary)
                                            <span class="absolute top-1 left-1 bg-brand text-black text-[8px] font-extrabold px-1 py-0.5 rounded uppercase">Primary</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Upload Replacement Primary Image</label>
                            <input type="file" name="primary_image" accept="image/*"
                                   class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand file:cursor-pointer hover:file:bg-brand/20">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Add Gallery Images</label>
                            <input type="file" name="gallery_images[]" accept="image/*" multiple
                                   class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand file:cursor-pointer hover:file:bg-brand/20">
                        </div>

                        <div class="pt-4 border-t border-padel-border/30">
                            <button type="submit" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                                Update Court
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
