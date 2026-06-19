<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (isset($title))
            {{ $title }} (Admin) - {{ config('app.name', 'Ayudita') }}
        @else
            Panel de Administración - {{ config('app.name', 'Ayudita') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- CSS & JS Assets (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" class="bg-mesh text-on-surface font-body-lg antialiased min-h-screen flex transition-all duration-300">

    <!-- Menú Lateral Admin -->
    <nav class="hidden md:flex bg-surface-container-low text-primary font-display text-body-sm fixed left-0 top-0 h-full border-r border-outline-variant flex-col p-3 pb-4 z-50 transition-all duration-300"
         :class="sidebarCollapsed ? 'w-20 items-center' : 'w-64'">
        
        <!-- Toggle Button -->
        <button @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)"
                class="hidden md:flex items-center justify-center w-8 h-8 rounded-full bg-surface-container border border-outline-variant hover:bg-surface-variant text-on-surface hover:text-primary transition-all absolute top-[72px] -right-4 z-50 shadow-md cursor-pointer"
                title="Contraer/Expandir menú">
            <span class="material-symbols-outlined text-[18px] transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''">chevron_left</span>
        </button>

        <!-- Logo/Branding Container -->
        <div class="h-16 flex items-center gap-3 border-b border-outline-variant/30 mb-6 w-full transition-all duration-300 shrink-0" :class="sidebarCollapsed ? 'justify-center px-0' : 'px-3'">
            <span class="material-symbols-outlined text-primary text-[32px]" :class="sidebarCollapsed ? '' : 'ml-1'">admin_panel_settings</span>
            <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex flex-col overflow-hidden whitespace-nowrap">
                <h1 class="font-display text-headline-md font-bold text-primary leading-none">Admin Panel</h1>
                <span class="font-body-sm text-on-surface-variant text-[9px] uppercase tracking-widest mt-1">Gestión de Tablas</span>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-2 w-full">
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('admin.dashboard') ? 'bg-inverse-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('admin.dashboard') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Dashboard">
                @if(Request::routeIs('admin.dashboard'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('admin.dashboard') ? 'fill-icon' : '' }} text-[20px]">dashboard</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Dashboard</span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('admin.carreras.*') ? 'bg-inverse-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('admin.carreras.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Carreras">
                @if(Request::routeIs('admin.carreras.*'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('admin.carreras.*') ? 'fill-icon' : '' }} text-[20px]">school</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Carreras</span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('admin.docentes.*') ? 'bg-inverse-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('admin.docentes.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Docentes">
                @if(Request::routeIs('admin.docentes.*'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('admin.docentes.*') ? 'fill-icon' : '' }} text-[20px]">groups</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Docentes</span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('admin.materias.*') ? 'bg-inverse-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('admin.materias.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Materias">
                @if(Request::routeIs('admin.materias.*'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('admin.materias.*') ? 'fill-icon' : '' }} text-[20px]">menu_book</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Materias</span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('admin.grupos.*') ? 'bg-inverse-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('admin.grupos.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Grupos">
                @if(Request::routeIs('admin.grupos.*'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('admin.grupos.*') ? 'fill-icon' : '' }} text-[20px]">hub</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Grupos</span>
            </a>
            <a class="relative flex items-center gap-3 px-3 py-2.5 {{ Request::routeIs('admin.users.*') ? 'bg-inverse-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-lg transition-all" href="{{ route('admin.users.index') }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Usuarios">
                @if(Request::routeIs('admin.users.*'))
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-white rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined {{ Request::routeIs('admin.users.*') ? 'fill-icon' : '' }} text-[20px]">person_search</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Usuarios</span>
            </a>
        </div>
        
        <div class="mt-auto mb-6 w-full flex justify-center" :class="sidebarCollapsed ? 'px-0' : 'px-2'">
            <a class="flex items-center justify-center gap-2 border border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary font-bold rounded-DEFAULT transition-all text-body-sm" href="{{ route('dashboard') }}" :class="sidebarCollapsed ? 'w-10 h-10 p-0 rounded-xl' : 'w-full py-2 px-4'" title="Volver al Sitio">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms>Volver al Sitio</span>
            </a>
        </div>
    </nav>

    <!-- Área de Contenido Principal -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
         :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'">
        
        <!-- Navbar Superior Admin -->
        <header class="bg-surface text-primary font-display text-body-lg fixed top-0 right-0 z-40 border-b border-outline-variant flex justify-between items-center h-16 px-margin-mobile md:px-margin-desktop transition-all duration-300"
                :class="sidebarCollapsed ? 'w-full md:w-[calc(100%-5rem)]' : 'w-full md:w-[calc(100%-16rem)]'">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="md:hidden font-display text-headline-md font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                    Admin
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
                        } elseif (str_contains(strtolower($secondPart), 'carrera') || str_contains(strtolower($headerText), 'carrera')) {
                            $secondIcon = 'school';
                        } elseif (str_contains(strtolower($secondPart), 'asignatura') || str_contains(strtolower($secondPart), 'materia')) {
                            $secondIcon = 'menu_book';
                        } elseif (str_contains(strtolower($secondPart), 'usuario') || str_contains(strtolower($secondPart), 'estudiante')) {
                            $secondIcon = 'person';
                        } elseif (str_contains(strtolower($secondPart), 'grupo') || str_contains(strtolower($secondPart), 'cátedra')) {
                            $secondIcon = 'hub';
                        }
                    @endphp
                    <div class="flex items-center gap-2 font-display text-body-sm hidden md:flex select-none">
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
                @else
                    <div class="flex items-center gap-2 font-display text-body-sm hidden md:flex select-none">
                        <span class="flex items-center gap-1.5 text-on-surface-variant/80 hover:text-primary transition-colors font-medium">
                            <span class="material-symbols-outlined text-[16px] text-primary">account_balance</span>
                            Ayudita
                        </span>
                        <span class="material-symbols-outlined text-outline-variant text-[14px] leading-none">chevron_right</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container/20 border border-primary-container/30 text-primary font-bold text-xs shadow-xs">
                            <span class="material-symbols-outlined text-[14px] fill-icon">admin_panel_settings</span>
                            Panel de Administración
                        </span>
                    </div>
                @endisset
            </div>
            <div class="flex items-center gap-4">
                <span class="brand-badge text-[10px]">Administrador</span>
                
                <!-- Menú Desplegable de Usuario -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="relative w-8 h-8 rounded-full bg-surface-container-high border border-outline-variant overflow-hidden cursor-pointer ml-2">
                            <div class="w-full h-full flex items-center justify-center bg-primary/20 text-primary font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('dashboard')">
                            Volver al Sitio
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
        </header>

        <!-- Main Canvas -->
        <main class="flex-1 pt-24 pb-12 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full flex flex-col gap-8">
            <!-- Alertas Flash de Éxito / Error -->
            @if (session('success'))
                <div class="p-4 bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer Admin -->
        <footer class="bg-surface-container-lowest text-on-surface-variant w-full py-6 border-t border-outline-variant max-w-container-max mx-auto px-margin-desktop flex justify-between items-center gap-6 mt-auto">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">admin_panel_settings</span>
                <span class="font-display text-body-sm font-bold text-primary tracking-tight">Ayudita Admin</span>
            </div>
            <div class="font-label-mono text-[10px] opacity-70">
                <p>© 2026 Ayudita Inc. Panel de Gestión.</p>
            </div>
        </footer>
    </div>
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
