<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Theme Initialization Script -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light' || (!savedTheme && window.matchMedia('(prefers-color-scheme: light)').matches)) {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            }
        })();
    </script>

    <!-- SEO Meta Tags (No Index for Private Dashboard) -->
    <title>@if (isset($title)) {{ $title }} - Ayudita USFX @else Panel de Estudiante - Ayudita USFX @endif</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo-icono.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- CSS & JS Assets (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ 
    sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    mobileSidebarOpen: false,
    darkTheme: localStorage.getItem('theme') !== 'light',
    toggleTheme() {
        this.darkTheme = !this.darkTheme;
        localStorage.setItem('theme', this.darkTheme ? 'dark' : 'light');
        this.applyTheme();
    },
    applyTheme() {
        if (this.darkTheme) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="applyTheme()" class="bg-mesh text-on-surface font-body-lg antialiased min-h-screen flex transition-all duration-300">

    <!-- Backdrop de Mobile Sidebar -->
    <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-xs z-40 md:hidden" style="display: none;"></div>

    <!-- Menú Lateral -->
    <nav class="fixed left-0 top-0 h-full border-r border-outline-variant bg-surface-container-low text-primary font-display text-body-sm flex flex-col p-3 pb-4 z-50 transition-all duration-300 transform md:translate-x-0"
         :class="[
            sidebarCollapsed ? 'md:w-20 md:items-center' : 'md:w-64',
            mobileSidebarOpen ? 'w-64 translate-x-0' : 'w-64 -translate-x-full md:translate-x-0'
         ]">
        
        <!-- Toggle Button (Desktop Only) -->
        <button @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)"
                class="hidden md:flex items-center justify-center w-8 h-8 rounded-full bg-surface-container border border-outline-variant hover:bg-surface-variant text-on-surface hover:text-primary transition-all absolute top-[72px] -right-4 z-50 shadow-md cursor-pointer"
                title="Contraer/Expandir menú">
            <span class="material-symbols-outlined text-[18px] transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''">chevron_left</span>
        </button>

        <!-- Close Button (Mobile Drawer Only) -->
        <button @click="mobileSidebarOpen = false" class="md:hidden absolute top-4 right-4 text-on-surface-variant hover:text-primary transition-colors p-2 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">close</span>
        </button>

        <!-- Logo/Branding Container -->
        <div class="h-16 flex items-center gap-3 border-b border-outline-variant/30 mb-6 w-full transition-all duration-300 shrink-0" :class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'">
            <img alt="Ayudita Logo" class="w-12 h-12 rounded-DEFAULT object-cover border border-outline-variant" src="{{ asset('images/logos/logo-icono.svg') }}"/>
            <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex flex-col overflow-hidden whitespace-nowrap">
                <h1 class="font-display text-headline-md font-bold text-primary leading-none">Ayudita</h1>
                <span class="font-body-sm text-on-surface-variant text-[9px] uppercase tracking-widest mt-1">Comunidad USFX</span>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-2 w-full">
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('dashboard') ? 'bg-primary-container text-on-primary-container font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('dashboard') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Dashboard">
                @if(Request::routeIs('dashboard'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('dashboard') ? 'fill-icon' : '' }} text-[20px]">dashboard</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Dashboard</span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('materias.index') || Request::routeIs('materias.show') ? 'bg-primary-container text-on-primary-container font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('materias.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Materias">
                @if(Request::routeIs('materias.index') || Request::routeIs('materias.show'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('materias.index') || Request::routeIs('materias.show') ? 'fill-icon' : '' }} text-[20px]">auto_stories</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Materias</span>
            </a>
            <!-- Botones que abren el Paywall -->
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('plan-estudios') ? 'bg-primary-container text-on-primary-container font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('plan-estudios') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Planes de Estudio">
                @if(Request::routeIs('plan-estudios'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('plan-estudios') ? 'fill-icon' : '' }} text-[20px]">map</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex items-center justify-between w-full">
                    <span>Planes de Estudio</span>
                </span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('docentes.index') ? 'bg-primary-container text-on-primary-container font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('docentes.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Docentes">
                @if(Request::routeIs('docentes.index'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('docentes.index') ? 'fill-icon' : '' }} text-[20px]">shield_person</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex items-center justify-between w-full">
                    <span>Docentes</span>
                    @if(!Auth::user()->isPremium())
                        <span class="material-symbols-outlined text-[16px] text-amber-400 fill-icon animate-pulse" title="Premium">workspace_premium</span>
                    @endif
                </span>
            </a>
        </div>
        <div class="mt-auto mb-6 w-full flex justify-center" :class="sidebarCollapsed ? 'px-0' : 'px-2'">
            <button @click="$dispatch('open-modal', 'premium-paywall')" class="bg-primary text-on-primary font-bold rounded-DEFAULT hover:brightness-110 transition-all text-body-sm" :class="sidebarCollapsed ? 'w-10 h-10 p-0 flex items-center justify-center rounded-xl' : 'w-full py-2 px-4'" title="Ver Mi Plan">
                <span x-show="sidebarCollapsed" class="material-symbols-outlined text-[20px]">workspace_premium</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Ver Mi Plan</span>
            </button>
        </div>
        <div class="flex flex-col gap-2 pt-4 border-t border-outline-variant/30 w-full">
            <a class="relative flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-variant/30 rounded-lg transition-all" href="#" :class="sidebarCollapsed ? 'justify-center' : ''" title="Ayuda">
                <span class="material-symbols-outlined text-[18px]">help</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Ayuda</span>
            </a>
        </div>
    </nav>

    <!-- Área de Contenido Principal -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
         :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'">
        
        <!-- Navbar Superior -->
        <header class="bg-surface text-primary font-display text-body-lg fixed top-0 right-0 z-40 border-b border-outline-variant flex justify-between items-center h-16 px-margin-mobile md:px-margin-desktop transition-all duration-300"
                :class="sidebarCollapsed ? 'w-full md:w-[calc(100%-5rem)]' : 'w-full md:w-[calc(100%-16rem)]'">
            <div class="flex items-center gap-2 w-full md:w-auto">
                <!-- Mobile Menu Toggle -->
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden text-on-surface-variant hover:text-primary transition-colors p-2 rounded-full mr-1 flex items-center justify-center cursor-pointer" title="Abrir menú">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="relative w-full max-w-md hidden md:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input class="w-full bg-surface-container-low border border-outline-variant rounded-DEFAULT pl-10 pr-4 py-1.5 text-body-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Buscar materias o patrones..." type="text"/>
                </div>
                <div class="md:hidden font-display text-headline-md font-bold text-primary flex items-center gap-2">
                    <img alt="Ayudita Logo" class="w-10 h-10 rounded-DEFAULT border border-outline-variant" src="{{ asset('images/logos/logo-icono.svg') }}"/>
                    <span>Ayudita</span>
                </div>
                @isset($headerText)
                    @php
                        $parts = explode(' / ', $headerText);
                        $secondPart = $parts[1] ?? '';
                        $secondIcon = 'bookmark';
                        if (str_contains(strtolower($secondPart), 'plan') || str_contains(strtolower($headerText), 'plan')) {
                            $secondIcon = 'map';
                        } elseif (str_contains(strtolower($secondPart), 'docente') || str_contains(strtolower($secondPart), 'perfil')) {
                            $secondIcon = 'shield_person';
                        } elseif (str_contains(strtolower($secondPart), 'asignatura') || str_contains(strtolower($secondPart), 'materia')) {
                            $secondIcon = 'auto_stories';
                        } elseif (str_contains(strtolower($secondPart), 'ecosistema')) {
                            $secondIcon = 'psychology';
                        }
                    @endphp
                    <div class="flex items-center gap-2 font-display text-body-sm hidden md:flex pl-4 select-none">
                        @if(count($parts) > 1)
                            <span class="flex items-center gap-1.5 text-on-surface-variant/80 hover:text-primary transition-colors font-medium">
                                <span class="material-symbols-outlined text-[16px] text-primary">account_balance</span>
                                {{ $parts[0] }}
                            </span>
                            <span class="material-symbols-outlined text-outline-variant text-[14px] leading-none">chevron_right</span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container/20 border border-primary-container/30 text-primary font-bold text-xs shadow-xs">
                                <span class="material-symbols-outlined text-[14px] fill-icon">{{ $secondIcon }}</span>
                                {{ $secondPart }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container/20 border border-primary-container/30 text-primary font-bold text-xs shadow-xs">
                                <span class="material-symbols-outlined text-[14px] fill-icon">{{ $secondIcon }}</span>
                                {{ $headerText }}
                            </span>
                        @endif
                    </div>
                @endisset
            </div>
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
                <!-- Theme Toggle Button -->
                <button @click="toggleTheme()" class="text-on-surface-variant hover:text-primary hover:bg-surface-variant/50 transition-colors p-2 rounded-full flex items-center justify-center" title="Alternar tema">
                    <span x-show="darkTheme" class="material-symbols-outlined" style="display: none;">light_mode</span>
                    <span x-show="!darkTheme" class="material-symbols-outlined" style="display: none;">dark_mode</span>
                </button>

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
        <footer class="bg-surface-container-lowest text-on-surface-variant w-full py-12 border-t border-outline-variant mt-auto">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-6 w-full">
                <div class="flex flex-col items-center md:items-start gap-2">
                    <div class="flex items-center gap-2.5">
                        <img alt="Ayudita Logo" class="w-6 h-6 rounded-md border border-outline-variant/30" src="{{ asset('images/logos/logo-icono.svg') }}"/>
                        <span class="font-display text-body-lg font-bold text-primary tracking-tight">Ayudita</span>
                    </div>
                    <p class="text-xs text-on-surface-variant text-center md:text-left">Problemas de antes, soluciones para hoy. Elevando el nivel académico de Sucre y la USFX.</p>
                </div>
                
                <!-- Redes de la comunidad -->
                <div class="flex flex-col items-center gap-3">
                    <span class="font-label-mono text-[11px] text-on-surface-variant uppercase tracking-wider">Sigue a la Comunidad</span>
                    <div class="flex items-center gap-5 text-on-surface-variant">
                        <a href="https://www.tiktok.com/@ayuditausfx0" target="_blank" class="hover:text-primary transition-colors duration-200" title="TikTok">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.01 1.62 4.14.94 1.08 2.27 1.81 3.69 2.07v3.89c-1.78-.14-3.48-.89-4.73-2.18-.1-.09-.17-.22-.3-.38v6.82c.02 4.05-2.52 7.77-6.37 9.03-3.85 1.26-8.2-.1-10.45-3.37A9.342 9.342 0 0 1 1.02 13c-.15-4.4 2.89-8.41 7.14-9.55 1.1-.3 2.25-.39 3.38-.27V7.1c-.88-.16-1.8-.07-2.61.31-1.63.75-2.63 2.51-2.43 4.3.2 1.8 1.7 3.23 3.5 3.23 1.63 0 3.03-1.18 3.28-2.79.05-.31.06-.63.06-.94V.02z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/ayuditausfx/" target="_blank" class="hover:text-primary transition-colors duration-200" title="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.062 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/share/1KxGd7doF9/" target="_blank" class="hover:text-primary transition-colors duration-200" title="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@ayudita-w4tf" target="_blank" class="hover:text-primary transition-colors duration-200" title="YouTube">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.518 3.5 12 3.5 12 3.5s-7.518 0-9.388.553a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11C4.482 20.5 12 20.5 12 20.5s7.518 0 9.388-.553a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div class="text-center md:text-right font-label-mono text-[11px] opacity-70 flex flex-col items-center md:items-end gap-1">
                    <p>© 2026 Ayudita Inc. Todos los derechos reservados.</p>
                    <div class="flex gap-3 text-[10px]">
                        <a href="{{ route('terminos') }}" class="hover:text-primary transition-colors underline">Términos y Condiciones</a>
                        <a href="{{ route('privacidad') }}" class="hover:text-primary transition-colors underline">Política de Privacidad</a>
                    </div>
                </div>
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
                <div class="flex items-center justify-center gap-2.5 mb-4">
                    <img alt="Ayudita Logo" class="w-16 h-16 rounded-md border border-outline-variant/50" src="{{ asset('images/logos/logo-icono.svg') }}">
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
                    <button @click="window.location.href = '{{ route('paywall') }}?plan=mensual'" class="w-full py-2.5 bg-surface-container-high border border-outline-variant text-on-surface hover:border-primary text-xs font-bold rounded-lg transition-all">
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
                    <button @click="window.location.href = '{{ route('paywall') }}?plan=semestral'" class="w-full py-2.5 bg-primary text-on-primary hover:brightness-110 text-xs font-bold rounded-lg transition-all shadow-[0_0_12px_rgba(183,109,255,0.3)]">
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
                    <button @click="window.location.href = '{{ route('paywall') }}?plan=anual'" class="w-full py-2.5 bg-surface-container-high border border-outline-variant text-on-surface hover:border-primary text-xs font-bold rounded-lg transition-all">
                        Elegir Plan
                    </button>
                </div>
            </div>

            <!-- Points Redemption Banner inside Modal -->
            @if(Auth::check() && Auth::user()->perfilEstudiante)
                <div class="mt-6 p-5 rounded-xl border border-outline-variant bg-surface-container flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[28px]">stars</span>
                        </div>
                        <div>
                            <h4 class="font-display text-body-lg font-bold text-on-surface">¿Tienes puntos acumulados?</h4>
                            <p class="text-xs text-on-surface-variant max-w-xl">
                                Tienes <strong class="text-primary">{{ Auth::user()->perfilEstudiante->puntos }} Pts</strong>. Puedes canjear 10 puntos por 1 mes de acceso Pro. Sube apuntes y gana 15 pts por archivo.
                            </p>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto shrink-0">
                        @if(Auth::user()->perfilEstudiante->puntos >= 10)
                            <button onclick="redeemPointsWithFetch()" id="modal-btn-redeem" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-primary to-secondary text-on-primary font-bold text-xs rounded-lg transition-all hover:brightness-110 active:scale-[0.98] flex items-center justify-center gap-1.5 shadow-md cursor-pointer border-0">
                                <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                                Canjear 10 Puntos por 1 Mes Pro
                            </button>
                        @else
                            <div class="flex flex-col items-stretch gap-2">
                                <button disabled class="w-full sm:w-auto px-6 py-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant/40 font-bold text-xs rounded-lg cursor-not-allowed flex items-center justify-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">lock</span>
                                    Necesitas 10 Puntos
                                </button>
                                <a href="{{ route('materias.index') }}" class="text-[10px] text-center text-primary hover:underline">
                                    Subir apuntes para ganar puntos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="text-center text-[10px] text-on-surface-variant mt-4">
                Los pagos son procesados de forma instantánea y segura mediante PayPal.
            </div>
        </div>
    </x-modal>

    <script>
        function redeemPointsWithFetch() {
            if (!confirm('¿Estás seguro de que deseas canjear 10 puntos por 1 mes de acceso Pro?')) {
                return;
            }
            
            const btn = document.getElementById('modal-btn-redeem') || document.getElementById('btn-redeem-points');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full mr-2"></span> Procesando...';
            }
            
            fetch("{{ route('premium.redeem_points') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(res => {
                if (res.success) {
                    alert(res.message);
                    window.location.href = "{{ route('dashboard') }}";
                } else {
                    throw new Error(res.message || 'No se pudo canjear los puntos.');
                }
            })
            .catch(err => {
                console.error('Error redeeming points:', err);
                alert('Error: ' + (err.message || 'Ocurrió un error al canjear los puntos. Por favor, inténtalo de nuevo.'));
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">workspace_premium</span> Canjear 10 Puntos por 1 Mes Pro';
                }
            });
        }
    </script>

    @stack('scripts')
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6a2c0a760451a21c2ebc2fe6/1jqu0ho8d';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
