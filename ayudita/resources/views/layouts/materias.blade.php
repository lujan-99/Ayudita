<!DOCTYPE html>
<html class="dark scroll-smooth" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Materia - Ayudita</title>
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
                        "full": "9999px",
                        "bento": "12px"
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
            <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-variant/50 rounded-lg transition-all" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                Dashboard
            </a>
            <a class="flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-lg font-bold transition-all" href="#">
                <span class="material-symbols-outlined fill-icon text-[20px]">auto_stories</span>
                Materias
            </a>
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
    </nav>

    <!-- Área de Contenido Principal -->
    <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
        
        <!-- Navbar Superior -->
        <header class="bg-surface text-primary font-display text-body-lg fixed top-0 w-full md:w-[calc(100%-16rem)] z-50 border-b border-outline-variant flex justify-between items-center h-16 px-margin-mobile md:px-margin-desktop">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="md:hidden font-display text-headline-md font-bold text-primary">Ayudita</div>
                <div class="font-display font-bold text-on-surface tracking-wide hidden md:block">
                    USFX / Plan de Estudios Vigente
                </div>
            </div>
            <div class="flex items-center gap-4">
                @if(Auth::user()->role_id == 1)
                    <button type="button" onclick="togglePaywallModal()" class="hidden md:block px-4 py-1.5 border border-outline-variant text-on-surface hover:border-primary text-body-sm rounded-DEFAULT transition-all hover:bg-surface-variant/50">
                        Mejorar a Pro ✨
                    </button>
                @endif
                <div class="relative w-8 h-8 rounded-full bg-primary/20 text-primary border border-outline-variant flex items-center justify-center font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Canvas Principal -->
        <main class="flex-1 pt-24 pb-12 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full flex flex-col gap-6">
            
            <!-- Resumen de la Materia -->
            <section class="bg-surface-container border border-outline-variant/30 rounded-bento p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-primary via-primary-container to-transparent"></div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-label-mono text-xs px-2 py-0.5 rounded bg-primary/10 text-primary uppercase">SIS301</span>
                            <span class="text-on-surface-variant text-xs font-label-mono">Rama Troncal / Facultad de Tecnología</span>
                        </div>
                        <h2 class="font-display text-2xl md:text-3xl font-bold text-on-surface">Álgebra Lineal</h2>
                        <p class="text-body-sm text-on-surface-variant mt-2 max-w-2xl">
                            Estudio de matrices, espacios vectoriales y transformaciones lineales. Una asignatura clave que define la base lógica para las ramas de modelado en semestres superiores.
                        </p>
                    </div>
                    <div class="bg-surface border border-outline-variant/20 rounded-lg p-3 text-center min-w-[120px]">
                        <span class="block font-label-mono text-[10px] text-on-surface-variant uppercase">Docente Titular</span>
                        <span class="text-body-sm font-semibold text-primary">Ing. Pérez</span>
                    </div>
                </div>
            </section>

            <!-- Sistema de Navegación por Pestañas (Tabs) -->
            <div class="flex border-b border-outline-variant/30 gap-2">
                <button onclick="switchTab('consejos')" id="tab-btn-consejos" class="px-6 py-2.5 font-display text-body-sm font-semibold text-primary border-b-2 border-primary transition-all">
                    Consejos y Patrones Académicos
                </button>
                <button onclick="switchTab('archivos')" id="tab-btn-archivos" class="px-6 py-2.5 font-display text-body-sm font-semibold text-on-surface-variant hover:text-on-surface transition-all flex items-center gap-2">
                    Archivos y Recursos Base
                    <span class="material-symbols-outlined text-sm opacity-70">lock</span>
                </button>
            </div>

            <!-- CONTENIDO PESTAÑA 1: CONSEJOS (DESBLOQUEADO - FREE) -->
            <div id="tab-content-consejos" class="space-y-6">
                
                <!-- Filtro Dinámico de Consejos -->
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input id="consejoSearch" onkeyup="filterConsejos()" class="w-full bg-surface-container border border-outline-variant rounded-DEFAULT pl-10 pr-4 py-2 text-body-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Buscar consejos por etiqueta o palabra clave..." type="text"/>
                </div>

                <!-- Lista Bento de Consejos con Etiquetas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-bento-gap" id="consejosContainer">
                    
                    <!-- Consejo 1 -->
                    <div class="bg-[#18181b] border border-[#27272a] rounded-bento p-5 flex flex-col gap-3 hover:border-outline-variant transition-colors consejo-card">
                        <div class="flex flex-wrap gap-2 mb-1">
                            <span class="font-label-mono text-[10px] px-2 py-0.5 rounded bg-error-container text-error uppercase font-bold tag">80% Práctico</span>
                            <span class="font-label-mono text-[10px] px-2 py-0.5 rounded bg-surface-variant text-on-surface-variant uppercase tag">Primer Parcial</span>
                        </div>
                        <p class="text-body-sm text-on-surface leading-relaxed content">
                            "El primer parcial es netamente práctico y se basa en la guía de ejercicios del 2024. No pierdas tiempo estudiando demostraciones abstractas para este examen, enfócate en sistemas de ecuaciones de Gauss-Jordan."
                        </p>
                        <div class="mt-auto pt-3 border-t border-[#27272a] flex items-center justify-between text-[11px] font-label-mono text-on-surface-variant">
                            <span>Aporte de: Aux. Ingeniería</span>
                            <span class="text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs fill-icon">verified</span> Verificado</span>
                        </div>
                    </div>

                    <!-- Consejo 2 -->
                    <div class="bg-[#18181b] border border-[#27272a] rounded-bento p-5 flex flex-col gap-3 hover:border-outline-variant transition-colors consejo-card">
                        <div class="flex flex-wrap gap-2 mb-1">
                            <span class="font-label-mono text-[10px] px-2 py-0.5 rounded bg-primary/10 text-primary uppercase font-bold tag">Final Troncal</span>
                            <span class="font-label-mono text-[10px] px-2 py-0.5 rounded bg-surface-variant text-on-surface-variant uppercase tag">Transformaciones</span>
                        </div>
                        <p class="text-body-sm text-on-surface leading-relaxed content">
                            "Para el examen final, la obsesión del docente son las Transformaciones Lineales y los Espacios Vectoriales. Cambia el formato de la evaluación y pregunta un 40% de teoría conceptual del libro base."
                        </p>
                        <div class="mt-auto pt-3 border-t border-[#27272a] flex items-center justify-between text-[11px] font-label-mono text-on-surface-variant">
                            <span>Aporte de: Universitario6to</span>
                            <span class="text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs fill-icon">verified</span> Verificado</span>
                        </div>
                    </div>
                </div>

                <!-- Foro / Muro Muro de la Comunidad -->
                <div class="bg-surface-container border border-outline-variant/30 rounded-bento p-6">
                    <h3 class="font-display font-semibold text-body-lg text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">forum</span>
                        Muro de Consejos Colectivos (Foro)
                    </h3>
                    
                    <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                        <div class="p-4 bg-background border border-outline-variant/10 rounded-lg">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-display text-xs font-bold text-primary">Carlos Mendoza (5to Semestre)</span>
                                <span class="text-[10px] font-label-mono text-on-surface-variant">Ayer</span>
                            </div>
                            <p class="text-body-sm text-on-surface-variant">"Los talleres de los jueves en la tarde son clave, el auxiliar regala puntos extra que van directo al promedio de prácticas."</p>
                        </div>
                        <div class="p-4 bg-background border border-outline-variant/10 rounded-lg">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-display text-xs font-bold text-primary">Mariana Flores (3er Semestre)</span>
                                <span class="text-[10px] font-label-mono text-on-surface-variant">Hace 3 días</span>
                            </div>
                            <p class="text-body-sm text-on-surface-variant">"¡Confirmo! Estudié solo de la guía práctica del 2024 y metí 75 en el primer parcial."</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENIDO PESTAÑA 2: ARCHIVOS (BLOQUEADO TOTALMENTE - REQUIERE PRO) -->
            <div id="tab-content-archivos" class="hidden relative min-h-[400px] bg-[#18181b] border border-[#27272a] rounded-bento p-8 flex flex-col justify-center items-center text-center">
                <!-- Capa de Bloqueo Visual -->
                <div class="absolute inset-0 bg-surface/90 backdrop-blur-md z-10 flex flex-col items-center justify-center p-6 text-center">
                    <div class="w-16 h-16 bg-primary-container/10 border border-primary/30 text-primary rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">lock</span>
                    </div>
                    <h3 class="font-display text-headline-md font-bold text-on-surface mb-2">Sección de Archivos Protegida</h3>
                    <p class="text-body-sm text-on-surface-variant max-w-md mb-6">
                        El banco de exámenes resueltos, guías oficiales en PDF y el álbum de fotos de pizarras presenciales están disponibles únicamente para miembros del plan Pro.
                    </p>
                    <div class="flex gap-4">
                        <button type="button" onclick="togglePaywallModal()" class="px-6 py-2.5 bg-[#842bd2] hover:bg-[#b76dff] text-white font-label-mono text-xs font-bold rounded transition-all shadow-md">
                            Mejorar a Pro ✨
                        </button>
                        <button type="button" onclick="switchTab('consejos')" class="px-6 py-2.5 border border-outline-variant text-on-surface text-xs font-label-mono rounded hover:bg-surface-variant transition-colors">
                            Volver a Consejos Gratis
                        </button>
                    </div>
                </div>
            </div>

        </main>

        <!-- Pie de Página (Footer) con Redes Sociales Oficiales -->
        <footer class="bg-surface-container-lowest text-on-surface-variant w-full py-12 border-t border-outline-variant max-w-container-max mx-auto px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-6 mt-auto">
            <div class="flex flex-col items-center md:items-start gap-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">hub</span>
                    <span class="font-display text-body-lg font-bold text-primary tracking-tight">Ayudita</span>
                </div>
                <p class="text-xs text-on-surface-variant text-center md:text-left">Problemas de antes, soluciones para hoy. Elevando el nivel académico de Sucre y la USFX.</p>
            </div>
            
            <div class="flex flex-col items-center gap-3">
                <span class="font-label-mono text-[11px] text-on-surface-variant uppercase tracking-wider">Sigue a la Comunidad</span>
                <div class="flex items-center gap-5 text-on-surface-variant">
                    <a href="https://tiktok.com/@ayudita_usfx" target="_blank" class="hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.01 1.62 4.14.94 1.08 2.27 1.81 3.69 2.07v3.89c-1.78-.14-3.48-.89-4.73-2.18-.1-.09-.17-.22-.3-.38v6.82c.02 4.05-2.52 7.77-6.37 9.03-3.85 1.26-8.2-.1-10.45-3.37A9.342 9.342 0 0 1 1.02 13c-.15-4.4 2.89-8.41 7.14-9.55 1.1-.3 2.25-.39 3.38-.27V7.1c-.88-.16-1.8-.07-2.61.31-1.63.75-2.63 2.51-2.43 4.3.2 1.8 1.7 3.23 3.5 3.23 1.63 0 3.03-1.18 3.28-2.79.05-.31.06-.63.06-.94V.02z"/></svg>
                    </a>
                    <a href="https://facebook.com/ayudita.usfx" target="_blank" class="hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                    </a>
                    <a href="https://instagram.com/ayudita.usfx" target="_blank" class="hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <div class="text-center md:text-right font-label-mono text-[11px] opacity-70">
                <p>© 2026 Ayudita Inc. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <!-- MODAL DEL PAYWALL -->
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

    <!-- Scripts de Control de Pestañas y Filtro -->
    <script>
        function togglePaywallModal() {
            const modal = document.getElementById('premiumPaywallModal');
            modal.classList.toggle('hidden');
        }

        function switchTab(tabName) {
            const consejosContent = document.getElementById('tab-content-consejos');
            const archivosContent = document.getElementById('tab-content-archivos');
            const consejosBtn = document.getElementById('tab-btn-consejos');
            const archivosBtn = document.getElementById('tab-btn-archivos');

            if (tabName === 'consejos') {
                consejosContent.classList.remove('hidden');
                archivosContent.classList.add('hidden');
                
                consejosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-primary border-b-2 border-primary transition-all";
                archivosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-on-surface-variant hover:text-on-surface transition-all flex items-center gap-2";
            } else {
                consejosContent.classList.add('hidden');
                archivosContent.classList.remove('hidden');
                
                consejosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-on-surface-variant hover:text-on-surface transition-all";
                archivosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-primary border-b-2 border-primary transition-all flex items-center gap-2";
            }
        }

        function filterConsejos() {
            const input = document.getElementById('consejoSearch');
            const filter = input.value.toLowerCase();
            const container = document.getElementById('consejosContainer');
            const cards = container.getElementsByClassName('consejo-card');

            for (let i = 0; i < cards.length; i++) {
                const card = cards[i];
                const content = card.getElementsByClassName('content')[0].innerText.toLowerCase();
                const tags = Array.from(card.getElementsByClassName('tag')).map(t => t.innerText.toLowerCase()).join(' ');
                
                if (content.includes(filter) || tags.includes(filter)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>