<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-amber-100 dark:bg-amber-900/30">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset Password</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('No problem. Enter your email and we\'ll send you a link to get back into your account.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Registered Email')" class="font-semibold" />
            <div class="relative mt-1">
                <x-text-input id="email" 
                    class="block w-full pl-4 transition duration-200 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="Enter the email you used to sign up"
                    required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col space-y-4">
            <x-primary-button class="flex justify-center w-full py-3 text-sm font-bold tracking-widest uppercase transition duration-150 bg-indigo-600 rounded-lg hover:bg-indigo-700">
                {{ __('Send Reset Link') }}
            </x-primary-button>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                    &larr; {{ __('Back to Login') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>