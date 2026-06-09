<x-guest-layout :compact="false" title="Ayudita Pro - Premium Paywall">
    <div class="flex min-h-screen items-center justify-center p-4 relative">
        <div class="absolute inset-0 z-0 bg-background/60 backdrop-blur-sm pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-[800px] p-1">
            <div class="glass-panel-strong rounded-xl glow-border overflow-hidden flex flex-col md:flex-row relative">
                
                <div class="flex-1 p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-4 mb-8">
                        <img alt="Ayudita Logo" class="w-10 h-10 rounded-md border border-outline-variant/50" src="{{ asset('images/logos/logo-icono.svg') }}">
                        <div>
                            <h2 class="font-display text-body-sm text-on-surface-variant {{ (isset($title) && $title !== '') ? 'normal-case' : 'uppercase' }} tracking-wider">
                                {{ (isset($title) && $title !== '') ? $title : 'Ayudita Pro' }}
                            </h2>
                        </div>
                    </div>

                    <h1 class="font-headline-lg-mobile md:font-headline-lg text-primary font-bold mb-4">
                        {{ $heading ?? 'Desbloquea Todo Tu Potencial' }}
                    </h1>
                    <p class="font-body-lg text-on-surface-variant mb-8">
                        @if(isset($slot) && !$slot->isEmpty())
                            {{ $slot }}
                        @else
                            Obtén acceso sin restricciones a recursos académicos premium diseñados para estudiantes de alto rendimiento. Domina tus materias con herramientas exclusivas.
                        @endif
                    </p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-body-lg text-on-surface">Acceso ilimitado a exámenes del semestre actual</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-body-lg text-on-surface">Descargas completas de proyectos y código fuente</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-body-lg text-on-surface">Consejos exclusivos de los mejores estudiantes</span>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-[360px] bg-surface-container-low border-t md:border-t-0 md:border-l border-outline-variant p-6 flex flex-col justify-between relative shrink-0">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
                    
                    <div class="space-y-4">
                        <span class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider text-center mb-2 select-none">Elige tu Suscripción</span>
                        
                        <!-- Mensual -->
                        <div onclick="selectPlan('mensual', 10, 'mes')" class="p-3 bg-surface border border-primary bg-primary/5 rounded-xl cursor-pointer hover:border-primary/50 transition-all plan-option" id="plan-mensual">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-display text-xs font-bold text-on-surface">Plan Mensual</span>
                                <span class="text-[10px] font-label-mono bg-surface-variant px-1.5 py-0.5 rounded text-on-surface-variant font-bold">Bs 10 / mes</span>
                            </div>
                            <p class="text-[10px] text-on-surface-variant">Prueba todas las funciones premium por 1 mes.</p>
                        </div>

                        <!-- Semestral -->
                        <div onclick="selectPlan('semestral', 40, '6 meses')" class="p-3 bg-surface border border-outline-variant rounded-xl cursor-pointer hover:border-primary/50 transition-all plan-option" id="plan-semestral">
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-display text-xs font-bold text-on-surface">Plan Semestral</span>
                                    <span class="text-[8px] font-label-mono bg-primary/20 text-primary px-1.5 py-0.5 rounded font-bold uppercase tracking-wider whitespace-nowrap">Recomendado</span>
                                </div>
                                <span class="text-[10px] font-label-mono bg-surface-variant px-1.5 py-0.5 rounded text-on-surface-variant font-bold">Bs 40 / 6m</span>
                            </div>
                            <p class="text-[10px] text-on-surface-variant">Asegura tu periodo completo. Ahorra un 33%.</p>
                        </div>

                        <!-- Anual -->
                        <div onclick="selectPlan('anual', 70, 'año')" class="p-3 bg-surface border border-outline-variant rounded-xl cursor-pointer hover:border-primary/50 transition-all plan-option" id="plan-anual">
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-display text-xs font-bold text-on-surface">Plan Anual</span>
                                    <span class="text-[8px] font-label-mono bg-secondary/20 text-secondary px-1.5 py-0.5 rounded font-bold uppercase tracking-wider whitespace-nowrap">Ahorra 41%</span>
                                </div>
                                <span class="text-[10px] font-label-mono bg-surface-variant px-1.5 py-0.5 rounded text-on-surface-variant font-bold">Bs 70 / año</span>
                            </div>
                            <p class="text-[10px] text-on-surface-variant">Acceso ilimitado por un año académico.</p>
                        </div>

                        <!-- Price display -->
                        <div class="text-center py-3 border-t border-outline-variant/30 select-none">
                            <div class="flex items-baseline justify-center gap-1">
                                <span class="font-display text-lg text-on-surface mr-1">Bs</span>
                                <span class="font-display text-4xl font-bold text-primary leading-none" id="display-price">10</span>
                                <span class="font-label-mono text-label-mono text-on-surface-variant" id="display-period">/mes</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 mt-4">
                        <button onclick="checkoutMock()" class="w-full py-3 bg-inverse-primary hover:bg-primary-container text-white font-display text-body-sm font-bold rounded-lg transition-all shadow-[0_0_15px_rgba(183,109,255,0.3)] flex items-center justify-center gap-2 group">
                            Comprar Plan <span id="btn-plan-name" class="capitalize">Mensual</span>
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <a class="font-label-mono text-xs text-on-surface-variant hover:text-primary transition-colors underline underline-offset-4" href="{{ url('/dashboard') }}">
                            Volver al Panel
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let selectedPlanId = 'mensual';

        function selectPlan(planId, price, period) {
            selectedPlanId = planId;
            
            // Update prices
            document.getElementById('display-price').innerText = price;
            document.getElementById('display-period').innerText = '/' + period;
            document.getElementById('btn-plan-name').innerText = planId;

            // Update border styles
            const options = document.getElementsByClassName('plan-option');
            for (let i = 0; i < options.length; i++) {
                const opt = options[i];
                if (opt.id === 'plan-' + planId) {
                    opt.className = "p-3 bg-surface border border-primary bg-primary/5 rounded-xl cursor-pointer hover:border-primary/50 transition-all plan-option";
                } else {
                    opt.className = "p-3 bg-surface border border-outline-variant rounded-xl cursor-pointer hover:border-primary/50 transition-all plan-option";
                }
            }
        }

        function checkoutMock() {
            alert('¡Gracias por elegir el Plan ' + selectedPlanId.toUpperCase() + '! La pasarela de pago (QR / Tigo Money) se habilitará próximamente.');
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            selectPlan('mensual', 10, 'mes');
        });
    </script>
</x-guest-layout>
