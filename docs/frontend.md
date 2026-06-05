# Contexto del frontend

## Layout y branding
- Se centralizó el layout visual en `resources/views/layouts/app.blade.php`.
- `resources/views/layouts/guest.blade.php` reutiliza la misma identidad visual.
- `resources/views/layouts/navigation.blade.php` quedó con navbar oscuro fijo y branding único.
- `resources/views/components/application-logo.blade.php` apunta a `public/images/logos/logo-horizontal.svg`.
- Convención de logos: `logo-icono.svg` para login y usos compactos, `logo-horizontal.svg` para navegación y encabezados, `logo-vertical.svg` para portada o bloques introductorios.

## Tema visual
- Tokens principales: `surface` `#121414`, `surface-container` `#1a1c1c`, `surface-container-strong` `#1e2020`, `outline-variant` `#27272a`, `primary` `#ddb7ff`.
- La fuente base quedó en `Space Grotesk`.
- Se agregaron utilidades de tarjeta, fondo y badge en `resources/css/app.css`.

## Vistas ajustadas
- `resources/views/welcome.blade.php` ahora muestra una portada alineada al nuevo lenguaje visual.
- `resources/views/dashboard.blade.php` usa las nuevas tarjetas y tipografía.
- `resources/views/profile/edit.blade.php` usa el mismo estilo que el resto del sistema.
- Los componentes de formularios y botones fueron retocados para no mezclar colores viejos de Breeze con el tema nuevo.

## Validación frontend
- `npm run build` termina sin errores.
