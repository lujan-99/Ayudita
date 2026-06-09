<?php

namespace Tests\Feature;

use App\Models\Carrera;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanEstudiosViewTest extends TestCase
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

    public function test_guest_cannot_view_plan_estudios(): void
    {
        $response = $this->get('/plan-estudios');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_student_can_view_plan_estudios(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->freeRole->id
        ]);

        $response = $this->actingAs($user)->get('/plan-estudios');
        $response->assertStatus(200);
        $response->assertSee('Plan de Estudios');
    }

    public function test_authenticated_student_can_view_subject_statuses(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->freeRole->id
        ]);

        $m1 = $this->carrera->materias()->create([
            'codigo' => 'MAT-101',
            'nombre' => 'Álgebra I',
            'semestre' => 1,
            'tm' => 'N'
        ]);

        $m2 = $this->carrera->materias()->create([
            'codigo' => 'MAT-102',
            'nombre' => 'Álgebra II',
            'semestre' => 2,
            'tm' => 'N'
        ]);

        // Attach statuses: m1 is approved, m2 is taking
        $user->materias()->attach($m1->id, ['estado' => 'aprobada']);
        $user->materias()->attach($m2->id, ['estado' => 'cursando']);

        $response = $this->actingAs($user)->get('/plan-estudios?carrera_id=' . $this->carrera->id);
        $response->assertStatus(200);
        $response->assertSee('Álgebra I');
        $response->assertSee('Vencida');
        $response->assertSee('Cursando');
        $response->assertSee('Falta');
    }
}
