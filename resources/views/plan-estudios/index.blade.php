<x-dashboard-layout title="Plan de Estudios" headerText="Visualización del Plan Curricular">
    
    <style>
        /* Custom styled scrollbar for study plan */
        #graph-container::-webkit-scrollbar {
            height: 8px;
        }
        #graph-container::-webkit-scrollbar-track {
            background: rgba(24, 24, 27, 0.4);
            border-radius: 8px;
        }
        #graph-container::-webkit-scrollbar-thumb {
            background: rgba(221, 183, 255, 0.2);
            border-radius: 8px;
        }
        #graph-container::-webkit-scrollbar-thumb:hover {
            background: rgba(221, 183, 255, 0.4);
        }

        /* Neural network floating node effect */
        @keyframes float {
            0% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-5px) translateX(2px); }
            50% { transform: translateY(0px) translateX(-2px); }
            75% { transform: translateY(5px) translateX(1.5px); }
            100% { transform: translateY(0px) translateX(0px); }
        }
        .floating-node {
            animation: float 6s ease-in-out infinite;
        }

        /* Transition for card borders and glows */
        .materia-node {
            transition: border-color 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease, transform 0.1s ease;
        }

        /* SVG path transition */
        .connection-line {
            transition: stroke-width 0.3s ease, opacity 0.3s ease, stroke 0.3s ease;
        }

        /* Dynamic Highlight Classes */
        .node-highlight-selected {
            border-color: #ddb7ff !important;
            box-shadow: 0 0 15px rgba(221, 183, 255, 0.6) !important;
            opacity: 1 !important;
            z-index: 30 !important;
        }
        .node-highlight-prereq {
            border-color: #ffb4ab !important;
            box-shadow: 0 0 15px rgba(255, 180, 171, 0.6) !important;
            opacity: 1 !important;
            z-index: 30 !important;
        }
        .node-highlight-dependent {
            border-color: #842bd2 !important;
            box-shadow: 0 0 15px rgba(132, 43, 210, 0.6) !important;
            opacity: 1 !important;
            z-index: 30 !important;
        }
        .node-dimmed {
            opacity: 0.15 !important;
        }
        .line-highlight-prereq {
            stroke: #ffb4ab !important;
            stroke-width: 3px !important;
            opacity: 1 !important;
        }
        .line-highlight-dependent {
            stroke: #842bd2 !important;
            stroke-width: 3px !important;
            opacity: 1 !important;
        }
        .line-dimmed {
            opacity: 0.02 !important;
        }
    </style>

    @if(!$carrera)
        <div class="glass-panel rounded-xl p-8 text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-[48px] text-primary mb-4">info</span>
            <p class="text-body-lg">No hay carreras registradas en el sistema en este momento.</p>
            <p class="text-xs mt-2">Inicia sesión en el panel de administración para registrar carreras y planes de estudio.</p>
        </div>
    @else
        <!-- Graph Area -->
        <div x-data="{
            isPremium: {{ Auth::user()->isPremium() ? 'true' : 'false' }},
            init() {
                if (!this.isPremium) {
                    setTimeout(() => {
                        this.$dispatch('open-modal', 'premium-paywall');
                    }, 5000);
                }
            }
        }" class="relative w-full">

            @if(!Auth::user()->isPremium())
                <!-- Premium Overlay -->
                <div @click="$dispatch('open-modal', 'premium-paywall')" class="absolute inset-0 bg-surface/40 backdrop-blur-md z-30 flex flex-col items-center justify-center text-center p-6 cursor-pointer select-none rounded-2xl border border-outline-variant/30 min-h-[500px]">
                    <div class="bg-surface-container-high border border-outline-variant/50 p-8 rounded-2xl max-w-md shadow-2xl flex flex-col items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-amber-400 to-amber-600 flex items-center justify-center shadow-lg animate-bounce">
                            <span class="material-symbols-outlined text-[36px] text-white fill-icon">workspace_premium</span>
                        </div>
                        <h3 class="font-display text-xl font-bold text-on-surface">Plan de Estudios Interactivo</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Visualiza el mapa de prerrequisitos, materias dependientes, semestres y haz un seguimiento inteligente y dinámico de tu progreso académico actual.
                        </p>
                        <button class="px-6 py-2.5 bg-primary text-on-primary font-bold text-xs rounded-lg hover:brightness-110 transition-all flex items-center gap-1.5 shadow-[0_0_15px_rgba(183,109,255,0.4)]">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Obtener Acceso Pro ✨
                        </button>
                    </div>
                </div>
            @endif

            <div class="{{ !Auth::user()->isPremium() ? 'blur-[8px] pointer-events-none select-none' : '' }} w-full">
                <div class="glass-panel rounded-xl p-0 relative overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-primary/30 to-transparent"></div>
            
            <!-- Instructions Legend -->
            <div class="flex flex-wrap items-center gap-4 mt-2 mx-2 mb-3 text-[10px] sm:text-xs text-on-surface-variant bg-surface-container/30 p-2.5 rounded-lg border border-outline-variant/30">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-primary shadow-[0_0_8px_#ddb7ff]"></span>Seleccionada</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-error shadow-[0_0_8px_#ffb4ab]"></span>Prerrequisitos</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#842bd2] shadow-[0_0_8px_#842bd2]"></span>Dependientes</span>
                <div class="w-px h-3 bg-outline-variant/40 mx-1 hidden sm:block"></div>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>Vencida (Aprobada)</span>
                <span class="flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                    </span>
                    Cursando actualmente
                </span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-on-surface-variant/40"></span>Pendiente (Falta)</span>
                <span class="ml-auto italic hidden lg:inline">Consejo: Haz clic en una materia para fijar sus conexiones.</span>
            </div>

            <!-- Scroll Top Wrapper & Container -->
            <!-- We rotate container 180deg to place scrollbar on top, and rotate canvas back 180deg to look normal -->
            <div id="graph-container" class="overflow-x-auto w-full relative min-h-[600px] h-[800px] pb-6" style="transform: rotateX(180deg); -webkit-transform: rotateX(180deg);">
                
                @php
                    $maxSemestre = max(10, $materiasBySemestre->keys()->max() ?? 10);
                    $colWidth = 460; // Increased spacing between semesters to make lines stand out
                    $cardWidth = 220; // Slightly narrower cards to give more lane breathing room
                    $canvasHeight = 1100; // Taller canvas to prevent vertical overlap
                    $yMin = 100; // Start below the lane header
                    $yMax = 980; // Spread all the way down
                @endphp

                <!-- Graph Canvas -->
                <div id="graph-canvas" class="relative" style="width: {{ $maxSemestre * $colWidth }}px; height: {{ $canvasHeight }}px; transform: rotateX(180deg); -webkit-transform: rotateX(180deg);">
                    
                    <!-- SVG connector overlay -->
                    <svg id="connector-svg" class="absolute top-0 left-0 w-full h-full pointer-events-none z-10 overflow-visible"></svg>

                    <!-- Semester Lanes (Background) -->
                    @for($sem = 1; $sem <= $maxSemestre; $sem++)
                        @php
                            $materias = $materiasBySemestre->get($sem, collect());
                            $total = $materias->count();
                        @endphp
                        
                        <!-- Lane Stripe -->
                        <div class="absolute top-0 bottom-0 border-r border-outline-variant/10 bg-surface-container-lowest/5" style="left: {{ ($sem - 1) * $colWidth }}px; width: {{ $colWidth }}px;">
                            <!-- Semester Title -->
                            <div class="absolute top-4 left-6 right-6 bg-surface-container-low border border-outline-variant/40 rounded-lg py-2 px-3 text-center font-display font-bold text-xs text-primary tracking-wide">
                                {{ $sem }}° Semestre
                            </div>
                        </div>

                        <!-- Staggered absolute subject cards -->
                        @foreach($materias as $i => $materia)
                            @php
                                // Staggered layout Math
                                $centerX = ($sem - 1) * $colWidth + ($colWidth - $cardWidth) / 2;
                                
                                // Vertical position distributed
                                if ($total > 1) {
                                    $step = ($yMax - $yMin) / ($total - 1);
                                    $top = $yMin + $i * $step;
                                } else {
                                    $top = ($yMin + $yMax) / 2;
                                }
                                
                                // Alternating horizontal offset (zigzag network)
                                if ($total > 1) {
                                    $xOffset = ($i % 2 == 0) ? -55 : 55;
                                } else {
                                    $xOffset = 0;
                                }
                                $left = $centerX + $xOffset;

                                // Float animations delay & speed
                                $delay = rand(-50, 50) / 10;
                                $duration = rand(60, 90) / 10;

                                // Style for Optativa to look distinct
                                $isOptativa = ($materia->tm === 'O');

                                // Get academic progress status
                                $estado = $userMaterias[$materia->id] ?? null;
                                if ($estado === 'aprobada') {
                                    $cardClasses = 'border-emerald-500/40 bg-emerald-500/5 shadow-[0_0_12px_rgba(16,185,129,0.06)] hover:border-emerald-500/70';
                                } elseif ($estado === 'cursando') {
                                    $cardClasses = 'border-sky-500/40 bg-sky-500/5 shadow-[0_0_12px_rgba(14,165,233,0.06)] hover:border-sky-500/70';
                                } else {
                                    $cardClasses = $isOptativa
                                        ? 'border-[#842bd2]/30 bg-[#842bd2]/5 shadow-[0_0_12px_rgba(132,43,210,0.06)] hover:border-[#842bd2]/70'
                                        : 'border-outline-variant hover:border-primary/50';
                                }
                            @endphp

                            <div
                                id="node-{{ $materia->codigo }}"
                                data-codigo="{{ $materia->codigo }}"
                                data-prereqs="{{ $materia->prerequisitos->pluck('codigo')->implode(',') }}"
                                class="materia-node absolute glass-card rounded-xl p-4 border cursor-pointer z-20 floating-node w-[220px] {{ $cardClasses }}"
                                style="left: {{ $left }}px; top: {{ $top }}px; animation-delay: {{ $delay }}s; animation-duration: {{ $duration }}s;"
                            >
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-label-mono text-[9px] text-primary uppercase tracking-wider">{{ $materia->codigo }}</span>
                                    @if($materia->tm === 'O')
                                        <span class="px-1.5 py-0.5 text-[8px] font-bold bg-[#842bd2]/20 text-[#ddb7ff] border border-[#842bd2]/40 rounded uppercase tracking-wider">Optativa</span>
                                    @else
                                        <span class="px-1.5 py-0.5 text-[8px] font-bold bg-surface-container-high text-on-surface-variant border border-outline-variant rounded uppercase tracking-wider">Normal</span>
                                    @endif
                                </div>
                                <h4 class="font-display font-semibold text-body-sm text-on-surface mb-2.5 leading-snug line-clamp-2">{{ $materia->nombre }}</h4>
                                <div class="flex justify-between items-center text-[10px] text-on-surface-variant pt-2 border-t border-outline-variant/10">
                                    @if($estado === 'aprobada')
                                        <span class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                            Vencida
                                        </span>
                                    @elseif($estado === 'cursando')
                                        <span class="flex items-center gap-1.5 text-sky-400 font-semibold">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                                            </span>
                                            Cursando
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5 text-on-surface-variant/70">
                                            <span class="w-2 h-2 rounded-full bg-on-surface-variant/40"></span>
                                            Falta
                                        </span>
                                    @endif

                                    @if($materia->gruposMateriaDocente->isNotEmpty())
                                        <span class="text-secondary flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[10px]">groups</span>
                                            {{ $materia->gruposMateriaDocente->count() }} Gp.
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endfor

                </div>

            </div>
        </div>

        @push('scripts')
            <script>
                let connections = [];
                let animationFrameId = null;
                let selectedNode = null; // Locked selection node code

                document.addEventListener('DOMContentLoaded', () => {
                    const canvas = document.getElementById('graph-canvas');
                    if (!canvas) return;

                    // Modern ResizeObserver to set up connections as soon as the element renders
                    const observer = new ResizeObserver(() => {
                        initConnections();
                    });
                    observer.observe(canvas);

                    // Setup user interaction click and hover listeners
                    setupGraphInteractions();

                    window.addEventListener('resize', () => {
                        initConnections();
                    });
                });

                window.addEventListener('beforeunload', () => {
                    if (animationFrameId) {
                        cancelAnimationFrame(animationFrameId);
                    }
                });

                function initConnections() {
                    const svg = document.getElementById('connector-svg');
                    const canvas = document.getElementById('graph-canvas');
                    if (!svg || !canvas) return;

                    // Sizing SVG precisely to the canvas content
                    svg.setAttribute('width', canvas.clientWidth);
                    svg.setAttribute('height', canvas.clientHeight);
                    svg.innerHTML = ''; // Clear SVG elements
                    connections = [];

                    const nodes = document.querySelectorAll('.materia-node');
                    const nodeMap = {};

                    // Map node positions for quick lookup
                    nodes.forEach(node => {
                        nodeMap[node.dataset.codigo] = node;
                    });

                    nodes.forEach(node => {
                        const toId = node.dataset.codigo;
                        const prereqsStr = node.dataset.prereqs;
                        if (!prereqsStr) return;

                        const prereqs = prereqsStr.split(',').filter(Boolean);
                        prereqs.forEach(fromId => {
                            const fromNode = nodeMap[fromId];
                            if (!fromNode) return;

                            // Create path element
                            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                            path.setAttribute('fill', 'none');
                            path.setAttribute('class', 'connection-line');
                            path.setAttribute('data-from', fromId);
                            path.setAttribute('data-to', toId);

                            svg.appendChild(path);

                            connections.push({
                                path: path,
                                fromNode: fromNode,
                                toNode: node
                            });
                        });
                    });

                    // Start loop for animation
                    if (animationFrameId) {
                        cancelAnimationFrame(animationFrameId);
                    }
                    updateConnectionPaths();
                }

                function updateConnectionPaths() {
                    const canvas = document.getElementById('graph-canvas');
                    if (!canvas) return;

                    const canvasRect = canvas.getBoundingClientRect();

                    connections.forEach(conn => {
                        const fromRect = conn.fromNode.getBoundingClientRect();
                        const toRect = conn.toNode.getBoundingClientRect();

                        // Coordinates relative to canvas (scroll-invariant!)
                        const startX = fromRect.right - canvasRect.left;
                        const startY = fromRect.top + fromRect.height / 2 - canvasRect.top;

                        const endX = toRect.left - canvasRect.left;
                        const endY = toRect.top + toRect.height / 2 - canvasRect.top;

                        // Cubic bezier curves
                        const dx = Math.abs(endX - startX);
                        const controlOffset = Math.max(80, dx * 0.45); // Curvature factor
                        const pathData = `M ${startX} ${startY} C ${startX + controlOffset} ${startY}, ${endX - controlOffset} ${endY}, ${endX} ${endY}`;

                        conn.path.setAttribute('d', pathData);
                    });

                    animationFrameId = requestAnimationFrame(updateConnectionPaths);
                }

                // Recursive pathfinders to retrieve all descendants and ancestors
                function getAncestors(codigo, visited = new Set()) {
                    if (visited.has(codigo)) return visited;
                    visited.add(codigo);
                    const node = document.querySelector(`.materia-node[data-codigo="${codigo}"]`);
                    if (node) {
                        const pStr = node.dataset.prereqs;
                        const prereqs = pStr ? pStr.split(',').filter(Boolean) : [];
                        prereqs.forEach(p => getAncestors(p, visited));
                    }
                    return visited;
                }

                function getDescendants(codigo, visited = new Set()) {
                    if (visited.has(codigo)) return visited;
                    visited.add(codigo);
                    document.querySelectorAll('.materia-node').forEach(n => {
                        const pStr = n.dataset.prereqs;
                        const pList = pStr ? pStr.split(',').filter(Boolean) : [];
                        if (pList.includes(codigo)) {
                            getDescendants(n.dataset.codigo, visited);
                        }
                    });
                    return visited;
                }

                function highlightChain(codigo) {
                    const nodes = document.querySelectorAll('.materia-node');
                    const lines = document.querySelectorAll('.connection-line');

                    if (!codigo) {
                        // Reset all elements
                        nodes.forEach(n => {
                            n.classList.remove('node-highlight-selected', 'node-highlight-prereq', 'node-highlight-dependent', 'node-dimmed');
                        });

                        lines.forEach(line => {
                            line.classList.remove('line-highlight-prereq', 'line-highlight-dependent', 'line-dimmed');
                        });
                        return;
                    }

                    const ancestors = getAncestors(codigo);
                    const descendants = getDescendants(codigo);

                    // Highlight node active states
                    nodes.forEach(n => {
                        const nCode = n.dataset.codigo;
                        n.classList.remove('node-highlight-selected', 'node-highlight-prereq', 'node-highlight-dependent', 'node-dimmed');

                        if (nCode === codigo) {
                            n.classList.add('node-highlight-selected');
                        } else if (ancestors.has(nCode)) {
                            n.classList.add('node-highlight-prereq');
                        } else if (descendants.has(nCode)) {
                            n.classList.add('node-highlight-dependent');
                        } else {
                            n.classList.add('node-dimmed');
                        }
                    });

                    // Highlight connection line active states
                    lines.forEach(line => {
                        const from = line.getAttribute('data-from');
                        const to = line.getAttribute('data-to');

                        line.classList.remove('line-highlight-prereq', 'line-highlight-dependent', 'line-dimmed');

                        const isPrereqPath = ancestors.has(from) && (to === codigo || ancestors.has(to));
                        const isDependentPath = (from === codigo || descendants.has(from)) && descendants.has(to);

                        if (isPrereqPath) {
                            line.classList.add('line-highlight-prereq');
                        } else if (isDependentPath) {
                            line.classList.add('line-highlight-dependent');
                        } else {
                            line.classList.add('line-dimmed');
                        }
                    });
                }

                function setupGraphInteractions() {
                    const nodes = document.querySelectorAll('.materia-node');

                    nodes.forEach(node => {
                        const codigo = node.dataset.codigo;

                        node.addEventListener('mouseenter', () => {
                            if (!selectedNode) {
                                highlightChain(codigo);
                            }
                        });

                        node.addEventListener('mouseleave', () => {
                            if (!selectedNode) {
                                highlightChain(null);
                            }
                        });

                        node.addEventListener('click', (e) => {
                            e.stopPropagation(); // Avoid background canvas click trigger
                            
                            if (selectedNode === codigo) {
                                // Toggle off
                                selectedNode = null;
                                highlightChain(null);
                            } else {
                                // Lock select node
                                selectedNode = codigo;
                                highlightChain(codigo);
                            }
                        });
                    });

                    // Clear selection when clicking the background canvas
                    const container = document.getElementById('graph-container');
                    const canvas = document.getElementById('graph-canvas');
                    if (canvas) {
                        canvas.addEventListener('click', (e) => {
                            if (e.target.id === 'graph-canvas' || e.target.id === 'connector-svg') {
                                selectedNode = null;
                                highlightChain(null);
                            }
                        });
                    }
                    if (container) {
                        container.addEventListener('click', (e) => {
                            if (e.target.id === 'graph-container') {
                                selectedNode = null;
                                highlightChain(null);
                            }
                        });
                    }
                }
            </script>
        @endpush
        </div>
        </div>
    @endif
</x-dashboard-layout>
