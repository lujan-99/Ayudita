<x-guest-layout :compact="false" title="Política de Privacidad">
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
            <h1 class="font-headline-lg text-headline-lg font-bold text-primary mb-6">Política de Privacidad</h1>
            <p class="text-xs text-on-surface-variant mb-8 font-label-mono">Última actualización: 10 de junio de 2026</p>

            <div class="space-y-8 text-body-md text-on-surface-variant leading-relaxed">
                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">1. Información que Recopilamos</h2>
                    <p>Para ofrecerte el servicio, recopilamos únicamente los datos básicos necesarios:</p>
                    <ul class="list-disc list-inside mt-3 space-y-2 pl-2">
                        <li><strong>Datos de Registro:</strong> Nombre, correo electrónico y contraseña (encriptada).</li>
                        <li><strong>Datos de Perfil Estudiantil:</strong> Carrera universitaria, materias inscritas e historial de reputación académica (puntos).</li>
                        <li><strong>Datos de Pago:</strong> Cuando adquieres el plan Premium, el pago es procesado de forma externa y segura por PayPal. Nosotros no almacenamos los datos de tus tarjetas o cuentas bancarias.</li>
                    </ul>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">2. Uso de la Información</h2>
                    <p>Utilizamos tu información exclusivamente para prestarte el servicio académico, gestionar tu progreso académico, controlar tu suscripción Premium y proteger la integridad del material subido de acuerdo a las reglas de la comunidad.</p>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">3. Cookies y Almacenamiento Local</h2>
                    <p>Utilizamos almacenamiento local del navegador (como `localStorage`) para recordar tus preferencias de diseño, incluyendo la selección del tema (Modo Oscuro o Modo Claro) y el colapso del menú lateral.</p>
                </section>

                <section class="bg-surface-container border bento-border p-6 rounded-bento">
                    <h2 class="font-headline-md text-on-surface mb-3">4. Derechos del Usuario</h2>
                    <p>Tienes derecho a acceder, rectificar o eliminar tus datos personales en cualquier momento a través del menú de edición de Perfil dentro de tu panel de estudiante, o borrando tu cuenta por completo.</p>
                </section>
            </div>
        </main>

        <footer class="bg-surface border-t bento-border py-12 text-center text-xs text-on-surface-variant">
            <p>© 2026 Ayudita Inc. Todos los derechos reservados.</p>
        </footer>
    </div>
</x-guest-layout>
