<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('An OTP has been sent to your email. Please enter it below to verify your account.') }}
    </div>

    <form method="POST" action="{{ route('otp.verify.post') }}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <!-- OTP -->
        <div>
            <x-input-label for="otp" :value="__('Enter OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>