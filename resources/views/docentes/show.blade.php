<x-dashboard-layout title="Docente - {{ $docente->nombre_completo }}" headerText="USFX / Perfil Académico">

    <!-- Mensajes de Estado -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <span class="text-body-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">error</span>
            <span class="text-body-sm">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col gap-8">
        <!-- Back link -->
        <div>
            <a href="{{ route('docentes.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver al Directorio
            </a>
        </div>

        <!-- Docente Header Profile Bento Card -->
        <section class="bg-surface-container border border-outline-variant/30 rounded-bento p-6 relative overflow-hidden flex flex-col md:flex-row gap-6 items-center md:items-start">
            <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-primary via-primary-container to-transparent"></div>
            
            <!-- Docente Photo -->
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-primary/20 bg-primary/10 flex items-center justify-center text-primary font-bold text-3xl shrink-0 shadow-lg">
                @if($docente->foto)
                    <img src="{{ asset($docente->foto) }}" alt="{{ $docente->nombre_completo }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($docente->nombre_completo, 0, 2)) }}
                @endif
            </div>

            <!-- Docente Meta -->
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                    <span class="font-label-mono text-xs px-2.5 py-0.5 rounded bg-primary/10 text-primary uppercase font-bold tracking-wider">Docente Universitario</span>
                    @if($isFirstDocente && !Auth::user()->isPremium())
                        <span class="font-label-mono text-xs px-2.5 py-0.5 rounded bg-amber-400/10 text-amber-400 uppercase font-bold tracking-wider animate-pulse flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">workspace_premium</span>
                            Vista Previa
                        </span>
                    @endif
                </div>
                <h2 class="font-display text-2xl md:text-3xl font-bold text-on-surface mb-2">{{ $docente->nombre_completo }}</h2>
                <p class="text-body-sm text-on-surface-variant max-w-2xl leading-relaxed">
                    {{ $docente->detalles_basicos ?? 'Este docente no cuenta con una descripción disponible en su perfil académico actualmente.' }}
                </p>
                
                <!-- Ratings Stats Grid -->
                <div class="flex flex-wrap gap-6 mt-6 justify-center md:justify-start border-t border-outline-variant/15 pt-6">
                    <div class="text-center md:text-left">
                        <span class="block font-label-mono text-[10px] text-on-surface-variant uppercase tracking-wider">Calificación Promedio</span>
                        <div class="flex items-center gap-1.5 mt-1 text-primary">
                            <span class="material-symbols-outlined text-[24px] text-amber-400 fill-icon">star</span>
                            <span class="font-display text-2xl font-bold text-on-surface">{{ number_format($docente->calificacion, 2) }}</span>
                            <span class="text-body-sm text-on-surface-variant font-medium">/ 5.00</span>
                        </div>
                    </div>
                    <div class="w-px h-10 bg-outline-variant/30 hidden sm:block"></div>
                    <div class="text-center md:text-left">
                        <span class="block font-label-mono text-[10px] text-on-surface-variant uppercase tracking-wider">Comentarios Recibidos</span>
                        <div class="flex items-center gap-1.5 mt-1 text-secondary">
                            <span class="material-symbols-outlined text-[24px]">chat_bubble</span>
                            <span class="font-display text-2xl font-bold text-on-surface">{{ $docente->comentarios->count() }}</span>
                            <span class="text-body-sm text-on-surface-variant font-medium">calificaciones</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Courses & Add Review Form -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Courses Taught Card -->
                <div class="bg-surface-container border border-outline-variant/30 rounded-xl p-5">
                    <h3 class="font-display font-semibold text-body-lg text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">auto_stories</span>
                        Asignaturas y Grupos
                    </h3>
                    @php
                        // Let's collect unique subjects
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
                    @endphp

                    @if(empty($materiasList))
                        <p class="text-body-sm text-on-surface-variant/50 italic">Sin materias asignadas actualmente.</p>
                    @else
                        <div class="flex flex-col gap-3">
                            @foreach($materiasList as $m)
                                <div class="bg-surface-container-low border border-outline-variant/20 p-3 rounded-lg flex flex-col gap-1.5">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <p class="font-display font-semibold text-body-sm text-on-surface leading-tight truncate">
                                                {{ $m['nombre'] }}
                                            </p>
                                            <p class="font-label-mono text-[9px] text-primary tracking-wider mt-0.5">
                                                {{ $m['codigo'] }}
                                            </p>
                                        </div>
                                        <div class="flex flex-wrap gap-1 flex-shrink-0">
                                            @foreach($m['grupos'] as $g)
                                                <span class="px-1.5 py-0.5 text-[8px] font-bold bg-primary/15 text-primary border border-primary/20 rounded-md">
                                                    Gp {{ $g }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($m['carrera'])
                                        <div class="flex items-center gap-1 text-[9px] text-secondary bg-surface-container-high py-0.5 px-2 rounded border border-outline-variant w-fit">
                                            <span class="material-symbols-outlined text-[10px]">school</span>
                                            <span class="truncate max-w-[190px]">{{ $m['carrera'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Add Comment Form -->
                <div class="bg-surface-container border border-outline-variant/30 rounded-xl p-5">
                    <h3 class="font-display font-semibold text-body-lg text-on-surface mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">rate_review</span>
                        Calificar Docente
                    </h3>

                    @if($isTakingClass)
                        <form method="POST" action="{{ route('docentes.comentarios.store', $docente->id) }}" class="space-y-4">
                            @csrf
                            <!-- Star Selector -->
                            <div x-data="{ rating: 5 }" class="flex flex-col gap-1">
                                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Tu Calificación:</label>
                                <input type="hidden" name="calificacion" :value="rating"/>
                                <div class="flex items-center gap-2">
                                    <template x-for="i in 5">
                                        <button type="button" @click="rating = i" class="text-on-surface-variant transition-transform hover:scale-110 focus:outline-none">
                                            <span class="material-symbols-outlined text-2xl" 
                                                  :class="rating >= i ? 'text-amber-400 fill-icon' : 'text-on-surface-variant/40'">
                                                star
                                            </span>
                                        </button>
                                    </template>
                                    <span class="font-label-mono text-sm font-bold text-on-surface pl-2" x-text="rating + '.00 / 5.00'"></span>
                                </div>
                            </div>

                            <!-- Comment input -->
                            <div>
                                <label for="comentario" class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Comentario / Experiencia:</label>
                                <textarea 
                                    id="comentario" 
                                    name="comentario" 
                                    rows="4" 
                                    required 
                                    placeholder="¿Cómo es su método de enseñanza? ¿Qué tal sus exámenes? Comparte tu experiencia honesta con tus compañeros..." 
                                    class="w-full bg-surface-container border border-outline-variant rounded-lg p-3 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary transition-colors resize-none"
                                ></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full py-2.5 bg-primary text-on-primary font-bold text-xs rounded-lg hover:brightness-110 transition-all flex items-center justify-center gap-1.5 shadow-[0_0_12px_rgba(183,109,255,0.3)]">
                                <span class="material-symbols-outlined text-[16px]">publish</span>
                                Publicar Calificación
                            </button>
                        </form>
                    @else
                        <div class="p-4 bg-surface-container-low border border-outline-variant/30 rounded-lg text-center flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-[32px] text-on-surface-variant/60">lock</span>
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                Solo puedes calificar a este docente si estás **cursando actualmente** una de sus asignaturas asociadas en este semestre.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side: Reviews/Comments Timeline -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-surface-container border border-outline-variant/30 rounded-xl p-5">
                    <h3 class="font-display font-semibold text-body-lg text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">reviews</span>
                        Comentarios e Historial de Calificaciones
                    </h3>

                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                        @forelse($docente->comentarios as $comentario)
                            <div class="bg-surface-container-low border border-outline-variant/20 rounded-lg p-4 flex flex-col gap-3">
                                <!-- Comment Header -->
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-display font-semibold text-body-sm text-primary">
                                                {{ $comentario->user->perfilEstudiante?->nickname ?? 'Estudiante Anónimo' }}
                                            </span>
                                            <span class="text-[9px] opacity-75 font-label-mono text-on-surface-variant">({{ $comentario->user->perfilEstudiante?->puntos ?? 0 }} pts)</span>
                                        </div>
                                        <span class="block text-[9px] font-label-mono text-on-surface-variant/80 mt-0.5">{{ $comentario->created_at->diffForHumans() }}</span>
                                    </div>
                                    <!-- Stars display -->
                                    <div class="flex items-center gap-0.5 text-amber-400 bg-amber-400/5 px-2 py-0.5 rounded border border-amber-400/10">
                                        <span class="material-symbols-outlined text-[14px] fill-icon">star</span>
                                        <span class="font-label-mono text-xs font-bold">{{ $comentario->calificacion }}.00</span>
                                    </div>
                                </div>

                                <!-- Comment Content -->
                                <p class="text-body-sm text-on-surface-variant leading-relaxed">
                                    {{ $comentario->comentario }}
                                </p>
                            </div>
                        @empty
                            <div class="p-8 text-center text-on-surface-variant bg-surface-container-low border border-outline-variant/15 rounded-lg">
                                <span class="material-symbols-outlined text-[40px] text-primary mb-3">chat_bubble_outline</span>
                                <h4 class="font-display font-semibold text-body-md text-on-surface">Sin comentarios aún</h4>
                                <p class="text-xs mt-1 max-w-xs mx-auto">Sé el primero en compartir tu experiencia con este docente y orientar a la comunidad.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
