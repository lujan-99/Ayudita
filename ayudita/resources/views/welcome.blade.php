<x-guest-layout :compact="false">
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
        
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "on-tertiary-fixed": "#1b1b1e",
                            "on-primary-container": "#644483",
                            "on-error": "#690005",
                            "surface-tint": "#ddb7ff",
                            "on-surface": "#e8e0e7",
                            "tertiary-fixed": "#e4e2e5",
                            "surface-container-highest": "#373438",
                            "on-primary-fixed-variant": "#583876",
                            "secondary-fixed": "#e4e2e4",
                            "primary-fixed": "#f0dbff",
                            "outline": "#988d9f",
                            "surface-container": "#211f23",
                            "on-primary": "#40215e",
                            "on-primary-fixed": "#2a0848",
                            "inverse-surface": "#e8e0e7",
                            "surface-dim": "#151217",
                            "primary-fixed-dim": "#ddb7ff",
                            "on-surface-variant": "#cfc2d6",
                            "primary": "#f0daff",
                            "primary-container": "#ddb7ff",
                            "background": "#151217",
                            "outline-variant": "#4d4354",
                            "on-tertiary": "#303033",
                            "surface-container-low": "#1d1b1f",
                            "surface-container-lowest": "#100d11",
                            "surface-container-high": "#2c292d",
                            "surface": "#121414",
                            "surface-bright": "#3b383d",
                            "on-tertiary-container": "#525254",
                            "tertiary": "#e3e1e4",
                            "error": "#ffb4ab",
                            "on-error-container": "#ffdad6",
                            "error-container": "#93000a",
                            "secondary-container": "#49494b",
                            "on-secondary-container": "#b9b8ba",
                            "on-secondary-fixed-variant": "#474648",
                            "inverse-on-surface": "#332f34",
                            "tertiary-fixed-dim": "#c8c6c9",
                            "inverse-primary": "#715090",
                            "on-tertiary-fixed-variant": "#474649",
                            "secondary": "#c8c6c8",
                            "tertiary-container": "#c7c5c8",
                            "on-secondary": "#303032",
                            "on-background": "#e8e0e7",
                            "secondary-fixed-dim": "#c8c6c8",
                            "surface-variant": "#373438",
                            "on-secondary-fixed": "#1b1b1d"
                        },
                        borderRadius: {
                            "DEFAULT": "0.25rem",
                            "lg": "0.5rem",
                            "xl": "0.75rem",
                            "full": "9999px",
                            "bento": "12px"
                        },
                        spacing: {
                            "gutter": "24px",
                            "margin-desktop": "48px",
                            "bento-gap": "16px",
                            "unit": "4px",
                            "margin-mobile": "16px",
                            "container-max": "1200px",
                            "section-padding-desktop": "120px"
                        },
                        fontFamily: {
                            "body-sm": [ "Geist" ],
                            "label-mono": [ "JetBrains Mono" ],
                            "body-lg": [ "Geist" ],
                            "headline-lg": [ "Geist" ],
                            "headline-lg-mobile": [ "Geist" ],
                            "headline-md": [ "Geist" ],
                            "display": [ "Geist" ],
                            "body-md": [ "Geist" ]
                        },
                        fontSize: {
                            "body-sm": [ "14px", { "lineHeight": "1.5", "letterSpacing": "0", "fontWeight": "400" } ],
                            "label-mono": [ "12px", { "lineHeight": "1.0", "letterSpacing": "0.05em", "fontWeight": "500" } ],
                            "body-lg": [ "16px", { "lineHeight": "1.6", "letterSpacing": "0", "fontWeight": "400" } ],
                            "body-md": [ "16px", { "lineHeight": "1.5", "letterSpacing": "0", "fontWeight": "400" } ],
                            "headline-lg": [ "32px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "600" } ],
                            "headline-lg-mobile": [ "24px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "600" } ],
                            "headline-md": [ "24px", { "lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "500" } ],
                            "display": [ "56px", { "lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "600" } ]
                        }
                    },
                },
            }
        </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
            .bento-border { border: 1px solid #27272a; }
            .glass-morphism { backdrop-filter: blur(12px); background: rgba(18, 20, 20, 0.7); }
        </style>
    @endpush

    <div class="bg-surface text-on-surface font-body-md selection:bg-primary-container selection:text-on-primary-container min-h-screen">
        
        <header class="sticky top-0 w-full z-50 glass-morphism border-b bento-border">
            <div class="flex justify-between items-center max-w-container-max mx-auto px-gutter py-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logos/logo-icono.svg') }}" alt="Ayudita Icono" class="h-8 w-auto">
                    <span class="font-headline-md text-headline-md font-bold text-on-surface tracking-tight">Ayudita</span>
                </div>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#historia">Nuestra Historia</a>
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#features">Patrones Académicos</a>
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#pricing">Planes Freemium</a>
                </nav>
                <div class="flex items-center gap-6">
                    <div class="hidden sm:flex items-center gap-3 text-on-surface-variant">
                        <a href="https://tiktok.com/@ayudita_usfx" target="_blank" class="hover:text-primary transition-colors flex items-center"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.01 1.62 4.14.94 1.08 2.27 1.81 3.69 2.07v3.89c-1.78-.14-3.48-.89-4.73-2.18-.1-.09-.17-.22-.3-.38v6.82c.02 4.05-2.52 7.77-6.37 9.03-3.85 1.26-8.2-.1-10.45-3.37A9.342 9.342 0 0 1 1.02 13c-.15-4.4 2.89-8.41 7.14-9.55 1.1-.3 2.25-.39 3.38-.27V7.1c-.88-.16-1.8-.07-2.61.31-1.63.75-2.63 2.51-2.43 4.3.2 1.8 1.7 3.23 3.5 3.23 1.63 0 3.03-1.18 3.28-2.79.05-.31.06-.63.06-.94V.02z"/></svg></a>
                        <a href="https://facebook.com/ayudita.usfx" target="_blank" class="hover:text-primary transition-colors flex items-center"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
                        <a href="https://instagram.com/ayudita.usfx" target="_blank" class="hover:text-primary transition-colors flex items-center"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a>
                    </div>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:bg-primary transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:bg-primary transition-colors">
                            Ingresar
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <section class="relative overflow-hidden pt-20 pb-32 md:pt-32 md:pb-48 bg-surface">
            <div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="z-10">
                    <span class="inline-block px-3 py-1.5 mb-6 rounded-md bg-surface-container-high border bento-border text-on-surface-variant font-label-mono text-label-mono">
                        Exclusivo para la comunidad USFX
                    </span>
                    <h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-display md:text-display text-on-surface mb-6 leading-tight">
                        Vence tus materias <span class="text-primary-container">con patrones de diseño académico</span>
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-xl">
                        No reinventes la rueda este semestre. Descubre los consejos, exámenes pasados, repositorios y las guías definitivas organizadas por carrera, materia y docente.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-center px-8 py-3 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:bg-primary transition-colors">
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-center px-8 py-3 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:bg-primary transition-colors">
                                Regístrate Gratis
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-center px-8 py-3 rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">
                                    Crear cuenta gratis
                                </a>
                            @endif
                        @endauth
                    </div>
                    <div class="mt-8 flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full border border-surface-container bg-zinc-700 flex items-center justify-center text-[10px] text-white">👨‍💻</div>
                            <div class="w-8 h-8 rounded-full border border-surface-container bg-zinc-600 flex items-center justify-center text-[10px] text-white">👩‍🎓</div>
                            <div class="w-8 h-8 rounded-full border border-surface-container bg-zinc-500 flex items-center justify-center text-[10px] text-white">👨‍🎓</div>
                        </div>
                        <span class="text-on-surface-variant font-label-mono text-label-mono">Más de 1,200 universitarios ya no jalan materias</span>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-primary-container/5 rounded-full blur-3xl"></div>
                    <div class="relative bg-surface-container p-2 rounded-bento bento-border rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="w-full h-64 bg-zinc-900 rounded-lg flex flex-col p-4 text-xs font-label-mono text-zinc-400 justify-between">
                            <div class="flex items-center justify-between border-b border-zinc-800 pb-2">
                                <span>USFX / Ingeniería de Sistemas / 3er Semestre</span>
                                <span class="bg-primary-container/20 text-primary-container px-2 py-0.5 rounded text-[10px]">Patrón Activo</span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-white font-bold text-sm">Materia: Álgebra Lineal — Docente: Ing. Pérez</p>
                                <p class="text-zinc-500">💡 Consejo Clave: "El primer parcial es 80% práctico basado en la guía del 2024. No faltes a los talleres de los viernes."</p>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-center text-[10px]">
                                <div class="p-2 bg-zinc-800 rounded border border-zinc-700">📂 14 Exámenes</div>
                                <div class="p-2 bg-zinc-800 rounded border border-zinc-700">📸 45 Fotos Pizarra</div>
                                <div class="p-2 bg-zinc-800 rounded border border-zinc-700">💻 3 Repositorios</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-surface border-y bento-border" id="historia">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-1 flex flex-col items-start gap-4">
                        <img src="{{ asset('images/logos/logo-vertical.svg') }}" alt="Ayudita Logo Vertical" class="h-16 w-auto">
                        <div>
                            <span class="font-label-mono text-label-mono text-primary-container uppercase block mb-1">NUESTRO ORIGEN</span>
                            <h3 class="font-headline-md text-headline-md text-on-surface">¿Por qué creamos Ayudita?</h3>
                        </div>
                    </div>
                    <div class="lg:col-span-2 text-on-surface-variant text-body-md space-y-4">
                        <p>
                            En la <strong>USFX</strong>, cada semestre se siente como empezar un juego en modo difícil sin manual. Nos dimos cuenta de que cientos de estudiantes tropezaban exactamente con la misma piedra: no sabían el enfoque de un docente, estudiaban de libros incorrectos o no tenían acceso a los laboratorios pasados. Los problemas eran idénticos; las soluciones ya existían, pero estaban dispersas.
                        </p>
                        <p>
                            Inspirados en los <strong>Patrones de Diseño de Software</strong>, decidimos crear un repositorio centralizado de soluciones académicas preestablecidas. Si alguien ya descifró el algoritmo para vencer una materia compleja con un docente específico, esa solución te pertenece a ti también. Nuestro eslogan lo resume todo: <span class="text-primary-container">"Problemas de antes, soluciones para hoy."</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface" id="features">
            <div class="max-w-container-max mx-auto px-gutter text-center mb-16">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Tu Arsenal Académico Basado en Datos Reales</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                    Filtra por tu Plan de Estudios y accede directamente a la sabiduría colectiva de la facultad.
                </p>
            </div>
            <div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-bento-gap">
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary-container transition-colors">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">psychology</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Consejos por Docente</h3>
                    <p class="text-body-sm text-on-surface-variant">La metodología exacta de evaluación, manías, qué libros prefiere y en qué áreas enfoca sus exámenes de forma específica.</p>
                </div>
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary-container transition-colors">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">history_edu</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Exámenes Pasados</h3>
                    <p class="text-body-sm text-on-surface-variant">Prácticas resueltas, exámenes de semestres anteriores y segundas instancias ordenados cronológicamente.</p>
                </div>
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary-container transition-colors">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">code</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Repositorios y Código</h3>
                    <p class="text-body-sm text-on-surface-variant">Proyectos base, laboratorios de redes, arquitecturas limpias y scripts validados por auxiliares de docencia oficiales.</p>
                </div>
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary-container transition-colors">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">photo_library</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Fotos de Pizarras</h3>
                    <p class="text-body-sm text-on-surface-variant">Apunta tus notas digitales. Fotos nítidas de pizarras con los ejercicios complejos de las clases magistrales presenciales.</p>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface overflow-hidden border-t bento-border">
            <div class="max-w-container-max mx-auto px-gutter space-y-24">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                    <div class="flex-1 order-2 lg:order-1">
                        <span class="font-label-mono text-label-mono text-primary-container mb-4 block">TU MAPA DE RUTA</span>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Mapeado según tu Plan de Estudios</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">
                            Nuestra base de datos no es un montón de archivos sueltos. Todo está indexado de acuerdo a los planes de estudio vigentes de las carreras de la USFX. Encuentra tu año, tu semestre, tu materia y listo.
                        </p>
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary-container">check_circle</span>
                                <span class="text-on-surface font-body-sm">Estructura limpia por semestres/años</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary-container">check_circle</span>
                                <span class="text-on-surface font-body-sm">Prerrequisitos: Mira instantáneamente qué asignaturas bloqueas si repruebas</span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 order-1 lg:order-2">
                        <div class="relative bg-surface-container p-2 rounded-bento bento-border">
                            <div class="w-full h-48 bg-zinc-900 rounded-lg flex items-center justify-center text-zinc-600 text-xs text-center p-4">
                                [Gráfico de Árbol: Sistemas ➔ Tercer Semestre ➔ Base de Datos I ➔ Carpeta de Contenido del Docente]
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                    <div class="flex-1">
                        <div class="relative bg-surface-container p-2 rounded-bento bento-border">
                            <div class="w-full h-48 bg-zinc-900 rounded-lg flex items-center justify-center text-zinc-600 text-xs text-center p-4">
                                [Foto de Comunidad: Universitarios colaborando en el Laboratorio de Computación]
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <span class="font-label-mono text-label-mono text-primary-container mb-4 block">SABIDURÍA COLECTIVA</span>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">De estudiantes para estudiantes</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">
                            Los mejores patrones nacen de quienes ya estuvieron en las trincheras. Sube tus apuntes, reporta si un examen cambió de formato y ayuda a mantener el ecosistema actualizado ganando reputación dentro de la app.
                        </p>
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary-container">check_circle</span>
                                <span class="text-on-surface font-body-sm">Sistema de verificación de contenido por moderadores</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary-container">check_circle</span>
                                <span class="text-on-surface font-body-sm">Roles Seguros: Accesos segmentados para estudiantes Free, Premium y cuentas de Administración</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface border-t bento-border">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="text-center mb-16">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Por Qué Estudiar con Patrones es Mejor</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                        Ahorra decenas de horas de frustración usando metodologías validadas por la comunidad de San Francisco Xavier.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-6 gap-bento-gap">
                    <div class="md:col-span-4 bg-surface-container border bento-border p-8 rounded-bento flex flex-col justify-between">
                        <div>
                            <h3 class="font-headline-md mb-2">Efectividad Académica</h3>
                            <p class="text-on-surface-variant font-body-sm">El 92% de los estudiantes que aplicaron el patrón de estudio correcto del docente aprobaron en primera instancia.</p>
                        </div>
                        <div class="mt-8 flex items-baseline gap-2">
                            <span class="text-4xl font-bold text-primary-container">92%</span>
                            <span class="font-label-mono text-on-surface-variant">Tasa de aprobación asistida</span>
                        </div>
                    </div>
                    <div class="md:col-span-2 bg-surface-container border bento-border p-8 rounded-bento">
                        <span class="material-symbols-outlined text-primary-container text-2xl mb-4">cloud_download</span>
                        <h3 class="font-headline-md text-xl mb-2 text-on-surface">Acceso Offline</h3>
                        <p class="text-on-surface-variant font-body-sm">Descarga las fotos de pizarras y pdfs para estudiar sin gastar tus megas.</p>
                    </div>
                    <div class="md:col-span-2 bg-surface-container border bento-border p-8 rounded-bento">
                        <span class="material-symbols-outlined text-primary-container text-2xl mb-4">rate_review</span>
                        <h3 class="font-headline-md text-xl mb-2 text-on-surface">Reseñas Anónimas</h3>
                        <p class="text-on-surface-variant font-body-sm">Comentarios 100% protegidos para opiniones honestas y realistas sobre los docentes.</p>
                    </div>
                    <div class="md:col-span-4 bg-surface-container border bento-border p-8 rounded-bento flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1">
                            <h3 class="font-headline-md mb-2">Cero Spam Académico</h3>
                            <p class="text-on-surface-variant font-body-sm">Filtramos grupos de WhatsApp caóticos. Aquí solo entra material que realmente sirve para los exámenes.</p>
                        </div>
                        <div class="flex-none bg-surface border bento-border p-4 rounded-lg">
                            <span class="material-symbols-outlined text-3xl text-primary-container">verified</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface border-t bento-border" id="testimonials">
            <div class="max-w-container-max mx-auto px-gutter text-center">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-16">Estudiantes que rompieron el ciclo</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-bento-gap text-left">
                    <div class="bg-surface-container border bento-border p-8 rounded-bento relative">
                        <span class="text-4xl text-primary-container/20 font-serif absolute top-4 left-6 italic">"</span>
                        <p class="font-body-sm text-body-sm text-on-surface mb-8 relative z-10 italic">
                            Llevaba dos semestres arrastrando una materia troncal. Gracias al patrón de estudio de Ayudita entendí que el docente priorizaba el diseño de bases de datos antes que la programación. Aprobé con 75 en mesas.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-zinc-700 flex items-center justify-center">👨</div>
                            <div>
                                <h4 class="font-headline-md text-sm text-on-surface">Alejandro Condori</h4>
                                <p class="font-label-mono text-xs text-on-surface-variant">Sistemas — 6to Semestre</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container border bento-border p-8 rounded-bento relative">
                        <span class="text-4xl text-primary-container/20 font-serif absolute top-4 left-6 italic">"</span>
                        <p class="font-body-sm text-body-sm text-on-surface mb-8 relative z-10 italic">
                            Las fotos de pizarras resueltas de los laboratorios avanzados me salvaron la vida. En los periodos de exámenes no hay tiempo de buscar libros completos; necesitas la solución al grano.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-zinc-600 flex items-center justify-center">👩</div>
                            <div>
                                <h4 class="font-headline-md text-sm text-on-surface">Mariana Flores</h4>
                                <p class="font-label-mono text-xs text-on-surface-variant">Ciencias de la Computación</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container border bento-border p-8 rounded-bento relative">
                        <span class="text-4xl text-primary-container/20 font-serif absolute top-4 left-6 italic">"</span>
                        <p class="font-body-sm text-body-sm text-on-surface mb-8 relative z-10 italic">
                            Las dolores de cabeza pasados ayudan a los changos nuevos que recién entran a la U. Subir mis exámenes pasados me dio acceso a las funciones pro de manera gratuita.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-zinc-500 flex items-center justify-center">👦</div>
                            <div>
                                <h4 class="font-headline-md text-sm text-on-surface">Carlos Mendoza</h4>
                                <p class="font-label-mono text-xs text-on-surface-variant">Ingeniería de Tecnologías</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface border-t bento-border" id="pricing">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="text-center mb-16">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Acceso Freemium Adaptado a tu Bolsillo</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                        Empieza gratis y accede a los pilares básicos, o apoya el mantenimiento del servidor para desbloquear soluciones de nivel avanzado.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-bento-gap items-center">
                    <div class="bg-surface-container p-8 rounded-bento border bento-border">
                        <h3 class="font-headline-md text-xl mb-2">Estudiante Base</h3>
                        <p class="font-body-sm text-on-surface-variant mb-6">Lo essencial para sobrevivir al semestre.</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-on-surface">Bs. 0</span>
                            <span class="font-label-mono text-on-surface-variant">/siempre gratis</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Filtros por carrera y plan de estudios</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Visualización de Consejos Generales</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Acceso a carpetas públicas de fotos</span>
                            </li>
                        </ul>
                        <button class="w-full py-2 rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">Empezar ya</button>
                    </div>
                    <div class="bg-surface-container p-8 rounded-bento border-2 border-primary-container relative md:-my-4 z-10">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary-container text-on-surface px-3 py-1 rounded-md font-label-mono text-[10px] uppercase">El Más Popular</div>
                        <h3 class="font-headline-md text-xl mb-2">Estudiante Pro</h3>
                        <p class="font-body-sm text-on-surface-variant mb-6">Para los que buscan la excelencia y asegurar nota.</p>
                        <div class="mb-8">
                            <span class="text-4xl font-bold text-primary-container">Bs. 15</span>
                            <span class="font-label-mono text-on-surface-variant">/mes</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Todo lo del plan gratuito</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Acceso completo a Repositorios Premium</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Descarga offline de Exámenes Resueltos</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Soporte directo de tutores superiores</span>
                            </li>
                        </ul>
                        <button class="w-full py-3 rounded-lg bg-primary-container text-surface-container-lowest font-label-mono text-label-mono hover:opacity-90 transition-opacity">Pasar a Pro</button>
                    </div>
                    <div class="bg-surface-container p-8 rounded-bento border bento-border">
                        <h3 class="font-headline-md text-xl mb-2">Colaborador</h3>
                        <p class="font-body-sm text-on-surface-variant mb-6">Intercambia tu conocimiento.</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-on-surface">Trueque</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Sube 3 recursos validados (exámenes/apuntes)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Consigue 1 mes de acceso Pro gratis</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Insignia especial en tu perfil público</span>
                            </li>
                        </ul>
                        <button class="w-full py-2 rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">Subir Material</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface border-t bento-border">
            <div class="max-w-3xl mx-auto px-gutter">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-12 text-center">Preguntas Frecuentes</h2>
                <div class="space-y-bento-gap">
                    <details class="group bg-surface-container border bento-border rounded-bento" open>
                        <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                            <span class="font-headline-md text-body-lg">¿Cómo se verifica que las respuestas o guías sean correctas?</span>
                            <span class="material-symbols-outlined text-primary-container transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="p-6 pt-0 font-body-sm text-on-surface-variant">
                            Todo archivo o consejo subido por la comunidad pasa por un filtro de estudiantes destacados de semestres superiores y auxiliares de docencia que actúan como moderadores para evitar información errónea.
                        </div>
                    </details>
                    <details class="group bg-surface-container border bento-border rounded-bento">
                        <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                            <span class="font-headline-md text-body-lg">¿Es legal compartir exámenes pasados de la USFX?</span>
                            <span class="material-symbols-outlined text-primary-container transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="p-6 pt-0 font-body-sm text-on-surface-variant">
                            ¡Claro que sí! Los exámenes pasados y las pizarras son recursos de dominio público de los estudiantes. Compartirlos fomenta la democratización de la educación y el estudio colaborativo.
                        </div>
                    </details>
                    <details class="group bg-surface-container border bento-border rounded-bento">
                        <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                            <span class="font-headline-md text-body-lg">¿Puedo usar la plataforma gratis para siempre?</span>
                            <span class="material-symbols-outlined text-primary-container transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="p-6 pt-0 font-body-sm text-on-surface-variant">
                            Sí, el plan base es gratuito por tiempo indefinido. Además, si colaboras activamente subiendo apuntes limpios o códigos funcionales, el mismo sistema te regalará días Pro sin pagar un solo peso.
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <section class="py-24 bg-surface border-t bento-border relative overflow-hidden">
            <div class="absolute inset-0 opacity-5">
                <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
                    <defs><pattern height="10" id="grid" patternUnits="userSpaceOnUse" width="10"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"></path></pattern></defs>
                    <rect fill="url(#grid)" height="100" width="100"></rect>
                </svg>
            </div>
            <div class="max-w-container-max mx-auto px-gutter text-center relative z-10">
                <h2 class="font-headline-lg-mobile md:font-display text-on-surface mb-8">Toma el control de tu historial académico</h2>
                <p class="text-on-surface-variant font-body-lg mb-12 max-w-2xl mx-auto">
                    No arriesgues tu promedio adivinando. Únete hoy a Ayudita y empieza a estudiar de forma inteligente con los patrones que funcionan.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 rounded-lg bg-primary-container text-surface-container-lowest font-label-mono text-label-mono hover:bg-primary transition-colors">
                            Ir al Dashboard Activo
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 rounded-lg bg-primary-container text-surface-container-lowest font-label-mono text-label-mono hover:bg-primary transition-colors">
                            Registrarme con mi Correo
                        </a>
                    @endauth
                </div>
                <p class="mt-8 text-on-surface-variant font-label-mono text-xs">Hecho con 💜 por y para estudiantes de la USFX.</p>
            </div>
        </section>

        <footer class="bg-surface border-t bento-border">
            <div class="max-w-container-max mx-auto px-gutter py-16">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <img src="{{ asset('images/logos/logo-horizontal.svg') }}" alt="Ayudita Logo Horizontal" class="h-6 w-auto">
                            <span class="font-headline-md text-lg font-bold text-on-surface tracking-tight">Ayudita</span>
                        </div>
                        <p class="font-body-sm text-on-surface-variant max-w-xs mb-4">Problemas de antes, soluciones para hoy. Elevando el nivel académico de Sucre y la USFX.</p>
                        <div class="flex items-center gap-4 text-on-surface-variant mt-2">
                            <a href="https://tiktok.com/@ayudita_usfx" target="_blank" class="hover:text-primary transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.01 1.62 4.14.94 1.08 2.27 1.81 3.69 2.07v3.89c-1.78-.14-3.48-.89-4.73-2.18-.1-.09-.17-.22-.3-.38v6.82c.02 4.05-2.52 7.77-6.37 9.03-3.85 1.26-8.2-.1-10.45-3.37A9.342 9.342 0 0 1 1.02 13c-.15-4.4 2.89-8.41 7.14-9.55 1.1-.3 2.25-.39 3.38-.27V7.1c-.88-.16-1.8-.07-2.61.31-1.63.75-2.63 2.51-2.43 4.3.2 1.8 1.7 3.23 3.5 3.23 1.63 0 3.03-1.18 3.28-2.79.05-.31.06-.63.06-.94V.02z"/></svg></a>
                            <a href="https://facebook.com/ayudita.usfx" target="_blank" class="hover:text-primary transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
                            <a href="https://instagram.com/ayudita.usfx" target="_blank" class="hover:text-primary transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a>
                        </div>
                    </div>
                    <div>
                        <h5 class="font-label-mono text-xs text-on-surface mb-6 uppercase">Explorar</h5>
                        <ul class="space-y-4 font-body-sm">
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Facultad de Tecnología</a></li>
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Facultad de Medicina</a></li>
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Ciencias Económicas</a></li>
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Derecho e Idiomas</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-label-mono text-xs text-on-surface mb-6 uppercase">Comunidad</h5>
                        <ul class="space-y-4 font-body-sm">
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Ser Moderador</a></li>
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Normas de Convivencia</a></li>
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Código de Honor</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-label-mono text-xs text-on-surface mb-6 uppercase">Soporte</h5>
                        <ul class="space-y-4 font-body-sm">
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Centro de Ayuda</a></li>
                            <li><a class="text-on-surface-variant hover:text-primary-container transition-colors" href="#">Reportar Contenido Erróneo</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 border-t bento-border flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-on-surface-variant font-label-mono text-xs">© 2026 Ayudita Inc. Inspirando soluciones colectivas.</p>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>