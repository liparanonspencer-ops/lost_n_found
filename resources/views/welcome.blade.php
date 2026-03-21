<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Lost & Found') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Your existing tailwind v4.0.7 fallback CSS stays here */
                {!! file_get_contents(public_path('css/fallback-tailwind.css')) !!} 
            </style>
        @endif

<style>

    .typing-effect {
        display: inline-block;
        overflow: hidden;
        border-right: 3px solid #f53003; 
        white-space: nowrap;
        margin: 0 auto;
        width: 100%; 
        animation: 
            typing 4s steps(22) infinite alternate,
            blink-caret .75s step-end infinite;
    }

    @keyframes typing { 
        from { width: 0 } 
        to { width: 100% } 
    }

    @keyframes blink-caret { 
        from, to { border-color: transparent } 
        50% { border-color: #f53003 } 
    }

   
    .typing-container {
        display: inline-flex;
        max-width: fit-content;
    }
</style>                                   
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row shadow-sm">
                
                <div class="flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold mb-2">
                            <span class="typing-effect text-[#f53003]">Lost it? Find it here.</span>
                        </h1>
                        <p class="text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                            Welcome to the official STI Lost and Found system. Reconnecting you with your belongings through a simple, organized community hub.
                        </p>
                    </div>

                    <div class="grid gap-4 mt-6">
                        <a href="{{ route('register') }}" class="group flex items-start gap-4 p-4 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] hover:bg-[#FDFDFC] dark:hover:bg-[#1b1b18] transition-all">
                            <div class="shrink-0 w-10 h-10 bg-[#fff2f2] dark:bg-[#2d1010] rounded-full flex items-center justify-center text-[#f53003]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-[14px]">Report a Lost Item</h3>
                                <p class="text-[13px] text-[#706f6c] dark:text-[#A1A09A]">Fill out a form to let others know what you've lost.</p>
                            </div>
                        </a>

                        <a href="#" class="group flex items-start gap-4 p-4 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] hover:bg-[#FDFDFC] dark:hover:bg-[#1b1b18] transition-all">
                            <div class="shrink-0 w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-[14px]">Browse Found Items</h3>
                                <p class="text-[13px] text-[#706f6c] dark:text-[#A1A09A]">Search through the gallery of items already surrendered.</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="relative lg:w-[448px] bg-[#f2f2f0] dark:bg-[#1b1b18] rounded-t-lg lg:rounded-t-none lg:rounded-r-lg overflow-hidden flex items-center justify-center p-12">
                     <div class="text-center">
                        <div class="inline-block p-4 bg-white dark:bg-[#0a0a0a] rounded-2xl shadow-xl transform -rotate-3 mb-4">
                            <svg class="w-16 h-16 text-[#f53003]" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>
                        </div>
                        <p class="text-[12px] font-medium uppercase tracking-widest text-[#706f6c]">System Status: Online</p>
                     </div>
                </div>
            </main>
        </div>

        <footer class="mt-8 text-[12px] text-[#706f6c] dark:text-[#A1A09A]">
            &copy; {{ date('Y') }} Lost & Found System &middot; School Project
        </footer>
    </body>
</html>