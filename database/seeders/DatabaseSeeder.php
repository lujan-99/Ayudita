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
        $freeRole = Role::query()->firstOrCreate(['nombre' => 'free']);
        $premiumRole = Role::query()->firstOrCreate(['nombre' => 'premium']);
        $adminRole = Role::query()->firstOrCreate(['nombre' => 'admin']);

        $ingenieriaSistemas = Carrera::query()->firstOrCreate(['nombre' => 'Ingeniería de Sistemas']);
        $derecho = Carrera::query()->firstOrCreate(['nombre' => 'Derecho']);

        $docenteJuan = Docente::query()->firstOrCreate([
            'nombre_completo' => 'Ing. Juan Perez',
        ], [
            'facultad' => 'Facultad de Tecnología',
        ]);

        $docenteMaria = Docente::query()->firstOrCreate([
            'nombre_completo' => 'Dra. Maria Lopez',
        ], [
            'facultad' => 'Facultad de Ciencias Jurídicas',
        ]);

        $programacionI = Materia::query()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'codigo' => 'SIS-111',
        ], [
            'nombre' => 'Programación I',
            'semestre' => 1,
        ]);

        $algoritmos = Materia::query()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'codigo' => 'SIS-211',
        ], [
            'nombre' => 'Algoritmos y Estructuras de Datos',
            'semestre' => 2,
        ]);

        $baseDatos = Materia::query()->firstOrCreate([
            'carrera_id' => $ingenieriaSistemas->id,
            'codigo' => 'SIS-311',
        ], [
            'nombre' => 'Bases de Datos I',
            'semestre' => 3,
        ]);

        $derechoRomano = Materia::query()->firstOrCreate([
            'carrera_id' => $derecho->id,
            'codigo' => 'DER-101',
        ], [
            'nombre' => 'Derecho Romano I',
            'semestre' => 1,
        ]);

        RequisitoMateria::query()->firstOrCreate([
            'materia_id' => $algoritmos->id,
            'requisito_id' => $programacionI->id,
        ]);

        RequisitoMateria::query()->firstOrCreate([
            'materia_id' => $baseDatos->id,
            'requisito_id' => $algoritmos->id,
        ]);

        GrupoMateriaDocente::query()->firstOrCreate([
            'materia_id' => $programacionI->id,
            'docente_id' => $docenteJuan->id,
            'grupo_codigo' => 'Grupo A',
        ]);

        GrupoMateriaDocente::query()->firstOrCreate([
            'materia_id' => $algoritmos->id,
            'docente_id' => $docenteJuan->id,
            'grupo_codigo' => 'Grupo B',
        ]);

        GrupoMateriaDocente::query()->firstOrCreate([
            'materia_id' => $derechoRomano->id,
            'docente_id' => $docenteMaria->id,
            'grupo_codigo' => 'Grupo 1',
        ]);

        $student = User::query()->firstOrCreate([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ], [
            'password' => 'password',
            'role_id' => $freeRole->id,
        ]);

        User::query()->firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => 'password',
            'role_id' => $adminRole->id,
        ]);

        User::query()->firstOrCreate([
            'email' => 'premium@example.com',
        ], [
            'name' => 'Premium User',
            'password' => 'password',
            'role_id' => $premiumRole->id,
        ]);

        PerfilEstudiante::query()->firstOrCreate([
            'user_id' => $student->id,
        ], [
            'carrera_id' => $ingenieriaSistemas->id,
            'semestre_actual' => 2,
            'formulario_completo' => true,
            'tour_visto' => true,
        ]);
    }
}
