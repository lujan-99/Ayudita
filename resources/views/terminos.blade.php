<x-guest-layout :compact="false" title="Términos y Condiciones">
    <div x-data="{
        darkTheme: localStorage.getItem('theme') !== 'light',
        toggleTheme() {
            this.darkTheme = !this.darkTheme;
            localStorage.setItem('theme', this.darkTheme ? 'dark' : 'light');
            this.applyTheme();
        },
        applyTheme() {
            if (this.darkTheme) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            }
        }
    }" x-init="applyTheme()" class="bg-surface text-on-surface font-body-md selection:bg-primary-container selection:text-on-primary-container min-h-screen">
        
        <header class="sticky top-0 w-full z-50 glass-morphism border-b bento-border">
            <div class="flex justify-between items-center max-w-container-max mx-auto px-gutter py-4">
                <a href="/" class="flex items-center gap-3 hover:opacity-95 transition-opacity">
                    <img src="{{ asset('images/logos/logo-icono.svg') }}" alt="Ayudita Icono" class="h-12 w-auto">
                    <span class="font-headline-md text-headline-md font-bold text-on-surface tracking-tight">Ayudita</span>
                </a>
                
                <div class="flex items-center gap-6">
                    <button @click="toggleTheme()" class="text-on-surface-variant hover:text-primary transition-colors flex items-center justify-center p-2 rounded-full hover:bg-surface-variant/20" title="Alternar tema">
                        <span x-show="darkTheme" class="material-symbols-outlined" style="display: none;">light_mode</span>
                        <span x-show="!darkTheme" class="material-symbols-outlined" style="display: none;">dark_mode</span>
                    </button>
                    <a href="/" class="px-6 py-2 rounded-lg bg-primary-container text-on-primary-container font-label-mono text-label-mono hover:bg-primary transition-colors">
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-gutter py-16">
            <h1 class="font-headline-lg text-headline-lg font-bold text-primary mb-6">Términos y Condiciones de Uso</h1>
            <p class="text-xs text-on-surface-variant mb-8 font-label-mono">Última actualización: 10 de junio de 2026</p>

            <div class="space-y-8 text-body-md text-on-surface-variant leading-relaxed">
                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">1. Aceptación de los Términos</h2>
                    <p>Al acceder y utilizar la plataforma <strong>Ayudita</strong>, aceptas cumplir y estar sujeto a los presentes Términos y Condiciones. Si no estás de acuerdo con alguna parte de estos términos, no debes utilizar la plataforma.</p>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">2. Uso de la Plataforma</h2>
                    <p>Ayudita es un espacio de colaboración académica freemium para estudiantes universitarios. Te comprometes a usar la plataforma únicamente para fines educativos lícitos. Queda estrictamente prohibido:</p>
                    <ul class="list-disc list-inside mt-3 space-y-2 pl-2">
                        <li>Subir contenido que infrinja derechos de autor o propiedad intelectual ajena.</li>
                        <li>Publicar respuestas de exámenes activos o realizar fraude académico directo en tiempo real.</li>
                        <li>Acosar, insultar o atentar contra la integridad de docentes, estudiantes o moderadores de la comunidad.</li>
                    </ul>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">3. Cuentas y Suscripciones</h2>
                    <p>Ofrecemos planes base gratuitos y suscripciones Premium (Pro) pagadas mediante PayPal. El usuario es responsable de mantener la seguridad de sus credenciales. Las suscripciones Pro se rigen por las tarifas y periodos vigentes seleccionados en la pasarela de pagos.</p>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">4. Exclusión de Responsabilidad</h2>
                    <p>El material compartido en Ayudita es provisto por la comunidad de estudiantes y revisado por moderadores independientes. Ayudita no garantiza la precisión del material ni se responsabiliza de los resultados académicos individuales de los usuarios.</p>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">5. Modificaciones</h2>
                    <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. El uso continuado de la plataforma tras la publicación de cambios implica la aceptación de los nuevos términos.</p>
                </section>
            </div>
        </main>

        <footer class="bg-surface border-t bento-border py-12 text-center text-xs text-on-surface-variant">
            <p>© 2026 Ayudita Inc. Todos los derechos reservados.</p>
        </footer>
    </div>
</x-guest-layout>
