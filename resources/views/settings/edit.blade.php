@extends('layouts.app')
@section('content')
<div class="py-12 bg-slate-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4">
        
        <h1 class="text-2xl font-black text-slate-800 dark:text-white mb-8 transition-colors">Account Settings</h1>

        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PATCH')
            {{-- Section 2: Preferences --}}
            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-gray-700 overflow-hidden mb-8 transition-colors">
                <div class="p-8">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center transition-colors">
                        <i class="fas fa-sliders-h mr-3 text-indigo-500"></i> Preferences
                    </h2>

                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-700 dark:text-slate-200">Email Notifications</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Receive updates about your claims via email.</p>
                            </div>
                            <input type="checkbox" name="email_notifications" value="1" {{ $user->email_notifications ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500 w-6 h-6 dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <hr class="border-slate-50 dark:border-gray-700">

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-700 dark:text-slate-200">Privacy Mode</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Show my phone number to people viewing my posts.</p>
                            </div>
                            <input type="checkbox" name="show_phone_publicly" value="1" {{ $user->show_phone_publicly ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500 w-6 h-6 dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <hr class="border-slate-50 dark:border-gray-700">

                        {{-- Corrected Dark Mode Toggle --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-700 dark:text-slate-200">Dark Mode</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Reduce eye strain in low-light environments.</p>
                            </div>
                            
                            <input type="hidden" name="theme_preference" id="theme-input" value="{{ $user->theme_preference }}">

                            <button type="button" onclick="toggleDarkMode()" 
                                class="relative inline-flex h-8 w-14 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 focus:outline-none bg-slate-200 dark:bg-indigo-600">
                                
                                <span class="sr-only">Toggle Dark Mode</span>
                                
                                {{-- ONLY ONE CIRCLE SPAN --}}
                                <span id="theme-toggle-circle" class="pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow-lg ring-0 transition-all duration-300 ease-in-out {{ $user->theme_preference === 'dark' ? 'translate-x-6' : 'translate-x-0' }}">
                                    <i id="theme-toggle-icon" class="fas {{ $user->theme_preference === 'dark' ? 'fa-moon text-indigo-500' : 'fa-sun text-amber-500' }} text-[12px] flex items-center justify-center h-full transition-all duration-300"></i>
                                </span> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-slate-900 dark:bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm hover:bg-slate-800 dark:hover:bg-indigo-500 transition shadow-lg active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDarkMode() {
    const html = document.documentElement;
    const circle = document.getElementById('theme-toggle-circle');
    const icon = document.getElementById('theme-toggle-icon');
    const input = document.getElementById('theme-input');

    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        input.value = 'light';
        
        circle.classList.remove('translate-x-6');
        circle.classList.add('translate-x-0');
        
        icon.classList.replace('fa-moon', 'fa-sun');
        icon.classList.replace('text-indigo-500', 'text-amber-500');
    } else {
        html.classList.add('dark');
        input.value = 'dark';
        
        circle.classList.remove('translate-x-0');
        circle.classList.add('translate-x-6');
        
        icon.classList.replace('fa-sun', 'fa-moon');
        icon.classList.replace('text-amber-500', 'text-indigo-500');
    }
}
</script>
@endsection