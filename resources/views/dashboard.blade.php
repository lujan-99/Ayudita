<!DOCTYPE html>
<html class="dark scroll-smooth" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard - Ayudita</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline-variant": "#4d4354",
                        "error-container": "#93000a",
                        "surface-tint": "#ddb7ff",
                        "on-secondary": "#313032",
                        "secondary": "#c8c6c8",
                        "surface-container": "#1e2020",
                        "tertiary": "#c8c6c9",
                        "surface": "#121414",
                        "inverse-primary": "#842bd2",
                        "error": "#ffb4ab",
                        "secondary-fixed-dim": "#c8c6c8",
                        "on-tertiary-fixed-variant": "#47464a",
                        "surface-variant": "#333535",
                        "primary-fixed-dim": "#ddb7ff",
                        "on-error": "#690005",
                        "on-primary-container": "#400071",
                        "on-surface": "#e2e2e2",
                        "on-error-container": "#ffdad6",
                        "primary": "#ddb7ff",
                        "surface-container-high": "#282a2b",
                        "background": "#121414",
                        "on-secondary-fixed": "#1c1b1d",
                        "surface-bright": "#38393a",
                        "inverse-surface": "#e2e2e2",
                        "surface-container-highest": "#333535",
                        "on-secondary-container": "#b7b4b7",
                        "primary-container": "#b76dff",
                        "on-primary-fixed-variant": "#6900b3",
                        "primary-fixed": "#f0dbff",
                        "surface-container-low": "#1a1c1c",
                        "tertiary-fixed-dim": "#c8c6c9",
                        "on-tertiary-fixed": "#1b1b1e",
                        "surface-dim": "#121414",
                        "tertiary-fixed": "#e4e1e5",
                        "secondary-container": "#474649",
                        "on-tertiary-container": "#29292c",
                        "on-primary": "#490080",
                        "on-secondary-fixed-variant": "#474649",
                        "inverse-on-surface": "#2f3131",
                        "on-primary-fixed": "#2c0051",
                        "secondary-fixed": "#e5e1e4",
                        "on-tertiary": "#303033",
                        "on-background": "#e2e2e2",
                        "surface-container-lowest": "#0c0f0f",
                        "on-surface-variant": "#cfc2d6",
                        "tertiary-container": "#919094",
                        "outline": "#988d9f"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "margin-desktop": "48px",
                        "bento-gap": "16px",
                        "gutter": "24px",
                        "container-max": "1200px",
                        "margin-mobile": "16px",
                        "unit": "4px"
                    },
                    fontFamily: {
                        "display": ["Geist"],
                        "headline-lg": ["Geist"],
                        "headline-md": ["Geist"],
                        "headline-lg-mobile": ["Geist"],
                        "label-mono": ["JetBrains Mono"],
                        "body-sm": ["Geist"],
                        "body-lg": ["Geist"]
                    }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            background: rgba(24, 24, 27, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid #27272a;
        }
        .glow-hover:hover {
            box-shadow: 0px 0px 20px rgba(168, 85, 247, 0.15);
            border-color: rgba(221, 183, 255, 0.3);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-lg antialiased min-h-screen flex">

    <!-- Menú Lateral -->
    <nav class="hidden md:flex bg-surface-container-low text-primary font-display text-body-sm fixed left-0 top-0 h-full w-64 border-r border-outline-variant flex-col p-4 gap-bento-gap z-40 pt-20">
        <div class="flex items-center gap-3 px-2 mb-8">
            <img alt="Ayudita Logo" class="w-8 h-8 rounded-DEFAULT object-cover border border-outline-variant" src="{{ asset('images/logos/logo-icono.svg') }}"/>
            <div>
                <h1 class="font-display text-headline-md font-bold text-primary">Ayudita</h1>
                <p class="font-body-sm text-on-surface-variant text-[10px] uppercase tracking-widest mt-1">Comunidad USFX</p>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-2">
            <a class="flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-lg font-bold transition-all" href="#">
                <span class="material-symbols-outlined fill-icon text-[20px]">dashboard</span>
                Dashboard
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-variant/50 rounded-lg transition-all" href="{{ route('materias.show', ['id' => 1]) }}">
                <span class="material-symbols-outlined text-[20px]">auto_stories</span>
                Materias
            </a>
            <!-- Candados agregados a las secciones de la izquierda -->
            <a onclick="togglePaywallModal()" class="flex items-center justify-between px-3 py-2 text-on-surface-variant hover:bg-surface-variant/50 rounded-lg transition-all cursor-pointer" href="#">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px]">map</span>
                    Planes de Estudio
                </div>
                <span class="material-symbols-outlined text-sm opacity-60">lock</span>
            </a>
            <a onclick="togglePaywallModal()" class="flex items-center justify-between px-3 py-2 text-on-surface-variant hover:bg-surface-variant/50 rounded-lg transition-all cursor-pointer" href="#">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px]">shield_person</span>
                    Docentes
                </div>
                <span class="material-symbols-outlined text-sm opacity-60">lock</span>
            </a>
        </div>
        <div class="mt-auto mb-6">
            <button onclick="togglePaywallModal()" class="w-full py-2 px-4 bg-primary text-on-primary font-bold rounded-DEFAULT hover:brightness-110 transition-all text-body-sm">
                Ver Mi Plan
            </button>
        </div>
        <div class="flex flex-col gap-2 pt-4 border-t border-outline-variant/30">
            <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-variant/30 rounded-lg transition-all" href="#">
                <span class="material-symbols-outlined text-[18px]">help</span>
                Ayuda
            </a>
        </div>
    </nav>

    <!-- Área de Contenido Principal -->
    <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
        
        <!-- Navbar Superior -->
        <header class="bg-surface text-primary font-display text-body-lg fixed top-0 w-full md:w-[calc(100%-16rem)] z-50 border-b border-outline-variant flex justify-between items-center h-16 px-margin-mobile md:px-margin-desktop">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full max-w-md hidden md:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input class="w-full bg-surface-container-low border border-outline-variant rounded-DEFAULT pl-10 pr-4 py-1.5 text-body-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Buscar materias o patrones..." type="text"/>
                </div>
                <div class="md:hidden font-display text-headline-md font-bold text-primary">
                    Ayudita
                </div>
            </div>
            <div class="flex items-center gap-4">
                @if(Auth::user()->role_id == 1)
                    <button type="button" onclick="togglePaywallModal()" class="hidden md:block px-4 py-1.5 border border-outline-variant text-on-surface hover:border-primary text-body-sm rounded-DEFAULT transition-all hover:bg-surface-variant/50">
                        Mejorar a Pro ✨
                    </button>
                @endif
                <button class="text-on-surface-variant hover:text-primary hover:bg-surface-variant/50 transition-colors p-2 rounded-full">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="relative w-8 h-8 rounded-full bg-surface-container-high border border-outline-variant overflow-hidden cursor-pointer ml-2">
                    <div class="w-full h-full flex items-center justify-center bg-primary/20 text-primary font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 {{ Auth::user()->role_id == 1 ? 'bg-secondary' : 'bg-primary-container' }} rounded-full border border-surface"></div>
                </div>
            </div>
        </header>

        <!-- Main Canvas -->
        <main class="flex-1 pt-24 pb-12 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full flex flex-col gap-8">
            
            <section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-outline-variant/30 pb-6">
                <div>
                    <h2 class="font-display text-headline-lg-mobile md:text-headline-lg font-bold text-on-surface mb-2">
                        Bienvenido, {{ explode(' ', Auth::user()->name)[0] }}.
                    </h2>
                    <p class="font-body-sm text-on-surface-variant">Tu resumen académico de patrones estructurado para este periodo.</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <div class="relative group w-full md:w-56">
                        <select class="w-full appearance-none bg-surface-container border border-outline-variant text-on-surface text-body-sm py-2 pl-3 pr-8 rounded-DEFAULT focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer hover:bg-surface-variant/50 transition-colors">
                            <option>Ingeniería de Sistemas</option>
                            <option>Ciencias de la Computación</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </section>

            <!-- Bento Grid -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-bento-gap">
                
                <div class="col-span-1 md:col-span-12 glass-panel rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6 glow-hover transition-all">
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="w-12 h-12 rounded-full bg-primary-container/20 flex items-center justify-center border border-primary/30 text-primary">
                            <span class="material-symbols-outlined text-[24px]">trending_up</span>
                        </div>
                        <div>
                            <p class="font-label-mono text-label-mono text-on-surface-variant uppercase">Tipo de Cuenta</p>
                            <p class="font-display text-headline-md font-bold text-on-surface">
                                {{ Auth::user()->role_id == 1 ? 'Estudiante Base (Free)' : 'Estudiante Pro' }}
                            </p>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex justify-between text-body-sm text-on-surface-variant mb-2">
                            <span>Progreso del Plan de Estudios</span>
                            <span class="font-label-mono text-primary">65%</span>
                        </div>
                        <div class="w-full h-1 bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: 65%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Materia 1: DESBLOQUEADA (Álgebra Lineal) -> Redirige a la vista completa de la materia -->
                <a href="{{ route('materias.show', ['id' => 1]) }}" class="col-span-1 md:col-span-4 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-all group cursor-pointer active:scale-[0.99]">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-primary opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-primary/10 text-primary mb-2 inline-block">SIS301</span>
                            <h3 class="font-display text-body-lg font-semibold text-on-surface">Álgebra Lineal</h3>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">more_vert</span>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                        Ing. Pérez
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Catálogo académico centralizado. Explora planes de estudio limpios y sin datos duplicados para el primer parcial.</p>
                    <div class="mt-auto pt-4 border-t border-[#27272a]">
                        <div class="flex justify-between text-label-mono text-on-surface-variant mb-1 uppercase tracking-wider text-xs">
                            <span>Evaluación</span>
                            <span>60% Práctico</span>
                        </div>
                        <div class="w-full h-1 bg-surface-variant rounded-full overflow-hidden mb-3">
                            <div class="h-full bg-secondary" style="width: 60%;"></div>
                        </div>
                        <div class="flex items-center gap-2 text-body-sm text-primary">
                            <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                            <span>45 Fotos de Pizarra (Acceso Libre)</span>
                        </div>
                    </div>
                </a>

                <!-- Materia 2: BLOQUEADA (Estructuras de Datos I) -> Abre Paywall Modal -->
                <div class="col-span-1 md:col-span-4 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-colors relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-secondary opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    @if(Auth::user()->role_id == 1)
                        <div onclick="togglePaywallModal()" class="absolute inset-0 bg-surface/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center p-4 text-center cursor-pointer group-hover:bg-surface/75 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl mb-2">lock</span>
                            <h4 class="font-display text-body-lg font-bold text-on-surface">Estructuras de Datos I</h4>
                            <p class="text-[12px] text-on-surface-variant mt-1 max-w-[180px]">Disponible exclusivamente en la versión Pro</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-secondary/10 text-secondary mb-2 inline-block">SIS302</span>
                            <h3 class="font-display text-body-lg font-semibold text-on-surface">Estructuras de Datos I</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                        Ing. Valeriano
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Mapeo relacional de materia con materia. Mira instantáneamente qué asignaturas bloqueas si repruebas en San Francisco Xavier.</p>
                    <div class="mt-auto pt-4 border-t border-[#27272a]">
                        <div class="w-full h-1 bg-surface-variant rounded-full overflow-hidden mb-3">
                            <div class="h-full bg-secondary" style="width: 85%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Materia 3: BLOQUEADA (Base de Datos I) -> Abre Paywall Modal -->
                <div class="col-span-1 md:col-span-4 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-colors relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-primary opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    @if(Auth::user()->role_id == 1)
                        <div onclick="togglePaywallModal()" class="absolute inset-0 bg-surface/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center p-4 text-center cursor-pointer group-hover:bg-surface/75 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl mb-2">lock</span>
                            <h4 class="font-display text-body-lg font-bold text-on-surface">Base de Datos I</h4>
                            <p class="text-[12px] text-on-surface-variant mt-1 max-w-[180px]">Sube recursos o adquiere Pro para desbloquear</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-primary/10 text-primary mb-2 inline-block">SIS400</span>
                            <h3 class="font-display text-body-lg font-semibold text-on-surface">Base de Datos I</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                        Docente de Especialidad
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Modelado lógico y físico de bases de datos relacionales bajo arquitecturas cliente-servidor consistentes.</p>
                </div>

                <!-- Materia 4: BLOQUEADA (Sistemas Operativos I) -> Abre Paywall Modal -->
                <div class="col-span-1 md:col-span-4 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-colors relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-secondary opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    @if(Auth::user()->role_id == 1)
                        <div onclick="togglePaywallModal()" class="absolute inset-0 bg-surface/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center p-4 text-center cursor-pointer group-hover:bg-surface/75 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl mb-2">lock</span>
                            <h4 class="font-display text-body-lg font-bold text-on-surface">Sistemas Operativos I</h4>
                            <p class="text-[12px] text-on-surface-variant mt-1 max-w-[180px]">Disponible exclusivamente en la versión Pro</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-secondary/10 text-secondary mb-2 inline-block">SIS303</span>
                            <h3 class="font-display text-body-lg font-semibold text-on-surface">Sistemas Operativos I</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                        Docente Tecnología
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Gestión de procesos, hilos de ejecución y adquisición de datos en entornos volátiles concurrentes.</p>
                </div>

                <!-- Materia 5: BLOQUEADA (Ingeniería de Software) -> Abre Paywall Modal -->
                <div class="col-span-1 md:col-span-4 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-colors relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-primary opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    @if(Auth::user()->role_id == 1)
                        <div onclick="togglePaywallModal()" class="absolute inset-0 bg-surface/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center p-4 text-center cursor-pointer group-hover:bg-surface/75 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl mb-2">lock</span>
                            <h4 class="font-display text-body-lg font-bold text-on-surface">Ingeniería de Software</h4>
                            <p class="text-[12px] text-on-surface-variant mt-1 max-w-[180px]">Disponible exclusivamente en la versión Pro</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-primary/10 text-primary mb-2 inline-block">SIS411</span>
                            <h3 class="font-display text-body-lg font-semibold text-on-surface">Ingeniería de Software</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                        Docente Troncal
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Modelado de requerimientos, patrones arquitectónicos y validación de software con métricas de calidad.</p>
                </div>

                <!-- Materia 6: BLOQUEADA (Redes de Computadoras I) -> Abre Paywall Modal -->
                <div class="col-span-1 md:col-span-4 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-colors relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-secondary opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    @if(Auth::user()->role_id == 1)
                        <div onclick="togglePaywallModal()" class="absolute inset-0 bg-surface/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center p-4 text-center cursor-pointer group-hover:bg-surface/75 transition-colors">
                            <span class="material-symbols-outlined text-primary text-3xl mb-2">lock</span>
                            <h4 class="font-display text-body-lg font-bold text-on-surface">Redes de Computadoras I</h4>
                            <p class="text-[12px] text-on-surface-variant mt-1 max-w-[180px]">Disponible exclusivamente en la versión Pro</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-secondary/10 text-secondary mb-2 inline-block">SIS422</span>
                            <h3 class="font-display text-body-lg font-semibold text-on-surface">Redes de Computadoras I</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                        Docente Laboratorio
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Estructura de la pila de protocolos TCP/IP, enrutamiento estático y configuración de subredes consistentes.</p>
                </div>

                <div class="col-span-1 md:col-span-6 glass-panel rounded-lg p-5">
                    <h3 class="font-display text-body-lg font-semibold text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">event</span>
                        Mapeo Relacional de Bloqueos
                    </h3>
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between py-3 border-b border-[#27272a] hover:bg-[#18181b] transition-colors -mx-5 px-5">
                            <div>
                                <p class="text-body-sm font-medium text-on-surface">Si repruebas Álgebra Lineal</p>
                                <p class="text-label-mono text-error uppercase mt-1">Bloqueas automáticamente la rama de Modelos</p>
                            </div>
                            <div class="text-right">
                                <p class="text-body-sm text-error font-medium">Crítico</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-3 hover:bg-[#18181b] transition-colors -mx-5 px-5">
                            <div>
                                <p class="text-body-sm font-medium text-on-surface">Si repruebas Estructuras de Datos I</p>
                                <p class="text-label-mono text-on-surface-variant uppercase mt-1">Bloqueas: Estructuras II y Sistemas Operativos</p>
                            </div>
                            <div class="text-right">
                                <p class="text-body-sm text-on-surface-variant font-medium">Troncal</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-6 bg-[#18181b] border border-[#27272a] rounded-lg p-5 flex flex-col justify-center items-center text-center relative overflow-hidden min-h-[250px]">
                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, rgba(221, 183, 255, 1) 1px, transparent 0); background-size: 20px 20px;"></div>
                    <div class="relative z-10 max-w-sm">
                        <span class="material-symbols-outlined text-[40px] text-primary mb-3">psychology</span>
                        <h3 class="font-display text-headline-md font-semibold text-on-surface mb-2">Consejos del Ecosistema</h3>
                        <p class="text-body-sm text-on-surface-variant mb-6">Evita los hilos caóticos de mensajería. Accede a las guías limpias organizadas por carrera y docente.</p>
                        <button class="px-6 py-2 bg-primary text-on-primary font-bold rounded-DEFAULT hover:brightness-110 transition-all text-body-sm shadow-[0_0_15px_rgba(183,109,255,0.4)]">
                            Explorar Repositorio General
                        </button>
                    </div>
                </div>

            </section>
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
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <div class="text-center md:text-right font-label-mono text-[11px] opacity-70">
                <p>© 2026 Ayudita Inc. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <!-- ESTRUCTURA DEL MODAL DEL PAYWALL INTERNO (Superposición de Capa) -->
    <div id="premiumPaywallModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-background/80 backdrop-blur-md" onclick="togglePaywallModal()"></div>
        <div class="relative z-10 w-full max-w-[760px] p-1">
            <div class="glass-panel rounded-xl border border-outline-variant bg-surface overflow-hidden flex flex-col md:flex-row relative shadow-2xl">
                
                <div class="flex-1 p-6 md:p-10 flex flex-col justify-center">
                    <div class="flex items-center gap-4 mb-6">
                        <img alt="Ayudita Logo" class="w-10 h-10 rounded-md border border-outline-variant/50" src="{{ asset('images/logos/logo-icono.svg') }}">
                        <div>
                            <h2 class="font-display text-body-sm text-on-surface-variant uppercase tracking-wider">Ayudita Pro</h2>
                        </div>
                    </div>
                    <h1 class="font-headline-lg-mobile md:font-headline-lg text-primary font-bold mb-3">Desbloquea Todo Tu Potencial</h1>
                    <p class="font-body-sm text-on-surface-variant mb-6">Obtén acceso sin restricciones a recursos académicos premium de la USFX. Domina tus materias con herramientas exclusivas.</p>
                    <ul class="space-y-3 mb-4 text-body-sm">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
                            <span class="text-on-surface">Acceso ilimitado a exámenes por docente</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
                            <span class="text-on-surface">Descargas completas de proyectos y scripts</span>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-[280px] bg-surface-container-low border-t md:border-t-0 md:border-l border-outline-variant p-6 flex flex-col justify-between relative">
                    <div>
                        <div class="text-center mb-6">
                            <div class="flex items-baseline justify-center gap-1">
                                <span class="font-display text-lg text-on-surface mr-1">Bs</span>
                                <span class="font-display text-4xl font-bold text-primary">15</span>
                                <span class="font-label-mono text-label-mono text-on-surface-variant">/mes</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <button class="w-full py-3 bg-[#842bd2] hover:bg-[#b76dff] text-white font-bold rounded-lg transition-all flex items-center justify-center gap-2">
                            Pasar a Pro
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                        <button type="button" onclick="togglePaywallModal()" class="w-full py-2 bg-transparent border border-outline-variant hover:bg-surface-variant text-on-surface-variant text-xs rounded-lg transition-colors">
                            Volver al Panel
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script JavaScript para controlar el estado del Modal -->
    <script>
        // Función unificada para abrir/cerrar el modal desde los candados de la grilla
        function togglePaywallModal() {
            const modal = document.getElementById('premiumPaywallModal');
            modal.classList.toggle('hidden');
        }
    </script>
</body>
</html>