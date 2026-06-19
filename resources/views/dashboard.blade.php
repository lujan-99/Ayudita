<x-dashboard-layout title="Dashboard" headerText="USFX / Plan de Estudios Vigente">

    <section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-outline-variant/30 pb-6">
        <div>
            <h2 class="font-display text-headline-lg-mobile md:text-headline-lg font-bold text-on-surface mb-2">
                Bienvenido, {{ explode(' ', Auth::user()->name)[0] }}.
            </h2>
            <p class="font-body-sm text-on-surface-variant">Tu resumen académico de patrones estructurado para este periodo.</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
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

            <a href="{{ route('materias.show', $materia->id) }}" class="col-span-1 md:col-span-4 bg-surface-container border border-outline-variant rounded-lg p-5 flex flex-col gap-4 hover:border-outline-variant transition-all group cursor-pointer active:scale-[0.99] relative overflow-hidden">
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
            <div class="col-span-1 md:col-span-12 glass-panel rounded-lg p-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[48px] text-primary mb-3">auto_stories</span>
                <h3 class="font-display text-body-lg font-semibold text-on-surface">No estás cursando ninguna materia</h3>
                <p class="text-xs mt-1 max-w-md mx-auto">Dirígete a tu perfil o registro para marcar asignaturas como cursando en este semestre.</p>
            </div>
        @endforelse

        <!-- Conexiones con Docentes -->
        <div class="col-span-1 md:col-span-6 glass-panel rounded-lg p-5 flex flex-col min-h-[250px]">
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

</x-dashboard-layout>