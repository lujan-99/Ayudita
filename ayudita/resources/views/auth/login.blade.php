<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Bienvenido de nuevo</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Ingresa tus credenciales para continuar con tus estudios</p>
        </div>

        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="email" class="mb-2 block font-body-sm text-body-sm text-on-surface-variant">Correo electrónico</label>
                    <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input id="email" class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0" type="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required autofocus autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="mb-2 block font-body-sm text-body-sm text-on-surface-variant">Contraseña</label>
                    <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input id="password" class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-10 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0" type="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
                        <button class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant transition-colors hover:text-primary" onclick="togglePassword()" type="button" aria-label="Mostrar u ocultar contraseña">
                            <span class="material-symbols-outlined text-sm" id="visibility-icon">visibility</span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 font-body-sm text-body-sm">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-outline-variant bg-surface text-primary focus:ring-primary focus:ring-offset-background" name="remember">
                    <span class="ml-2 block text-on-surface-variant">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="font-medium text-primary transition-colors hover:text-primary-container" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <div>
                <x-primary-button class="w-full justify-center py-3 px-4 text-body-lg bg-[#a855f7] hover:bg-[#9333ea]">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-outline-variant"></div>
                </div>
                <div class="relative flex justify-center font-body-sm text-body-sm">
                    <span class="bg-transparent px-2 text-on-surface-variant">O continúa con</span>
                </div>
            </div>

            <div class="mt-6">
                <button class="inline-flex w-full items-center justify-center rounded-lg border border-outline-variant bg-surface px-4 py-3 font-body-sm text-body-sm text-on-surface transition-colors hover:bg-surface-variant" type="button">
                    <svg aria-hidden="true" class="mr-2 h-5 w-5" viewBox="0 0 24 24">
                        <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86 8.87028 4.75 12.0003 4.75Z" fill="#EA4335"></path>
                        <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4"></path>
                        <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05"></path>
                        <path d="M12.0004 24C15.2404 24 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.26537 14.29L1.27539 17.385C3.25539 21.31 7.3104 24 12.0004 24Z" fill="#34A853"></path>
                    </svg>
                    Google
                </button>
            </div>
        </div>

        <div class="mt-8 text-center font-body-sm text-body-sm">
            <span class="text-on-surface-variant">¿No tienes una cuenta?</span>
            @if (Route::has('register'))
                <a class="ml-1 font-medium text-primary transition-colors hover:text-primary-container" href="{{ route('register') }}">Regístrate gratis</a>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const visibilityIcon = document.getElementById('visibility-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    visibilityIcon.textContent = 'visibility_off';
                } else {
                    passwordInput.type = 'password';
                    visibilityIcon.textContent = 'visibility';
                }
            }
        </script>
    @endpush
</x-guest-layout>
