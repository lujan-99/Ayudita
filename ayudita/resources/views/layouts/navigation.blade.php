<nav x-data="{ open: false }" class="fixed inset-x-0 top-0 z-50 border-b border-outline-variant/80 bg-surface/90 backdrop-blur-xl">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-4">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logos/logo-horizontal.svg') }}" class="block h-10 w-auto max-w-[180px]" alt="{{ config('app.name', 'STUDENT_PATTERNS') }} logo">
                        <span class="hidden text-sm font-semibold tracking-[0.28em] text-primary uppercase md:inline">{{ config('app.name', 'STUDENT_PATTERNS') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center gap-2 sm:ms-8 sm:flex">
                    <a href="{{ route('dashboard') }}" class="rounded-full border border-outline-variant px-4 py-2 text-sm font-medium text-foreground transition hover:border-primary hover:text-primary">
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-full border border-outline-variant bg-surface-container px-4 py-2 text-sm font-medium text-foreground transition hover:border-primary hover:text-primary focus:outline-none">
                            <div class="max-w-[10rem] truncate">{{ Auth::user()->name }}</div>

                            <div class="ms-1 text-muted">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-full border border-outline-variant bg-surface-container p-2.5 text-foreground transition hover:border-primary hover:text-primary focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-outline-variant bg-surface/98 sm:hidden">
        <div class="mx-auto max-w-7xl space-y-2 px-4 py-4 sm:px-6">
            <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-outline-variant bg-surface-container px-4 py-3 text-sm font-medium text-foreground">
                Dashboard
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-outline-variant px-4 pb-4 pt-4">
            <div class="rounded-2xl border border-outline-variant bg-surface-container px-4 py-4">
                <div class="font-medium text-base text-foreground">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-muted">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-4 space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
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
