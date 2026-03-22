<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
                {{ __('Lost & Found Items') }}
            </h2>
            <a href="{{ route('items.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Report Item
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <form action="{{ route('items.index') }}" method="GET" class="relative max-w-2xl mx-auto">
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search by item name, location, or category..." 
                               class="block w-full pl-11 pr-32 py-4 bg-white dark:bg-gray-800 border-none rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 text-slate-900 dark:text-white placeholder-slate-400 transition-all">
                        <button type="submit" class="absolute right-2 px-6 py-2 bg-slate-900 dark:bg-indigo-600 text-white text-sm font-bold rounded-1.5xl hover:bg-slate-800 transition-all">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($items as $item)
                    <div class="group bg-white dark:bg-gray-800 rounded-3xl overflow-hidden border border-slate-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-slate-200/50 dark:hover:shadow-none transition-all duration-300 flex flex-col">
                        
                        <div class="relative h-56 w-full overflow-hidden bg-slate-100 dark:bg-gray-700">
                            @if($item->image_path)
                                <img src="/storage/{{ $item->image_path }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-400">
                                    <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="text-xs font-medium uppercase tracking-widest">No Image</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-tighter rounded-full shadow-sm {{ $item->type == 'lost' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white' }}">
                                    {{ $item->type }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex-grow flex flex-col">
                            <div class="mb-4">
                                <p class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-1">{{ $item->category }}</p>
                                <h2 class="font-bold text-slate-900 dark:text-white text-lg leading-snug group-hover:text-indigo-600 transition-colors">{{ $item->item_name }}</h2>
                            </div>
                            
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-slate-500 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-xs truncate">{{ $item->location }}</span>
                                </div>
                                <div class="flex items-center text-slate-400 dark:text-slate-500">
                                    <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-[11px] font-medium">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <a href="{{ route('items.show', $item->id) }}" 
                               class="mt-auto w-full inline-flex items-center justify-center px-4 py-3 bg-slate-50 dark:bg-gray-700 text-slate-700 dark:text-slate-200 text-sm font-bold rounded-xl hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 transition-all duration-200 group/btn">
                                View Details
                                <svg class="w-4 h-4 ml-2 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 flex flex-col items-center justify-center bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-slate-200 dark:border-gray-700">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-gray-900 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">No items found</h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">Try adjusting your search or filters.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $items->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>