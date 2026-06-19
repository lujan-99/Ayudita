<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YLEESGRR3T"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YLEESGRR3T');
</script>


<x-guest-layout :compact="false">


    <div x-data="{
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
    }" x-init="applyTheme()" class="bg-surface text-on-surface font-body-md selection:bg-primary-container selection:text-on-primary-container min-h-screen">
        
        <header class="sticky top-0 w-full z-50 glass-morphism border-b bento-border">
            <div class="flex justify-between items-center max-w-container-max mx-auto px-gutter py-4">
                <a href="/" class="flex items-center gap-3 hover:opacity-95 transition-opacity">
                    <img src="{{ asset('images/logos/logo-icono.svg') }}" alt="Ayudita Icono" class="h-[72px] w-auto">
                    <span class="font-headline-md text-headline-md font-bold text-on-surface tracking-tight">Ayudita</span>
                </a>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#historia">Nuestra Historia</a>
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#features">Patrones Académicos</a>
                    @auth
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('plan-estudios') }}">Plan de Estudios</a>
                    @else
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#plan-estudios-section">Plan de Estudios</a>
                    @endauth
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}#pricing">Planes Freemium</a>
                </nav>                <div class="flex items-center gap-6">
                    <div class="hidden sm:flex items-center gap-3 text-on-surface-variant">
                        <a href="https://www.tiktok.com/@ayuditausfx0" target="_blank" class="hover:text-primary transition-colors flex items-center" title="TikTok"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.01 1.62 4.14.94 1.08 2.27 1.81 3.69 2.07v3.89c-1.78-.14-3.48-.89-4.73-2.18-.1-.09-.17-.22-.3-.38v6.82c.02 4.05-2.52 7.77-6.37 9.03-3.85 1.26-8.2-.1-10.45-3.37A9.342 9.342 0 0 1 1.02 13c-.15-4.4 2.89-8.41 7.14-9.55 1.1-.3 2.25-.39 3.38-.27V7.1c-.88-.16-1.8-.07-2.61.31-1.63.75-2.63 2.51-2.43 4.3.2 1.8 1.7 3.23 3.5 3.23 1.63 0 3.03-1.18 3.28-2.79.05-.31.06-.63.06-.94V.02z"/></svg></a>
                        <a href="https://www.instagram.com/ayuditausfx/" target="_blank" class="hover:text-primary transition-colors flex items-center" title="Instagram"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.062 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a>
                        <a href="https://www.facebook.com/share/1KxGd7doF9/" target="_blank" class="hover:text-primary transition-colors flex items-center" title="Facebook"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
                        <a href="https://www.youtube.com/@ayudita-w4tf" target="_blank" class="hover:text-primary transition-colors flex items-center" title="YouTube"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.518 3.5 12 3.5 12 3.5s-7.518 0-9.388.553a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11C4.482 20.5 12 20.5 12 20.5s7.518 0 9.388-.553a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                    </div>>

                    <!-- Theme Toggle Button -->
                    <button @click="toggleTheme()" class="text-on-surface-variant hover:text-primary transition-colors flex items-center justify-center p-2 rounded-full hover:bg-surface-variant/20" title="Alternar tema">
                        <span x-show="darkTheme" class="material-symbols-outlined" style="display: none;">light_mode</span>
                        <span x-show="!darkTheme" class="material-symbols-outlined" style="display: none;">dark_mode</span>
                    </button>

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
                        Vence tus materias <span class="text-primary">con patrones de diseño académico</span>
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
                            <a href="{{ route('register') }}" class="text-center px-8 py-3 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:bg-primary transition-colors">
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
                            <div class="w-8 h-8 rounded-full border border-surface-container bg-primary-container/20 flex items-center justify-center text-[10px] font-bold text-primary font-label-mono">AC</div>
                            <div class="w-8 h-8 rounded-full border border-surface-container bg-secondary-container/20 flex items-center justify-center text-[10px] font-bold text-secondary font-label-mono">MF</div>
                            <div class="w-8 h-8 rounded-full border border-surface-container bg-tertiary-container/20 flex items-center justify-center text-[10px] font-bold text-tertiary font-label-mono">CM</div>
                        </div>
                        <span class="text-on-surface-variant font-label-mono text-label-mono">Comunidad de la Facultad de Tecnología compartiendo experiencia real</span>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-primary-container/5 rounded-full blur-3xl"></div>
                    <div class="relative bg-surface-container p-2 rounded-bento bento-border rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="w-full h-64 bg-zinc-900 rounded-lg flex flex-col p-4 text-xs font-label-mono text-zinc-400 justify-between">
                            <div class="flex items-center justify-between border-b border-zinc-800 pb-2">
                                <span>USFX / Ingeniería de Sistemas / 3er Semestre</span>
                                <span class="bg-primary-container/20 text-primary px-2 py-0.5 rounded text-[10px]">Patrón Activo</span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-white font-bold text-sm">Materia: Álgebra Lineal — Docente: Ing. Pérez</p>
                                <div class="text-zinc-500 flex items-start gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-primary mt-0.5" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                                    <span>Consejo Clave: "El primer parcial es práctico y basado en la guía de estudio. No faltes a los talleres semanales."</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-center text-[10px]">
                                <div class="p-2 bg-zinc-800 rounded border border-zinc-700 flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[12px] text-primary">folder</span><span>Exámenes</span></div>
                                <div class="p-2 bg-zinc-800 rounded border border-zinc-700 flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[12px] text-primary">photo_camera</span><span>Pizarras</span></div>
                                <div class="p-2 bg-zinc-800 rounded border border-zinc-700 flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[12px] text-primary">code</span><span>Código</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24 bg-surface border-y bento-border" id="historia">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-1 flex flex-col items-start gap-4">
                        <img src="{{ asset('images/logos/logo-horizontal.svg') }}" alt="Ayudita Logo Horizontal" class="h-24 w-auto">
                        <div>
                            <span class="font-label-mono text-label-mono text-primary uppercase block mb-1">NUESTRO ORIGEN</span>
                            <h3 class="font-headline-md text-headline-md text-on-surface">¿Por qué creamos Ayudita?</h3>
                        </div>
                    </div>
                    <div class="lg:col-span-2 text-on-surface-variant text-body-md space-y-4">
                        <p>
                            En la <strong>USFX</strong>, cada semestre se siente como empezar un juego en modo difícil sin manual. Nos dimos cuenta de que cientos de estudiantes tropezaban exactamente con la misma piedra: no sabían el enfoque de un docente, estudiaban de libros incorrectos o no tenían acceso a los laboratorios pasados. Los problemas eran idénticos; las soluciones ya existían, pero estaban dispersas.
                        </p>
                        <p>
                            Inspirados en los <strong>Patrones de Diseño de Software</strong>, decidimos crear un repositorio centralizado de soluciones académicas preestablecidas. Si alguien ya descifró el algoritmo para vencer una materia compleja con un docente específico, esa solución te pertenece a ti también. Nuestro eslogan lo resume todo: <span class="text-primary">"Problemas de antes, soluciones para hoy."</span>
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
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">psychology</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Consejos por Docente</h3>
                    <p class="text-body-sm text-on-surface-variant">La metodología exacta de evaluación, manías, qué libros prefiere y en qué áreas enfoca sus exámenes de forma específica.</p>
                </div>
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">history_edu</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Exámenes Pasados</h3>
                    <p class="text-body-sm text-on-surface-variant">Prácticas resueltas, exámenes de semestres anteriores y segundas instancias ordenados cronológicamente.</p>
                </div>
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">code</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Repositorios y Código</h3>
                    <p class="text-body-sm text-on-surface-variant">Proyectos base, laboratorios de redes, arquitecturas limpias y scripts validados por auxiliares de docencia oficiales.</p>
                </div>
                <div class="p-6 rounded-bento bg-surface-container bento-border hover:bg-surface-container-high transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center mb-6 bento-border group-hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">photo_library</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2 text-on-surface">Fotos de Pizarras</h3>
                    <p class="text-body-sm text-on-surface-variant">Apunta tus notas digitales. Fotos nítidas de pizarras con los ejercicios complejos de las clases magistrales presenciales.</p>
                </div>
            </div>
        </section>

        <section class="py-section-padding-desktop bg-surface overflow-hidden border-t bento-border" id="plan-estudios-section">
            <div class="max-w-container-max mx-auto px-gutter space-y-24">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                    <div class="flex-1 order-2 lg:order-1">
                        <span class="font-label-mono text-label-mono text-primary mb-4 block">TU MAPA DE RUTA</span>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Mapeado según tu Plan de Estudios</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">
                            Nuestra base de datos no es un montón de archivos sueltos. Todo está indexado de acuerdo a los planes de estudio vigentes de las carreras de la USFX. Encuentra tu año, tu semestre, tu materia y listo.
                        </p>
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-on-surface font-body-sm">Estructura limpia por semestres/años</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-on-surface font-body-sm">Prerrequisitos: Mira instantáneamente qué asignaturas bloqueas si repruebas</span>
                            </li>
                        </ul>
                        <div class="mt-8">
                            @auth
                                <a href="{{ route('plan-estudios') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-xs font-bold hover:bg-primary transition-all">
                                    <span>Ver mi Plan de Estudios</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-xs font-bold hover:bg-primary transition-all">
                                    <span>Ver mi Plan de Estudios</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="flex-1 order-1 lg:order-2">
                        <div class="relative bg-surface-container p-2 rounded-bento bento-border overflow-hidden group">
                            <img src="{{ asset('images/MapacheConLibrosMuchos.png') }}" alt="Mapache con libros" class="w-full h-64 md:h-80 object-cover rounded-lg shadow-sm group-hover:scale-[1.02] transition-transform duration-500">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                    <div class="flex-1">
                        <div class="relative bg-surface-container p-2 rounded-bento bento-border overflow-hidden group">
                            <img src="{{ asset('images/CompartiendoInfo.png') }}" alt="Comunidad estudiantil" class="w-full h-64 md:h-80 object-cover rounded-lg shadow-sm group-hover:scale-[1.02] transition-transform duration-500">
                        </div>
                    </div>
                    <div class="flex-1">
                        <span class="font-label-mono text-label-mono text-primary mb-4 block">SABIDURÍA COLECTIVA</span>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">De estudiantes para estudiantes</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">
                            Los mejores patrones nacen de quienes ya estuvieron en las trincheras. Sube tus apuntes, reporta si un examen cambió de formato y ayuda a mantener el ecosistema actualizado ganando reputación dentro de la app.
                        </p>
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-on-surface font-body-sm">Sistema de verificación de contenido por moderadores</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
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
                            <h3 class="font-headline-md mb-2">Estrategia Académica</h3>
                            <p class="text-on-surface-variant font-body-sm">Los estudiantes que aplican el patrón de estudio correcto del docente logran asimilar mejor los conceptos clave y aprueban con éxito.</p>
                        </div>
                        <div class="mt-8 flex items-center gap-2 text-primary">
                            <span class="material-symbols-outlined text-3xl">trending_up</span>
                            <span class="font-label-mono text-on-surface-variant">Rendimiento académico optimizado</span>
                        </div>
                    </div>
                    <div class="md:col-span-2 bg-surface-container border bento-border p-8 rounded-bento">
                        <span class="material-symbols-outlined text-primary text-2xl mb-4">cloud_download</span>
                        <h3 class="font-headline-md text-xl mb-2 text-on-surface">Acceso Offline</h3>
                        <p class="text-on-surface-variant font-body-sm">Descarga las fotos de pizarras y pdfs para estudiar sin gastar tus megas.</p>
                    </div>
                    <div class="md:col-span-2 bg-surface-container border bento-border p-8 rounded-bento">
                        <span class="material-symbols-outlined text-primary text-2xl mb-4">rate_review</span>
                        <h3 class="font-headline-md text-xl mb-2 text-on-surface">Reseñas Anónimas</h3>
                        <p class="text-on-surface-variant font-body-sm">Comentarios completamente protegidos para opiniones honestas y realistas sobre los docentes.</p>
                    </div>
                    <div class="md:col-span-4 bg-surface-container border bento-border p-8 rounded-bento flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1">
                            <h3 class="font-headline-md mb-2">Cero Spam Académico</h3>
                            <p class="text-on-surface-variant font-body-sm">Filtramos grupos de WhatsApp caóticos. Aquí solo entra material que realmente sirve para los exámenes.</p>
                        </div>
                        <div class="flex-none bg-surface border bento-border p-4 rounded-lg">
                            <span class="material-symbols-outlined text-3xl text-primary">verified</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
                    <!-- Social Feed Section -->
        <section class="py-section-padding-desktop bg-surface border-t bento-border" id="social-feed">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="text-center mb-20">
                    <span class="font-label-mono text-label-mono text-primary mb-4 block">COMUNIDAD ACTIVA</span>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Sigue a la Comunidad</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                        Únete a miles de estudiantes y mantente al tanto de todo el material académico y novedades de la USFX.
                    </p>
                </div>

                @php
                    $fbPost = null;
                    $igPost = null;
                    foreach (($posts ?? []) as $p) {
                        if (($p['source'] ?? '') === 'facebook' && !$fbPost) {
                            $fbPost = $p;
                        }
                        if (($p['source'] ?? '') === 'instagram' && !$igPost) {
                            $igPost = $p;
                        }
                        if ($fbPost && $igPost) break;
                    }

                    // Fallbacks
                    $fbText = $fbPost['text'] ?? '¡Nuevo repositorio de Álgebra Lineal subido! Exámenes pasados resueltos, pizarras y ejercicios resueltos paso a paso por auxiliares autorizados.';
                    $fbImage = $fbPost['image'] ?? '';
                    $fbLink = $fbPost['link'] ?? 'https://www.facebook.com/share/1KxGd7doF9/';
                    $fbDate = isset($fbPost['timestamp']) ? date('d M, Y', $fbPost['timestamp']) : 'Hace unos días';

                    $igText = $igPost['text'] ?? '¿Sufriendo con Física General en la USFX? Aquí tienes un patrón de estudio clave para superar el primer parcial del Ing. Ramos. ¡Asegura tu nota hoy!';
                    $igImage = $igPost['image'] ?? '';
                    $igLink = $igPost['link'] ?? 'https://www.instagram.com/ayuditausfx/';
                    $igDate = isset($igPost['timestamp']) ? date('d M, Y', $igPost['timestamp']) : 'Hace 3 días';
                @endphp

                <div class="space-y-24">
                    <!-- Row 1: Facebook (Reel/Post on Left, CTA on Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <!-- Left: Facebook Post/Reel Mockup -->
                        <div class="lg:col-span-6">
                            <div class="bg-surface-container border bento-border rounded-bento overflow-hidden flex flex-col justify-between group hover:border-[#1877F2]/50 transition-all shadow-sm">
                                <div class="p-4 border-b border-outline-variant/30 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold text-sm select-none">
                                            F
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1">
                                                <span class="font-headline-md text-xs font-semibold text-on-surface">Ayudita USFX</span>
                                                <span class="material-symbols-outlined text-[#1877F2] text-[14px] fill-icon">verified</span>
                                            </div>
                                            <span class="text-[10px] font-label-mono text-on-surface-variant">Facebook Page</span>
                                        </div>
                                    </div>
                                    <span class="text-[#1877F2]">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                                    </span>
                                </div>

                                @if($fbImage)
                                    <div class="relative overflow-hidden aspect-[4/3] bg-surface-container-high border-b border-outline-variant/30">
                                        <img src="{{ $fbImage }}" alt="Facebook post" class="w-full h-full object-cover group-hover:scale-[1.01] transition-transform duration-300">
                                    </div>
                                @else
                                    <div class="relative overflow-hidden aspect-[4/3] bg-gradient-to-br from-blue-600/5 to-sky-400/5 flex flex-col items-center justify-center p-8 text-center border-b border-outline-variant/30">
                                        <span class="material-symbols-outlined text-[48px] text-[#1877F2] mb-2 opacity-50">format_quote</span>
                                        <p class="text-body-sm text-xs text-on-surface line-clamp-4 italic leading-relaxed">
                                            "{{ $fbText }}"
                                        </p>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <p class="text-body-sm text-on-surface-variant line-clamp-3 leading-relaxed mb-4">
                                        {{ $fbText }}
                                    </p>
                                    <div class="flex items-center justify-between border-t border-outline-variant/30 pt-4 text-[10px] font-label-mono text-on-surface-variant">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-xs text-primary">thumb_up</span> Recomendado por estudiantes</span>
                                        <span>{{ $fbDate }}</span>
                                    </div>
                                    <a href="{{ $fbLink }}" target="_blank" class="w-full mt-4 py-2.5 rounded-lg bg-surface border bento-border text-on-surface hover:text-[#1877F2] hover:border-[#1877F2]/40 text-center font-label-mono text-[11px] font-semibold flex items-center justify-center gap-2 transition-all duration-300">
                                        <span>Ver en Facebook</span>
                                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Follow CTA Facebook -->
                        <div class="lg:col-span-6 flex flex-col justify-center p-4 lg:p-8">
                            <span class="font-label-mono text-[10px] text-blue-500 uppercase tracking-wider block mb-2 font-bold">FACEBOOK</span>
                            <h3 class="font-headline-lg text-2xl md:text-3xl text-on-surface mb-6 leading-tight">Síguenos en Facebook</h3>
                            <p class="font-body-lg text-on-surface-variant mb-8 leading-relaxed">
                                Entérate al instante de novedades académicas, convocatorias oficiales, comunicados de la USFX y descarga exámenes pasados completos.
                            </p>
                            <div>
                                <a href="https://www.facebook.com/share/1KxGd7doF9/" target="_blank" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-label-mono text-xs font-bold transition-all shadow-md hover:shadow-blue-500/20 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Seguir en Facebook</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Instagram (CTA on Left, Reel/Post on Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <!-- Left: Follow CTA Instagram (Desktop Left, Mobile Order will be handled nicely) -->
                        <div class="lg:col-span-6 order-2 lg:order-1 flex flex-col justify-center p-4 lg:p-8">
                            <span class="font-label-mono text-[10px] text-pink-500 uppercase tracking-wider block mb-2 font-bold">INSTAGRAM</span>
                            <h3 class="font-headline-lg text-2xl md:text-3xl text-on-surface mb-6 leading-tight">Síguenos en Instagram</h3>
                            <p class="font-body-lg text-on-surface-variant mb-8 leading-relaxed">
                                Encuentra tips diarios de estudio, resúmenes visuales de materias difíciles y dinámicas estudiantiles interactivas en historias.
                            </p>
                            <div>
                                <a href="https://www.instagram.com/ayuditausfx/" target="_blank" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white font-label-mono text-xs font-bold transition-all shadow-md hover:shadow-pink-500/20 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Seguir en Instagram</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                        <!-- Right: Instagram Post/Reel Mockup -->
                        <div class="lg:col-span-6 order-1 lg:order-2">
                            <div class="bg-surface-container border bento-border rounded-bento overflow-hidden flex flex-col justify-between group hover:border-pink-500/50 transition-all shadow-sm">
                                <div class="p-4 border-b border-outline-variant/30 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-pink-500/10 text-pink-500 flex items-center justify-center font-bold text-sm select-none">
                                            I
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1">
                                                <span class="font-headline-md text-xs font-semibold text-on-surface">ayuditausfx</span>
                                                <span class="material-symbols-outlined text-pink-500 text-[14px] fill-icon">verified</span>
                                            </div>
                                            <span class="text-[10px] font-label-mono text-on-surface-variant">Instagram Profile</span>
                                        </div>
                                    </div>
                                    <span class="text-pink-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.062 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 0 0 0 0-2.881z"/></svg>
                                    </span>
                                </div>

                                @if($igImage)
                                    <div class="relative overflow-hidden aspect-[4/3] bg-surface-container-high border-b border-outline-variant/30">
                                        <img src="{{ $igImage }}" alt="Instagram post" class="w-full h-full object-cover group-hover:scale-[1.01] transition-transform duration-300">
                                    </div>
                                @else
                                    <div class="relative overflow-hidden aspect-[4/3] bg-gradient-to-br from-pink-500/5 to-orange-500/5 flex flex-col items-center justify-center p-8 text-center border-b border-outline-variant/30">
                                        <span class="material-symbols-outlined text-[48px] text-pink-500 mb-2 opacity-50">format_quote</span>
                                        <p class="text-body-sm text-xs text-on-surface line-clamp-4 italic leading-relaxed">
                                            "{{ $igText }}"
                                        </p>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <p class="text-body-sm text-on-surface-variant line-clamp-3 leading-relaxed mb-4">
                                        {{ $igText }}
                                    </p>
                                    <div class="flex items-center justify-between border-t border-outline-variant/30 pt-4 text-[10px] font-label-mono text-on-surface-variant">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-xs text-red-500" style="font-variation-settings: 'FILL' 1;">favorite</span> Destacado por la comunidad</span>
                                        <span>{{ $igDate }}</span>
                                    </div>
                                    <a href="{{ $igLink }}" target="_blank" class="w-full mt-4 py-2.5 rounded-lg bg-surface border bento-border text-on-surface hover:text-pink-500 hover:border-pink-500/40 text-center font-label-mono text-[11px] font-semibold flex items-center justify-center gap-2 transition-all duration-300">
                                        <span>Ver en Instagram</span>
                                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    </a>
                                </div>
                            </div>
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
                        <span class="text-4xl text-primary/20 font-serif absolute top-4 left-6 italic">"</span>
                        <p class="font-body-sm text-body-sm text-on-surface mb-8 relative z-10 italic">
                            Llevaba varios periodos intentando aprobar una materia troncal. Gracias al patrón de estudio de Ayudita entendí que el docente priorizaba el diseño de bases de datos antes que la programación y logré pasar satisfactoriamente.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary-container/20 border border-primary-container/30 flex items-center justify-center font-bold text-primary font-label-mono text-sm">AC</div>
                            <div>
                                <h4 class="font-headline-md text-sm text-on-surface">Alejandro Condori</h4>
                                <p class="font-label-mono text-xs text-on-surface-variant">Ingeniería de Sistemas</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container border bento-border p-8 rounded-bento relative">
                        <span class="text-4xl text-primary/20 font-serif absolute top-4 left-6 italic">"</span>
                        <p class="font-body-sm text-body-sm text-on-surface mb-8 relative z-10 italic">
                            Las fotos de pizarras resueltas de los laboratorios avanzados me salvaron la vida. En los periodos de exámenes no hay tiempo de buscar libros completos; necesitas la solución al grano.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-secondary-container/20 border border-secondary-container/30 flex items-center justify-center font-bold text-secondary font-label-mono text-sm">MF</div>
                            <div>
                                <h4 class="font-headline-md text-sm text-on-surface">Mariana Flores</h4>
                                <p class="font-label-mono text-xs text-on-surface-variant">Ciencias de la Computación</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container border bento-border p-8 rounded-bento relative">
                        <span class="text-4xl text-primary/20 font-serif absolute top-4 left-6 italic">"</span>
                        <p class="font-body-sm text-body-sm text-on-surface mb-8 relative z-10 italic">
                            Las dificultades de semestres anteriores ayudan a los nuevos estudiantes que recién entran a la universidad. Subir mis apuntes me dio acceso a las funciones pro de manera gratuita.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-tertiary-container/20 border border-tertiary-container/30 flex items-center justify-center font-bold text-tertiary font-label-mono text-sm">CM</div>
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
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Filtros por carrera y plan de estudios</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Visualización de Consejos Generales</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Acceso a carpetas públicas de fotos</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full inline-block py-2 text-center rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">Empezar ya</a>
                        @else
                            <a href="{{ route('login') }}" class="w-full inline-block py-2 text-center rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">Empezar ya</a>
                        @endauth
                    </div>
                    <div class="bg-surface-container p-8 rounded-bento border-2 border-primary-container relative md:-my-4 z-10">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary-container text-on-primary-container px-3 py-1 rounded-md font-label-mono text-[10px] uppercase">El Más Popular</div>
                        <h3 class="font-headline-md text-xl mb-2">Estudiante Pro</h3>
                        <p class="font-body-sm text-on-surface-variant mb-6">Para los que buscan la excelencia y asegurar nota.</p>
                        <div class="mb-8">
                            <span class="text-4xl font-bold text-primary">Bs. 10</span>
                            <span class="font-label-mono text-on-surface-variant">/mes</span>
                            <div class="text-[10px] text-on-surface-variant mt-1">Bs. 40 semestral · Bs. 70 anual</div>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Todo lo del plan gratuito</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Acceso completo a Repositorios Premium</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Descarga offline de Exámenes Resueltos</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Soporte directo de tutores superiores</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('paywall') }}" class="w-full inline-block py-3 text-center rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:opacity-90 transition-opacity">Pasar a Pro</a>
                        @else
                            <a href="{{ route('login') }}" class="w-full inline-block py-3 text-center rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:opacity-90 transition-opacity">Pasar a Pro</a>
                        @endauth
                    </div>
                    <div class="bg-surface-container p-8 rounded-bento border bento-border">
                        <h3 class="font-headline-md text-xl mb-2">Colaborador Pro</h3>
                        <p class="font-body-sm text-on-surface-variant mb-6">Canjea tu aporte por suscripción gratis.</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-on-surface">10 Puntos</span>
                            <span class="font-label-mono text-on-surface-variant">/ 1 mes Pro</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Sube archivos y gana 15 pts por documento</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Aporta consejos y gana 5 pts por texto</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Gana 1 pt por cada like en tus aportes</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">check</span>
                                <span class="font-body-sm text-on-surface">Canjea 10 pts por 1 mes de acceso Pro</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('paywall') }}" class="w-full inline-block py-2 text-center rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">Canjear Puntos</a>
                        @else
                            <a href="{{ route('login') }}" class="w-full inline-block py-2 text-center rounded-lg border bento-border text-on-surface font-label-mono text-label-mono hover:bg-surface-container-high transition-colors">Canjear Puntos</a>
                        @endauth
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
                            <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="p-6 pt-0 font-body-sm text-on-surface-variant">
                            Todo archivo o consejo subido por la comunidad pasa por un filtro de estudiantes destacados de semestres superiores y auxiliares de docencia que actúan como moderadores para evitar información errónea.
                        </div>
                    </details>
                    <details class="group bg-surface-container border bento-border rounded-bento">
                        <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                            <span class="font-headline-md text-body-lg">¿Es legal compartir exámenes pasados de la USFX?</span>
                            <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="p-6 pt-0 font-body-sm text-on-surface-variant">
                            ¡Claro que sí! Los exámenes pasados y las pizarras son recursos de dominio público de los estudiantes. Compartirlos fomenta la democratización de la educación y el estudio colaborativo.
                        </div>
                    </details>
                    <details class="group bg-surface-container border bento-border rounded-bento">
                        <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                            <span class="font-headline-md text-body-lg">¿Puedo usar la plataforma gratis para siempre?</span>
                            <span class="material-symbols-outlined text-primary transition-transform group-open:rotate-180">expand_more</span>
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
            </div>
        </section>

        <footer class="bg-surface border-t bento-border">
            <div class="max-w-container-max mx-auto px-gutter py-12">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-8">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logos/logo-icono.svg') }}" alt="Ayudita Logo" class="h-10 w-auto">
                        <span class="font-headline-md text-lg font-bold text-on-surface tracking-tight">Ayudita</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-8 font-label-mono text-xs text-on-surface-variant">
                        <a class="hover:text-primary transition-colors" href="{{ route('terminos') }}">Términos y Condiciones</a>
                        <span class="text-outline-variant/50 hidden md:inline">•</span>
                        <a class="hover:text-primary transition-colors" href="{{ route('privacidad') }}">Política de Privacidad</a>
                    </div>
                    <div class="flex items-center gap-4 text-on-surface-variant">
                        <a href="https://www.facebook.com/share/1KxGd7doF9/" target="_blank" class="hover:text-[#1877F2] hover:scale-110 active:scale-95 transition-all duration-300" title="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/ayuditausfx/" target="_blank" class="hover:text-pink-500 hover:scale-110 active:scale-95 transition-all duration-300" title="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.062 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 0 0 0 0-2.881z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="pt-8 border-t border-outline-variant/30 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                    <p class="text-on-surface-variant/80 font-label-mono text-xs">© 2026 Ayudita Inc. Elevando el nivel académico de la USFX.</p>
                    <p class="text-on-surface-variant/80 font-label-mono text-xs flex items-center justify-center md:justify-start gap-1">
                        Hecho con 
                        <span class="material-symbols-outlined text-[12px] text-primary" style="font-variation-settings: 'FILL' 1;">favorite</span> 
                        por y para estudiantes de Sucre.
                    </p>
                </div>
            </div>
        </footer>

        <!-- Floating Messenger Support Bubble -->
        <div class="fixed bottom-6 left-6 z-50 flex flex-col items-start gap-2 group" x-data="{ openWelcome: true }">
            <!-- Tooltip/Welcome Bubble -->
            <div x-show="openWelcome" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 class="bg-surface-container border bento-border px-4 py-3 rounded-2xl shadow-xl max-w-xs text-left flex flex-col gap-1 items-start relative select-none">
                <button @click="openWelcome = false" class="absolute top-1 right-2 text-on-surface-variant hover:text-on-surface text-[14px] p-1 leading-none font-bold">
                    &times;
                </button>
                <span class="font-label-mono text-[9px] text-secondary uppercase tracking-wider font-bold">Contáctanos</span>
                <p class="text-[12px] text-on-surface leading-normal mt-1">
                    ¿Tienes alguna consulta comercial o duda general? Escríbenos en Facebook.
                </p>
                <div class="w-3 h-3 bg-surface-container border-l border-b border-outline-variant/30 rotate-45 absolute -bottom-1.5 left-6"></div>
            </div>
            
            <!-- Floating Bubble Button -->
            <a href="https://m.me/1218697017982831" target="_blank" 
               class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#006AFF] to-[#00B2FE] text-white flex items-center justify-center shadow-lg hover:scale-105 active:scale-95 transition-all duration-300 relative group-hover:shadow-2xl">
                <!-- Messenger Icon -->
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.477 2 2 6.145 2 11.25c0 2.913 1.455 5.513 3.738 7.153V22l3.435-1.89c.875.241 1.796.39 2.827.39 5.523 0 10-4.145 10-9.25C22 6.145 17.523 2 12 2zm1.06 12.195-2.585-2.753-5.047 2.753 5.545-5.89 2.645 2.753 4.987-2.753-5.545 5.89z"/>
                </svg>
                <!-- Ping Notification Badge -->
                <span class="absolute -top-1 -right-1 flex h-4 w-4">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500 border-2 border-white"></span>
                </span>
            </a>
        </div>

    </div>

    @push('scripts')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => 'https://ayudita.up.railway.app/#organization',
                'name' => 'Ayudita USFX',
                'url' => 'https://ayudita.up.railway.app',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://ayudita.up.railway.app/images/logos/logo-vertical.svg',
                    'width' => 512,
                    'height' => 512
                ],
                'sameAs' => [
                    'https://www.facebook.com/share/1KxGd7doF9/',
                    'https://www.instagram.com/ayuditausfx/',
                    'https://www.tiktok.com/@ayuditausfx0',
                    'https://www.youtube.com/@ayudita-w4tf'
                ]
            ],
            [
                '@type' => 'WebSite',
                '@id' => 'https://ayudita.up.railway.app/#website',
                'url' => 'https://ayudita.up.railway.app',
                'name' => 'Ayudita USFX',
                'description' => 'La plataforma académica freemium líder para estudiantes de la Universidad de San Francisco Xavier (USFX).',
                'publisher' => [
                    '@id' => 'https://ayudita.up.railway.app/#organization'
                ]
            ],
            [
                '@type' => 'WebApplication',
                '@id' => 'https://ayudita.up.railway.app/#webapp',
                'url' => 'https://ayudita.up.railway.app',
                'name' => 'Ayudita USFX App',
                'applicationCategory' => 'EducationalApplication',
                'operatingSystem' => 'All',
                'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
                'offers' => [
                    '@type' => 'AggregateOffer',
                    'priceCurrency' => 'BOB',
                    'lowPrice' => '0',
                    'highPrice' => '70',
                    'offerCount' => '3',
                    'offers' => [
                        [
                            '@type' => 'Offer',
                            'name' => 'Estudiante Base',
                            'price' => '0',
                            'priceCurrency' => 'BOB',
                            'category' => 'Free'
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'Estudiante Pro Mensual',
                            'price' => '10',
                            'priceCurrency' => 'BOB'
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'Estudiante Pro Semestral',
                            'price' => '40',
                            'priceCurrency' => 'BOB'
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'Estudiante Pro Anual',
                            'price' => '70',
                            'priceCurrency' => 'BOB'
                        ]
                    ]
                ]
            ],
            [
                '@type' => 'FAQPage',
                '@id' => 'https://ayudita.up.railway.app/#faq',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name' => '¿Cómo se verifica que las respuestas o guías sean correctas?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Todo archivo o consejo subido por la comunidad pasa por un filtro de estudiantes destacados de semestres superiores y auxiliares de docencia que actúan como moderadores para evitar información errónea.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => '¿Es legal compartir exámenes pasados de la USFX?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => '¡Claro que sí! Los exámenes pasados y las pizarras son recursos de dominio público de los estudiantes. Compartirlos fomenta la democratización de la educación y el estudio colaborativo.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => '¿Puedo usar la plataforma gratis para siempre?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Sí, el plan base es gratuito por tiempo indefinido. Además, si colaboras activamente subiendo apuntes limpios o códigos funcionales, el mismo sistema te regalará días Pro sin pagar un solo peso.'
                        ]
                    ]
                ]
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    @endpush
</x-guest-layout>