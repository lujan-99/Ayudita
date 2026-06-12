<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Docente;
use App\Models\GrupoMateriaDocente;
use App\Models\Materia;
use App\Models\PerfilEstudiante;
use App\Models\RequisitoMateria;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles
        $freeRole = Role::query()->firstOrCreate(['nombre' => 'free']);
        $premiumRole = Role::query()->firstOrCreate(['nombre' => 'premium']);
        $adminRole = Role::query()->firstOrCreate(['nombre' => 'admin']);

        // 2. Careers
        $ingenieriaSistemas = Carrera::query()->firstOrCreate(['nombre' => 'Ingeniería de Sistemas']);
        $derecho = Carrera::query()->firstOrCreate(['nombre' => 'Derecho']);

        // 3. Subjects (Materias)
        $programacionI = Materia::query()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'codigo' => 'SIS-111',
        ], [
            'nombre' => 'Programación I',
            'semestre' => 1,
            'tm' => 'N',
        ]);

        $algoritmos = Materia::query()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'codigo' => 'SIS-211',
        ], [
            'nombre' => 'Algoritmos y Estructuras de Datos',
            'semestre' => 2,
            'tm' => 'N',
        ]);

        $baseDatos = Materia::query()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'codigo' => 'SIS-311',
        ], [
            'nombre' => 'Bases de Datos I',
            'semestre' => 3,
            'tm' => 'N',
        ]);

        $derechoRomano = Materia::query()->firstOrCreate([
            'carrera_id' => $derecho->id,
            'codigo' => 'DER-101',
        ], [
            'nombre' => 'Derecho Romano I',
            'semestre' => 1,
            'tm' => 'O',
        ]);

        // 4. Prerequisites
        RequisitoMateria::query()->firstOrCreate([
            'materia_id' => $algoritmos->id,
            'requisito_id' => $programacionI->id,
        ]);

        RequisitoMateria::query()->firstOrCreate([
            'materia_id' => $baseDatos->id,
            'requisito_id' => $algoritmos->id,
        ]);

        // 5. Users (Students and Admins)
        $admin = User::query()->firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        $studentPremium = User::query()->firstOrCreate([
            'email' => 'premium@example.com',
        ], [
            'name' => 'Premium User',
            'password' => bcrypt('password'),
            'role_id' => $premiumRole->id,
            'premium_until' => now()->addYear(),
        ]);

        $studentFree = User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'role_id' => $freeRole->id,
        ]);

        // Student Profiles
        $studentPremium->perfilEstudiante()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'semestre_actual' => 3,
            'carnet_identidad' => '87654321',
            'carnet_universitario' => '20-876543',
            'formulario_completo' => true,
            'tour_visto' => true,
        ]);

        $studentFree->perfilEstudiante()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'semestre_actual' => 2,
            'carnet_identidad' => '12345678',
            'carnet_universitario' => '20-12345',
            'formulario_completo' => true,
            'tour_visto' => true,
        ]);

        // Create some helper students to author comments
        $otherStudents = [];
        $helperEmails = [
            'alejandro@example.com' => 'Alejandro Condori',
            'mariana@example.com' => 'Mariana Flores',
            'carlos@example.com' => 'Carlos Mendoza',
            'patricia@example.com' => 'Patricia Aramayo'
        ];

        foreach ($helperEmails as $email => $name) {
            $helperUser = User::query()->firstOrCreate([
                'email' => $email,
            ], [
                'name' => $name,
                'password' => bcrypt('password'),
                'role_id' => $freeRole->id,
            ]);

            $helperUser->perfilEstudiante()->firstOrCreate([
                'carrera_id' => $ingenieriaSistemas->id,
                'semestre_actual' => 2,
                'carnet_identidad' => rand(10000000, 99999999),
                'carnet_universitario' => '20-' . rand(100000, 999999),
                'formulario_completo' => true,
                'tour_visto' => true,
            ]);

            $otherStudents[] = $helperUser;
        }

        // 6. Define 10 Docentes with comments
        $docentesData = [
            [
                'nombre_completo' => 'Ing. Juan Perez',
                'detalles_basicos' => 'Especialista en Programación y Estructuras de Datos. Docente de la materia SIS-111 y SIS-211.',
                'materia' => $programacionI,
                'grupo' => 'Grupo A',
                'comentarios' => [
                    ['user' => $studentPremium, 'calificacion' => 4, 'comentario' => 'Excelente docente. Sus explicaciones de Programación I son muy claras, aunque sus exámenes prácticos son bastante exigentes.'],
                    ['user' => $otherStudents[0], 'calificacion' => 5, 'comentario' => 'Muy metódico y ordenado. Si estudias sus diapositivas y haces todas las prácticas de laboratorio, apruebas seguro.'],
                ]
            ],
            [
                'nombre_completo' => 'Dra. Maria Lopez',
                'detalles_basicos' => 'Doctora en Derecho Comparado e Historia Jurídica. Docente titular de la asignatura DER-101.',
                'materia' => $derechoRomano,
                'grupo' => 'Grupo 1',
                'comentarios' => [
                    ['user' => $studentPremium, 'calificacion' => 3, 'comentario' => 'Su clase es bastante teórica. Evalúa de manera justa, pero es muy estricta con el control de asistencia.'],
                    ['user' => $otherStudents[1], 'calificacion' => 4, 'comentario' => 'Domina muy bien la historia del Derecho Romano. Es bastante amigable y comprensiva con las dudas de los estudiantes.'],
                ]
            ],
            [
                'nombre_completo' => 'Ing. Ricardo Silva',
                'detalles_basicos' => 'Especialista en Complejidad Algorítmica y Optimizaciones. Docente de Algoritmos SIS-211.',
                'materia' => $algoritmos,
                'grupo' => 'Grupo A',
                'comentarios' => [
                    ['user' => $otherStudents[2], 'calificacion' => 5, 'comentario' => 'Explica excelente las estructuras de datos y la complejidad. Sus proyectos de laboratorio son muy retadores y útiles.'],
                    ['user' => $otherStudents[3], 'calificacion' => 4, 'comentario' => 'Es un muy buen docente, pero avanza rápido. Recomiendo leer la teoría antes de entrar a su clase.'],
                ]
            ],
            [
                'nombre_completo' => 'Dra. Ana Gomez',
                'detalles_basicos' => 'Investigadora en Inteligencia Artificial y Lógica Computacional. Docente de SIS-111.',
                'materia' => $programacionI,
                'grupo' => 'Grupo B',
                'comentarios' => [
                    ['user' => $studentPremium, 'calificacion' => 5, 'comentario' => 'Muy didáctica en Programación I. Utiliza buenos ejemplos interactivos en Python y tiene mucha paciencia.'],
                    ['user' => $otherStudents[0], 'calificacion' => 5, 'comentario' => 'Su paciencia con los estudiantes que recién empiezan a programar es admirable. 100% recomendada.'],
                ]
            ],
            [
                'nombre_completo' => 'Lic. Carlos Martinez',
                'detalles_basicos' => 'Magíster en Ciencias de la Computación. Docente de SIS-211.',
                'materia' => $algoritmos,
                'grupo' => 'Grupo B',
                'comentarios' => [
                    ['user' => $otherStudents[1], 'calificacion' => 3, 'comentario' => 'Las clases de algoritmos son interesantes, pero sus exámenes teóricos son muy complejos. Estudien demostraciones.'],
                    ['user' => $otherStudents[2], 'calificacion' => 3, 'comentario' => 'Bastante estricto con las fechas de entrega del laboratorio. No perdona retrasos ni un solo minuto.'],
                ]
            ],
            [
                'nombre_completo' => 'Ing. Laura Ortega',
                'detalles_basicos' => 'Ingeniera de Datos y Administradora de Bases de Datos. Docente de Bases de Datos I SIS-311.',
                'materia' => $baseDatos,
                'grupo' => 'Grupo A',
                'comentarios' => [
                    ['user' => $studentPremium, 'calificacion' => 5, 'comentario' => 'Tiene un excelente dominio de SQL y modelado. Sus clases prácticas de bases de datos son indispensables para el proyecto.'],
                    ['user' => $otherStudents[3], 'calificacion' => 4, 'comentario' => 'Muy exigente con el diseño y normalización de tablas. Explica con paciencia en pizarra y aclara dudas.'],
                ]
            ],
            [
                'nombre_completo' => 'Dra. Patricia Rios',
                'detalles_basicos' => 'Especialista en Derecho Romano y Civil de la Facultad de Ciencias Jurídicas.',
                'materia' => $derechoRomano,
                'grupo' => 'Grupo 2',
                'comentarios' => [
                    ['user' => $otherStudents[1], 'calificacion' => 3, 'comentario' => 'Muy formal y tradicional en sus clases. Exige bastante lectura obligatoria de un semestre a otro.'],
                    ['user' => $otherStudents[0], 'calificacion' => 2, 'comentario' => 'Exige memorizar conceptos y términos textuales de los códigos civiles romanos antiguos en los parciales.'],
                ]
            ],
            [
                'nombre_completo' => 'Ing. Fernando Castro',
                'detalles_basicos' => 'Especialista en Redes de Computadoras y Telecomunicaciones. Docente de SIS-211.',
                'materia' => $algoritmos,
                'grupo' => 'Grupo C',
                'comentarios' => [
                    ['user' => $otherStudents[2], 'calificacion' => 5, 'comentario' => 'Sus laboratorios prácticos de arquitecturas son excepcionales. Aprendes de manera práctica y real.'],
                    ['user' => $studentPremium, 'calificacion' => 4, 'comentario' => 'Muy práctico y va directo al grano. Sus parciales son sumamente parecidos a las guías prácticas resueltas en clases.'],
                ]
            ],
            [
                'nombre_completo' => 'Lic. Sandra Velasquez',
                'detalles_basicos' => 'Licenciada en Informática con mención en Ingeniería de Software. Docente de SIS-111.',
                'materia' => $programacionI,
                'grupo' => 'Grupo C',
                'comentarios' => [
                    ['user' => $otherStudents[3], 'calificacion' => 4, 'comentario' => 'Una de las mejores docentes de primer semestre. Es sumamente comprensiva y explica todo paso a paso en clases.'],
                    ['user' => $otherStudents[1], 'calificacion' => 5, 'comentario' => 'Hace que aprender a programar parezca algo sencillo. Ideal para entrar con muy buena base al siguiente semestre.'],
                ]
            ],
            [
                'nombre_completo' => 'Ing. Hugo Morales',
                'detalles_basicos' => 'Especialista en Big Data y Arquitectura de Sistemas de Información. Docente de SIS-311.',
                'materia' => $baseDatos,
                'grupo' => 'Grupo B',
                'comentarios' => [
                    ['user' => $studentPremium, 'calificacion' => 4, 'comentario' => 'Excelente clase sobre optimización de consultas en Postgresql y modelado relacional.'],
                    ['user' => $otherStudents[2], 'calificacion' => 4, 'comentario' => 'Da excelentes pautas de diseño para los proyectos finales de bases de datos. Es exigente con el rendimiento.'],
                ]
            ]
        ];

        // Seed docentes, groups, and comments
        foreach ($docentesData as $docenteItem) {
            $docente = Docente::query()->firstOrCreate([
                'nombre_completo' => $docenteItem['nombre_completo'],
            ], [
                'detalles_basicos' => $docenteItem['detalles_basicos'],
                'calificacion' => 0.0,
            ]);

            // Create Group for this docente and materia
            GrupoMateriaDocente::query()->firstOrCreate([
                'materia_id' => $docenteItem['materia']->id,
                'docente_id' => $docente->id,
                'grupo_codigo' => $docenteItem['grupo'],
            ]);

            // Create Comments
            foreach ($docenteItem['comentarios'] as $comentarioItem) {
                $docente->comentarios()->create([
                    'user_id' => $comentarioItem['user']->id,
                    'comentario' => $comentarioItem['comentario'],
                    'calificacion' => $comentarioItem['calificacion'],
                ]);
            }

            // Recalculate and update average calificacion
            $avgCalificacion = $docente->comentarios()->avg('calificacion');
            $docente->update([
                'calificacion' => $avgCalificacion ?? 0.0
            ]);
        }

        // Attach studentFree (Test User) to SIS-211 Grupo A (Ing. Juan Perez)
        $grupoA_SIS211 = GrupoMateriaDocente::query()->where('materia_id', $algoritmos->id)->first();
        if ($grupoA_SIS211) {
            $studentFree->materias()->syncWithoutDetaching([
                $algoritmos->id => [
                    'estado' => 'cursando',
                    'grupo_materia_docente_id' => $grupoA_SIS211->id,
                ]
            ]);
        }
    }
}
