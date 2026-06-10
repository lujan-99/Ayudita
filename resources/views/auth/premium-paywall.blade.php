<x-guest-layout :compact="false" title="Ayudita Pro - Premium Paywall">
    <div class="flex min-h-screen items-center justify-center p-4 relative">
        <div class="absolute inset-0 z-0 bg-background/60 backdrop-blur-sm pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-[800px] p-1">
            <div class="glass-panel-strong rounded-xl glow-border overflow-hidden flex flex-col md:flex-row relative">
                
                <div class="flex-1 p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-4 mb-8">
                        <img alt="Ayudita Logo" class="w-20 h-20 rounded-md border border-outline-variant/50" src="{{ asset('images/logos/logo-icono.svg') }}">
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
                        <!-- Spinner de carga -->
                        <div id="loading-spinner" class="hidden flex flex-col items-center justify-center py-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary mb-2"></div>
                            <span class="text-xs text-on-surface-variant font-display text-center">Procesando y verificando tu pago...</span>
                        </div>
                        
                        <!-- Contenedor del Botón de PayPal -->
                        <div id="paypal-button-container" class="w-full relative z-20"></div>
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

@push('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
    <script>
        let selectedPlanId = 'mensual';

        function selectPlan(planId, price, period) {
            selectedPlanId = planId;
            
            // Update prices
            document.getElementById('display-price').innerText = price;
            document.getElementById('display-period').innerText = '/' + period;

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

        // Initialize PayPal Smart Buttons
        paypal.Buttons({
            createOrder: function(data, actions) {
                let usdAmount = '1.00'; // fallback / mensual
                if (selectedPlanId === 'semestral') {
                    usdAmount = '4.00';
                } else if (selectedPlanId === 'anual') {
                    usdAmount = '7.00';
                }
                
                return actions.order.create({
                    purchase_units: [{
                        description: 'Suscripcion Ayudita Pro - Plan ' + selectedPlanId.toUpperCase(),
                        amount: {
                            currency_code: 'USD',
                            value: usdAmount
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Show loading spinner
                document.getElementById('paypal-button-container').classList.add('hidden');
                document.getElementById('loading-spinner').classList.remove('hidden');

                // Send payment info to backend
                return fetch("{{ route('paypal.completed') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID,
                        plan: selectedPlanId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(res => {
                    if (res.success) {
                        alert(res.message || '¡Pago verificado y cuenta actualizada a Pro con éxito!');
                        window.location.href = "{{ route('dashboard') }}";
                    } else {
                        throw new Error(res.message || 'No se pudo verificar el pago.');
                    }
                })
                .catch(err => {
                    console.error('Error verifying payment:', err);
                    alert('Error de verificacion: ' + (err.message || 'No se pudo verificar la transaccion. Por favor contacta a soporte.'));
                    
                    // Hide spinner, show button container again
                    document.getElementById('loading-spinner').classList.add('hidden');
                    document.getElementById('paypal-button-container').classList.remove('hidden');
                });
            },
            onError: function(err) {
                console.error('PayPal checkout error:', err);
                alert('Ocurrio un error al procesar el pago con la pasarela de PayPal.');
            }
        }).render('#paypal-button-container');

        // Initialize from query parameters or default to mensual
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const initialPlan = urlParams.get('plan') || 'mensual';
            
            const planPrices = {
                mensual: { price: 10, period: 'mes' },
                semestral: { price: 40, period: '6 meses' },
                anual: { price: 70, period: 'año' }
            };
            
            if (planPrices[initialPlan]) {
                selectPlan(initialPlan, planPrices[initialPlan].price, planPrices[initialPlan].period);
            } else {
                selectPlan('mensual', 10, 'mes');
            }
        });
    </script>
@endpush
</x-guest-layout>
