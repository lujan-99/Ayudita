<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\DocenteComentario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
    /**
     * Display a listing of the docentes for students.
     */
    public function index(): View
    {
        $docentes = Docente::with(['gruposMateriaDocente.materia.carrera'])
            ->orderBy('nombre_completo')
            ->get();

        $user = Auth::user();
        $cursandoDocentesIds = [];
        if ($user) {
            $cursandoDocentesIds = $user->materias()
                ->wherePivot('estado', 'cursando')
                ->get()
                ->flatMap(function ($materia) use ($user) {
                    $groupId = $materia->pivot->grupo_materia_docente_id;
                    $group = $materia->gruposMateriaDocente->firstWhere('id', $groupId);
                    return $group && $group->docente_id ? [$group->docente_id] : [];
                })
                ->unique()
                ->toArray();
        }

        return view('docentes.index', compact('docentes', 'cursandoDocentesIds'));
    }

    /**
     * Display a teacher detail page with reviews.
     */
    public function show($id): View|RedirectResponse
    {
        $firstDocente = Docente::orderBy('nombre_completo')->first();
        $isFirstDocente = $firstDocente && $firstDocente->id == $id;

        if (!Auth::user()->isPremium() && !$isFirstDocente) {
            return redirect()->route('paywall');
        }

        $docente = Docente::with(['gruposMateriaDocente.materia.carrera', 'comentarios.user.perfilEstudiante'])
            ->findOrFail($id);

        $isTakingClass = false;
        if (Auth::check()) {
            $isTakingClass = Auth::user()->materias()
                ->wherePivot('estado', 'cursando')
                ->whereHas('gruposMateriaDocente', function($query) use ($id) {
                    $query->where('docente_id', $id);
                })
                ->exists();
        }

        return view('docentes.show', compact('docente', 'isTakingClass', 'isFirstDocente'));
    }

    /**
     * Store a comment/rating for a docente.
     */
    public function storeComentario(Request $request, $id): RedirectResponse
    {
        $firstDocente = Docente::orderBy('nombre_completo')->first();
        $isFirstDocente = $firstDocente && $firstDocente->id == $id;

        if (!Auth::user()->isPremium() && !$isFirstDocente) {
            return redirect()->route('paywall');
        }

        $isTakingClass = Auth::user()->materias()
            ->wherePivot('estado', 'cursando')
            ->whereHas('gruposMateriaDocente', function($query) use ($id) {
                $query->where('docente_id', $id);
            })
            ->exists();

        if (!$isTakingClass) {
            return back()->with('error', 'Solo puedes calificar y comentar si estás cursando una materia con este docente.');
        }

        $request->validate([
            'comentario' => 'required|string|min:5|max:1000',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        $docente = Docente::findOrFail($id);

        $docente->comentarios()->create([
            'user_id' => Auth::id(),
            'comentario' => $request->comentario,
            'calificacion' => $request->calificacion,
        ]);

        // Recalculate average calificacion of docente
        $avgCalificacion = $docente->comentarios()->avg('calificacion');
        $docente->update([
            'calificacion' => $avgCalificacion
        ]);

        return back()->with('success', 'Tu calificación y comentario fueron registrados exitosamente.');
    }
}
