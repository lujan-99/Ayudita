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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="app-shell">
            @include('layouts.navigation')

            <main class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 pb-16 pt-24 sm:px-6 lg:px-8">
                @isset($header)
                    <header class="mb-8">
                        <div class="surface-card-strong px-6 py-5 sm:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <section class="relative flex-1">
                    {{ $slot }}
                </section>

                <footer class="mt-10 border-t border-outline-variant pt-6 text-sm text-muted">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <p>{{ config('app.name', 'STUDENT_PATTERNS') }} · USFX Freemium backend</p>
                        <p>MySQL · Laravel 12 · Blade</p>
                    </div>
                </footer>
            </main>
        </div>
        <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6a2c0a760451a21c2ebc2fe6/1jqu0ho8d';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
