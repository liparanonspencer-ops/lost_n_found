<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
            </h2>
            @can('admin')
            <div class="hidden md:flex items-center gap-3">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-200 dark:border-indigo-800">
                    System Controller
                </span>
            </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-gray-900 min-h-screen text-slate-900 dark:text-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

         @can('admin')
<div class="mb-12" 
     x-data="{ 
        stats: { active: 0, pending: 0, resolved: 0, users: 0 },
        async updateStats() {
            try {
                let response = await fetch('/api/admin/stats');
                this.stats = await response.json();
            } catch (e) { console.log('Stats fetch failed'); }
        }
     }" 
     x-init="updateStats(); setInterval(() => updateStats(), 10000)"> {{-- Refreshes every 10s --}}

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white">Management Overview</h3>
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
            </div>
            <p class="text-sm text-slate-500 font-medium">Statics live platform activity...</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-green-500 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
            </div>
            <h3 class="text-white text-xs font-black uppercase tracking-widest">Active Posts</h3>
            <p class="text-3xl font-black mt-1 text-slate-900 dark:text-white tabular-nums" x-text="stats.active"></p>
        </div>

        <div class="bg-yellow-400 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <template x-if="stats.pending > 0">
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg uppercase animate-pulse">Action Req.</span>
                </template>
            </div>
            <h3 class="text-white text-xs font-black uppercase tracking-widest">Pending Claims</h3>
            <p class="text-3xl font-black mt-1 text-slate-900 dark:text-white tabular-nums" x-text="stats.pending"></p>
        </div>

        <div class="bg-blue-500 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <i class="fas fa-handshake text-xl"></i>
                </div>
            </div>
            <h3 class="text-white text-xs font-black uppercase tracking-widest">Resolved</h3>
            <p class="text-3xl font-black mt-1 text-slate-900 dark:text-white tabular-nums" x-text="stats.resolved"></p>
        </div>

        <div class="bg-indigo-500 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center text-rose-600 dark:text-rose-400">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <h3 class="text-white text-xs font-black uppercase tracking-widest">Total Users</h3>
            <p class="text-3xl font-black mt-1 text-slate-900 dark:text-white tabular-nums" x-text="stats.users"></p>
        </div>
    </div>
    
    <hr class="my-12 border-slate-200 dark:border-gray-800">
</div>
@endcan
            @can('user')
            <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-center">
                <a href="{{ route('items.create') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Report Lost/Found Item
                </a>

                <a href="{{ route('items.index') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-800 text-slate-700 dark:text-slate-200 font-bold rounded-2xl border border-slate-200 dark:border-gray-700 shadow-sm hover:bg-slate-50 dark:hover:bg-gray-700 hover:-translate-y-0.5 transition-all duration-200">
                    View Public Directory
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8 border-b border-slate-50 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Your Feed</h3>
                        <p class="text-sm text-slate-400">Items reported across the community</p>
                    </div>
                    <span class="hidden sm:block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50 dark:bg-gray-900 px-4 py-2 rounded-full">Live Updates</span>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($items as $item)
                            <div class="group bg-white dark:bg-gray-900 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 dark:hover:shadow-none transition-all duration-300">
                                <div class="relative h-56 overflow-hidden">
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full bg-slate-50 dark:bg-gray-800 text-slate-300">
                                            <i class="fas fa-image text-3xl opacity-20 mb-2"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-widest">No Preview</span>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-4 left-4">
                                        <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg {{ $item->type == 'lost' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white' }}">
                                            {{ $item->type }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h4 class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors truncate">{{ $item->item_name }}</h4>
                                    
                                    <div class="flex items-center text-slate-500 dark:text-slate-400 mt-3 space-x-4">
                                        <div class="flex items-center text-xs">
                                            <i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i>
                                            <span class="truncate max-w-[120px]">{{ $item->location }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 pt-5 border-t border-slate-50 dark:border-gray-800 flex justify-between items-center">
                                        <span class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">{{ $item->created_at->diffForHumans() }}</span>
                                        <a href="{{ route('items.show', $item->id) }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-widest group/btn">
                                            View Details 
                                            <i class="fas fa-arrow-right ml-2 transform group-hover/btn:translate-x-1 transition-transform"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-24 flex flex-col items-center justify-center text-center">
                                <div class="w-24 h-24 bg-slate-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                                    <i class="fas fa-inbox text-4xl text-slate-200"></i>
                                </div>
                                <h3 class="text-slate-900 dark:text-white font-black text-xl">The directory is empty</h3>
                                <p class="text-slate-500 dark:text-slate-400 max-w-xs mx-auto mt-2 font-medium">Be the first to help the community by reporting an item.</p>
                            </div>
                        @endforelse
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>