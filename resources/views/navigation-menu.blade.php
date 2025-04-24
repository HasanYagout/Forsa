<nav x-data="{ open: false }" class="bg-blue-50 border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a class="flex flex-1 items-center justify-center sm:justify-center md:justify-start" href="{{ route('dashboard') }}">
                        <img class="h-16 w-auto" src="{{ asset('img/logo.png') }}" alt="Your Company">
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('jobs.index') }}" :active="request()->routeIs('jobs.index')">
                        {{ __('Jobs') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('trainings.index') }}" :active="request()->routeIs('trainings.index')">
                        {{ __('Trainings') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('contact.index') }}" :active="request()->routeIs('contact.index')">
                        {{ __('Post a job/Training') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative ms-4 border border-3 me-6 border-gray-300 rounded-full" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-1 px-2.5 py-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        @if(app()->getLocale() == 'ar')
                            <span class="text-sm">AR</span>
                        @else
                            <span class="text-sm">EN</span>
                        @endif
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-50">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                English
                                @if(app()->getLocale() == 'en')
                                    <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </a>
                            <a href="{{ route('language.switch', 'ar') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                العربية
                                @if(app()->getLocale() == 'ar')
                                    <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

            @auth
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-hidden focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-blue-50 hover:text-gray-700 focus:outline-hidden focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('bookmark.show') }}">
                                    {{ __('Saved') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login', ['tab' => 'login']) }}"
                               class="inline-block px-5 py-1.5 hover:bg-secondary bg-gray-300 rounded-xs text-white border border-transparent hover:border-[#19140035] text-sm leading-normal">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('login', ['tab' => 'register']) }}"
                                   class="inline-block px-5 py-1.5 border-[#19140035] bg-secondary hover:border-[#1915014a] border text-white rounded-xs text-sm leading-normal">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        </div>

                @endauth
            </div>

            <!-- Language Dropdown -->

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('jobs.index') }}" :active="request()->routeIs('jobs.index')">
                {{ __('Jobs') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('trainings.index') }}" :active="request()->routeIs('trainings.index')">
                {{ __('Trainings') }}
            </x-responsive-nav-link>
        </div>
        <div class="px-4 pt-2 pb-3 border-t border-gray-200">
            <div class="flex flex-col gap-2">
                <a href="{{ route('language.switch', 'en') }}" class="flex justify-between items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                    English
                    @if(app()->getLocale() == 'en')
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
                <a href="{{ route('language.switch', 'ar') }}" class="flex justify-between items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                    العربية
                    @if(app()->getLocale() == 'ar')
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            </div>
        </div>
        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link
                    href="{{ route('login', ['tab' => 'login']) }}"
                    :active="request()->routeIs('login') && request('tab') === 'login'">
                    {{ __('Log in') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link
                        href="{{ route('login', ['tab' => 'register']) }}"
                        :active="request()->routeIs('login') && request('tab') === 'register'">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>
