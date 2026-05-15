<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ Auth::user()->theme_preference === 'dark' ? 'dark' : '' }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

        <title>{{ config('app.name', 'STI lost&found') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            function toggleDarkMode() {
                const html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    document.getElementById('theme-input').value = 'light';
                } else {
                    html.classList.add('dark');
                    document.getElementById('theme-input').value = 'dark';
                }
            }
        </script>
        
        @stack('styles')
        <style>
            /* Base Calendar Styling */
            #calendar {
                background: white;
                padding: 20px;
                border-radius: 2rem; /* Matches your dashboard UI */
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            /* DARK MODE OVERRIDES */
            .dark #calendar {
                background: #1f2937; /* Gray-800 to match dashboard cards */
                border: 1px solid #374151; /* Gray-700 */
                box-shadow: none;
            }

            /* FullCalendar Internal Text Fixes for Dark Mode */
            .dark .fc {
                --fc-border-color: #374151;
                --fc-daygrid-event-dot-width: 8px;
                --fc-page-bg-color: #1f2937;
                --fc-neutral-bg-color: #111827;
                --fc-list-event-hover-bg-color: #374151;
            }

            .dark .fc .fc-col-header-cell-cushion,
            .dark .fc .fc-daygrid-day-number,
            .dark .fc .fc-toolbar-title {
                color: #f3f4f6 !important; /* gray-100 */
            }

            .dark .fc .fc-button-primary {
                background-color: #4f46e5 !important; /* indigo-600 */
                border: none !important;
            }

            .dark .fc .fc-button-primary:hover {
                background-color: #4338ca !important; /* indigo-700 */
            }

            .dark .fc td, .dark .fc th {
                border-color: #374151 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-zinc-100 dark:bg-gray-900 transition-colors duration-300">
            @include('layouts.navigation')

            <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>

            @if(session('success'))
                <div class="fixed bottom-10 right-10 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 animate-bounce">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <main>
                @yield('content')
            </main>
        </div>

        @stack('scripts')
    </body>
</html>