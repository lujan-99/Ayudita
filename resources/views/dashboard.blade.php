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

        <div class="col-span-1 md:col-span-6 glass-panel rounded-lg p-5">
            <h3 class="font-display text-body-lg font-semibold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">event</span>
                Mapeo Relacional de Bloqueos
            </h3>
            <div class="flex flex-col">
                <div class="flex items-center justify-between py-3 border-b border-outline-variant/30 hover:bg-surface-container/50 transition-colors -mx-5 px-5">
                    <div>
                        <p class="text-body-sm font-medium text-on-surface">Si repruebas Álgebra Lineal</p>
                        <p class="text-label-mono text-error uppercase mt-1 text-[10px]">Bloqueas automáticamente la rama de Modelos</p>
                    </div>
                    <div class="text-right">
                        <p class="text-body-sm text-error font-medium">Crítico</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 hover:bg-surface-container/50 transition-colors -mx-5 px-5">
                    <div>
                        <p class="text-body-sm font-medium text-on-surface">Si repruebas Estructuras de Datos I</p>
                        <p class="text-label-mono text-on-surface-variant uppercase mt-1 text-[10px]">Bloqueas: Estructuras II y Sistemas Operativos</p>
                    </div>
                    <div class="text-right">
                        <p class="text-body-sm text-on-surface-variant font-medium">Troncal</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-1 md:col-span-6 bg-surface-container border border-outline-variant rounded-lg p-5 flex flex-col justify-center items-center text-center relative overflow-hidden min-h-[250px]">
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

</x-dashboard-layout>