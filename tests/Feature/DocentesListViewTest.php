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

class DocentesListViewTest extends TestCase
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

    public function test_guest_cannot_view_docentes(): void
    {
        $response = $this->get('/docentes');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_student_can_view_docentes_list_with_subjects_and_careers(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->freeRole->id
        ]);

        // Create docente
        $docente = Docente::create([
            'nombre_completo' => 'Dr. Walter White',
            'detalles_basicos' => 'Profesor de Química Orgánica y procesos.',
            'calificacion' => 4.85
        ]);

        // Create materia associated with carrera
        $materia = $this->carrera->materias()->create([
            'codigo' => 'QMC-101',
            'nombre' => 'Química General I',
            'semestre' => 1,
            'tm' => 'N'
        ]);

        // Create grupo connecting them
        GrupoMateriaDocente::create([
            'materia_id' => $materia->id,
            'docente_id' => $docente->id,
            'grupo_codigo' => 'Grupo 1A',
            'calificacion' => 4.80
        ]);

        $response = $this->actingAs($user)->get('/docentes');

        $response->assertStatus(200);
        $response->assertSee('Directorio de Docentes');
        $response->assertSee('Dr. Walter White');
        $response->assertSee('Profesor de Química Orgánica');
        $response->assertSee('4.85');
        $response->assertSee('Química General I');
        $response->assertSee('QMC-101');
        $response->assertSee('Ingeniería de Sistemas');
        $response->assertSee('Grupo 1A');
    }
}
