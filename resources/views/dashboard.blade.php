<x-dashboard-layout title="Dashboard" headerText="USFX / Plan de Estudios Vigente">

    <section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-outline-variant/30 pb-6">
        <div>
            <h2 class="font-display text-headline-lg-mobile md:text-headline-lg font-bold text-on-surface mb-2">
                Bienvenido, {{ explode(' ', Auth::user()->name)[0] }}.
            </h2>
            <p class="font-body-sm text-on-surface-variant">Tu resumen académico de patrones estructurado para este periodo.</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto items-center">
            <!-- Reset Tour Button -->
            <button @click="$dispatch('start-tour')" class="flex items-center gap-1.5 px-3 py-2 border border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary text-xs font-bold rounded-DEFAULT transition-all hover:bg-surface-variant/50 cursor-pointer bg-transparent">
                <span class="material-symbols-outlined text-[16px] animate-pulse">explore</span>
                <span>Guía Rápida</span>
            </button>

            <div class="relative group w-full md:w-56">
                <div class="w-full bg-surface-container border border-outline-variant text-on-surface text-body-sm py-2 px-3 rounded-DEFAULT flex items-center gap-2 select-none">
                    <span class="material-symbols-outlined text-primary text-[18px]">school</span>
                    <span class="truncate">{{ $carrera?->nombre ?? 'Sin carrera registrada' }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-12 gap-bento-gap">
        
        <div id="tour-welcome" class="col-span-1 md:col-span-12 glass-panel rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6 glow-hover transition-all">
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
                    <span>Progreso del Plan de Estudios (Todas las obligatorias + 3 optativas)</span>
                    <span class="font-label-mono text-primary">{{ $progreso }}%</span>
                </div>
                <div class="w-full h-1 bg-surface-variant rounded-full overflow-hidden">
                    <div class="h-full bg-primary" style="width: {{ $progreso }}%;"></div>
                </div>
            </div>
        </div>
        <!-- Cursando Subjects -->
        @forelse($cursandoMaterias as $materia)
            @php
                $selectedGroupId = $materia->pivot->grupo_materia_docente_id;
                $selectedGroup = $materia->gruposMateriaDocente->firstWhere('id', $selectedGroupId);

                if ($selectedGroup) {
                    $groupsStr = $selectedGroup->grupo_codigo;
                    $teacherStr = $selectedGroup->docente ? $selectedGroup->docente->nombre_completo : 'Por asignar';
                } else {
                    $groups = [];
                    $teachers = [];
                    foreach($materia->gruposMateriaDocente as $gmd) {
                        $groups[] = $gmd->grupo_codigo;
                        if ($gmd->docente) {
                            $teachers[] = $gmd->docente->nombre_completo;
                        }
                    }
                    $groupsStr = !empty($groups) ? implode(', ', $groups) : 'Sin grupo';
                    $teacherStr = !empty($teachers) ? implode(', ', array_unique($teachers)) : 'Por asignar';
                }

                $isEven = ($loop->index % 2 === 0);
                $lineColor = $isEven ? 'bg-primary' : 'bg-secondary';
                $badgeBg = $isEven ? 'bg-primary/10 text-primary' : 'bg-secondary/10 text-secondary';
            @endphp

            <a id="{{ $loop->first ? 'tour-subjects' : '' }}" href="{{ route('materias.show', $materia->id) }}" class="col-span-1 md:col-span-4 bg-surface-container border border-outline-variant rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-all group cursor-pointer active:scale-[0.99] relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[2px] {{ $lineColor }} opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-label-mono text-label-mono px-2 py-0.5 rounded {{ $badgeBg }} mb-2 inline-block">{{ $materia->codigo }}</span>
                        <h3 class="font-display text-body-lg font-semibold text-on-surface line-clamp-2 leading-tight">{{ $materia->nombre }}</h3>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">more_vert</span>
                </div>
                <div class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px]">person</span>
                    <span class="truncate">{{ $teacherStr }}</span>
                </div>
                <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-3">
                    Asignatura activa en tu semestre. Haz clic para consultar exámenes pasados resueltos, pizarras y material de estudio.
                </p>
                <div class="mt-auto pt-4 border-t border-outline-variant/50">
                    <div class="flex justify-between text-label-mono text-on-surface-variant mb-1 uppercase tracking-wider text-xs">
                        <span>Evaluación</span>
                        <span>{{ $selectedGroup ? 'Grupo' : 'Grupos' }}: {{ $groupsStr }}</span>
                    </div>
                    <div class="w-full h-1 bg-surface-variant rounded-full overflow-hidden mb-3">
                        <div class="h-full bg-secondary" style="width: 100%;"></div>
                    </div>
                    <div class="flex items-center gap-2 text-body-sm text-primary">
                        <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                        <span>Exámenes y Pizarras Libres</span>
                    </div>
                </div>
            </a>
        @empty
            <div id="tour-subjects" class="col-span-1 md:col-span-12 glass-panel rounded-lg p-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[48px] text-primary mb-3">auto_stories</span>
                <h3 class="font-display text-body-lg font-semibold text-on-surface">No estás cursando ninguna materia</h3>
                <p class="text-xs mt-1 max-w-md mx-auto">Dirígete a tu perfil o registro para marcar asignaturas como cursando en este semestre.</p>
            </div>
        @endforelse

        <!-- Conexiones con Docentes -->
        <div id="tour-connections" class="col-span-1 md:col-span-6 glass-panel rounded-lg p-5 flex flex-col min-h-[250px]">
            <div class="mb-4">
                <h3 class="font-display text-body-lg font-semibold text-on-surface flex items-center gap-2 select-none">
                    <span class="material-symbols-outlined text-[20px] text-primary">groups</span>
                    Mis Conexiones con Docentes
                </h3>
                <p class="text-[10px] text-on-surface-variant mt-1 leading-normal">Docentes activos que dictan tus asignaturas este semestre.</p>
            </div>
            <div class="flex-1 flex flex-col divide-y divide-outline-variant/30 overflow-y-auto max-h-[300px]">
                @forelse($misDocentes as $docente)
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-container/20 border border-primary/20 flex items-center justify-center text-primary font-bold text-sm overflow-hidden select-none">
                                @if($docente->foto)
                                    <img src="{{ asset('storage/' . $docente->foto) }}" alt="{{ $docente->nombre_completo }}" class="w-full h-full object-cover">
                                @else
                                    {{ collect(explode(' ', $docente->nombre_completo))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                                @endif
                            </div>
                            <div>
                                <h4 class="text-body-sm font-semibold text-on-surface">{{ $docente->nombre_completo }}</h4>
                                <p class="text-[10px] text-on-surface-variant flex items-center gap-1">
                                    <span class="font-bold text-primary">{{ $docente->materia_codigo }}</span>
                                    <span>•</span>
                                    <span class="truncate max-w-[150px]" title="{{ $docente->materia_nombre }}">{{ $docente->materia_nombre }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <div class="flex items-center gap-0.5 text-xs text-primary font-bold">
                                <span class="material-symbols-outlined text-[14px] fill-icon">star</span>
                                <span>{{ number_format($docente->calificacion ?? 5.0, 1) }}</span>
                            </div>
                            <a href="{{ route('docentes.show', $docente->id) }}" class="text-[10px] text-primary hover:underline font-bold">Ver Perfil</a>
                        </div>
                    </div>
                @empty
                    <div class="flex-1 flex flex-col justify-center items-center text-center p-6 text-on-surface-variant select-none">
                        <span class="material-symbols-outlined text-[32px] text-outline mb-2">person_off</span>
                        <p class="text-xs">No tienes docentes asignados aún.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Últimas Publicaciones de Materias -->
        <div class="col-span-1 md:col-span-6 glass-panel rounded-lg p-5 flex flex-col min-h-[250px]">
            <div class="mb-4">
                <h3 class="font-display text-body-lg font-semibold text-on-surface flex items-center gap-2 select-none">
                    <span class="material-symbols-outlined text-[20px] text-primary">feed</span>
                    Últimas Publicaciones de mis Materias
                </h3>
                <p class="text-[10px] text-on-surface-variant mt-1 leading-normal">Últimos exámenes resueltos, pizarras y apuntes cargados por la comunidad.</p>
            </div>
            <div class="flex-1 flex flex-col divide-y divide-outline-variant/30 overflow-y-auto max-h-[300px]">
                @forelse($ultimasPublicaciones as $publicacion)
                    <div class="py-3 flex flex-col gap-1.5 text-left">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="text-[9px] font-label-mono bg-primary/10 text-primary px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">{{ $publicacion->tipo }}</span>
                                <span class="text-[10px] text-on-surface-variant font-bold truncate max-w-[120px]">{{ $publicacion->materia->nombre }}</span>
                            </div>
                            <span class="text-[9px] text-on-surface-variant select-none">{{ $publicacion->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-on-surface leading-snug line-clamp-2">{{ $publicacion->contenido }}</p>
                        <div class="flex items-center justify-between mt-0.5">
                            <span class="text-[9px] text-on-surface-variant">Por: {{ explode(' ', $publicacion->user->name)[0] }}</span>
                            
                            @if($publicacion->archivo_path || $publicacion->archivo_base64)
                                @if(Auth::user()->isPremium())
                                    <a href="{{ route('consejos.download', $publicacion->id) }}" download class="inline-flex items-center gap-1 text-[10px] text-primary hover:underline font-bold">
                                        <span class="material-symbols-outlined text-[12px]">download</span>
                                        Descargar recurso
                                    </a>
                                @else
                                    <a href="{{ route('paywall') }}" class="inline-flex items-center gap-1 text-[10px] text-on-surface-variant/75 hover:text-primary hover:underline font-bold">
                                        <span class="material-symbols-outlined text-[12px]">lock</span>
                                        Descargar (Pro)
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex-1 flex flex-col justify-center items-center text-center p-6 text-on-surface-variant select-none">
                        <span class="material-symbols-outlined text-[32px] text-outline mb-2">article</span>
                        <p class="text-xs">No hay publicaciones recientes en tus materias.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </section>

    @push('modals')
    <!-- Alpine Onboarding Tour Component -->
    <div x-data="{
        tourActive: false,
        currentStep: 0,
        origCollapsed: false,
        origMobileOpen: false,
        arrowDirection: 'up',
        steps: [
            {
                targetId: 'tour-welcome',
                title: 'Progreso de tu Carrera',
                content: 'Aquí puedes ver el avance de tu plan de estudios y el tipo de tu membresía (Base o Pro).',
                image: 'saludo.png'
            },
            {
                targetId: 'tour-subjects',
                title: 'Materias del Semestre',
                content: 'Estas son las materias que estás cursando. Haz clic en cualquiera para ver apuntes, pizarras y descargar exámenes pasados.',
                image: 'sentado.png'
            },
            {
                targetId: 'tour-plan-link',
                title: 'Mapa de Asignaturas',
                content: 'Explora tu plan de estudios en un lienzo interactivo infinito estilo Figma. Los usuarios Pro tienen acceso ilimitado.',
                image: 'corriendo.png'
            },
            {
                targetId: 'tour-docentes-link',
                title: 'Directorio de Docentes',
                content: 'Consulta la lista de profesores de tus materias, lee valoraciones reales de compañeros y deja tus propias opiniones.',
                image: 'oculto.png'
            },
            {
                targetId: 'tour-connections',
                title: 'Ecosistema Académico',
                content: 'Aquí verás un listado rápido de tus docentes del semestre y las últimas guías subidas en tiempo real por la comunidad.',
                image: 'feliz.png'
            }
        ],
        spotlight: {
            top: 0,
            left: 0,
            width: 0,
            height: 0,
            active: false,
            transition: false
        },
        init() {
            const userId = {{ Auth::id() }};
            // Only start the tour if it hasn't been completed yet for this user
            if (!localStorage.getItem('onboardingCompleted_' + userId)) {
                setTimeout(() => {
                    this.startTour();
                }, 1000);
            }
        },
        startTour() {
            this.tourActive = true;
            this.currentStep = 0;
            this.origCollapsed = sidebarCollapsed;
            this.origMobileOpen = mobileSidebarOpen;
            this.showStep();
        },
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;
                this.showStep();
            } else {
                this.endTour();
            }
        },
        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
                this.showStep();
            }
        },
        endTour() {
            this.tourActive = false;
            const userId = {{ Auth::id() }};
            localStorage.setItem('onboardingCompleted_' + userId, 'true');
            
            // Clean up highlights
            this.steps.forEach(s => {
                const el = document.getElementById(s.targetId);
                if (el) el.classList.remove('tour-highlight');
            });
            
            // Restore sidebar states
            sidebarCollapsed = this.origCollapsed;
            mobileSidebarOpen = this.origMobileOpen;
            this.spotlight.active = false;
        },
        showStep() {
            // Hide spotlight and tooltip opacity during transit
            this.spotlight.active = false;
            if (this.$refs.tourTooltip) {
                this.$refs.tourTooltip.style.opacity = '0';
            }

            const step = this.steps[this.currentStep];
            
            // Restore baseline sidebar settings before making changes
            sidebarCollapsed = this.origCollapsed;
            mobileSidebarOpen = this.origMobileOpen;
            
            if (step.targetId === 'tour-plan-link' || step.targetId === 'tour-docentes-link') {
                if (window.innerWidth < 768) {
                    mobileSidebarOpen = true;
                } else {
                    sidebarCollapsed = false;
                }
            }
            
            this.$nextTick(() => {
                const target = document.getElementById(step.targetId);
                if (!target) {
                    this.nextStep();
                    return;
                }
                
                // Highlight target (semantically)
                this.steps.forEach(s => {
                    const el = document.getElementById(s.targetId);
                    if (el) el.classList.remove('tour-highlight');
                });
                target.classList.add('tour-highlight');
                
                // Scroll target into view
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Position spotlight and tooltip after scroll settles
                setTimeout(() => {
                    this.updateLayout(true);
                }, 350);
            });
        },
        updateLayout(useTransition = false) {
            if (!this.tourActive) return;
            const step = this.steps[this.currentStep];
            const target = document.getElementById(step.targetId);
            if (!target) return;
            
            const rect = target.getBoundingClientRect();
            
            // Set spotlight geometry
            this.spotlight.transition = useTransition;
            this.spotlight.top = rect.top;
            this.spotlight.left = rect.left;
            this.spotlight.width = rect.width;
            this.spotlight.height = rect.height;
            this.spotlight.active = true;
            
            // Position tooltip
            const tooltip = this.$refs.tourTooltip;
            if (!tooltip) return;
            
            const tooltipRect = tooltip.getBoundingClientRect();
            let top = rect.bottom + 12;
            let left = rect.left;
            
            // Prevent right side overflow
            if (left + tooltipRect.width > window.innerWidth) {
                left = window.innerWidth - tooltipRect.width - 16;
            }
            if (left < 16) left = 16;
            
            // Position tooltip above target if it overflows viewport bottom
            if (rect.bottom + tooltipRect.height > window.innerHeight) {
                top = rect.top - tooltipRect.height - 12;
                this.arrowDirection = 'down';
            } else {
                this.arrowDirection = 'up';
            }
            
            tooltip.style.top = top + 'px';
            tooltip.style.left = left + 'px';
            tooltip.style.opacity = '1';
        }
    }" 
    @start-tour.window="startTour()"
    @scroll.window.passive="if (tourActive) updateLayout(false)"
    @resize.window.passive="if (tourActive) updateLayout(false)"
    x-show="tourActive" 
    class="fixed inset-0 pointer-events-none z-[100000]" 
    style="display: none;">
        <!-- Backdrop (transparent layer to catch click outside) -->
        <div class="fixed inset-0 bg-transparent transition-opacity duration-300 pointer-events-auto z-[99990]" @click="endTour()"></div>
        
        <!-- Spotlight visual highlight layer (z-99995) -->
        <div 
            x-show="spotlight.active" 
            class="fixed rounded-lg pointer-events-none z-[99995]"
            :class="spotlight.transition ? 'transition-all duration-300' : ''"
            :style="`top: ${spotlight.top}px; left: ${spotlight.left}px; width: ${spotlight.width}px; height: ${spotlight.height}px; box-shadow: 0 0 0 4px var(--color-primary), 0 0 0 9999px rgba(0, 0, 0, 0.45);`"
        ></div>

        <!-- Floating Tooltip Card (z-99999) -->
        <div x-ref="tourTooltip" 
             class="fixed z-[99999] w-[290px] bg-surface-container-high rounded-xl p-4 shadow-2xl pointer-events-auto text-left opacity-0 select-none border-0"
             :class="spotlight.transition ? 'transition-all duration-300' : 'transition-opacity duration-300'">
            
            <!-- Arrow up marker -->
            <div x-show="arrowDirection === 'up'" class="absolute -top-2 left-6 w-3 h-3 bg-surface-container-high rotate-45 pointer-events-none"></div>
            <!-- Arrow down marker -->
            <div x-show="arrowDirection === 'down'" class="absolute -bottom-2 left-6 w-3 h-3 bg-surface-container-high rotate-45 pointer-events-none"></div>
            
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[9px] font-bold text-primary font-label-mono uppercase tracking-wider">Paso <span x-text="currentStep + 1"></span> de <span x-text="steps.length"></span></span>
                <button @click="endTour()" class="text-on-surface-variant hover:text-error transition-colors p-1 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>
            
            <div class="flex gap-3 items-start mb-3 select-none">
                <img :src="'/images/character/' + steps[currentStep].image" class="w-12 h-12 object-contain shrink-0" alt="Mapache Ayudita">
                <div class="flex-1 min-w-0">
                    <h3 class="font-display text-body-sm font-bold text-on-surface leading-tight mb-1" x-text="steps[currentStep].title"></h3>
                    <p class="text-[10px] text-on-surface-variant leading-relaxed" x-text="steps[currentStep].content"></p>
                </div>
            </div>
            
            <div class="flex justify-between items-center pt-2.5 border-t border-outline-variant/30">
                <button @click="endTour()" class="text-[10px] text-on-surface-variant hover:text-primary transition-all font-bold">Omitir</button>
                <div class="flex gap-2">
                    <button @click="prevStep()" x-show="currentStep > 0" class="px-2 py-1 border border-outline-variant text-[10px] font-bold rounded-DEFAULT text-on-surface hover:bg-surface-variant/50 transition-all cursor-pointer">
                        Atrás
                    </button>
                    <button @click="nextStep()" class="px-2.5 py-1 bg-primary text-on-primary text-[10px] font-bold rounded-DEFAULT hover:brightness-110 active:scale-[0.98] transition-all cursor-pointer border-0">
                        <span x-text="currentStep === steps.length - 1 ? 'Finalizar' : 'Siguiente'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endpush

</x-dashboard-layout>