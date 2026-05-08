@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-4 sm:px-0">
        {{ __('User Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-6 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    <div class="overflow-hidden rounded-2xl bg-slate-200 shadow-sm border border-gray-100">
        
        <div class="h-24 sm:h-32 bg-gradient-to-r from-gray-100 to-gray-200"></div>

        <div class="relative px-6 pb-8">
            <div class="relative -mt-12 sm:-mt-16 flex flex-col sm:flex-row items-center sm:items-end space-y-4 sm:space-y-0 sm:space-x-5 text-center sm:text-left">
                
                <div class="relative">
                    <img class="h-24 w-24 sm:h-32 sm:w-32 rounded-full border-4 border-white object-cover shadow-md" 
                         src="{{ $user->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->first_name) }}" 
                         alt="Profile Photo">
                    <span class="absolute bottom-1 right-1 sm:bottom-2 sm:right-2 block h-3 w-3 sm:h-4 sm:w-4 rounded-full bg-green-400 ring-2 ring-white" title="Online"></span>
                </div>
                
                <div class="pb-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h1>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 italic">Acc ID: #{{ $user->id }}</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-4 sm:gap-6 border-t border-gray-100 pt-8 sm:grid-cols-3">
                
                <div class="flex flex-col space-y-1 p-3 bg-gray-50 sm:bg-transparent rounded-lg sm:p-0">
                    <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-blue-600">Email Address</span>
                    <span class="text-sm text-gray-700 font-medium break-all">{{ $user->email }}</span>
                </div>

                <div class="flex flex-col space-y-1 p-3 bg-gray-50 sm:bg-transparent rounded-lg sm:p-0">
                    <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-blue-600">Account Type</span>
                    <span class="inline-flex items-center w-fit rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

                <div class="flex flex-col space-y-1 p-3 bg-gray-50 sm:bg-transparent rounded-lg sm:p-0">
                    <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-blue-600">Member Since</span>
                    <span class="text-sm text-gray-700 font-medium">{{ $user->created_at->format('M Y') }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection