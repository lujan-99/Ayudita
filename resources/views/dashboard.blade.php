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
            <h3 class="font-display text-body-lg font-semibold text-on-surface mb-4 flex items-center gap-2 select-none">
                <span class="material-symbols-outlined text-[20px] text-primary">groups</span>
                Mis Conexiones con Docentes
            </h3>
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
            <h3 class="font-display text-body-lg font-semibold text-on-surface mb-4 flex items-center gap-2 select-none">
                <span class="material-symbols-outlined text-[20px] text-primary">feed</span>
                Últimas Publicaciones de mis Materias
            </h3>
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
                            
                            @if($publicacion->archivo_path)
                                @if(Auth::user()->isPremium())
                                    <a href="{{ asset('storage/' . $publicacion->archivo_path) }}" download class="inline-flex items-center gap-1 text-[10px] text-primary hover:underline font-bold">
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
                title: 'Progreso de tu Carrera 📈',
                content: 'Aquí puedes ver el avance de tu plan de estudios y el tipo de tu membresía (Base o Pro).'
            },
            {
                targetId: 'tour-subjects',
                title: 'Materias del Semestre 📚',
                content: 'Estas son las materias que estás cursando. Haz clic en cualquiera para ver apuntes, pizarras y descargar exámenes pasados.'
            },
            {
                targetId: 'tour-plan-link',
                title: 'Mapa de Asignaturas 🗺️',
                content: 'Explora tu plan de estudios en un lienzo interactivo infinito estilo Figma. Los usuarios Pro tienen acceso ilimitado.'
            },
            {
                targetId: 'tour-docentes-link',
                title: 'Directorio de Docentes 👨‍🏫',
                content: 'Consulta la lista de profesores de tus materias, lee valoraciones reales de compañeros y deja tus propias opiniones.'
            },
            {
                targetId: 'tour-connections',
                title: 'Ecosistema Académico 🌐',
                content: 'Aquí verás un listado rápido de tus docentes del semestre y las últimas guías subidas en tiempo real por la comunidad.'
            }
        ],
        init() {
            // Only start the tour if it hasn't been completed yet
            if (!localStorage.getItem('onboardingCompleted')) {
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
            localStorage.setItem('onboardingCompleted', 'true');
            
            // Clean up highlights
            this.steps.forEach(s => {
                const el = document.getElementById(s.targetId);
                if (el) el.classList.remove('tour-highlight');
            });
            
            // Restore sidebar states
            sidebarCollapsed = this.origCollapsed;
            mobileSidebarOpen = this.origMobileOpen;
        },
        showStep() {
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
                
                // Highlight target and dim others
                this.steps.forEach(s => {
                    const el = document.getElementById(s.targetId);
                    if (el) el.classList.remove('tour-highlight');
                });
                target.classList.add('tour-highlight');
                
                // Scroll target into view
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Position tooltip
                setTimeout(() => {
                    const rect = target.getBoundingClientRect();
                    const tooltip = this.$refs.tourTooltip;
                    if (!tooltip) return;
                    
                    const tooltipRect = tooltip.getBoundingClientRect();
                    let top = rect.bottom + window.scrollY + 12;
                    let left = rect.left + window.scrollX;
                    
                    // Prevent right side overflow
                    if (left + tooltipRect.width > window.innerWidth) {
                        left = window.innerWidth - tooltipRect.width - 16;
                    }
                    if (left < 16) left = 16;
                    
                    // Position tooltip above target if it overflows viewport bottom
                    if (rect.bottom + tooltipRect.height > window.innerHeight) {
                        top = rect.top + window.scrollY - tooltipRect.height - 12;
                        this.arrowDirection = 'down';
                    } else {
                        this.arrowDirection = 'up';
                    }
                    
                    tooltip.style.top = top + 'px';
                    tooltip.style.left = left + 'px';
                    tooltip.style.opacity = '1';
                }, 300);
            });
        }
    }" 
    @start-tour.window="startTour()"
    x-show="tourActive" 
    class="fixed inset-0 z-[9998] pointer-events-none" 
    style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/45 backdrop-blur-xs transition-opacity duration-300 pointer-events-auto" @click="endTour()"></div>
        
        <!-- Floating Tooltip Card -->
        <div x-ref="tourTooltip" class="absolute z-[9999] w-[320px] bg-surface-container border border-primary/40 rounded-xl p-5 shadow-2xl transition-all duration-300 pointer-events-auto text-left opacity-0 select-none">
            <!-- Arrow up marker -->
            <div x-show="arrowDirection === 'up'" class="absolute -top-2 left-6 w-3 h-3 bg-surface-container border-t border-l border-primary/40 rotate-45"></div>
            <!-- Arrow down marker -->
            <div x-show="arrowDirection === 'down'" class="absolute -bottom-2 left-6 w-3 h-3 bg-surface-container border-b border-r border-primary/40 rotate-45"></div>
            
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-primary font-label-mono uppercase tracking-wider">Paso <span x-text="currentStep + 1"></span> de <span x-text="steps.length"></span></span>
                <button @click="endTour()" class="text-on-surface-variant hover:text-error transition-colors p-1 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            
            <h3 class="font-display text-body-lg font-bold text-on-surface mb-2" x-text="steps[currentStep].title"></h3>
            <p class="text-xs text-on-surface-variant leading-relaxed mb-4" x-text="steps[currentStep].content"></p>
            
            <div class="flex justify-between items-center pt-3 border-t border-outline-variant/30">
                <button @click="endTour()" class="text-[11px] text-on-surface-variant hover:text-primary transition-all font-bold">Omitir</button>
                <div class="flex gap-2">
                    <button @click="prevStep()" x-show="currentStep > 0" class="px-2.5 py-1.5 border border-outline-variant text-[11px] font-bold rounded-DEFAULT text-on-surface hover:bg-surface-variant/50 transition-all cursor-pointer">
                        Atrás
                    </button>
                    <button @click="nextStep()" class="px-3 py-1.5 bg-primary text-on-primary text-[11px] font-bold rounded-DEFAULT hover:brightness-110 active:scale-[0.98] transition-all cursor-pointer border-0">
                        <span x-text="currentStep === steps.length - 1 ? 'Finalizar' : 'Siguiente'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inline styles for Spotlight Highlight -->
    <style>
        .tour-highlight {
            position: relative !important;
            z-index: 9999 !important;
            box-shadow: 0 0 0 4px var(--color-primary), 0 0 0 9999px rgba(0, 0, 0, 0.5) !important;
            pointer-events: none !important;
            transition: all 0.3s ease;
        }
    </style>

</x-dashboard-layout>