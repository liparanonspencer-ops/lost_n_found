<x-app-layout>
    <x-slot name="header">
         <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
                    {{ __('Claims Archive') }}
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-1">A permanent record of all processed requests</p>
            </div>
            <a href="{{ route('admin.claims.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all group shadow-sm">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to pending
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-gray-700/50 border-b border-slate-100 dark:border-gray-700">
                                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">Item Information</th>
                                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">Claimant Details</th>
                                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">Processed On</th>
                                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Outcome</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-gray-700">
                            @forelse($claims as $claim)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-700/30 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-gray-700 flex items-center justify-center shrink-0">
                                                @if($claim->item->image_path)
                                                    <img src="{{ asset('storage/' . $claim->item->image_path) }}" class="w-full h-full rounded-lg object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-slate-800 dark:text-slate-200 leading-tight">{{ $claim->item->item_name }}</div>
                                                <div class="text-[11px] font-medium text-indigo-500 uppercase tracking-tighter mt-0.5">{{ $claim->item->category }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $claim->user->first_name }} {{ $claim->user->last_name }}</div>
                                        <div class="text-[11px] text-slate-400 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                                            {{ $claim->user->email }}
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-600 dark:text-slate-400">{{ $claim->updated_at->format('M d, Y') }}</span>
                                            <span class="text-[10px] font-medium text-slate-400">{{ $claim->updated_at->format('h:i A') }}</span>
                                        </div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm
                                            {{ $claim->status === 'approved' 
                                                ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800' 
                                                : 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-800' }}">
                                            <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $claim->status === 'approved' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            {{ $claim->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">No archived records</h3>
                                            <p class="text-slate-500 text-sm mt-1">Once you approve or reject a claim, it will appear here.</p>
                                        </div>
                                    </td>
                                @endforelse
                        </tbody>
                    </table>
                </div>

                @if($claims->hasPages())
                    <div class="p-6 border-t border-slate-50 dark:border-gray-700 bg-slate-50/30 dark:bg-gray-800/50">
                        {{ $claims->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>