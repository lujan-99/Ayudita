<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $carreras = \App\Models\Carrera::all();
        return view('auth.register', compact('carreras'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'carrera_id' => ['required', 'exists:carreras,id'],
            'semestre_actual' => ['required', 'integer', 'min:1', 'max:12'],
            'carnet_identidad' => ['required', 'string', 'max:20', 'unique:perfiles_estudiantes,carnet_identidad'],
            'carnet_universitario' => ['required', 'string', 'max:30', 'unique:perfiles_estudiantes,carnet_universitario'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cursando_materias' => ['nullable', 'array'],
            'cursando_materias.*' => ['exists:materias,id'],
            'grupo_materias' => ['nullable', 'array'],
            'grupo_materias.*' => ['nullable', 'exists:grupo_materia_docente,id'],
        ]);

        $cursandoIds = $request->input('cursando_materias', []);
        $aprobadasIds = [];

        if (!empty($cursandoIds)) {
            // Find all prerequisites recursively (BFS)
            $queue = \App\Models\Materia::with('prerequisitos')->whereIn('id', $cursandoIds)->get();
            $prereqsToTraverse = [];
            foreach ($queue as $materia) {
                foreach ($materia->prerequisitos as $p) {
                    $prereqsToTraverse[] = $p->id;
                }
            }

            while (!empty($prereqsToTraverse)) {
                $currentId = array_shift($prereqsToTraverse);
                if (!in_array($currentId, $aprobadasIds)) {
                    $aprobadasIds[] = $currentId;
                    $m = \App\Models\Materia::with('prerequisitos')->find($currentId);
                    if ($m) {
                        foreach ($m->prerequisitos as $p) {
                            $prereqsToTraverse[] = $p->id;
                        }
                    }
                }
            }

            // Conflict check
            foreach ($cursandoIds as $cId) {
                if (in_array($cId, $aprobadasIds)) {
                    throw ValidationException::withMessages([
                        'cursando_materias' => 'Conflicto de prerrequisitos: No puedes cursar una materia y su prerrequisito simultáneamente.',
                    ]);
                }
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->perfilEstudiante()->create([
            'carrera_id' => $request->carrera_id,
            'semestre_actual' => $request->semestre_actual,
            'carnet_identidad' => $request->carnet_identidad,
            'carnet_universitario' => $request->carnet_universitario,
            'formulario_completo' => true,
            'tour_visto' => true,
        ]);

        // Attach subjects with correct states
        if (!empty($cursandoIds)) {
            $grupoMaterias = $request->input('grupo_materias', []);
            foreach ($cursandoIds as $id) {
                $groupId = isset($grupoMaterias[$id]) && !empty($grupoMaterias[$id]) ? $grupoMaterias[$id] : null;
                $user->materias()->attach($id, [
                    'estado' => 'cursando',
                    'grupo_materia_docente_id' => $groupId
                ]);
            }
            foreach ($aprobadasIds as $id) {
                $user->materias()->attach($id, [
                    'estado' => 'aprobada',
                    'grupo_materia_docente_id' => null
                ]);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
