@extends('layouts.app') {{-- Assumes your main dashboard layout --}}

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Your Notifications') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Main Inbox Container --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
            {{-- Header/Filter Bar --}}
            <div class="p-6 border-b border-gray-200 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                <div class="mb-3 mb-sm-0">
                    <span class="text-sm text-gray-600">
                        {{ __('You have') }} 
                        <span class="font-bold text-gray-900">{{ $unreadCount }}</span> 
                        {{ __('unread notifications.') }}
                    </span>
                </div>
                
                {{-- Add a "Mark all as Read" button later if you want --}}
                {{-- <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">{{ __('Mark All as Read') }}</a> --}}
            </div>

            {{-- Notification List --}}
            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    {{-- THIS IS THE INDIVIDUAL NOTIFICATION COMPONENT --}}
                    @include('notifications.partials.notification_item', ['notification' => $notification])
                @empty
                    <div class="p-12 text-center">
                        <i class="fas fa-bell-slash fa-3x text-gray-300 mb-4"></i>
                        <p class="text-lg text-gray-600">{{ __('Your inbox is clear!') }}</p>
                        <p class="text-sm text-gray-500">{{ __('Check back later for new updates.') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="p-6 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>

        </div>
    </div>
</div>
@endsection