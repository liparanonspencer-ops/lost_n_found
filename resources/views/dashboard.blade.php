@extends('layouts.app')
    @section('header')
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            @can('admin')
            <div class="hidden md:flex items-center gap-3">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-200 dark:border-indigo-800">
                    System Controller
                </span>
            </div>
            @endcan
        </div>
    @endsection

    @section('content')
    <div class="py-8 bg-slate-50 dark:bg-gray-900 min-h-screen text-slate-900 dark:text-slate-100 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ADMIN SECTION: Stats & Management --}}
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
                 x-init="updateStats(); setInterval(() => updateStats(), 10000)">

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Management Overview</h3>
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 font-medium">Statistics live platform activity...</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('items.index') }}" class="block transition-transform hover:scale-[1.02] bg-emerald-500 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl border border-slate-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-white dark:text-indigo-400">
                                <i class="fas fa-box-open text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-white/80 text-xs font-black uppercase tracking-widest">Active Posts</h3>
                        <p class="text-3xl font-black mt-1 text-white tabular-nums" x-text="stats.active"></p>
                    </a>

                    <a href="{{ route('admin.claims.index') }}" class="block transition-transform hover:scale-[1.02] bg-amber-400 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl border border-slate-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center text-white dark:text-amber-400">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <template x-if="stats.pending > 0">
                                <span class="text-[10px] font-bold text-amber-900 bg-white/80 px-2 py-1 rounded-lg uppercase animate-pulse">Action Req.</span>
                            </template>
                        </div>
                        <h3 class="text-amber-900/80 text-xs font-black uppercase tracking-widest">Pending Claims</h3>
                        <p class="text-3xl font-black mt-1 text-amber-900 dark:text-white tabular-nums" x-text="stats.pending"></p>
                    </a>

                    <a href="{{ route('admin.claims.history') }}" class="block transition-transform hover:scale-[1.02] bg-blue-500 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl border border-slate-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-white dark:text-emerald-400">
                                <i class="fas fa-handshake text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-white/80 text-xs font-black uppercase tracking-widest">Resolved</h3>
                        <p class="text-3xl font-black mt-1 text-white tabular-nums" x-text="stats.resolved"></p>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="block transition-transform hover:scale-[1.02] bg-indigo-500 dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl border border-slate-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center text-white dark:text-rose-400">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-white/80 text-xs font-black uppercase tracking-widest">Total Users</h3>
                        <p class="text-3xl font-black mt-1 text-white tabular-nums" x-text="stats.users"></p>
                    </a>
                </div>
                
                <hr class="my-12 border-slate-200 dark:border-gray-800">
            </div>
            @endcan

            {{-- USER SECTION: Combined Slider & Description --}}
            @can('user')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12 bg-white dark:bg-gray-800 rounded-[3rem] p-4 shadow-2xl shadow-slate-200 dark:shadow-none border border-slate-100 dark:border-gray-700 overflow-hidden">
                
                {{-- Left: The Slider Container --}}
               <div x-data="{ 
        activePulse: 1, 
        pulses: [
            { id: 1, src: 'https://www.sti.edu/images/stilogo-160.png', title: 'Find what you lost' },
            { id: 2, src: 'https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800', title: 'Return what you found' },
            { id: 3, src: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800', title: 'Secure Verification' }
        ],
        next() { 
            this.activePulse = this.activePulse === this.pulses.length ? 1 : this.activePulse + 1 
        }
    }" 
    x-init="setInterval(() => next(), 3500)"
    class="relative h-64 md:h-[400px] w-full rounded-[2.5rem] overflow-hidden group bg-gray-900">

    <template x-for="pulse in pulses" :key="pulse.id">
        <div x-show="activePulse === pulse.id" 
             {{-- Pulse Animation Transitions --}}
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-105"
             class="absolute inset-0">
            
            <img :src="pulse.src" 
                 class="w-full h-full object-cover transform transition-transform duration-[5000ms] scale-110"
                 :class="activePulse === pulse.id ? 'scale-100' : 'scale-110'">

            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/90 via-indigo-900/20 to-transparent"></div>

            <div class="absolute bottom-8 left-8 right-8">
                <p class="text-indigo-300 text-xs font-black uppercase tracking-[0.3em] mb-2" 
                   x-text="'Feature 0' + pulse.id"></p>
                <h3 class="text-white text-3xl font-black tracking-tight" 
                    x-text="pulse.title"></h3>
            </div>
        </div>
    </template>

    {{-- Slider Indicators (Dots) --}}
    <div class="absolute bottom-8 right-8 flex gap-3 z-20">
        <template x-for="pulse in pulses" :key="pulse.id">
            <button @click="activePulse = pulse.id" 
                    :class="activePulse === pulse.id ? 'bg-white w-10' : 'bg-white/30 w-2 hover:bg-white/50'" 
                    class="h-2 rounded-full transition-all duration-500 ease-in-out"></button>
        </template>
    </div>
</div>
                  
                   

                {{-- Right: The Description Content --}}
                <div class="p-6 md:p-8 flex flex-col justify-center">
                    <span class="inline-block w-fit px-4 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                        Official Campus Safety Net
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black mb-4 leading-tight text-slate-800 dark:text-white">Your STI Campus <br>Lost & Found Portal</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm md:text-base leading-relaxed mb-8">
                        Finding a lost item shouldn't be a game of chance. This digital hub is built to reunite STIers with their essentials. Secure verification and real-time alerts ensure every item finds its way home.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('items.create') }}" 
                           class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i> Report Item
                        </a>
                        <a href="{{ route('items.index') }}" 
                           class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 text-slate-700 dark:text-white font-bold rounded-2xl border border-slate-200 dark:border-gray-600 hover:bg-slate-50 transition-all duration-200">
                            View Directory
                        </a>
                    </div>
                </div>
            </div>

            {{-- Community Feed Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8 border-b border-slate-50 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Community Feed</h3>
                        <p class="text-sm text-slate-400">Items reported across the campus</p>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($items as $item)
                            {{-- ... rest of your item card code ... --}}
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
                                <i class="fas fa-inbox text-4xl text-slate-200 mb-6"></i>
                                <h3 class="text-slate-900 dark:text-white font-black text-xl">The directory is empty</h3>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endcan
            {{-- Footer Trust Badge --}}
        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                STI &bull; Lost & Found System
            </p>
        </div>
        </div>
    </div>

    @endsection