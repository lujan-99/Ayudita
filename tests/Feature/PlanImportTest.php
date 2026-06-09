<?php

namespace Tests\Feature;

use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanImportTest extends TestCase
{
    use RefreshDatabase;

    private Role $freeRole;
    private Role $adminRole;
    private Carrera $carrera;

    protected function setUp(): void
    {
        parent::setUp();

        $this->freeRole = Role::create(['nombre' => 'free']);
        $this->adminRole = Role::create(['nombre' => 'admin']);
        $this->carrera = Carrera::create(['nombre' => 'Ingeniería de Sistemas']);
    }

    public function test_non_admin_cannot_access_import_page(): void
    {
        $user = User::factory()->create(['role_id' => $this->freeRole->id]);

        $response = $this->actingAs($user)->get(route('admin.carreras.import', $this->carrera));
        $response->assertStatus(403);
    }

    public function test_admin_can_import_plan_from_json_text(): void
    {
        $user = User::factory()->create(['role_id' => $this->adminRole->id]);

        $jsonText = '[
            {
                "sigla": "FIS100",
                "nombre": "FÍSICA BÁSICA I",
                "tm": "N",
                "curso": "Curso: 1",
                "requisitos": []
            },
            {
                "sigla": "MAT100",
                "nombre": "ÁLGEBRA I",
                "tm": "N",
                "curso": "Curso: 1",
                "requisitos": []
            },
            {
                "sigla": "MAT102",
                "nombre": "CÁLCULO II",
                "tm": "N",
                "curso": "Curso: 2",
                "requisitos": ["MAT100"]
            }
        ]';

        $response = $this->actingAs($user)->post(route('admin.carreras.import.post', $this->carrera), [
            'json_text' => $jsonText
        ]);

        $response->assertRedirect(route('admin.carreras.index'));
        $response->assertSessionHas('success');

        // Check materias were created in DB
        $this->assertDatabaseHas('materias', [
            'carrera_id' => $this->carrera->id,
            'codigo' => 'FIS100',
            'nombre' => 'FÍSICA BÁSICA I',
            'semestre' => 1,
            'tm' => 'N'
        ]);

        $this->assertDatabaseHas('materias', [
            'carrera_id' => $this->carrera->id,
            'codigo' => 'MAT100',
            'nombre' => 'ÁLGEBRA I',
            'semestre' => 1,
            'tm' => 'N'
        ]);

        $materiaCalculo = Materia::where('carrera_id', $this->carrera->id)->where('codigo', 'MAT102')->first();
        $this->assertNotNull($materiaCalculo);
        $this->assertEquals(2, $materiaCalculo->semestre);

        // Check prerequisite was linked
        $this->assertTrue($materiaCalculo->prerequisitos->contains('codigo', 'MAT100'));
    }
}
