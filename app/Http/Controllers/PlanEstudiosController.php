<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanEstudiosController extends Controller
{
    /**
     * Show the interactive study plan for a career.
     */
    public function show(Request $request): View
    {
        $user = auth()->user();
        $carreras = Carrera::all();

        // Get selected career ID or default to student's career or first career
        $carreraId = $request->input('carrera_id');
        if (empty($carreraId)) {
            $carreraId = $user->perfilEstudiante?->carrera_id;
        }
        if (empty($carreraId)) {
            $carreraId = $carreras->first()?->id;
        }

        $carrera = null;
        $materiasBySemestre = collect();
        $userMaterias = [];

        if ($carreraId) {
            $carrera = Carrera::with(['materias' => function ($query) {
                $query->with('prerequisitos')->orderBy('semestre')->orderBy('codigo');
            }])->find($carreraId);

            if ($carrera) {
                $materiasBySemestre = $carrera->materias->groupBy('semestre');
            }

            // Retrieve student's academic progress mapping (materia_id => estado)
            $userMaterias = $user->materias()->pluck('estado', 'materia_id')->toArray();
        }

        return view('plan-estudios.index', compact('carreras', 'carrera', 'carreraId', 'materiasBySemestre', 'userMaterias'));
    }

    /**
     * Get list of subjects for a career as JSON.
     */
    public function getMateriasJson(Carrera $carrera): \Illuminate\Http\JsonResponse
    {
        $materias = $carrera->materias()
            ->with([
                'prerequisitos' => function ($query) {
                    $query->select('materias.id', 'materias.codigo', 'materias.nombre');
                },
                'gruposMateriaDocente.docente'
            ])
            ->orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        return response()->json($materias);
    }
}
