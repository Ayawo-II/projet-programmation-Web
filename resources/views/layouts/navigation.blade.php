<nav x-data="{ open: false }" class="navbar bg-white/90 backdrop-blur border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-slate-900">
                    <x-application-logo class="block h-10 w-auto fill-current text-cyan-600" />
                    <span class="text-lg font-semibold">AskCampus</span>
                </a>

                <div class="hidden items-center gap-1 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profil') }}
                    </x-nav-link>
                </div>
            </div>

            @php $user = Auth::user(); @endphp
            @if($user)
                <div class="hidden sm:flex sm:items-center sm:gap-4">
                    <!-- Notification Bell -->
                    <x-notification-bell />

                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                <span>{{ __('Mon compte') }}</span>
                                <svg class="ms-2 h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profil') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-primary">{{ __('Connexion') }}</a>
                    <a href="{{ route('register') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:border-primary hover:text-primary">{{ __('Inscription') }}</a>
                </div>
            @endif

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">{{ __('Profil') }}</x-responsive-nav-link>
        </div>

        @if($user)
            <div class="border-t border-slate-200 pt-4 pb-1">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-900">{{ $user->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ $user->email }}</div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profil') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="border-t border-slate-200 pt-4 pb-1">
                <div class="px-4 flex flex-col gap-3">
                    <a href="{{ route('login') }}" class="font-medium text-base text-slate-900 hover:text-primary">{{ __('Connexion') }}</a>
                    <a href="{{ route('register') }}" class="font-medium text-sm text-slate-500 hover:text-primary">{{ __('Inscription') }}</a>
                </div>
            </div>
        @endif
    </div>
</nav>
