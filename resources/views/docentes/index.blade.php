<x-dashboard-layout title="Docentes" headerText="USFX / Docentes Universitarios">

    <div x-data="{ search: '' }" class="flex flex-col gap-6">
        <!-- Top bar with search input -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-outline-variant/30 pb-6">
            <div>
                <h2 class="font-display text-headline-lg font-bold text-on-surface mb-2">Directorio de Docentes</h2>
                <p class="font-body-sm text-on-surface-variant">Consulta el plantel docente, sus calificaciones académicas y las materias asignadas por carrera.</p>
            </div>
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                <input 
                    type="text" 
                    x-model="search"
                    placeholder="Buscar docente o materia..." 
                    class="w-full bg-surface-container border border-outline-variant text-on-surface text-body-sm py-2.5 pl-10 pr-4 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors"
                />
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
                    x-show="search === '' || '{{ strtolower($searchableName) }}'.includes(search.toLowerCase()) || '{{ strtolower($searchableDetails) }}'.includes(search.toLowerCase()) || '{{ strtolower($searchableMateriasStr) }}'.includes(search.toLowerCase())"
                    class="glass-panel rounded-xl p-5 border border-outline-variant/30 flex flex-col justify-between hover:border-primary/40 hover:shadow-[0_0_15px_rgba(221,183,255,0.06)] transition-all duration-300"
                >
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
            @empty
                <div class="col-span-full glass-panel rounded-xl p-8 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-primary mb-4">person_off</span>
                    <p class="text-body-lg font-semibold">No hay docentes registrados</p>
                    <p class="text-xs mt-2">Próximamente se añadirán docentes universitarios al sistema.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-dashboard-layout>
