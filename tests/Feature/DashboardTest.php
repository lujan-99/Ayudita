<?php

namespace Tests\Feature;

use App\Models\Carrera;
use App\Models\Docente;
use App\Models\GrupoMateriaDocente;
use App\Models\Materia;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private Role $freeRole;
    private Carrera $carrera;

    protected function setUp(): void
    {
        parent::setUp();

        $this->freeRole = Role::create(['nombre' => 'free']);
        $this->carrera = Carrera::create(['nombre' => 'Ingeniería de Sistemas']);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_student_can_view_dashboard_with_career_and_cursando_subjects(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->freeRole->id
        ]);

        // Attach career to student profile
        $user->perfilEstudiante()->create([
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 2,
            'carnet_identidad' => '87654321',
            'carnet_universitario' => '20-54321'
        ]);

        // Create subject
        $m1 = $this->carrera->materias()->create([
            'codigo' => 'SIS301',
            'nombre' => 'Álgebra Lineal',
            'semestre' => 3,
            'tm' => 'N'
        ]);

        // Mark as cursando
        $user->materias()->attach($m1->id, ['estado' => 'cursando']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Ingeniería de Sistemas');
        $response->assertSee('Álgebra Lineal');
        $response->assertSee('SIS301');
        $response->assertDontSee('No estás cursando ninguna materia');
    }

    public function test_student_can_access_unlocked_subject_detail_page(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->freeRole->id
        ]);

        // Attach career and details to student profile
        $user->perfilEstudiante()->create([
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 3,
            'carnet_identidad' => '87654321',
            'carnet_universitario' => '20-54321'
        ]);

        $m1 = $this->carrera->materias()->create([
            'codigo' => 'SIS301',
            'nombre' => 'Álgebra Lineal',
            'semestre' => 3,
            'tm' => 'N'
        ]);

        $docente = Docente::create(['nombre_completo' => 'Ing. Pérez']);
        
        $grupo = GrupoMateriaDocente::create([
            'materia_id' => $m1->id,
            'docente_id' => $docente->id,
            'grupo_codigo' => '1',
            'calificacion' => 4.5
        ]);

        // Enroll user in subject and group
        $user->materias()->attach($m1->id, [
            'estado' => 'cursando',
            'grupo_materia_docente_id' => $grupo->id
        ]);

        $response = $this->actingAs($user)->get('/materias/' . $m1->id);

        $response->assertStatus(200);
        $response->assertSee('Materia - Álgebra Lineal');
        $response->assertSee('SIS301');
        $response->assertSee('Archivos y Recursos');
        $response->assertDontSee('Esta asignatura requiere nivel PRO');
    }
}
