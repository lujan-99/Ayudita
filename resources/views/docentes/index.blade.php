<x-dashboard-layout title="Docentes" headerText="USFX / Docentes Universitarios">

    <div x-data="{ 
        search: '',
        filterCursando: false,
        isPremium: {{ Auth::user()->isPremium() ? 'true' : 'false' }},
        init() {
            if (!this.isPremium) {
                setTimeout(() => {
                    this.$dispatch('open-modal', 'premium-paywall');
                }, 5000);
            }
        }
    }" class="relative flex flex-col gap-6">
        <div class="flex flex-col gap-6 w-full">
            <!-- Top bar with search input -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant/30 pb-6">
            <div>
                <h2 class="font-display text-headline-lg font-bold text-on-surface mb-2">Directorio de Docentes</h2>
                <p class="font-body-sm text-on-surface-variant">Consulta el plantel docente, sus calificaciones académicas y las materias asignadas por carrera.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                <!-- Reset Tour Button -->
                <button @click="$dispatch('start-tour')" class="px-3 py-2.5 border border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary text-body-sm font-semibold rounded-lg transition-all hover:bg-surface-variant/50 cursor-pointer bg-transparent flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px] animate-pulse">explore</span>
                    <span>Guía Rápida</span>
                </button>

                <!-- Cursando Filter Toggle -->
                <button 
                    id="tour-docentes-filter"
                    @click="filterCursando = !filterCursando"
                    :class="filterCursando ? 'bg-primary/20 border-primary text-primary' : 'bg-surface-container border-outline-variant text-on-surface-variant hover:text-on-surface'"
                    class="px-4 py-2.5 rounded-lg border text-body-sm font-semibold flex items-center justify-center gap-2 transition-all cursor-pointer"
                    title="Filtrar por docentes actuales"
                >
                    <span class="material-symbols-outlined text-[18px]">school</span>
                    <span>Mis Docentes</span>
                </button>

                <!-- Search Input -->
                <div id="tour-docentes-search" class="relative w-full sm:w-72">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                    <input 
                        type="text" 
                        x-model="search"
                        placeholder="Buscar docente o materia..." 
                        class="w-full bg-surface-container border border-outline-variant text-on-surface text-body-sm py-2.5 pl-10 pr-4 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors"
                    />
                </div>
            </div>
        </div>

        <!-- Grid of Docentes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($docentes as $docente)
                @php
                    // Let's collect unique subjects with their careers and groups
                    $materiasList = [];
                    foreach($docente->gruposMateriaDocente as $grupo) {
                        $materia = $grupo->materia;
                        if ($materia) {
                            $materiaId = $materia->id;
                            if (!isset($materiasList[$materiaId])) {
                                $materiasList[$materiaId] = [
                                    'codigo' => $materia->codigo,
                                    'nombre' => $materia->nombre,
                                    'carrera' => $materia->carrera?->nombre,
                                    'grupos' => []
                                ];
                            }
                            if (!in_array($grupo->grupo_codigo, $materiasList[$materiaId]['grupos'])) {
                                $materiasList[$materiaId]['grupos'][] = $grupo->grupo_codigo;
                            }
                        }
                    }
                    
                    // Compile searchable strings for Alpine.js search
                    $searchableName = addslashes($docente->nombre_completo);
                    $searchableDetails = addslashes($docente->detalles_basicos ?? '');
                    $searchableMaterias = [];
                    foreach($materiasList as $m) {
                        $searchableMaterias[] = $m['codigo'] . ' ' . $m['nombre'] . ' ' . ($m['carrera'] ?? '');
                    }
                    $searchableMateriasStr = addslashes(implode(' ', $searchableMaterias));
                @endphp

                <div 
                    id="{{ $loop->first ? 'tour-docentes-card' : '' }}"
                    x-show="(search === '' || '{{ strtolower($searchableName) }}'.includes(search.toLowerCase()) || '{{ strtolower($searchableDetails) }}'.includes(search.toLowerCase()) || '{{ strtolower($searchableMateriasStr) }}'.includes(search.toLowerCase())) && (!filterCursando || {{ in_array($docente->id, $cursandoDocentesIds) ? 'true' : 'false' }})"
                    @click="if (isPremium || {{ $loop->first ? 'true' : 'false' }}) { window.location.href = '{{ route('docentes.show', $docente->id) }}'; } else { $dispatch('open-modal', 'premium-paywall'); }"
                    class="glass-panel rounded-xl p-5 border border-outline-variant/30 flex flex-col justify-between hover:border-primary/40 hover:shadow-[0_0_15px_rgba(221,183,255,0.06)] transition-all duration-300 relative cursor-pointer"
                >
                    @if(!Auth::user()->isPremium() && !$loop->first)
                        <!-- Premium Lock Overlay for Card (Sharp and Clean) -->
                        <div class="absolute inset-0 z-20 flex flex-col items-center justify-center gap-2 p-4 text-center select-none bg-surface/5">
                            <div class="w-10 h-10 rounded-full bg-amber-400/10 border border-amber-400/30 flex items-center justify-center shadow-md animate-pulse">
                                <span class="material-symbols-outlined text-amber-400 text-[20px] fill-icon">lock</span>
                            </div>
                            <span class="text-xs font-bold font-display text-on-surface">Docente Premium</span>
                            <span class="text-[9px] text-on-surface-variant/80 max-w-[150px]">Pasa a Pro para ver calificaciones y comentarios</span>
                        </div>
                    @endif

                    <div class="flex flex-col justify-between h-full w-full {{ (!Auth::user()->isPremium() && !$loop->first) ? 'blur-[12px] opacity-10 select-none pointer-events-none' : '' }}">
                        <!-- Docente Info -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                @if($docente->foto)
                                    <img src="{{ asset($docente->foto) }}" alt="{{ $docente->nombre_completo }}" class="w-14 h-14 rounded-full object-cover border-2 border-primary/30 shadow-md">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary/20 to-secondary/20 border-2 border-primary/30 flex items-center justify-center text-primary font-bold text-lg shadow-md">
                                        {{ strtoupper(substr($docente->nombre_completo, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-display font-bold text-body-lg text-on-surface truncate leading-tight">{{ $docente->nombre_completo }}</h3>
                                    <div class="flex items-center gap-1 mt-1 text-xs text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px] text-amber-400 fill-icon">star</span>
                                        <span class="font-bold font-label-mono text-on-surface">{{ number_format($docente->calificacion, 2) }}</span>
                                        <span>/ 5.00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Biografía/Detalles -->
                            <p class="text-body-sm text-on-surface-variant/80 mb-4 line-clamp-3 leading-relaxed">
                                {{ $docente->detalles_basicos ?? 'Este docente no cuenta con una descripción disponible en su perfil académico actualmente.' }}
                            </p>
                        </div>

                        <!-- Materias & Carreras Section -->
                        <div class="border-t border-outline-variant/15 pt-4 mt-auto">
                            <h4 class="font-label-mono text-[10px] text-primary uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px]">auto_stories</span>
                                Asignaturas Impartidas
                            </h4>
                            @if(empty($materiasList))
                                <p class="text-[11px] text-on-surface-variant/50 italic">Sin materias asignadas actualmente.</p>
                            @else
                                <div class="flex flex-col gap-2.5 max-h-48 overflow-y-auto pr-1">
                                    @foreach($materiasList as $m)
                                        <div class="bg-surface-container-low/40 p-2 rounded-lg border border-outline-variant/15 flex flex-col gap-1">
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="min-w-0">
                                                    <p class="font-display font-semibold text-body-sm text-on-surface leading-tight truncate">
                                                        {{ $m['nombre'] }}
                                                    </p>
                                                    <p class="font-label-mono text-[9px] text-on-surface-variant/60 tracking-wider">
                                                        {{ $m['codigo'] }}
                                                    </p>
                                                </div>
                                                <div class="flex flex-wrap gap-1 flex-shrink-0">
                                                    @foreach($m['grupos'] as $g)
                                                        <span class="px-1.5 py-0.5 text-[8px] font-bold bg-primary/15 text-primary border border-primary/20 rounded-md">
                                                            {{ $g }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if($m['carrera'])
                                                <div class="flex items-center gap-1 text-[9px] text-secondary bg-surface-container-high py-0.5 px-1.5 rounded border border-outline-variant w-fit mt-0.5">
                                                    <span class="material-symbols-outlined text-[10px]">school</span>
                                                    <span class="truncate max-w-[170px]" title="{{ $m['carrera'] }}">{{ $m['carrera'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass-panel rounded-xl p-8 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-primary mb-4">person_off</span>
                    <p class="text-body-lg font-semibold">No hay docentes registrados</p>
                    <p class="text-xs mt-2">Próximamente se añadirán docentes universitarios al sistema.</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('modals')
    <!-- Alpine Onboarding Tour Component -->
    <div x-data="{
        tourActive: false,
        currentStep: 0,
        arrowDirection: 'up',
        steps: [
            {
                targetId: 'tour-docentes-filter',
                title: 'Filtrar por tus Profesores',
                content: 'Usa este botón para mostrar únicamente los docentes de las materias que estás cursando este semestre.',
                image: 'saludo.png'
            },
            {
                targetId: 'tour-docentes-search',
                title: 'Buscar Profesores',
                content: 'Busca profesores rápidamente por su nombre, su descripción o el código/nombre de la materia que dictan.',
                image: 'sentado.png'
            },
            {
                targetId: 'tour-docentes-card',
                title: 'Perfil del Docente',
                content: 'Aquí puedes ver la foto, calificación promedio y materias dictadas de cada docente. Haz clic en la tarjeta para ver las valoraciones completas y escribir tu propio comentario.',
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
            if (!localStorage.getItem('onboardingCompleted_docentes_' + userId)) {
                setTimeout(() => {
                    this.startTour();
                }, 1200);
            }
        },
        startTour() {
            this.tourActive = true;
            this.currentStep = 0;
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
            localStorage.setItem('onboardingCompleted_docentes_' + userId, 'true');
            this.spotlight.active = false;
        },
        showStep() {
            // Hide spotlight and tooltip opacity during transit
            this.spotlight.active = false;
            if (this.$refs.tourTooltip) {
                this.$refs.tourTooltip.style.opacity = '0';
            }

            const step = this.steps[this.currentStep];
            
            this.$nextTick(() => {
                const target = document.getElementById(step.targetId);
                if (!target) {
                    this.nextStep();
                    return;
                }
                
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
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
