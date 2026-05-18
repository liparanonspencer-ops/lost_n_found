<nav x-data="{ open: false }" class="bg-stone-300 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @can('user')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-blue-400 dark:text-gray-400">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                     <x-nav-link :href="route('items.index')" :active="request()->routeIs('items.index')" class="text-black dark:text-gray-400">
                        {{ __('Items') }}
                    </x-nav-link>
                     <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="text-black dark:text-gray-400">
                        {{ __('Notifications') }}
                    </x-nav-link>
                       <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.index')" class="text-black dark:text-gray-400">
                        {{ __('Calendar') }}
                    </x-nav-link>
                     
                    @endcan
                    @can('admin')
                      <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-blue-400 dark:text-gray-400">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                     <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="text-black dark:text-gray-400">
                        {{ __('Notifications') }}
                    </x-nav-link>
                        <x-nav-link :href="route('admin.claims.index')" :active="request()->routeIs('admin.claims.index')" class="text-black dark:text-gray-400">
                            {{ __('Manage Claims') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.claims.history')" :active="request()->routeIs('admin.claims.history')" class="text-black dark:text-gray-400">
                            {{ __('Claim History') }}
                        </x-nav-link>
                    @endcan
                   
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <div class="photo-section">
        @auth
    <a href="{{ route('profile.show', Auth::id()) }}">
        <img src="{{ Auth::user()->photo_url }}" 
             class="w-10 h-10 rounded-full object-cover" 
             alt="Profile">
    </a>
@endauth
           </div>
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 transition duration-150">
                    <i class="fas fa-bell text-xl"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-1 right-1 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-[10px] text-white items-center justify-center font-bold">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        </span>
                    @endif
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->email }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('settings.edit')">
                        {{ __('Settings') }}
                    </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-400 mr-2">
                    <i class="fas fa-bell text-lg"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-600"></span>
                    @endif
                </a>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
      
            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')">
                {{ __('Notifications') }} 
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-400 text-red-800 shadow-sm animate-pulse">
                        {{ auth()->user()->unreadNotifications->count() }} new
                    </span>
                @endif
            </x-responsive-nav-link>
           
      
        
            @can('admin')
                <x-responsive-nav-link :href="route('admin.claims.index')" :active="request()->routeIs('admin.claims.index')">
                    {{ __('Manage Claims') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.claims.history')" :active="request()->routeIs('admin.claims.history')">
                    {{ __('Claim History') }}
                </x-responsive-nav-link>
            @endcan
            @can('user')
                <x-responsive-nav-link :href="route('items.index')" :active="request()->routeIs('items.index')">
                    {{ __('Items') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('items.create')" :active="request()->routeIs('items.create')">
                    {{__('Add item') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.index')">
                {{ __('Calendar') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('settings.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.show')">
                    {{__('View profile')}} 
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>