<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-100 dark:bg-indigo-900">
            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Help someone find what they've lost today.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold" />
            <div class="relative mt-1">
                <x-text-input id="email" 
                    class="block w-full pl-4 transition duration-200 ease-in-out border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="name@example.com"
                    required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="relative mt-1">
                <x-text-input id="password" 
                    class="block w-full pl-4 transition duration-200 ease-in-out border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 shadow-sm" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                {{ __('Stay signed in for 30 days') }}
            </label>
        </div>

        <div>
            <x-primary-button class="flex justify-center w-full py-3 text-sm font-bold tracking-widest uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500">Create one now</a>
            </p>
        </div>
    </form>
</x-guest-layout>