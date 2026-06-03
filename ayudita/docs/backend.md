# Contexto del backend

## Esquema académico
- Se crearon las tablas `roles`, `carreras`, `docentes`, `materias`, `requisitos_materias`, `grupo_materia_docente` y `perfiles_estudiantes`.
- `users` recibió `role_id` para el modelo freemium.
- `User` tiene relaciones `role()` y `perfilEstudiante()`.

## Relación de tablas
- `carreras` agrupa muchas `materias`.
- `requisitos_materias` resuelve el árbol de prerrequisitos con una relación materia a materia.
- `grupo_materia_docente` cruza materia, docente y grupo para anclar recursos académicos al contenido real.
- `perfiles_estudiantes` conecta el usuario con carrera, semestre y estado del formulario/tour.

## Freemium
- `roles` contiene `free`, `premium` y `admin`.
- `DatabaseSeeder` crea esos roles y asigna `free` como base.
- El usuario inicial y los usuarios semilla heredan el rol correspondiente.

## Validación backend
- Las migraciones corren sobre MySQL.
- `php artisan migrate:fresh --seed` funciona con datos de prueba.
- `php artisan test` pasa completo después del seed.
