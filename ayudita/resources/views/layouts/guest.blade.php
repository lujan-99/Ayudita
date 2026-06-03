<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-mesh min-h-screen font-sans text-on-surface">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="glass-card relative w-full max-w-md overflow-hidden rounded-xl p-8">
                <div class="absolute left-1/2 top-0 h-px w-3/4 -translate-x-1/2 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
                <div class="mb-8 flex flex-col items-center text-center">
                    <a href="/" class="mb-4 inline-flex flex-col items-center gap-3">
                        <img src="{{ asset('images/logos/logo-icono.svg') }}" class="h-16 w-16 rounded-xl shadow-lg" alt="{{ config('app.name', 'STUDENT_PATTERNS') }} logo">
                        <span class="font-headline-lg text-headline-lg text-primary tracking-tight">{{ config('app.name', 'STUDENT_PATTERNS') }}</span>
                    </a>
                    <p class="max-w-sm font-body-sm text-body-sm text-on-surface-variant">Acceso al entorno académico con una identidad visual consistente para registro, login y perfil.</p>
                </div>

                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
