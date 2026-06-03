<x-guest-layout>
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-fade-in">
        
        <div class="flex flex-col items-center text-center mb-12">
            <div class="relative mb-4">
                <img src="{{ asset('images/logos/logo-vertical.svg') }}" alt="Student Patterns Logo" class="h-16 w-auto">
                <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-24 h-[1px] bg-gradient-to-r from-transparent via-primary to-transparent opacity-60"></div>
            </div>
            
            <span class="font-mono text-[12px] uppercase tracking-widest text-primary bg-primary/10 px-3 py-1 rounded-full mb-4">
                USFX_FREEMIUM_SYSTEM
            </span>
            
            <h1 class="font-display text-4xl sm:text-5xl font-semibold tracking-tight text-on-surface max-w-2xl leading-tight">
                Student Patterns
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-4 max-w-xl">
                Carreras, materias, prerrequisitos y docentes organizados bajo una sola interfaz oscura, predictiva y consistente.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-3 mb-12">
            
            <div class="glass-card rounded-xl p-6 relative overflow-hidden transition-all hover:border-primary/40 duration-300">
                <div class="flex items-center gap-3 mb-3">
                    <span class="material-symbols-outlined text-primary font-medium" data-icon="school">school</span>
                    <h3 class="font-headline-md text-lg text-on-surface font-semibold">Carreras USFX</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Catálogo académico centralizado. Explora planes de estudio limpios y sin datos duplicados.
                </p>
            </div>

            <div class="glass-card rounded-xl p-6 relative overflow-hidden transition-all hover:border-primary/40 duration-300">
                <div class="flex items-center gap-3 mb-3">
                    <span class="material-symbols-outlined text-primary font-medium" data-icon="account_tree">account_tree</span>
                    <h3 class="font-headline-md text-lg text-on-surface font-semibold">Prerrequisitos</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Mapeo relacional de materia con materia. Mira instantáneamente qué asignaturas bloqueas si repruebas.
                </p>
            </div>

            <div class="glass-card rounded-xl p-6 relative overflow-hidden transition-all hover:border-primary/40 duration-300">
                <div class="flex items-center gap-3 mb-3">
                    <span class="material-symbols-outlined text-primary font-medium" data-icon="shield_person">shield_person</span>
                    <h3 class="font-headline-md text-lg text-on-surface font-semibold">Roles Seguros</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Accesos segmentados para estudiantes Free, Premium y cuentas de Administración mediante control de perfil.
                </p>
            </div>

        </div>

        <div class="flex flex-col gap-4 sm:flex-row justify-center items-center">
            @auth
                <a href="{{ url('/dashboard') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-[#a855f7] hover:bg-[#9333ea] px-8 py-3.5 font-body-lg text-body-lg font-medium text-white shadow-sm hover:shadow-[0_0_20px_rgba(168,85,247,0.4)] transition-all duration-300">
                    Ir al Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-[#a855f7] hover:bg-[#9333ea] px-8 py-3.5 font-body-lg text-body-lg font-medium text-white shadow-sm hover:shadow-[0_0_20px_rgba(168,85,247,0.4)] transition-all duration-300">
                    Entrar a la Plataforma
                </a>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg border border-outline-variant bg-surface px-8 py-3.5 font-body-lg text-body-lg font-medium text-on-surface-variant hover:border-primary hover:text-primary hover:bg-surface-variant/30 transition-all duration-300">
                        Crear cuenta gratis
                    </a>
                @endif
            @endauth
        </div>

    </div>
</x-guest-layout>