<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-brand/10 border border-brand/20 text-brand px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Navigation Tabs / Info Summary -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-padel-card rounded-2xl p-6 border border-padel-border/50 text-center">
                        <div class="relative inline-block mx-auto mb-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="h-28 w-28 rounded-full object-cover border-2 border-brand/40 shadow-lg">
                            @else
                                <div class="h-28 w-28 rounded-full bg-brand/10 border-2 border-brand/20 flex items-center justify-center text-brand font-bold text-3xl mx-auto">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold bg-brand/10 text-brand border border-brand/25 mt-4 uppercase tracking-wider">
                            {{ $user->role->display_name }}
                        </span>
                    </div>
                </div>

                <!-- Forms Area (Right 2 cols) -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Profile Information Form -->
                    <div class="bg-padel-card rounded-2xl p-6 sm:p-8 border border-padel-border/50">
                        <h3 class="text-lg font-bold text-white mb-6">Profile Information</h3>
                        
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div>
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Display Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Profile Avatar</label>
                                <input type="file" name="avatar" accept="image/*"
                                       class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand file:cursor-pointer hover:file:bg-brand/20">
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Form -->
                    <div class="bg-padel-card rounded-2xl p-6 sm:p-8 border border-padel-border/50">
                        <h3 class="text-lg font-bold text-white mb-6">Update Password</h3>
                        
                        <form action="{{ route('user.profile.password') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Current Password</label>
                                <input type="password" name="current_password" required
                                       class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">New Password</label>
                                <input type="password" name="password" required
                                       class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-padel-muted uppercase tracking-wider mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full bg-padel-input border border-padel-border rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-brand text-black font-bold py-3 px-6 rounded-xl text-xs hover:bg-brand-dark transition shadow-md">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
