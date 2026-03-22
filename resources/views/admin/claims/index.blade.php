<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ __('Claim Requests') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 italic">Review and verify ownership claims</p>
            </div>
             <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all group shadow-sm">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Admin dashboard
            </a>
            <div class="flex items-center space-x-2 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-2 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-xs font-bold text-indigo-700 dark:text-indigo-300 tracking-wide uppercase">
                    {{ $claims->count() }} Pending Review
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-2xl shadow-sm animate-fade-in-down">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-gray-700/50 border-b border-slate-100 dark:border-gray-700">
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em]">Item Details</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em]">Claimant Info</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-center">Date Submitted</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-gray-700">
                            @forelse($claims as $claim)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-gray-700/30 transition duration-150 group">
                                    <td class="p-6">
                                        <div class="flex items-center">
                                            <div class="relative w-12 h-12 shrink-0">
                                                @if($claim->item->image_path)
                                                    <img src="{{ asset('storage/' . $claim->item->image_path) }}" class="w-full h-full rounded-xl object-cover ring-2 ring-slate-100 dark:ring-gray-700">
                                                @else
                                                    <div class="w-full h-full rounded-xl bg-slate-100 dark:bg-gray-700 flex items-center justify-center border border-dashed border-slate-300">
                                                        <i class="fas fa-box text-slate-300"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-slate-900 dark:text-white leading-tight group-hover:text-indigo-600 transition-colors">{{ $claim->item->item_name }}</div>
                                                <div class="flex items-center text-[11px] text-slate-500 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                                    {{ $claim->item->location }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-6">
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $claim->user->first_name }} {{ $claim->user->last_name }}</div>
                                        <div class="text-[11px] text-slate-500 font-medium flex items-center mt-0.5">
                                            <svg class="w-3 h-3 mr-1 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                                            {{ $claim->user->email }}
                                        </div>
                                    </td>

                                    <td class="p-6 text-center">
                                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $claim->created_at->format('M d, Y') }}</div>
                                        <div class="text-[10px] text-slate-400 font-medium">{{ $claim->created_at->diffForHumans() }}</div>
                                    </td>

                                    <td class="p-6 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            @if($claim->status === 'pending')
                                              <form action="{{ route('admin.claims.update', $claim->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="approved">
    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold transition-all shadow-lg shadow-emerald-200">
        Approve
    </button>
</form>

                                                <form id="reject-form-{{ $claim->id }}" action="{{ route('admin.claims.update', $claim) }}" method="POST" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="button" 
                                                        onclick="openConfirmModal('reject-form-{{ $claim->id }}', 'reject')"
                                                        class="h-9 px-4 bg-white dark:bg-gray-700 border border-slate-200 dark:border-gray-600 text-rose-600 dark:text-rose-400 text-xs font-bold rounded-xl hover:bg-rose-50 dark:hover:bg-rose-900/20 transition active:scale-95">
                                                        Reject
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-3 py-1 bg-slate-100 dark:bg-gray-700 text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-lg">
                                                    Archived
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-slate-300 text-2xl"></i>
                                            </div>
                                            <p class="text-slate-500 dark:text-slate-400 font-bold">All clear! No pending claims.</p>
                                        </div>
                                    </td>
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <div class="flex min-h-screen items-end sm:items-center justify-center p-0 sm:p-4 text-center">
            <div class="relative transform overflow-hidden rounded-t-[2.5rem] sm:rounded-[2rem] bg-white dark:bg-gray-800 text-left shadow-2xl transition-all w-full sm:max-w-lg animate-fade-in-up">
                <div class="p-8">
                    <div class="flex flex-col items-center text-center">
                        <div id="modalIconContainer" class="flex h-20 w-20 items-center justify-center rounded-3xl mb-6">
                            <i id="modalIcon" class="fas text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white" id="modal-title">Confirm Action</h3>
                        <p class="mt-4 text-slate-500 dark:text-slate-400 leading-relaxed text-sm" id="modalDescription"></p>
                    </div>
                </div>
                <div class="p-8 pt-0 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="button" id="confirmBtn" class="w-full sm:flex-1 py-4 px-6 rounded-2xl text-white font-bold text-sm shadow-xl transition active:scale-95">
                        Confirm
                    </button>
                    <button type="button" onclick="closeModal()" class="w-full sm:flex-1 py-4 px-6 rounded-2xl bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-300 font-bold text-sm hover:bg-slate-200 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>