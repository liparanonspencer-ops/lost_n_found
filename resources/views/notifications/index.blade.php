@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
                {{ __('Notifications') }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">Stay updated on your item claims and reports</p>
        </div>

        @if($unreadCount > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-900/20 px-4 py-2 rounded-xl transition-all active:scale-95">
                    <i class="fas fa-check-double mr-2"></i>{{ __('Mark All as Read') }}
                </button>
            </form>
        @endif
    </div>
@endsection

@section('content')
<div class="py-8 bg-slate-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 overflow-hidden">
            
            {{-- Header/Stats Bar --}}
            <div class="px-8 py-6 border-b border-slate-50 dark:border-gray-700 flex items-center justify-between bg-slate-50/50 dark:bg-gray-700/30">
                <div class="flex items-center space-x-3">
                    <div class="flex -space-x-2">
                        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white ring-2 ring-white dark:ring-gray-800">
                            <i class="fas fa-bell text-xs"></i>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">
                        {{ __('You have') }} <span class="text-indigo-600 dark:text-indigo-400">{{ $unreadCount }}</span> {{ __('new alerts') }}
                    </span>
                </div>
            </div>

            {{-- Notification List --}}
            <div class="divide-y divide-slate-50 dark:divide-gray-700">
                @forelse($notifications as $notification)
                    @include('notifications.partials.notification_item', ['notification' => $notification])
                @empty
                    <div class="py-24 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 dark:bg-gray-700 text-slate-300 mb-6">
                            <i class="fas fa-bell-slash text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ __('All caught up!') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-xs mx-auto">
                            {{ __('Your inbox is clear. We will notify you when there is an update on your items.') }}
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="px-8 py-6 bg-slate-50/30 dark:bg-gray-700/10 border-t border-slate-50 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection