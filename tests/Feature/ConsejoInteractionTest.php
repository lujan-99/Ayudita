<?php

namespace Tests\Feature;

use App\Models\Carrera;
use App\Models\Docente;
use App\Models\GrupoMateriaDocente;
use App\Models\Materia;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConsejoInteractionTest extends TestCase
{
    use RefreshDatabase;

    private User $student;
    private Carrera $carrera;
    private Materia $materia1;
    private Materia $materia2;
    private GrupoMateriaDocente $grupoA;
    private GrupoMateriaDocente $grupoB;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['nombre' => 'free']);

        $this->carrera = Carrera::create(['nombre' => 'Ing. Sistemas']);
        
        $this->materia1 = Materia::create([
            'carrera_id' => $this->carrera->id,
            'codigo' => 'MAT101',
            'nombre' => 'Cálculo I',
            'semestre' => 1,
            'tm' => 'N',
        ]);

        $this->materia2 = Materia::create([
            'carrera_id' => $this->carrera->id,
            'codigo' => 'MAT102',
            'nombre' => 'Cálculo II',
            'semestre' => 2,
            'tm' => 'N',
        ]);

        $docente = Docente::create(['nombre_completo' => 'Dr. Newton']);
        
        $this->grupoA = GrupoMateriaDocente::create([
            'materia_id' => $this->materia1->id,
            'docente_id' => $docente->id,
            'grupo_codigo' => 'A',
            'calificacion' => 4.5,
        ]);

        $this->grupoB = GrupoMateriaDocente::create([
            'materia_id' => $this->materia1->id,
            'docente_id' => $docente->id,
            'grupo_codigo' => 'B',
            'calificacion' => 4.2,
        ]);

        // Register Student taking Materia 1 / Grupo A
        $this->student = User::create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->student->perfilEstudiante()->create([
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 1,
            'carnet_identidad' => '12345678',
            'carnet_universitario' => '20-123456',
            'formulario_completo' => true,
            'tour_visto' => true,
        ]);

        $this->student->materias()->attach($this->materia1->id, [
            'estado' => 'cursando',
            'grupo_materia_docente_id' => $this->grupoA->id,
        ]);
    }

    public function test_student_has_anonymous_nickname_automatically_generated(): void
    {
        $perfil = $this->student->perfilEstudiante;
        $this->assertNotNull($perfil->nickname);
        $this->assertStringStartsWith('El ', $perfil->nickname);
        $this->assertEquals(0, $perfil->puntos);
    }

    public function test_student_can_only_access_subjects_they_are_currently_taking(): void
    {
        // Materia 1 is cursando -> Access allowed (200 OK)
        $response = $this->actingAs($this->student)->get("/materias/{$this->materia1->id}");
        $response->assertStatus(200);
        $response->assertViewHas('selectedGroup');

        // Materia 2 is NOT cursando -> Access denied (403 Forbidden)
        $response = $this->actingAs($this->student)->get("/materias/{$this->materia2->id}");
        $response->assertStatus(403);
    }

    public function test_student_can_post_text_only_advice_and_earns_5_points(): void
    {
        $this->assertEquals(0, $this->student->perfilEstudiante->puntos);

        $response = $this->actingAs($this->student)->post("/materias/{$this->materia1->id}/consejos", [
            'contenido' => 'Estudien la guia practica para el primer parcial.',
            'tipo' => 'consejo',
        ]);

        $response->assertRedirect();
        
        // Assert stored in database
        $this->assertDatabaseHas('consejos', [
            'materia_id' => $this->materia1->id,
            'grupo_materia_docente_id' => $this->grupoA->id,
            'user_id' => $this->student->id,
            'contenido' => 'Estudien la guia practica para el primer parcial.',
            'tipo' => 'consejo',
            'archivo_path' => null,
        ]);

        // Assert points increased
        $this->student->perfilEstudiante->refresh();
        $this->assertEquals(5, $this->student->perfilEstudiante->puntos);
    }

    public function test_student_can_upload_files_with_advice_and_earns_15_points(): void
    {
        $this->assertEquals(0, $this->student->perfilEstudiante->puntos);

        $file = UploadedFile::fake()->create('examen_2025.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->student)->post("/materias/{$this->materia1->id}/consejos", [
            'contenido' => 'Examen resuelto del periodo anterior.',
            'tipo' => 'examen',
            'archivo' => $file,
        ]);

        $response->assertRedirect();

        // Retrieve council
        $consejo = \App\Models\Consejo::where('user_id', $this->student->id)->first();
        $this->assertNotNull($consejo);
        $this->assertEquals('examen', $consejo->tipo);
        $this->assertNotNull($consejo->archivo_path);
        $this->assertEquals('examen_2025.pdf', $consejo->archivo_nombre);

        // Assert file exists in public/uploads/consejos
        $this->assertFileExists(public_path($consejo->archivo_path));

        // Clean up
        @unlink(public_path($consejo->archivo_path));

        // Assert points increased by 15
        $this->student->perfilEstudiante->refresh();
        $this->assertEquals(15, $this->student->perfilEstudiante->puntos);
    }

    public function test_like_increases_count_and_awards_1_point_to_author(): void
    {
        // Setup author and advice
        $author = User::create([
            'name' => 'Author Student',
            'email' => 'author@test.com',
            'password' => bcrypt('password123'),
        ]);
        $author->perfilEstudiante()->create([
            'carrera_id' => $this->carrera->id,
            'semestre_actual' => 1,
            'carnet_identidad' => '87654329',
            'carnet_universitario' => '20-876543',
            'formulario_completo' => true,
        ]);

        $consejo = \App\Models\Consejo::create([
            'materia_id' => $this->materia1->id,
            'grupo_materia_docente_id' => $this->grupoA->id,
            'user_id' => $author->id,
            'contenido' => 'Consejo de prueba.',
            'tipo' => 'consejo',
        ]);

        $this->assertEquals(0, $author->perfilEstudiante->puntos);
        $this->assertEquals(0, $consejo->likes_count);

        // Student upvotes author's advice
        $response = $this->actingAs($this->student)->post("/consejos/{$consejo->id}/like");
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'likes_count' => 1,
            'author_puntos' => 1,
        ]);

        // Refresh database assertions
        $consejo->refresh();
        $author->perfilEstudiante->refresh();

        $this->assertEquals(1, $consejo->likes_count);
        $this->assertEquals(1, $author->perfilEstudiante->puntos);
    }

    public function test_student_can_view_their_enrolled_subjects_index(): void
    {
        $response = $this->actingAs($this->student)->get('/materias');
        $response->assertStatus(200);
        $response->assertViewHas('materias');
        
        $responseMaterias = $response->viewData('materias');
        $this->assertCount(1, $responseMaterias);
        $this->assertEquals($this->materia1->id, $responseMaterias->first()->id);
    }
}
