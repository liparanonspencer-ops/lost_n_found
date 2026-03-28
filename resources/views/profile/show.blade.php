@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-100">
        
        <div class="h-32 bg-gray-200"></div>

        <div class="relative px-6 pb-8">
            <div class="relative -mt-16 flex items-end space-x-5">
                <div class="relative">
                    <img class="h-32 w-32 rounded-full border-4 border-white object-cover shadow-md" 
                         src="{{ $user->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->first_name) }}" 
                         alt="Profile Photo">
                    <span class="absolute bottom-2 right-2 block h-4 w-4 rounded-full bg-green-400 ring-2 ring-white" title="Online"></span>
                </div>
                
                <div class="pb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h1>
                    <p class="text-sm font-medium text-gray-500 italic">User ID: #{{ $user->id }}</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 border-t border-gray-100 pt-8 sm:grid-cols-3">
                
                <div class="flex flex-col space-y-1">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Email Address</span>
                    <span class="text-sm text-gray-700 font-medium">{{ $user->email }}</span>
                </div>

                <div class="flex flex-col space-y-1">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Account Type</span>
                    <span class="inline-flex items-center w-fit rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        Member
                    </span>
                </div>

                <div class="flex flex-col space-y-1">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Member Since</span>
                    <span class="text-sm text-gray-700 font-medium">{{ $user->created_at->format('M Y') }}</span>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection