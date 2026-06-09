<?php

namespace Tests\Feature;

use App\Models\Carrera;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationSubjectsTest extends TestCase
{
    use RefreshDatabase;

    private Carrera $carrera;
    private Materia $calculo1;
    private Materia $calculo2;
    private Materia $algebra1;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic role
        \App\Models\Role::create(['nombre' => 'free']);

        // Create Career
        $this->carrera = Carrera::create(['nombre' => 'Ingeniería de Sistemas']);

        // Create Subjects
        $this->algebra1 = Materia::create([
            'carrera_id' => $this->carrera->id,
            'codigo' => 'MAT100',
            'nombre' => 'ÁLGEBRA I',
            'semestre' => 1,
            'tm' => 'N',
        ]);

        $this->calculo1 = Materia::create([
            'carrera_id' => $this->carrera->id,
            'codigo' => 'MAT101',
            'nombre' => 'CÁLCULO I',
            'semestre' => 1,
            'tm' => 'N',
        ]);

        $this->calculo2 = Materia::create([
            'carrera_id' => $this->carrera->id,
            'codigo' => 'MAT102',
            'nombre' => 'CÁLCULO II',
            'semestre' => 2,
            'tm' => 'N',
        ]);

        // Link Prerequisites: Calculus I is prerequisite of Calculus II
        $this->calculo2->prerequisitos()->attach($this->calculo1->id);
    }

    public function test_student_can_register_with_currently_taking_subject_and_auto_fills_prerequisites(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 2,
            'carnet_identidad' => '87654321',
            'carnet_universitario' => '20-54321',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'cursando_materias' => [$this->calculo2->id]
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);

        // Verify currently taking subject
        $this->assertTrue($user->materias()->where('materia_id', $this->calculo2->id)->wherePivot('estado', 'cursando')->exists());

        // Verify recursively auto-filled prerequisite subject (Calculus I is approved)
        $this->assertTrue($user->materias()->where('materia_id', $this->calculo1->id)->wherePivot('estado', 'aprobada')->exists());

        // Verify Algebra I (unrelated to Calculus II) is NOT associated with the user
        $this->assertFalse($user->materias()->where('materia_id', $this->algebra1->id)->exists());
    }

    public function test_student_registration_fails_if_prerequisite_is_also_marked_as_currently_taking(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 2,
            'carnet_identidad' => '99999999',
            'carnet_universitario' => '20-99999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // Calculus I is a prerequisite of Calculus II, they cannot both be marked as currently taking!
            'cursando_materias' => [$this->calculo1->id, $this->calculo2->id]
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('cursando_materias');
    }

    public function test_student_can_register_with_group_selection_for_currently_taking_subjects(): void
    {
        $docente = \App\Models\Docente::create([
            'nombre_completo' => 'Dr. Isaac Newton',
            'calificacion' => 4.80,
        ]);

        $grupo = \App\Models\GrupoMateriaDocente::create([
            'materia_id' => $this->calculo2->id,
            'docente_id' => $docente->id,
            'grupo_codigo' => 'A',
            'calificacion' => 4.80,
        ]);

        $response = $this->post('/register', [
            'name' => 'John Group',
            'email' => 'johngroup@example.com',
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 2,
            'carnet_identidad' => '87654322',
            'carnet_universitario' => '20-54322',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'cursando_materias' => [$this->calculo2->id],
            'grupo_materias' => [
                $this->calculo2->id => $grupo->id
            ]
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');

        $user = User::where('email', 'johngroup@example.com')->first();
        $this->assertNotNull($user);

        // Verify currently taking subject
        $materiaUser = $user->materias()->where('materia_id', $this->calculo2->id)->first();
        $this->assertNotNull($materiaUser);
        $this->assertEquals('cursando', $materiaUser->pivot->estado);
        $this->assertEquals($grupo->id, $materiaUser->pivot->grupo_materia_docente_id);

        // Verify recursively auto-filled prerequisite subject (Calculus I is approved)
        $prereqUser = $user->materias()->where('materia_id', $this->calculo1->id)->first();
        $this->assertNotNull($prereqUser);
        $this->assertEquals('aprobada', $prereqUser->pivot->estado);
        $this->assertNull($prereqUser->pivot->grupo_materia_docente_id);
    }
}
