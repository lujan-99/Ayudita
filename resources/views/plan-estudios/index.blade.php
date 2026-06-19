<x-dashboard-layout title="Plan de Estudios" headerText="Visualización del Plan Curricular" :hideFooter="true">
    
    <style>
        /* Hide scrollbar for Figma-like canvas */
        #graph-container::-webkit-scrollbar {
            display: none;
        }
        #graph-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Figma-like infinite dot-grid */
        .canvas-dot-grid {
            background-image: radial-gradient(rgba(132, 43, 210, 0.15) 1.2px, transparent 1.2px);
            background-size: 32px 32px;
        }
        .dark .canvas-dot-grid {
            background-image: radial-gradient(rgba(221, 183, 255, 0.08) 1.2px, transparent 1.2px);
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
        <!-- Screen Breakout Wrapper -->
        <div class="fixed top-16 bottom-0 right-0 z-30 transition-all duration-300 select-none overflow-hidden"
             :class="sidebarCollapsed ? 'left-0 md:left-20' : 'left-0 md:left-64'">

            <!-- HUD Panel: Career Info -->
            <div id="tour-plan-title" class="hud-panel absolute top-4 left-4 z-40 bg-surface-container-high/90 border border-outline-variant/50 backdrop-blur-md px-4 py-3 rounded-xl shadow-lg flex flex-col gap-0.5 pointer-events-auto">
                <span class="text-[9px] font-label-mono text-on-surface-variant uppercase tracking-widest">Plan de Estudios Vigente</span>
                <h2 class="font-display font-bold text-sm text-primary leading-tight">{{ $carrera->nombre }}</h2>
            </div>

            <!-- HUD Panel: Legend -->
            <div id="tour-plan-legend" class="hud-panel absolute top-4 right-4 z-40 max-w-[280px] bg-surface-container-high/90 border border-outline-variant/50 backdrop-blur-md p-3.5 rounded-xl shadow-lg flex flex-col gap-2.5 pointer-events-auto">
                <div class="flex items-center justify-between border-b border-outline-variant/30 pb-1.5">
                    <span class="font-display font-bold text-[10px] text-primary uppercase tracking-wider">Leyenda del Plan</span>
                    <span class="text-[8px] text-on-surface-variant/80 italic">Click para fijar</span>
                </div>
                <div class="grid grid-cols-2 gap-x-3 gap-y-2 text-[10px] text-on-surface-variant">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_#ddb7ff]"></span>Seleccionada</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>Aprobada</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-error shadow-[0_0_8px_#ffb4ab]"></span>Prerrequisito</span>
                    <span class="flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                        </span>
                        Cursando
                    </span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#842bd2] shadow-[0_0_8px_#842bd2]"></span>Dependiente</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-on-surface-variant/40"></span>Pendiente (Falta)</span>
                </div>
            </div>

            <!-- HUD Panel: Zoom Controls -->
            <div id="tour-plan-zoom" class="hud-panel absolute bottom-4 left-4 z-40 flex items-center gap-2 bg-surface-container-high/90 border border-outline-variant/50 backdrop-blur-md px-3 py-2 rounded-xl shadow-lg pointer-events-auto">
                <button id="zoom-out-btn" class="w-8 h-8 rounded-lg hover:bg-surface-variant flex items-center justify-center text-on-surface transition-colors cursor-pointer" title="Alejar (Zoom Out)">
                    <span class="material-symbols-outlined text-[20px]">remove</span>
                </button>
                <span id="zoom-badge" class="font-label-mono text-xs font-bold text-primary min-w-[48px] text-center">75%</span>
                <button id="zoom-in-btn" class="w-8 h-8 rounded-lg hover:bg-surface-variant flex items-center justify-center text-on-surface transition-colors cursor-pointer" title="Acercar (Zoom In)">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                </button>
                <div class="w-px h-5 bg-outline-variant/40 mx-1"></div>
                <button id="zoom-reset-btn" class="w-8 h-8 rounded-lg hover:bg-surface-variant flex items-center justify-center text-on-surface transition-colors cursor-pointer" title="Centrar / Restablecer vista">
                    <span class="material-symbols-outlined text-[20px]">fullscreen</span>
                </button>
                <div class="w-px h-5 bg-outline-variant/40 mx-1"></div>
                <button @click="$dispatch('start-tour')" class="w-8 h-8 rounded-lg hover:bg-surface-variant flex items-center justify-center text-on-surface hover:text-primary transition-colors cursor-pointer" title="Guía Rápida (Tour)">
                    <span class="material-symbols-outlined text-[20px] animate-pulse">explore</span>
                </button>
            </div>

            <!-- Canvas Viewport -->
            <div id="graph-container" class="w-full h-full relative overflow-hidden canvas-dot-grid cursor-grab active:cursor-grabbing" style="user-select: none; -webkit-user-select: none;">
                
                @php
                    $maxSemestre = max(10, $materiasBySemestre->keys()->max() ?? 10);
                    $colWidth = 460;
                    $cardWidth = 220;
                    $canvasHeight = 1100;
                    $yMin = 100;
                    $yMax = 980;
                @endphp

                <!-- Graph Canvas (Transformed via JS) -->
                <div id="graph-canvas" class="relative origin-top-left" style="width: {{ $maxSemestre * $colWidth }}px; height: {{ $canvasHeight }}px;">
                    
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
                                id="{{ ($sem === 1 && $loop->first) ? 'tour-plan-materia' : 'node-' . $materia->codigo }}"
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

        </div> <!-- Close Screen Breakout Wrapper -->

        @push('scripts')
            <script>
                let connections = [];
                let animationFrameId = null;
                let selectedNode = null; // Locked selection node code

                // Pan and Zoom states
                let scale = 0.75;
                let panX = 60;
                let panY = 40;
                let isDragging = false;
                let startX = 0;
                let startY = 0;
                let hasMoved = false;

                document.addEventListener('DOMContentLoaded', () => {
                    const canvas = document.getElementById('graph-canvas');
                    if (!canvas) return;

                    // Initialize Pan & Zoom
                    setupPanAndZoom();

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

                    // Hard premium paywall after 5 seconds
                    @if(!Auth::user()->isPremium())
                        let paywallShown = false;
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'premium-paywall' }));
                            paywallShown = true;
                            
                            // Observe if modal gets closed (Escape, background click, close button) and redirect
                            const modal = document.getElementById('premium-paywall');
                            if (modal) {
                                const checkInterval = setInterval(() => {
                                    if (paywallShown && modal.style.display === 'none') {
                                        clearInterval(checkInterval);
                                        window.location.href = "{{ route('dashboard') }}";
                                    }
                                }, 300);
                            }
                        }, 5000);
                    @endif
                });

                window.addEventListener('beforeunload', () => {
                    if (animationFrameId) {
                        cancelAnimationFrame(animationFrameId);
                    }
                });

                function applyTransform() {
                    const canvas = document.getElementById('graph-canvas');
                    const container = document.getElementById('graph-container');
                    const badge = document.getElementById('zoom-badge');
                    if (!canvas) return;
                    
                    canvas.style.transform = `translate(${panX}px, ${panY}px) scale(${scale})`;
                    if (container) {
                        container.style.backgroundPosition = `${panX}px ${panY}px`;
                        container.style.backgroundSize = `${32 * scale}px ${32 * scale}px`;
                    }
                    if (badge) {
                        badge.innerText = `${Math.round(scale * 100)}%`;
                    }
                }

                function setupPanAndZoom() {
                    const container = document.getElementById('graph-container');
                    const canvas = document.getElementById('graph-canvas');
                    if (!container || !canvas) return;

                    // Centering calculation dynamically with layout delay
                    setTimeout(() => {
                        const containerWidth = container.clientWidth;
                        const containerHeight = container.clientHeight;
                        const canvasHeight = canvas.clientHeight || 1100;
                        
                        scale = Math.min(0.8, Math.max(0.4, containerWidth / 1800)); // Dynamic scale
                        panY = (containerHeight - (canvasHeight * scale)) / 2;
                        if (panY < 20) panY = 20;
                        panX = 60;
                        
                        applyTransform();
                        initConnections();
                    }, 100);

                    // Mouse Wheel Zooming centered on cursor
                    container.addEventListener('wheel', (e) => {
                        e.preventDefault();

                        const rect = container.getBoundingClientRect();
                        const mouseX = e.clientX - rect.left;
                        const mouseY = e.clientY - rect.top;

                        // Canvas coordinate under the mouse before zoom
                        const canvasX = (mouseX - panX) / scale;
                        const canvasY = (mouseY - panY) / scale;

                        // Zoom factor
                        const zoomFactor = e.deltaY < 0 ? 1.05 : 0.95;
                        let newScale = scale * zoomFactor;

                        // Bounds
                        newScale = Math.min(Math.max(newScale, 0.2), 2.0);

                        // Adjust pan to zoom towards mouse position
                        panX = mouseX - canvasX * newScale;
                        panY = mouseY - canvasY * newScale;
                        scale = newScale;

                        applyTransform();
                    }, { passive: false });

                    // Panning Event Listeners (Mouse)
                    container.addEventListener('mousedown', (e) => {
                        // Only drag with left click
                        if (e.button !== 0) return;
                        
                        // Ignore drag if clicking on nodes, HUD panels or buttons
                        if (e.target.closest('.materia-node') || e.target.closest('.hud-panel') || e.target.closest('button')) {
                            return;
                        }
                        
                        isDragging = true;
                        hasMoved = false;
                        startX = e.clientX - panX;
                        startY = e.clientY - panY;
                        
                        container.classList.remove('cursor-grab');
                        container.classList.add('cursor-grabbing');
                    });

                    window.addEventListener('mousemove', (e) => {
                        if (!isDragging) return;
                        
                        const newX = e.clientX - startX;
                        const newY = e.clientY - startY;
                        
                        // Check if mouse actually moved
                        if (Math.abs(newX - panX) > 4 || Math.abs(newY - panY) > 4) {
                            hasMoved = true;
                        }
                        
                        panX = newX;
                        panY = newY;
                        applyTransform();
                    });

                    window.addEventListener('mouseup', () => {
                        if (!isDragging) return;
                        isDragging = false;
                        container.classList.remove('cursor-grabbing');
                        container.classList.add('cursor-grab');
                    });

                    // Touch support for mobile panning
                    let touchStartX = 0;
                    let touchStartY = 0;
                    container.addEventListener('touchstart', (e) => {
                        if (e.touches.length === 1) {
                            if (e.touches[0].target.closest('.materia-node') || e.touches[0].target.closest('.hud-panel') || e.touches[0].target.closest('button')) {
                                return;
                            }
                            isDragging = true;
                            touchStartX = e.touches[0].clientX - panX;
                            touchStartY = e.touches[0].clientY - panY;
                        }
                    }, { passive: true });

                    container.addEventListener('touchmove', (e) => {
                        if (!isDragging || e.touches.length !== 1) return;
                        panX = e.touches[0].clientX - touchStartX;
                        panY = e.touches[0].clientY - touchStartY;
                        applyTransform();
                    }, { passive: true });

                    container.addEventListener('touchend', () => {
                        isDragging = false;
                    }, { passive: true });

                    // Prevent click actions if drag occurred
                    const nodes = document.querySelectorAll('.materia-node');
                    nodes.forEach(node => {
                        node.addEventListener('click', (e) => {
                            if (hasMoved) {
                                e.stopImmediatePropagation();
                                e.preventDefault();
                            }
                        }, true);
                    });

                    // HUD Buttons
                    document.getElementById('zoom-in-btn').addEventListener('click', () => {
                        zoomAtCenter(1.15);
                    });

                    document.getElementById('zoom-out-btn').addEventListener('click', () => {
                        zoomAtCenter(0.85);
                    });

                    document.getElementById('zoom-reset-btn').addEventListener('click', () => {
                        const containerWidth = container.clientWidth;
                        const containerHeight = container.clientHeight;
                        const canvasHeight = canvas.clientHeight || 1100;
                        
                        scale = Math.min(0.8, Math.max(0.4, containerWidth / 1800));
                        panY = (containerHeight - (canvasHeight * scale)) / 2;
                        if (panY < 20) panY = 20;
                        panX = 60;
                        applyTransform();
                    });

                    function zoomAtCenter(factor) {
                        const containerWidth = container.clientWidth;
                        const containerHeight = container.clientHeight;
                        const centerX = containerWidth / 2;
                        const centerY = containerHeight / 2;

                        const canvasX = (centerX - panX) / scale;
                        const canvasY = (centerY - panY) / scale;

                        let newScale = scale * factor;
                        newScale = Math.min(Math.max(newScale, 0.2), 2.0);

                        panX = centerX - canvasX * newScale;
                        panY = centerY - canvasY * newScale;
                        scale = newScale;

                        applyTransform();
                    }
                }

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

                        // Coordinates relative to canvas, adjusted by the scale factor
                        const startX = (fromRect.right - canvasRect.left) / scale;
                        const startY = (fromRect.top + fromRect.height / 2 - canvasRect.top) / scale;

                        const endX = (toRect.left - canvasRect.left) / scale;
                        const endY = (toRect.top + toRect.height / 2 - canvasRect.top) / scale;

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

                // Retrieve all descendants
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
    @endif

    @push('modals')
    <!-- Alpine Onboarding Tour Component -->
    <div x-data="{
        tourActive: false,
        currentStep: 0,
        arrowDirection: 'up',
        steps: [
            {
                targetId: 'tour-plan-title',
                title: 'Carrera y Plan de Estudios',
                content: 'Aquí puedes ver el plan de estudios vigente para tu carrera.',
                image: 'saludo.png'
            },
            {
                targetId: 'tour-plan-materia',
                title: 'Tarjeta de Asignatura',
                content: 'Cada tarjeta representa una materia. Al hacer clic sobre ella, verás de forma interactiva cuáles son sus prerrequisitos (en rojo) y sus materias dependientes (en morado).',
                image: 'sentado.png'
            },
            {
                targetId: 'tour-plan-legend',
                title: 'Estados y Leyenda',
                content: 'Usa la leyenda para identificar el estado académico de cada materia (aprobada, cursando o pendiente).',
                image: 'corriendo.png'
            },
            {
                targetId: 'tour-plan-zoom',
                title: 'Navegación del Lienzo',
                content: 'Puedes arrastrar el fondo para moverte estilo Figma, usar la rueda del mouse para hacer zoom, o usar estos controles para centrar y ajustar la escala.',
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
            if (!localStorage.getItem('onboardingCompleted_planEstudios_' + userId)) {
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
            localStorage.setItem('onboardingCompleted_planEstudios_' + userId, 'true');
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
