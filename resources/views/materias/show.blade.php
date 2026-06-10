<x-dashboard-layout title="Materia - {{ $materia->nombre }}" headerText="USFX / Ecosistema Académico">

    <!-- Mensajes de Estado -->
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <span class="text-body-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Resumen de la Materia -->
    <section class="bg-surface-container border border-outline-variant/30 rounded-bento p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-primary via-primary-container to-transparent"></div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-label-mono text-xs px-2 py-0.5 rounded bg-primary/10 text-primary uppercase font-bold">{{ $materia->codigo }}</span>
                    <span class="text-on-surface-variant text-xs font-label-mono">{{ $materia->tm === 'O' ? 'Optativa' : 'Obligatoria' }} / {{ $materia->carrera?->nombre ?? 'Semestre ' . $materia->semestre }}</span>
                </div>
                <h2 class="font-display text-2xl md:text-3xl font-bold text-on-surface">{{ $materia->nombre }}</h2>
                <p class="text-body-sm text-on-surface-variant mt-2 max-w-2xl">
                    Estudio y contenido curricular de la asignatura {{ $materia->nombre }}. En esta sección accedes únicamente al contenido de tu grupo inscrito.
                </p>
            </div>
            
            <!-- Tarjeta del Docente del Grupo -->
            @if($selectedGroup)
                <div class="flex items-center gap-4 bg-surface-container-low border border-outline-variant/20 rounded-xl p-4 w-full md:w-auto md:min-w-[280px]">
                    <div class="w-12 h-12 rounded-full overflow-hidden border border-primary/20 bg-primary/10 flex items-center justify-center text-primary font-bold shrink-0">
                        @if($selectedGroup->docente && $selectedGroup->docente->foto)
                            <img src="{{ asset($selectedGroup->docente->foto) }}" alt="{{ $selectedGroup->docente->nombre_completo }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($selectedGroup->docente?->nombre_completo ?? 'D', 0, 2)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="block font-label-mono text-[9px] text-on-surface-variant uppercase tracking-wider">Docente - Grupo {{ $selectedGroup->grupo_codigo }}</span>
                        <h4 class="text-body-sm font-semibold text-on-surface truncate">{{ $selectedGroup->docente?->nombre_completo ?? 'Docente por asignar' }}</h4>
                        @if($selectedGroup->docente && $selectedGroup->docente->calificacion)
                            <div class="flex items-center gap-1 mt-0.5 text-xs text-primary font-bold">
                                <span class="material-symbols-outlined text-[14px]">star</span>
                                <span>{{ number_format($selectedGroup->docente->calificacion, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-surface border border-outline-variant/20 rounded-lg p-3 text-center min-w-[150px]">
                    <span class="block font-label-mono text-[10px] text-on-surface-variant uppercase">Grupo</span>
                    <span class="text-body-sm font-semibold text-primary">Sin grupo asignado</span>
                </div>
            @endif
        </div>
    </section>

    <!-- Barra de Navegación del Muro y Acciones -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-outline-variant/30 pb-4">
        <!-- Sistema de Navegación por Pestañas (Tabs) -->
        <div class="flex gap-2">
            <button onclick="switchTab('consejos')" id="tab-btn-consejos" class="px-6 py-2.5 font-display text-body-sm font-semibold text-primary border-b-2 border-primary transition-all">
                Consejos y Recursos
            </button>
            <button onclick="switchTab('archivos')" id="tab-btn-archivos" class="px-6 py-2.5 font-display text-body-sm font-semibold text-on-surface-variant hover:text-on-surface transition-all flex items-center gap-2">
                Archivos y Recursos
                @if(!Auth::user()->isPremium())
                    <span class="material-symbols-outlined text-[16px] text-amber-400 fill-icon animate-pulse" title="Contenido Premium">workspace_premium</span>
                @endif
            </button>
        </div>

        <!-- Botón para Aportar Consejo/Archivo -->
        <button onclick="toggleAporteForm()" class="px-4 py-2 bg-primary text-on-primary font-bold text-body-sm rounded-DEFAULT hover:brightness-110 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(183,109,255,0.2)]">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Aportar a la Comunidad
        </button>
    </div>

    <!-- FORMULARIO DE APORTACIÓN COLLAPSIBLE -->
    <div id="aporteFormContainer" class="hidden transition-all duration-300">
        <form method="POST" action="{{ route('consejos.store', $materia->id) }}" enctype="multipart/form-data" class="p-6 bg-surface-container-low border border-outline-variant/50 rounded-bento space-y-4 shadow-lg">
            @csrf
            <h3 class="font-display font-semibold text-body-lg text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">share</span>
                Compartir Aporte para el Grupo {{ $selectedGroup?->grupo_codigo ?? '' }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tipo de Recurso -->
                <div>
                    <label for="tipo" class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Tipo de Contenido:</label>
                    <select id="tipo" name="tipo" required class="w-full bg-surface-container border border-outline-variant rounded-DEFAULT py-2.5 px-3 font-body-sm text-body-sm text-on-surface focus:ring-0">
                        <option value="consejo">Consejo / Recomendación Práctica</option>
                        <option value="examen">Examen (Pasado / Resuelto)</option>
                        <option value="apunte">Apunte de Clase / Notas</option>
                        <option value="otro">Otro Recurso Académico</option>
                    </select>
                </div>

                <!-- Archivo Adjunto (Opcional) -->
                <div>
                    <label for="archivo" class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Archivo Adjunto (Opcional - Imagen o PDF, máx. 10MB):</label>
                    <input type="file" id="archivo" name="archivo" accept="application/pdf,image/*" class="w-full text-body-sm text-on-surface border border-outline-variant/60 rounded-DEFAULT bg-surface-container/30 px-3 py-1.5 focus:outline-none">
                </div>
            </div>

            <!-- Contenido -->
            <div>
                <label for="contenido" class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Consejo / Descripción:</label>
                <textarea id="contenido" name="contenido" rows="4" required placeholder="Escribe aquí tu consejo práctico, recomendación de estudio, o descripción del archivo adjunto..." class="w-full bg-surface-container border border-outline-variant rounded-DEFAULT p-3 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary transition-colors"></textarea>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="toggleAporteForm()" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 hover:text-on-surface font-bold rounded-DEFAULT text-body-sm transition-all">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 bg-primary text-on-primary font-bold rounded-DEFAULT text-body-sm hover:brightness-110 transition-all shadow-[0_0_12px_rgba(183,109,255,0.3)]">
                    Publicar Aporte
                </button>
            </div>
        </form>
    </div>

    <!-- CONTENIDO PESTAÑA 1: CONSEJOS Y RECURSOS -->
    <div id="tab-content-consejos" class="space-y-6">
        
        <!-- Controles de Filtros -->
        <div class="flex flex-col md:flex-row md:items-center gap-4 justify-between bg-surface-container/40 p-4 border border-outline-variant/20 rounded-xl">
            <!-- Barra de búsqueda -->
            <div class="relative w-full max-w-sm">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                <input id="consejoSearch" onkeyup="filterConsejos()" class="w-full bg-surface-container-low border border-outline-variant rounded-DEFAULT pl-10 pr-4 py-2 text-body-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Buscar consejos..." type="text"/>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Filtro por Fechas -->
                <div class="flex items-center gap-2">
                    <label for="dateFilter" class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fecha:</label>
                    <select id="dateFilter" onchange="filterConsejos()" class="bg-surface-container border border-outline-variant rounded-DEFAULT py-1.5 px-3 font-body-sm text-xs text-on-surface focus:ring-0">
                        <option value="all">Cualquier fecha</option>
                        <option value="week">Última semana</option>
                        <option value="month">Último mes</option>
                        <option value="year">Último año</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categorías (Pills de tipo) -->
        <div class="flex flex-wrap gap-2">
            <button onclick="setCategoryFilter('all')" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant bg-primary text-on-primary" id="cat-all">
                Todos
            </button>
            <button onclick="setCategoryFilter('consejo')" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant text-on-surface-variant hover:bg-surface-variant/30" id="cat-consejo">
                Consejos
            </button>
            <button onclick="setCategoryFilter('examen')" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant text-on-surface-variant hover:bg-surface-variant/30" id="cat-examen">
                Exámenes
            </button>
            <button onclick="setCategoryFilter('apunte')" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant text-on-surface-variant hover:bg-surface-variant/30" id="cat-apunte">
                Apuntes
            </button>
            <button onclick="setCategoryFilter('otro')" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant text-on-surface-variant hover:bg-surface-variant/30" id="cat-otro">
                Otros
            </button>
        </div>

        <!-- Grid de Consejos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-bento-gap" id="consejosContainer">
            @forelse($consejos as $consejo)
                @php
                    $isImage = false;
                    if ($consejo->archivo_path) {
                        $ext = strtolower(pathinfo($consejo->archivo_path, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp']);
                    }
                    
                    // Colores de categoría
                    $badgeClass = match($consejo->tipo) {
                        'consejo' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
                        'examen' => 'bg-red-500/10 text-red-400 border border-red-500/20',
                        'apunte' => 'bg-sky-500/10 text-sky-400 border border-sky-500/20',
                        default => 'bg-purple-500/10 text-purple-400 border border-purple-500/20',
                    };
                    $tipoLabel = match($consejo->tipo) {
                        'consejo' => 'Consejo',
                        'examen' => 'Examen',
                        'apunte' => 'Apunte',
                        default => 'Otro',
                    };
                @endphp
                <div class="bg-surface-container border border-outline-variant rounded-bento p-5 flex flex-col gap-3 hover:border-outline-variant transition-colors consejo-card"
                     data-timestamp="{{ $consejo->created_at->timestamp }}"
                     data-tipo="{{ $consejo->tipo }}">
                    
                    <!-- Cabecera de la tarjeta: Categoría y Validación -->
                    <div class="flex justify-between items-center">
                        <div class="flex flex-wrap gap-2">
                            <span class="font-label-mono text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-wider {{ $badgeClass }} tag-tipo">{{ $tipoLabel }}</span>
                            <span class="font-label-mono text-[9px] px-2 py-0.5 rounded bg-surface-variant text-on-surface-variant uppercase tracking-wider">Grupo {{ $consejo->grupoMateriaDocente?->grupo_codigo }}</span>
                        </div>
                        @if($consejo->validado)
                            <span class="text-primary flex items-center gap-1 font-label-mono text-[10px] font-bold">
                                <span class="material-symbols-outlined text-[14px] fill-icon">verified</span>
                                Verificado
                            </span>
                        @endif
                    </div>

                    <!-- Contenido -->
                    <p class="text-body-sm text-on-surface leading-relaxed content-text">{{ $consejo->contenido }}</p>

                    <!-- Render de archivo adjunto si existe -->
                    @if($consejo->archivo_path)
                        @if(!Auth::user()->isPremium())
                            <!-- Blocked File Preview for Base Users -->
                            <div onclick="window.dispatchEvent(new CustomEvent('open-modal', 'premium-paywall'))" class="mt-2 p-3 bg-surface-container-low border border-outline-variant/30 rounded-lg flex flex-col gap-2 cursor-pointer relative overflow-hidden group hover:border-primary/50 transition-all duration-300">
                                <div class="flex items-center justify-between gap-3 filter blur-xs opacity-50 select-none pointer-events-none">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">
                                            {{ $isImage ? 'image' : 'picture_as_pdf' }}
                                        </span>
                                        <span class="text-xs text-on-surface truncate font-medium font-display">{{ $consejo->archivo_nombre }}</span>
                                    </div>
                                    <span class="px-2.5 py-1 bg-primary/10 text-primary font-label-mono text-[9px] font-bold rounded flex items-center gap-1 shrink-0">
                                        <span class="material-symbols-outlined text-xs">download</span>
                                        Bajar
                                    </span>
                                </div>
                                <!-- Lock overlay -->
                                <div class="absolute inset-0 bg-surface-container-low/80 backdrop-blur-[2px] flex items-center justify-center gap-2 text-primary font-display text-[11px] font-bold">
                                    <span class="material-symbols-outlined text-[16px] text-amber-400 fill-icon animate-pulse">workspace_premium</span>
                                    <span>Ver Archivo Premium</span>
                                </div>
                            </div>
                        @else
                            <!-- Original file preview for Premium users -->
                            <div class="mt-2 p-3 bg-surface-container-low border border-outline-variant/30 rounded-lg flex flex-col gap-2">
                                @if($isImage)
                                    <img src="{{ asset($consejo->archivo_path) }}" alt="{{ $consejo->archivo_nombre }}" class="max-h-40 w-full object-cover rounded border border-outline-variant/30 cursor-zoom-in" onclick="window.open(this.src)">
                                @endif
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">
                                            {{ $isImage ? 'image' : 'picture_as_pdf' }}
                                        </span>
                                        <span class="text-xs text-on-surface truncate font-medium font-display">{{ $consejo->archivo_nombre }}</span>
                                    </div>
                                    <a href="{{ asset($consejo->archivo_path) }}" download class="px-2.5 py-1 bg-primary/10 hover:bg-primary text-primary hover:text-on-primary font-label-mono text-[9px] font-bold rounded transition-colors flex items-center gap-1 shrink-0">
                                        <span class="material-symbols-outlined text-xs">download</span>
                                        Bajar
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Autor y Fecha -->
                    <div class="mt-auto pt-3 border-t border-outline-variant/30 flex items-center justify-between text-[10px] font-label-mono text-on-surface-variant">
                        <div>
                            <span>Aporte de: </span>
                            <span class="font-bold text-primary">{{ $consejo->user->perfilEstudiante?->nickname ?? 'Anónimo' }}</span>
                            <span class="text-[9px] opacity-75">({{ $consejo->user->perfilEstudiante?->puntos ?? 0 }} pts)</span>
                        </div>
                        <span class="text-on-surface-variant/80">{{ $consejo->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Botones de Reacción (Likes/Dislikes) -->
                    <div class="flex items-center gap-4 pt-2 border-t border-outline-variant/10">
                        <button onclick="voteConsejo({{ $consejo->id }}, 'like')" class="flex items-center gap-1.5 text-on-surface-variant hover:text-primary transition-colors text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px]">thumb_up</span>
                            <span id="likes-count-{{ $consejo->id }}">{{ $consejo->likes_count }}</span>
                        </button>
                        <button onclick="voteConsejo({{ $consejo->id }}, 'dislike')" class="flex items-center gap-1.5 text-on-surface-variant hover:text-error transition-colors text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px]">thumb_down</span>
                            <span id="dislikes-count-{{ $consejo->id }}">{{ $consejo->dislikes_count }}</span>
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-1 md:col-span-2 glass-panel rounded-lg p-10 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-primary mb-3">volunteer_activism</span>
                    <h3 class="font-display text-body-lg font-semibold text-on-surface">No hay consejos para este grupo aún</h3>
                    <p class="text-xs mt-1 max-w-md mx-auto">Sé el primero en compartir un consejo o archivo de examen para el Grupo {{ $selectedGroup?->grupo_codigo ?? '' }} y gana puntos de reputación.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- CONTENIDO PESTAÑA 2: ARCHIVOS Y RECURSOS (SOLO CONSEJOS CON ARCHIVO) -->
    <div id="tab-content-archivos" class="hidden space-y-6 relative min-h-[400px]">
        @if(!Auth::user()->isPremium())
            <!-- Premium Overlay for Archivos/Documentos -->
            <div onclick="window.dispatchEvent(new CustomEvent('open-modal', 'premium-paywall'))" class="absolute inset-0 bg-surface/40 backdrop-blur-md z-30 flex flex-col items-center justify-center text-center p-6 cursor-pointer select-none rounded-2xl border border-outline-variant/30 min-h-[350px]">
                <div class="bg-surface-container-high border border-outline-variant/50 p-8 rounded-2xl max-w-md shadow-2xl flex flex-col items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-amber-400 to-amber-600 flex items-center justify-center shadow-lg animate-bounce">
                        <span class="material-symbols-outlined text-[36px] text-white fill-icon">workspace_premium</span>
                    </div>
                    <h3 class="font-display text-xl font-bold text-on-surface">Exámenes y Apuntes Pro</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Desbloquea el acceso ilimitado a exámenes pasados resueltos, pizarras de auxiliaturas, apuntes en PDF y otros recursos compartidos por tus compañeros.
                    </p>
                    <button class="px-6 py-2.5 bg-primary text-on-primary font-bold text-xs rounded-lg hover:brightness-110 transition-all flex items-center gap-1.5 shadow-[0_0_15px_rgba(183,109,255,0.4)]">
                        <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                        Obtener Acceso Pro ✨
                    </button>
                </div>
            </div>
        @endif

        <div class="{{ !Auth::user()->isPremium() ? 'blur-[8px] pointer-events-none select-none' : '' }} space-y-6 w-full">
            <!-- Grid de Archivos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-bento-gap" id="archivosContainer">
            @php
                $archivosCount = 0;
            @endphp
            @foreach($consejos as $consejo)
                @if($consejo->archivo_path)
                    @php
                        $archivosCount++;
                        $isImage = false;
                        $ext = strtolower(pathinfo($consejo->archivo_path, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp']);
                        
                        $badgeClass = match($consejo->tipo) {
                            'consejo' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
                            'examen' => 'bg-red-500/10 text-red-400 border border-red-500/20',
                            'apunte' => 'bg-sky-500/10 text-sky-400 border border-sky-500/20',
                            default => 'bg-purple-500/10 text-purple-400 border border-purple-500/20',
                        };
                        $tipoLabel = match($consejo->tipo) {
                            'consejo' => 'Consejo',
                            'examen' => 'Examen',
                            'apunte' => 'Apunte',
                            default => 'Otro',
                        };
                    @endphp
                    <div class="bg-surface-container border border-outline-variant rounded-bento p-5 flex flex-col gap-3 hover:border-outline-variant transition-colors archivo-card"
                         data-timestamp="{{ $consejo->created_at->timestamp }}"
                         data-tipo="{{ $consejo->tipo }}">
                        
                        <!-- Categoría -->
                        <div class="flex justify-between items-center">
                            <div class="flex flex-wrap gap-2">
                                <span class="font-label-mono text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-wider {{ $badgeClass }}">{{ $tipoLabel }}</span>
                                <span class="font-label-mono text-[9px] px-2 py-0.5 rounded bg-surface-variant text-on-surface-variant uppercase tracking-wider font-bold">Grupo {{ $consejo->grupoMateriaDocente?->grupo_codigo }}</span>
                            </div>
                            @if($consejo->validado)
                                <span class="text-primary flex items-center gap-1 font-label-mono text-[10px] font-bold">
                                    <span class="material-symbols-outlined text-[14px] fill-icon">verified</span>
                                    Verificado
                                </span>
                            @endif
                        </div>

                        <!-- Descripción -->
                        <p class="text-body-sm text-on-surface-variant leading-relaxed">{{ $consejo->contenido }}</p>

                        <!-- Box de Archivo -->
                        <div class="mt-2 p-3 bg-background border border-outline-variant/20 rounded-lg flex flex-col gap-2">
                            @if($isImage)
                                <img src="{{ asset($consejo->archivo_path) }}" alt="{{ $consejo->archivo_nombre }}" class="max-h-40 w-full object-cover rounded border border-outline-variant/30 cursor-zoom-in" onclick="window.open(this.src)">
                            @endif
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">
                                        {{ $isImage ? 'image' : 'picture_as_pdf' }}
                                    </span>
                                    <span class="text-xs text-on-surface truncate font-semibold font-display">{{ $consejo->archivo_nombre }}</span>
                                </div>
                                <a href="{{ asset($consejo->archivo_path) }}" download class="px-2.5 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-on-primary font-label-mono text-[10px] font-bold rounded transition-colors flex items-center gap-1 shrink-0">
                                    <span class="material-symbols-outlined text-xs">download</span>
                                    Bajar
                                </a>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-auto pt-3 border-t border-outline-variant/30 flex items-center justify-between text-[10px] font-label-mono text-on-surface-variant">
                            <div>
                                <span>Subido por: </span>
                                <span class="font-bold text-primary">{{ $consejo->user->perfilEstudiante?->nickname ?? 'Anónimo' }}</span>
                            </div>
                            <span>{{ $consejo->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endif
            @endforeach

            @if($archivosCount === 0)
                <div class="col-span-1 md:col-span-2 glass-panel rounded-lg p-10 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-primary mb-3">folder_open</span>
                    <h3 class="font-display text-body-lg font-semibold text-on-surface">No hay archivos en este grupo aún</h3>
                    <p class="text-xs mt-1 max-w-md mx-auto">Sube un examen o apunte en PDF para ganar 15 puntos de reputación y colaborar con tus compañeros.</p>
                </div>
            @endif
        </div>
        </div>

    </div>

    @push('scripts')
        <script>
            let currentCategoryFilter = 'all';

            let archivosTimer = null;
            function switchTab(tabName) {
                const consejosContent = document.getElementById('tab-content-consejos');
                const archivosContent = document.getElementById('tab-content-archivos');
                const consejosBtn = document.getElementById('tab-btn-consejos');
                const archivosBtn = document.getElementById('tab-btn-archivos');

                if (tabName === 'consejos') {
                    consejosContent.classList.remove('hidden');
                    archivosContent.classList.add('hidden');
                    
                    consejosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-primary border-b-2 border-primary transition-all";
                    archivosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-on-surface-variant hover:text-on-surface transition-all flex items-center gap-2";
                    
                    if (archivosTimer) {
                        clearTimeout(archivosTimer);
                        archivosTimer = null;
                    }
                } else {
                    consejosContent.classList.add('hidden');
                    archivosContent.classList.remove('hidden');
                    
                    consejosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-on-surface-variant hover:text-on-surface transition-all";
                    archivosBtn.className = "px-6 py-2.5 font-display text-body-sm font-semibold text-primary border-b-2 border-primary transition-all flex items-center gap-2";
                    
                    @if(!Auth::user()->isPremium())
                        if (!archivosTimer) {
                            archivosTimer = setTimeout(() => {
                                window.dispatchEvent(new CustomEvent('open-modal', 'premium-paywall'));
                            }, 5000);
                        }
                    @endif
                }
            }

            function toggleAporteForm() {
                const form = document.getElementById('aporteFormContainer');
                if (form.classList.contains('hidden')) {
                    form.classList.remove('hidden');
                } else {
                    form.classList.add('hidden');
                }
            }

            function setCategoryFilter(category) {
                currentCategoryFilter = category;
                
                // Actualizar estilo de botones
                const buttons = document.getElementsByClassName('category-btn');
                for (let i = 0; i < buttons.length; i++) {
                    const btn = buttons[i];
                    if (btn.id === 'cat-' + category) {
                        btn.className = "category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant bg-primary text-on-primary";
                    } else {
                        btn.className = "category-btn px-4 py-1.5 rounded-full text-xs font-bold transition-all border border-outline-variant text-on-surface-variant hover:bg-surface-variant/30";
                    }
                }
                
                filterConsejos();
            }

            function filterConsejos() {
                const searchInput = document.getElementById('consejoSearch');
                const filterText = searchInput ? searchInput.value.toLowerCase() : '';
                const dateFilter = document.getElementById('dateFilter') ? document.getElementById('dateFilter').value : 'all';
                
                const container = document.getElementById('consejosContainer');
                if (!container) return;
                const cards = container.getElementsByClassName('consejo-card');

                const now = Math.floor(Date.now() / 1000);
                const oneWeek = 7 * 24 * 60 * 60;
                const oneMonth = 30 * 24 * 60 * 60;
                const oneYear = 365 * 24 * 60 * 60;

                let targetTime = 0;
                if (dateFilter === 'week') {
                    targetTime = now - oneWeek;
                } else if (dateFilter === 'month') {
                    targetTime = now - oneMonth;
                } else if (dateFilter === 'year') {
                    targetTime = now - oneYear;
                }

                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const contentText = card.getElementsByClassName('content-text')[0].innerText.toLowerCase();
                    const cardTipo = card.getAttribute('data-tipo');
                    const cardTimestamp = parseInt(card.getAttribute('data-timestamp')) || 0;

                    const matchesSearch = contentText.includes(filterText);
                    const matchesDate = (dateFilter === 'all' || cardTimestamp >= targetTime);
                    const matchesCategory = (currentCategoryFilter === 'all' || cardTipo === currentCategoryFilter);

                    if (matchesSearch && matchesDate && matchesCategory) {
                        card.style.display = "";
                    } else {
                        card.style.display = "none";
                    }
                }

                // Filtrar también los archivos de la pestaña 2
                const archivosContainer = document.getElementById('archivosContainer');
                if (archivosContainer) {
                    const fileCards = archivosContainer.getElementsByClassName('archivo-card');
                    for (let i = 0; i < fileCards.length; i++) {
                        const card = fileCards[i];
                        const cardTipo = card.getAttribute('data-tipo');
                        const cardTimestamp = parseInt(card.getAttribute('data-timestamp')) || 0;

                        const matchesDate = (dateFilter === 'all' || cardTimestamp >= targetTime);
                        const matchesCategory = (currentCategoryFilter === 'all' || cardTipo === currentCategoryFilter);

                        if (matchesDate && matchesCategory) {
                            card.style.display = "";
                        } else {
                            card.style.display = "none";
                        }
                    }
                }
            }

            function voteConsejo(consejoId, voteType) {
                fetch(`/consejos/${consejoId}/${voteType}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (voteType === 'like') {
                            document.getElementById(`likes-count-${consejoId}`).innerText = data.likes_count;
                        } else {
                            document.getElementById(`dislikes-count-${consejoId}`).innerText = data.dislikes_count;
                        }
                    }
                })
                .catch(err => console.error(err));
            }
        </script>
    @endpush

</x-dashboard-layout>
