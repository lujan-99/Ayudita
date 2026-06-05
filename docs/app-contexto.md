# Contexto general de la app

## Nombre y entorno
- La app quedó nombrada como `STUDENT_PATTERNS` en `.env`.
- La base de datos sigue en MySQL con `DB_CONNECTION=mysql`.

## Seed y datos de prueba
- Hay roles, carreras, docentes, materias, prerrequisitos, grupos y perfiles de estudiante semilla.
- El seed deja el proyecto listo para explorar sin arrancar desde cero.
- El usuario de prueba y los usuarios `admin` y `premium` también quedan creados.

## Flujo de trabajo recomendado
- `php artisan migrate:fresh --seed` para reconstruir la base y cargar datos.
- `php artisan test` para validar el backend.
- `npm run build` para validar frontend.
- `php artisan serve` para correr la app localmente.

## Estado actual
- La estructura base ya está estable.
- El siguiente paso natural es ampliar el catálogo semilla con más carreras y materias USFX reales.