<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <title>@if(isset($title) && $title) {{ $title }} - Ayudita USFX @else Ayudita USFX - Vence tus materias con patrones académicos @endif</title>
        <meta name="description" content="{{ $description ?? 'Ayudita USFX: La plataforma académica freemium líder para estudiantes de San Francisco Xavier. Encuentra exámenes pasados resueltos, pizarras de auxiliaturas, apuntes y consejos clave organizados por carrera, materia y docente para vencer tu semestre.' }}">
        <meta name="keywords" content="{{ $keywords ?? 'Ayudita, USFX, San Francisco Xavier, Sucre, exámenes pasados, exámenes resueltos, auxiliaturas, apuntes universidad, plan de estudios, docentes USFX, ingeniería de sistemas' }}">
        <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@if(isset($title) && $title) {{ $title }} - Ayudita USFX @else Ayudita USFX - Vence tus materias con patrones académicos @endif">
        <meta property="og:description" content="{{ $description ?? 'No reinventes la rueda este semestre. Consigue exámenes pasados resueltos, pizarras y consejos específicos de docentes en Ayudita USFX.' }}">
        <meta property="og:image" content="{{ $ogImage ?? url('images/logos/og-image.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@if(isset($title) && $title) {{ $title }} - Ayudita USFX @else Ayudita USFX - Vence tus materias con patrones académicos @endif">
        <meta property="twitter:description" content="{{ $description ?? 'No reinventes la rueda este semestre. Consigue exámenes pasados resueltos, pizarras y consejos específicos de docentes en Ayudita USFX.' }}">
        <meta property="twitter:image" content="{{ $ogImage ?? url('images/logos/og-image.png') }}">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo-favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-mesh min-h-screen font-body-lg text-on-surface">
        @if ($compact)
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="glass-card relative w-full max-w-md overflow-hidden rounded-xl p-8">
                    <div class="absolute left-1/2 top-0 h-px w-3/4 -translate-x-1/2 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>

                    <div class="mb-8 flex flex-col items-center">
                        <a href="/" class="inline-flex flex-col items-center">
                            <img
                                src="{{ asset('images/logos/logo-icono.svg') }}"
                                class="mb-4 h-16 w-16 rounded-xl shadow-lg"
                                alt="{{ config('app.name', 'Ayudita') }}"
                            >
                            <h1 class="font-headline-lg text-headline-lg tracking-tight text-primary">{{ config('app.name', 'Ayudita') }}</h1>
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        @else
            {{ $slot }}
        @endif

        @stack('scripts')
    </body>
</html>
