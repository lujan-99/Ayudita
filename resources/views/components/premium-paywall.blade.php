<!DOCTYPE html>
<html class="dark scroll-smooth" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Ayudita - Premium Paywall</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline-variant": "#4d4354",
                        "error-container": "#93000a",
                        "surface-tint": "#ddb7ff",
                        "on-secondary": "#313032",
                        "secondary": "#c8c6c8",
                        "surface-container": "#1e2020",
                        "tertiary": "#c8c6c9",
                        "surface": "#121414",
                        "inverse-primary": "#842bd2",
                        "error": "#ffb4ab",
                        "secondary-fixed-dim": "#c8c6c8",
                        "on-tertiary-fixed-variant": "#47464a",
                        "surface-variant": "#333535",
                        "primary-fixed-dim": "#ddb7ff",
                        "on-error": "#690005",
                        "on-primary-container": "#400071",
                        "on-surface": "#e2e2e2",
                        "on-error-container": "#ffdad6",
                        "primary": "#ddb7ff",
                        "surface-container-high": "#282a2b",
                        "background": "#121414",
                        "on-secondary-fixed": "#1c1b1d",
                        "surface-bright": "#38393a",
                        "inverse-surface": "#e2e2e2",
                        "surface-container-highest": "#333535",
                        "on-secondary-container": "#b7b4b7",
                        "primary-container": "#b76dff",
                        "on-primary-fixed-variant": "#6900b3",
                        "primary-fixed": "#f0dbff",
                        "surface-container-low": "#1a1c1c",
                        "tertiary-fixed-dim": "#c8c6c9",
                        "on-tertiary-fixed": "#1b1b1e",
                        "surface-dim": "#121414",
                        "tertiary-fixed": "#e4e1e5",
                        "secondary-container": "#474649",
                        "on-tertiary-container": "#29292c",
                        "on-primary": "#490080",
                        "on-secondary-fixed-variant": "#474649",
                        "inverse-on-surface": "#2f3131",
                        "on-primary-fixed": "#2c0051",
                        "secondary-fixed": "#e5e1e4",
                        "on-tertiary": "#303033",
                        "on-background": "#e2e2e2",
                        "surface-container-lowest": "#0c0f0f",
                        "on-surface-variant": "#cfc2d6",
                        "tertiary-container": "#919094",
                        "outline": "#988d9f"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "margin-desktop": "48px",
                        "bento-gap": "16px",
                        "gutter": "24px",
                        "container-max": "1200px",
                        "margin-mobile": "16px",
                        "unit": "4px"
                    },
                    fontFamily: {
                        "display": ["Geist", "sans-serif"],
                        "headline-lg": ["Geist", "sans-serif"],
                        "headline-md": ["Geist", "sans-serif"],
                        "headline-lg-mobile": ["Geist", "sans-serif"],
                        "label-mono": ["JetBrains Mono", "monospace"],
                        "body-sm": ["Geist", "sans-serif"],
                        "body-lg": ["Geist", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        body {
            background-color: #09090b;
            color: #e2e2e2;
        }
        .glass-panel {
            background: rgba(24, 24, 27, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid #27272a;
        }
        .glow-border {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.15);
        }
    </style>
</head>
<body class="min-h-screen font-body-sm antialiased overflow-hidden relative flex items-center justify-center">

    <div class="absolute inset-0 z-0 bg-background/60 backdrop-blur-sm pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[800px] mx-margin-mobile md:mx-margin-desktop p-1">
        <div class="glass-panel rounded-xl glow-border overflow-hidden flex flex-col md:flex-row relative">
            
            <div class="flex-1 p-8 md:p-12 flex flex-col justify-center">
                <div class="flex items-center gap-4 mb-8">
                    <img alt="Ayudita Logo" class="w-10 h-10 rounded-md border border-outline-variant/50" src="{{ asset('images/logos/logo-icono.svg') }}">
                    <div>
                        <h2 class="font-display text-body-sm text-on-surface-variant {{ isset($title) ? 'normal-case' : 'uppercase' }} tracking-wider">
                            {{ $title ?? 'Ayudita Pro' }}
                        </h2>
                    </div>
                </div>

                <h1 class="font-headline-lg-mobile md:font-headline-lg text-primary font-bold mb-4">
                    {{ $heading ?? 'Desbloquea Todo Tu Potencial' }}
                </h1>
                <p class="font-body-lg text-on-surface-variant mb-8">
                    {{ $slot->isEmpty() ? 'Obtén acceso sin restricciones a recursos académicos premium diseñados para estudiantes de alto rendimiento. Domina tus materias con herramientas exclusivas.' : $slot }}
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

            <div class="w-full md:w-[320px] bg-surface-container-low border-t md:border-t-0 md:border-l border-outline-variant p-8 flex flex-col justify-between relative">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
                <div>
                    <div class="flex items-center justify-center bg-surface border border-outline-variant rounded-lg p-1 mb-8">
                        <div class="w-1/2 text-center py-2 font-label-mono text-label-mono text-primary bg-surface-variant rounded shadow-sm cursor-pointer">MENSUAL</div>
                        <div class="w-1/2 text-center py-2 font-label-mono text-label-mono text-on-surface-variant cursor-pointer hover:text-on-surface transition-colors">SEMESTRAL</div>
                    </div>

                    <div class="text-center mb-8">
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="font-display text-xl text-on-surface mr-1">Bs</span>
                            <span class="font-display text-5xl font-bold text-primary leading-none">15</span>
                            <span class="font-label-mono text-label-mono text-on-surface-variant">/mes</span>
                        </div>
                        <p class="font-body-sm text-on-surface-variant mt-4 text-xs">Elige el plan semestral de trueque si aportas material validado.</p>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-[#842bd2] hover:bg-[#b76dff] text-white font-headline-md text-body-lg rounded-lg transition-all shadow-[0_0_15px_rgba(132,43,210,0.4)] flex items-center justify-center gap-2 group">
                            Pasar a Pro
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <a class="font-label-mono text-xs text-on-surface-variant hover:text-primary transition-colors underline underline-offset-4" href="{{ url('/dashboard') }}">
                        Volver al Panel
                    </a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>