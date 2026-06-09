# Informe de Técnicas y Optimizaciones SEO - Ayudita USFX

Este documento detalla todas las técnicas de optimización en motores de búsqueda (SEO) y metadatos sociales aplicados sobre la plataforma **Ayudita USFX** (`https://ayudita.up.railway.app`) para mejorar su visibilidad, rastreabilidad y presentación visual en Google Search y redes sociales.

---

## 1. Solución al Logotipo en los Resultados de Búsqueda (Favicon)

### El Problema
En la captura de pantalla de los resultados de búsqueda de Google, se observaba el icono genérico de un globo terráqueo en lugar del logotipo oficial de Ayudita. Esto se debía a una restricción técnica estricta del rastreador de favicons de Google (`Googlebot-Image` / `Googlebot-Favicons`):
* **Directiva de Google**: El archivo del favicon debe ser **completamente cuadrado** (relación de aspecto 1:1, ej. 48x48px, 192x192px, etc.). Si no es cuadrado, Google ignora el icono de forma silenciosa y muestra el globo por defecto.
* **Diagnóstico**: El archivo de icono original `logo-icono.svg` tenía unas dimensiones y un viewBox de `260 x 279` píxeles (no cuadrado, rectangular vertical).

### La Solución Aplicada
1. **SVG Cuadrado en la Misma Ruta**: Para evitar problemas de caché del navegador y evitar enlaces rotos, mantuvimos el nombre de archivo estable y original en la ruta [logo-icono.svg](file:///c:/Users/david/Documents/Comercio/Pagina/public/images/logos/logo-icono.svg), pero reescribimos su contenido vectorial para que sea 100% cuadrado.
2. **Uso de Contenedor y Transformación de Grupo**:
   - Ajustamos las dimensiones del elemento `<svg>` a `279 x 279` píxeles con un `viewBox="0 0 279 279"` (relación 1:1 perfecta).
   - Agrupamos todas las rutas vectoriales originales del logotipo dentro de una etiqueta de grupo `<g transform="translate(9.5, 0)">`. Esto desplaza horizontalmente todo el logotipo por `9.5` píxeles hacia el centro de forma matemáticamente exacta, agregando el margen necesario en los laterales.
3. **Enlaces Estables**: Mantuvimos las vinculaciones de favicon hacia `logo-icono.svg` en las plantillas Blade de layout ([guest.blade.php](file:///c:/Users/david/Documents/Comercio/Pagina/resources/views/layouts/guest.blade.php) y [dashboard.blade.php](file:///c:/Users/david/Documents/Comercio/Pagina/resources/views/layouts/dashboard.blade.php)), asegurando compatibilidad inmediata tanto en Google Search como en las pestañas del navegador del usuario.

*Nota: Una vez desplegado, Google Search actualizará el logotipo en su próximo rastreo del index (suele tomar de 3 a 10 días dependiendo de la frecuencia de indexación de Google).*

---

## 2. Metadatos SEO y Redes Sociales Dinámicos

Optimizamos el archivo de cabecera común para inyectar metadatos relevantes de forma dinámica por página:
* **Estructura Dinámica**: Extendimos el constructor del componente `GuestLayout` ([GuestLayout.php](file:///c:/Users/david/Documents/Comercio/Pagina/app/View/Components/GuestLayout.php)) para aceptar las siguientes propiedades:
  - `title`: Título personalizado de la página (ej: `"Iniciar Sesión - Ayudita USFX"`).
  - `description`: Meta-descripción única para evitar contenido duplicado.
  - `keywords`: Lista de términos clave de la asignatura o vista.
  - `robots`: Permite forzar directivas como `noindex, nofollow` en páginas con información transaccional sensible.
  - `ogImage`: Imagen específica para compartir en redes.

* **Metadatos Sociales (Open Graph & Twitter Cards)**:
  - Cambiamos las referencias de preview para usar la función `url(...)` de Laravel, lo que genera direcciones web **absolutas** (ej. `https://ayudita.up.railway.app/images/logos/og-image.png`). Las plataformas como WhatsApp y Twitter/X no cargan vistas previas si las URLs de las imágenes son relativas.
  - **Imagen PNG de Alta Resolución**: Generamos e integramos una tarjeta de previsualización social en formato PNG ([og-image.png](file:///c:/Users/david/Documents/Comercio/Pagina/public/images/logos/og-image.png)). Los rastreadores de previsualización de enlaces de redes **no renderizan SVG**; requieren obligatoriamente formatos rasterizados (PNG o JPEG).

---

## 3. Datos Estructurados JSON-LD (Rich Snippets)

Añadimos un bloque de marcado enriquecido mediante datos estructurados al final de [welcome.blade.php](file:///c:/Users/david/Documents/Comercio/Pagina/resources/views/welcome.blade.php):
* **Esquemas Declarados**:
  - `Organization`: Información de la marca, logotipo oficial y perfiles de redes sociales de Ayudita (TikTok, Instagram, Facebook).
  - `WebSite`: El nombre del sitio y su dominio principal.
  - `WebApplication`: Catalogada en la sección de aplicaciones educativas, detallando los requerimientos de navegador y las tarifas de los planes académicos.
  - `FAQPage`: Estructura las Preguntas Frecuentes. Esto habilita a Google para mostrar la sección de preguntas desplegables directamente en la lista de resultados de búsqueda.

* **Evitar Errores de Blade**:
  - En lugar de escribir el JSON plano en el archivo Blade, lo construimos como un array de PHP y lo renderizamos utilizando `{!! json_encode(...) !!}`. Esto evita que el motor de plantillas de Blade interprete el símbolo `@` de las llaves de JSON-LD (como `@context` o `@type`) como directivas de servidor inválidas, lo cual rompía la compilación y arrojaba errores 500 de sintaxis.

---

## 4. Sincronización del Archivo robots.txt y Sitemap

* **Corrección de Conflicto de Rastreo**:
  - Anteriormente, [robots.txt](file:///c:/Users/david/Documents/Comercio/Pagina/public/robots.txt) bloqueaba el acceso a `/login` y `/register` usando la regla `Disallow`.
  - Sin embargo, estas mismas páginas estaban listadas en el mapa de navegación [sitemap.xml](file:///c:/Users/david/Documents/Comercio/Pagina/public/sitemap.xml) con prioridad. Esta contradicción produce advertencias de rastreo ("Sitemap contiene URLs bloqueadas") en Google Search Console.
  - **Ajuste**: Removimos los bloqueos sobre `/login` y `/register`. Ahora los usuarios pueden buscar "Ayudita USFX ingresar" o "Ayudita USFX registrarse" en Google y encontrar los enlaces directos a tus formularios sin penalizaciones.
* **Seguridad en Panel Privado**:
  - Mantuvimos los bloqueos en `robots.txt` para `/admin`, `/dashboard` y `/profile` para proteger la privacidad académica y evitar que los motores indexen vistas vacías o que requieran autenticación.

---

## 5. Coherencia en el Embudo de Precios

* Modificamos la tarjeta de precios de la landing page para reflejar con precisión los precios de la pasarela Pro de Ayudita: **Bs. 10 / mes** (anteriormente Bs. 15), mencionando los descuentos por periodos más largos:
  - Plan Mensual: Bs. 10
  - Plan Semestral: Bs. 40
  - Plan Anual: Bs. 70
* Esto evita la desconfianza del usuario al ver discrepancias en el precio al presionar "Pasar a Pro".
