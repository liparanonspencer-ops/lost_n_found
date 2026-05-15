<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-green-100 dark:bg-green-900/30">
            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Account</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Join our community to help return lost items.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" class="font-semibold" />
                <x-text-input id="first_name" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" type="text" name="first_name" :value="old('first_name')" required autofocus placeholder="John" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" class="font-semibold" />
                <x-text-input id="last_name" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" type="text" name="last_name" :value="old('last_name')" required placeholder="Doe" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="address" :value="__('Full Address')" class="font-semibold" />
            <x-text-input id="address" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" type="text" name="address" :value="old('address')" required placeholder="Street, City, Province" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" type="email" name="email" :value="old('email')" required placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500" type="password" name="password_confirmation" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-2">
            <x-primary-button class="flex justify-center w-full py-3 text-sm font-bold tracking-widest uppercase bg-indigo-600 rounded-lg hover:bg-indigo-700">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Already have an account?') }} 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500">
                    {{ __('Sign In') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>