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
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- ADMIN SECTION: Stats & Calendar Side-by-Side --}}
        @can('admin')
        <div class="flex flex-col lg:flex-row gap-8 mb-12">
            
            {{-- LEFT SIDE: Stats Grid (2/3 width) --}}
            <div class="w-full lg:w-2/3" 
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

                <div class="mb-6">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Management Overview</h3>
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Live Platform Activity</p>
                </div>
             
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <a href="{{ route('items.index') }}" class="block transition-transform hover:scale-[1.02] bg-emerald-500 p-6 rounded-[2rem] shadow-xl border border-emerald-400/20">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white mb-4">
                            <i class="fas fa-box-open text-lg"></i>
                        </div>
                        <h3 class="text-white/80 text-[10px] font-black uppercase tracking-widest">Active Posts</h3>
                        <p class="text-3xl font-black mt-1 text-white tabular-nums" x-text="stats.active"></p>
                    </a>

                    <a href="{{ route('admin.claims.index') }}" class="block transition-transform hover:scale-[1.02] bg-amber-400 p-6 rounded-[2rem] shadow-xl border border-amber-300/20">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-amber-900">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                            <template x-if="stats.pending > 0">
                                <span class="text-[9px] font-black text-amber-900 bg-white/80 px-2 py-1 rounded-lg uppercase animate-pulse">Action Req.</span>
                            </template>
                        </div>
                        <h3 class="text-amber-900/80 text-[10px] font-black uppercase tracking-widest">Pending Claims</h3>
                        <p class="text-3xl font-black mt-1 text-amber-900 tabular-nums" x-text="stats.pending"></p>
                    </a>

                    <a href="{{ route('admin.claims.history') }}" class="block transition-transform hover:scale-[1.02] bg-blue-500 p-6 rounded-[2rem] shadow-xl border border-blue-400/20">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white mb-4">
                            <i class="fas fa-handshake text-lg"></i>
                        </div>
                        <h3 class="text-white/80 text-[10px] font-black uppercase tracking-widest">Resolved</h3>
                        <p class="text-3xl font-black mt-1 text-white tabular-nums" x-text="stats.resolved"></p>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="block transition-transform hover:scale-[1.02] bg-indigo-500 p-6 rounded-[2rem] shadow-xl border border-indigo-400/20">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white mb-4">
                            <i class="fas fa-users text-lg"></i>
                        </div>
                        <h3 class="text-white/80 text-[10px] font-black uppercase tracking-widest">Total Users</h3>
                        <p class="text-3xl font-black mt-1 text-white tabular-nums" x-text="stats.users"></p>
                    </a>
                </div>
            </div>

            {{-- RIGHT SIDE: Calendar (1/3 width) --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-gray-700 h-full">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-indigo-500"></i>
                        Calendar
                    </h3>
                    <div id='calendar' class="dark:text-white text-[11px]"></div>
                </div>
            </div>
        </div>

        <hr class="my-12 border-slate-200 dark:border-gray-800">
        @endcan

        {{-- USER SECTION: Slider --}}
        @can('user')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12 bg-white dark:bg-gray-800 rounded-[3rem] p-4 shadow-2xl border border-slate-100 dark:border-gray-700 overflow-hidden">
            <div x-data="{ 
                activePulse: 1, 
                pulses: [
                    { id: 1, src: 'https://www.sti.edu/images/stilogo-160.png', title: 'Find what you lost' },
                    { id: 2, src: 'https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800', title: 'Return what you found' }
                ],
                next() { this.activePulse = this.activePulse === this.pulses.length ? 1 : this.activePulse + 1 }
            }" 
            x-init="setInterval(() => next(), 4000)"
            class="relative h-64 md:h-[400px] rounded-[2.5rem] overflow-hidden bg-gray-900">
                <template x-for="pulse in pulses" :key="pulse.id">
                    <div x-show="activePulse === pulse.id" 
                         x-transition.opacity.duration.1000ms 
                         class="absolute inset-0">
                        <img :src="pulse.src" class="w-full h-full object-cover opacity-60">
                        <div class="absolute bottom-8 left-8">
                            <h3 class="text-white text-3xl font-black" x-text="pulse.title"></h3>
                        </div>
                    </div>
                </template>
            </div>

            <div class="p-8 flex flex-col justify-center">
                <span class="inline-block w-fit px-4 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">Campus Safety Net</span>
                <h1 class="text-3xl font-black mb-4 leading-tight">STI Lost & Found</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-8 leading-relaxed">Securely reuniting the campus community with their belongings through verified digital claims.</p>
                <div class="flex gap-4">
                    <a href="{{ route('items.create') }}" class="flex-1 text-center py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200/50">Report Item</a>
                    <a href="{{ route('items.index') }}" class="flex-1 text-center py-4 bg-slate-100 dark:bg-gray-700 font-bold rounded-2xl">Directory</a>
                </div>
            </div>
        </div>

        {{-- Community Feed --}}
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 border border-slate-100 dark:border-gray-700">
            <h3 class="text-xl font-bold mb-8">Community Feed</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($items as $item)
                    <div class="group bg-slate-50 dark:bg-gray-900 rounded-[2rem] overflow-hidden border border-slate-100 dark:border-gray-800 transition-all hover:shadow-xl">
                        <div class="h-48 overflow-hidden relative">
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div class="flex h-full items-center justify-center opacity-20"><i class="fas fa-image text-3xl"></i></div>
                            @endif
                            <span class="absolute top-4 left-4 px-3 py-1 text-[9px] font-black uppercase rounded-lg shadow-lg {{ $item->type == 'lost' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white' }}">
                                {{ $item->type }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h4 class="font-bold truncate">{{ $item->item_name }}</h4>
                            <p class="text-[11px] text-slate-400 mt-2 italic"><i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> {{ $item->location }}</p>
                            <div class="mt-6 pt-4 border-t border-slate-200 dark:border-gray-800 flex justify-between items-center">
                                <span class="text-[10px] text-slate-400 font-bold">{{ $item->created_at->diffForHumans() }}</span>
                                <a href="{{ route('items.show', $item->id) }}" class="text-indigo-600 text-[10px] font-black uppercase">View Details <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400">The directory is currently empty.</div>
                @endforelse
            </div>
        </div>
        @endcan

        <div class="mt-12 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">STI &bull; Lost & Found System</p>
        </div>
    </div>
</div>

<style>
    .fc .fc-toolbar-title { @apply text-slate-800 dark:text-white font-black text-sm; }
    .fc .fc-button-primary { @apply bg-indigo-600 border-none text-[9px] uppercase font-black px-2 !important; }
    .fc .fc-daygrid-day-number { @apply dark:text-slate-400 p-2 font-bold; }
    .fc td, .fc th { border-color: rgba(226, 232, 240, 0.1) !important; }
</style>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            height: 'auto',
            headerToolbar: { left: 'prev', center: 'title', right: 'next' },
            events: '/api/events',
            eventColor: '#6366f1',
            dateClick: function(info) {
                let title = prompt('Quick Event for ' + info.dateStr + ':');
                if (title) { console.log('Saving local event: ' + title); }
            }
        });
        calendar.render();
    });
</script>
@endpush
@endsection