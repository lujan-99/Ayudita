<x-dashboard-layout title="Mis Materias" headerText="USFX / Mis Asignaturas En Curso">

    <section class="border-b border-outline-variant/30 pb-6">
        <h2 class="font-display text-headline-lg font-bold text-on-surface mb-2">Mis Materias</h2>
        <p class="font-body-sm text-on-surface-variant">Accede a las asignaturas en curso que seleccionaste para este periodo académico.</p>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($materias as $materia)
            @php
                $selectedGroupId = $materia->pivot->grupo_materia_docente_id;
                $selectedGroup = $materia->gruposMateriaDocente->firstWhere('id', $selectedGroupId);
                
                $docenteName = $selectedGroup && $selectedGroup->docente ? $selectedGroup->docente->nombre_completo : 'Docente por asignar';
                $groupCode = $selectedGroup ? $selectedGroup->grupo_codigo : 'Sin grupo';
                
                $isEven = ($loop->index % 2 === 0);
                $lineColor = $isEven ? 'bg-primary' : 'bg-secondary';
                $badgeBg = $isEven ? 'bg-primary/10 text-primary' : 'bg-secondary/10 text-secondary';
            @endphp

            <div class="bg-surface-container border border-outline-variant rounded-lg p-5 flex flex-col gap-4 hover:border-primary/40 transition-all relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-[2px] {{ $lineColor }} opacity-50 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-label-mono text-label-mono px-2 py-0.5 rounded {{ $badgeBg }} mb-2 inline-block text-[10px] uppercase font-bold">{{ $materia->codigo }}</span>
                        <h3 class="font-display text-body-lg font-semibold text-on-surface line-clamp-2 leading-tight">{{ $materia->nombre }}</h3>
                    </div>
                </div>

                <!-- Docente asignado del grupo -->
                <div class="flex items-center gap-3 bg-surface-container-low border border-outline-variant/20 rounded-xl p-3 mt-1">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-primary/20 bg-primary/10 flex items-center justify-center text-primary font-bold shrink-0 text-xs">
                        @if($selectedGroup && $selectedGroup->docente && $selectedGroup->docente->foto)
                            <img src="{{ asset($selectedGroup->docente->foto) }}" alt="{{ $docenteName }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($docenteName, 0, 2)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="block font-label-mono text-[8px] text-on-surface-variant uppercase tracking-wider">Grupo {{ $groupCode }}</span>
                        <h4 class="text-xs font-semibold text-on-surface truncate">{{ $docenteName }}</h4>
                        @if($selectedGroup && $selectedGroup->docente && $selectedGroup->docente->calificacion)
                            <div class="flex items-center gap-1 mt-0.5 text-[10px] text-primary font-bold">
                                <span class="material-symbols-outlined text-[12px]">star</span>
                                <span>{{ number_format($selectedGroup->docente->calificacion, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-2 mt-1">
                    Consigue consejos prácticos, exámenes pasados y apuntes específicos para este grupo.
                </p>

                <!-- Acción para entrar -->
                <div class="mt-auto pt-4 border-t border-outline-variant/50">
                    <a href="{{ route('materias.show', $materia->id) }}" class="w-full text-center px-4 py-2 bg-primary/10 hover:bg-primary text-primary hover:text-on-primary text-xs font-bold rounded-DEFAULT transition-all flex items-center justify-center gap-2">
                        Ver Muro y Recursos
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-3 glass-panel rounded-lg p-10 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[48px] text-primary mb-3">auto_stories</span>
                <h3 class="font-display text-body-lg font-semibold text-on-surface">No estás cursando ninguna materia</h3>
                <p class="text-xs mt-1 max-w-sm mx-auto">Dirígete a tu perfil o registro para marcar asignaturas como cursando en este semestre.</p>
            </div>
        @endforelse
    </section>

</x-dashboard-layout>
