<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Edit Membership Plan</h1>
                    <p class="text-xs text-gray-400 mt-1">Configure pricing rates, booking discounts, and edit benefits log.</p>
                </div>
                <a href="{{ route('admin.memberships.index') }}" class="text-xs text-brand hover:underline font-semibold">&larr; Back to Plans</a>
            </div>

            <div class="bg-padel-card rounded-2xl p-6 sm:p-8 border border-padel-border/50">
                <form action="{{ route('admin.memberships.update', $membership->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Plan Name</label>
                        <input type="text" name="name" value="{{ old('name', $membership->name) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Price (Rp)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $membership->price) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Discount Percentage (%)</label>
                        <input type="number" step="0.01" name="discount_percentage" value="{{ old('discount_percentage', $membership->discount_percentage) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Duration (Days)</label>
                        <input type="number" name="duration_in_days" value="{{ old('duration_in_days', $membership->duration_in_days) }}" required
                               class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Benefits List</label>
                        <div class="space-y-3" id="benefits-wrapper">
                            @foreach($membership->benefits as $index => $benefit)
                                <input type="text" name="benefits[]" value="{{ $benefit }}" required
                                       class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            @endforeach
                        </div>
                        <button type="button" onclick="addBenefitInput()" class="mt-3 text-xs text-brand hover:underline font-semibold">+ Add Benefit Line</button>
                    </div>

                    <div class="pt-4 border-t border-padel-border/30">
                        <button type="submit" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                            Update Plan Tiers
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addBenefitInput() {
            const wrapper = document.getElementById('benefits-wrapper');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'benefits[]';
            input.placeholder = 'Describe a new benefit...';
            input.required = true;
            input.className = 'w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand mt-2';
            wrapper.appendChild(input);
        }
    </script>
</x-app-layout>
