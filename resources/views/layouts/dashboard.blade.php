<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags (No Index for Private Dashboard) -->
    <title>@if (isset($title)) {{ $title }} - Ayudita USFX @else Panel de Estudiante - Ayudita USFX @endif</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo-favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- CSS & JS Assets (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" class="bg-mesh text-on-surface font-body-lg antialiased min-h-screen flex transition-all duration-300">

    <!-- Menú Lateral -->
    <nav class="hidden md:flex bg-surface-container-low text-primary font-display text-body-sm fixed left-0 top-0 h-full border-r border-outline-variant flex-col p-4 gap-bento-gap z-40 pt-20 transition-all duration-300"
         :class="sidebarCollapsed ? 'w-20 items-center' : 'w-64'">
        
        <!-- Toggle Button -->
        <button @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)"
                class="hidden md:flex items-center justify-center w-8 h-8 rounded-full bg-surface-container border border-outline-variant hover:bg-surface-variant text-on-surface hover:text-primary transition-all absolute top-4 right-[-16px] z-50 shadow-md">
            <span class="material-symbols-outlined text-[18px] transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''">chevron_left</span>
        </button>

        <div class="flex items-center gap-3 mb-8 transition-all duration-300" :class="sidebarCollapsed ? 'px-0 justify-center' : 'px-2'">
            <img alt="Ayudita Logo" class="w-8 h-8 rounded-DEFAULT object-cover border border-outline-variant" src="{{ asset('images/logos/logo-icono.svg') }}"/>
            <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>
                <h1 class="font-display text-headline-md font-bold text-primary">Ayudita</h1>
                <p class="font-body-sm text-on-surface-variant text-[10px] uppercase tracking-widest mt-1">Comunidad USFX</p>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-2 w-full">
            <a class="flex items-center gap-3 px-3 py-2 {{ Request::routeIs('dashboard') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('dashboard') }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                <span class="material-symbols-outlined {{ Request::routeIs('dashboard') ? 'fill-icon' : '' }} text-[20px]">dashboard</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 {{ Request::routeIs('materias.index') || Request::routeIs('materias.show') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('materias.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                <span class="material-symbols-outlined {{ Request::routeIs('materias.index') || Request::routeIs('materias.show') ? 'fill-icon' : '' }} text-[20px]">auto_stories</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Materias</span>
            </a>
            <!-- Botones que abren el Paywall -->
            <a class="flex items-center gap-3 px-3 py-2 {{ Request::routeIs('plan-estudios') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('plan-estudios') }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                <span class="material-symbols-outlined {{ Request::routeIs('plan-estudios') ? 'fill-icon' : '' }} text-[20px]">map</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Planes de Estudio</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 {{ Request::routeIs('docentes.index') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('docentes.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                <span class="material-symbols-outlined {{ Request::routeIs('docentes.index') ? 'fill-icon' : '' }} text-[20px]">shield_person</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Docentes</span>
            </a>
        </div>
        <div class="mt-auto mb-6 w-full flex justify-center" :class="sidebarCollapsed ? 'px-0' : 'px-2'">
            <button @click="$dispatch('open-modal', 'premium-paywall')" class="bg-primary text-on-primary font-bold rounded-DEFAULT hover:brightness-110 transition-all text-body-sm" :class="sidebarCollapsed ? 'w-10 h-10 p-0 flex items-center justify-center' : 'w-full py-2 px-4'">
                <span x-show="sidebarCollapsed" class="material-symbols-outlined text-[20px]">workspace_premium</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Ver Mi Plan</span>
            </button>
        </div>
        <div class="flex flex-col gap-2 pt-4 border-t border-outline-variant/30 w-full">
            <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-variant/30 rounded-lg transition-all" href="#" :class="sidebarCollapsed ? 'justify-center' : ''">
                <span class="material-symbols-outlined text-[18px]">help</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Ayuda</span>
            </a>
        </div>
    </nav>

    <!-- Área de Contenido Principal -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
         :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'">
        
        <!-- Navbar Superior -->
        <header class="bg-surface text-primary font-display text-body-lg fixed top-0 right-0 z-50 border-b border-outline-variant flex justify-between items-center h-16 px-margin-mobile md:px-margin-desktop transition-all duration-300"
                :class="sidebarCollapsed ? 'w-full md:w-[calc(100%-5rem)]' : 'w-full md:w-[calc(100%-16rem)]'">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full max-w-md hidden md:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input class="w-full bg-surface-container-low border border-outline-variant rounded-DEFAULT pl-10 pr-4 py-1.5 text-body-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Buscar materias o patrones..." type="text"/>
                </div>
                <div class="md:hidden font-display text-headline-md font-bold text-primary">
                    Ayudita
                </div>
                @isset($headerText)
                    <div class="font-display font-bold text-on-surface tracking-wide hidden md:block pl-4">
                        {{ $headerText }}
                    </div>
                @endisset
            <div class="flex items-center gap-4">
                @if(Auth::user()->perfilEstudiante)
                    <div class="hidden md:flex flex-col text-right leading-none select-none pr-2">
                        <span class="text-xs font-bold text-primary mb-1">{{ Auth::user()->perfilEstudiante->nickname }}</span>
                        <span class="text-[9px] font-label-mono text-on-surface-variant uppercase tracking-wider">
                            {{ Auth::user()->role_id == 1 ? 'Base' : 'Pro' }} • {{ Auth::user()->perfilEstudiante->puntos }} Pts
                        </span>
                    </div>
                @endif
                @if(Auth::user()->role_id == 1)
                    <button type="button" @click="$dispatch('open-modal', 'premium-paywall')" class="hidden md:block px-4 py-1.5 border border-outline-variant text-on-surface hover:border-primary text-body-sm rounded-DEFAULT transition-all hover:bg-surface-variant/50">
                        Mejorar a Pro ✨
                    </button>
                @endif
                <button class="text-on-surface-variant hover:text-primary hover:bg-surface-variant/50 transition-colors p-2 rounded-full">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                
                <!-- Menú Desplegable de Usuario -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="relative w-8 h-8 rounded-full bg-surface-container-high border border-outline-variant overflow-hidden cursor-pointer ml-2">
                            <div class="w-full h-full flex items-center justify-center bg-primary/20 text-primary font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-2.5 h-2.5 {{ Auth::user()->role_id == 1 ? 'bg-secondary' : 'bg-primary-container' }} rounded-full border border-surface"></div>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if (Auth::user()->role && Auth::user()->role->nombre === 'admin')
                            <x-dropdown-link :href="route('admin.dashboard')">
                                Panel Admin
                            </x-dropdown-link>
                        @endif

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
        </header>

        <!-- Main Canvas -->
        <main class="flex-1 pt-24 pb-12 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full flex flex-col gap-8">
            {{ $slot }}
        </main>

        <!-- Pie de Página (Footer) con Redes Sociales Unificadas -->
        <footer class="bg-surface-container-lowest text-on-surface-variant w-full py-12 border-t border-outline-variant max-w-container-max mx-auto px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-6 mt-auto">
            <div class="flex flex-col items-center md:items-start gap-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">hub</span>
                    <span class="font-display text-body-lg font-bold text-primary tracking-tight">Ayudita</span>
                </div>
                <p class="text-xs text-on-surface-variant text-center md:text-left">Problemas de antes, soluciones para hoy. Elevando el nivel académico de Sucre y la USFX.</p>
            </div>
            
            <!-- Redes de la comunidad -->
            <div class="flex flex-col items-center gap-3">
                <span class="font-label-mono text-[11px] text-on-surface-variant uppercase tracking-wider">Sigue a la Comunidad</span>
                <div class="flex items-center gap-5 text-on-surface-variant">
                    <a href="https://www.tiktok.com/@ayuditausfx0?is_from_webapp=1&sender_device=pc" target="_blank" class="hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.01 1.62 4.14.94 1.08 2.27 1.81 3.69 2.07v3.89c-1.78-.14-3.48-.89-4.73-2.18-.1-.09-.17-.22-.3-.38v6.82c.02 4.05-2.52 7.77-6.37 9.03-3.85 1.26-8.2-.1-10.45-3.37A9.342 9.342 0 0 1 1.02 13c-.15-4.4 2.89-8.41 7.14-9.55 1.1-.3 2.25-.39 3.38-.27V7.1c-.88-.16-1.8-.07-2.61.31-1.63.75-2.63 2.51-2.43 4.3.2 1.8 1.7 3.23 3.5 3.23 1.63 0 3.03-1.18 3.28-2.79.05-.31.06-.63.06-.94V.02z"/></svg>
                    </a>
                    <a href="https://youtube.com/@ayudita-w4tf?si=oxi0buOmWOT248Fl" target="_blank" class="hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/ayuditausfx" target="_blank" class="hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.062 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <div class="text-center md:text-right font-label-mono text-[11px] opacity-70">
                <p>© 2026 Ayudita Inc. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <!-- MODAL DEL PAYWALL PREMIUM COMPARTIDO -->
    <x-modal name="premium-paywall" maxWidth="5xl">
        <div class="p-6 md:p-10 bg-surface-container rounded-xl relative -m-6">
            <button @click="$dispatch('close-modal', 'premium-paywall')" class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>

            <div class="text-center max-w-2xl mx-auto mb-8">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <img alt="Ayudita Logo" class="w-8 h-8 rounded-md border border-outline-variant/50" src="{{ asset('images/logos/logo-icono.svg') }}">
                    <span class="font-display text-headline-sm font-bold text-primary">Ayudita Pro</span>
                </div>
                <h2 class="font-display text-headline-md font-bold text-on-surface mb-2">Desbloquea todo el Ecosistema Académico</h2>
                <p class="font-body-sm text-on-surface-variant">Acceso ilimitado a exámenes pasados resueltos, pizarras de auxiliaturas, apuntes y consejos específicos de tus docentes.</p>
            </div>

            <!-- Pricing Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Plan Mensual -->
                <div class="bg-surface-container-low border border-outline-variant/60 rounded-xl p-6 flex flex-col justify-between hover:border-primary/50 transition-all group relative">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-primary text-[20px]">calendar_today</span>
                            <h3 class="font-display text-body-lg font-bold text-on-surface">Plan Mensual</h3>
                        </div>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Prueba todas las funciones premium por un mes.</p>
                        
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="font-display text-lg text-on-surface font-semibold">Bs</span>
                            <span class="font-display text-4xl font-bold text-primary">10</span>
                            <span class="font-label-mono text-[10px] text-on-surface-variant">/ mes</span>
                        </div>

                        <ul class="space-y-3 text-xs text-on-surface-variant mb-6">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Exámenes resueltos de tu grupo</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Pizarras y guías en PDF</span>
                            </li>
                        </ul>
                    </div>
                    <button @click="$dispatch('close-modal', 'premium-paywall'); alert('¡Gracias por elegir el Plan Mensual! Lógica de pago próximamente.')" class="w-full py-2.5 bg-surface-container-high border border-outline-variant text-on-surface hover:border-primary text-xs font-bold rounded-lg transition-all">
                        Elegir Plan
                    </button>
                </div>

                <!-- Plan Semestral (Best Value) -->
                <div class="bg-surface-container-low border-2 border-primary rounded-xl p-6 flex flex-col justify-between hover:scale-[1.01] transition-all group relative">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-primary text-on-primary font-label-mono text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md whitespace-nowrap">
                        Recomendado • Ahorra 33%
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3 mt-1">
                            <span class="material-symbols-outlined text-primary text-[20px]">event_repeat</span>
                            <h3 class="font-display text-body-lg font-bold text-on-surface">Plan Semestral</h3>
                        </div>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Perfecto para asegurar todo tu periodo académico.</p>
                        
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="font-display text-lg text-on-surface font-semibold">Bs</span>
                            <span class="font-display text-4xl font-bold text-primary">40</span>
                            <span class="font-label-mono text-[10px] text-on-surface-variant">/ 6 meses</span>
                        </div>

                        <ul class="space-y-3 text-xs text-on-surface-variant mb-6">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Exámenes resueltos de tu grupo</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Pizarras y guías en PDF</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Soporte prioritario</span>
                            </li>
                        </ul>
                    </div>
                    <button @click="$dispatch('close-modal', 'premium-paywall'); alert('¡Gracias por elegir el Plan Semestral! Lógica de pago próximamente.')" class="w-full py-2.5 bg-primary text-on-primary hover:brightness-110 text-xs font-bold rounded-lg transition-all shadow-[0_0_12px_rgba(183,109,255,0.3)]">
                        Adquirir Plan
                    </button>
                </div>

                <!-- Plan Anual (Best Deal) -->
                <div class="bg-surface-container-low border border-outline-variant/60 rounded-xl p-6 flex flex-col justify-between hover:border-primary/50 transition-all group relative">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary font-label-mono text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md whitespace-nowrap">
                        Mejor Ahorro • Ahorra 41%
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3 mt-1">
                            <span class="material-symbols-outlined text-primary text-[20px]">workspace_premium</span>
                            <h3 class="font-display text-body-lg font-bold text-on-surface">Plan Anual</h3>
                        </div>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Para estudiantes comprometidos a largo plazo.</p>
                        
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="font-display text-lg text-on-surface font-semibold">Bs</span>
                            <span class="font-display text-4xl font-bold text-primary">70</span>
                            <span class="font-label-mono text-[10px] text-on-surface-variant">/ año</span>
                        </div>

                        <ul class="space-y-3 text-xs text-on-surface-variant mb-6">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Acceso total sin límite de tiempo</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Todos los recursos de tu carrera</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                <span>Descarga libre de proyectos</span>
                            </li>
                        </ul>
                    </div>
                    <button @click="$dispatch('close-modal', 'premium-paywall'); alert('¡Gracias por elegir el Plan Anual! Lógica de pago próximamente.')" class="w-full py-2.5 bg-surface-container-high border border-outline-variant text-on-surface hover:border-primary text-xs font-bold rounded-lg transition-all">
                        Elegir Plan
                    </button>
                </div>
            </div>

            <div class="text-center text-[10px] text-on-surface-variant">
                Lógica de pasarela de pago (QR / Tigo Money) próximamente en producción.
            </div>
        </div>
    </x-modal>

    @stack('scripts')
</body>
</html>
