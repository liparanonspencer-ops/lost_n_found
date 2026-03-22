<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
                {{ __('Item Details') }}
            </h2>
            <a href="{{ route('items.index') }}" 
               class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-xl shadow-slate-200/60 dark:shadow-none overflow-hidden border border-slate-100 dark:border-gray-700">
                <div class="flex flex-col lg:flex-row">
                    
                    {{-- Left Side: Image Section --}}
                    <div class="lg:w-1/2 bg-slate-100 dark:bg-gray-900 flex items-center justify-center relative min-h-[400px]">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center text-slate-400">
                                <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="font-medium italic">No Image Available</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-1.5 text-xs font-black uppercase tracking-widest rounded-full shadow-lg {{ $item->type == 'lost' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white' }}">
                                {{ $item->type }}
                            </span>
                        </div>
                    </div>

                    {{-- Right Side: Details Section --}}
                    
                    <div class="lg:w-1/2 p-8 lg:p-12">
                        <div class="mb-6">
                            <p class="text-indigo-600 dark:text-indigo-400 font-black text-xs uppercase tracking-[0.2em] mb-2">{{ $item->category }}</p>
                            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">{{ $item->item_name }}</h1>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="col-span-2">
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Description</h3>
                                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">{{ $item->description }}</p>
                            </div>

                             <div class="font-bold absolute bottom-25 right-12">
                                <span class="border border-emerald-700 animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 px-3 py-1 text-[12px] font-black uppercase tracking-tighter rounded-full shadow-sm {{ $item->status == 'lost' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white' }}">
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                                    {{ $item->status }}
                                </span>
                            </div>

                            
                            <div class="bg-slate-50 dark:bg-gray-700/50 p-4 rounded-2xl">
                                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Location</h3>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate">{{ $item->location }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700/50 p-4 rounded-2xl">
                                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Posted On</h3>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $item->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        {{-- Action Section --}}
                        <div class="mt-8 pt-8 border-t border-slate-100 dark:border-gray-700">
                            @if(auth()->id() !== $item->user_id)
                                @php
                                    $userClaim = \App\Models\Claim::where('item_id', $item->id)->where('user_id', auth()->id())->first();
                                @endphp

                                @if(!$userClaim)
                                    {{-- No Claim Yet: Show Request Button --}}
                                    <form action="{{ route('claims.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" class="w-full py-4 rounded-2xl shadow-lg text-white font-bold transition-transform hover:scale-[1.02] active:scale-[0.98]" style="background: #5b4ef3;">
                                            This is Mine / I Found This
                                        </button>
                                    </form>
                                    <p class="text-[10px] text-center text-slate-400 mt-3 uppercase tracking-widest font-bold">Verification will be required</p>

                                @elseif($userClaim->status === 'approved')
                                    {{-- Claim Approved: Show QR Code --}}
                                    <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-800 text-center">
                                        <div class="flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            <span class="font-black uppercase tracking-wider">Claim Approved!</span>
                                        </div>
                                        
                                        <div class="bg-white p-4 rounded-2xl inline-block shadow-sm mb-4">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('/admin/verify-claim/' . $userClaim->id)) }}" 
                                                 alt="Verification QR Code"
                                                 class="mx-auto">
                                        </div>
                                        
                                        <p class="text-xs text-emerald-700 dark:text-emerald-300 font-medium leading-relaxed">
                                            Show this QR code to the Admin <br> to finalize the retrieval.
                                        </p>
                                    </div>

                                @elseif($userClaim->status === 'rejected')
                                    <div class="bg-rose-50 p-5 rounded-2xl border border-rose-100 text-rose-700 text-center">
                                        <p class="font-black uppercase text-xs tracking-widest">Claim Not Approved</p>
                                    </div>

                                @else
                                    {{-- Claim Pending --}}
                                    <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100 text-amber-800 text-center">
                                        <div class="flex items-center justify-center mb-1">
                                            <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <p class="font-black uppercase text-xs tracking-widest">Claim Pending Review</p>
                                        </div>
                                        <p class="text-xs text-amber-700">The admin is checking your claim.</p>
                                    </div>
                                @endif

                            @else
                                {{-- User is the one who posted the item --}}
                                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-800 text-indigo-800 dark:text-indigo-300 text-sm text-center font-bold">
                                    You posted this report.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
