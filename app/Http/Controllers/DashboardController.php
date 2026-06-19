<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        $carrera = $user->perfilEstudiante?->carrera;

        $progreso = 0;
        $cursandoMaterias = collect();
        $misDocentes = collect();
        $ultimasPublicaciones = collect();

        if ($carrera) {
            // Calculate progress:
            // 1. Total normal subjects (tm !== 'O')
            $totalNormales = $carrera->materias()->where('tm', '!=', 'O')->count();
            
            // 2. All subjects the user has approved
            $aprobadas = $user->materias()->wherePivot('estado', 'aprobada')->get();
            $aprobadasNormales = $aprobadas->where('tm', '!=', 'O')->count();
            $aprobadasOptativas = $aprobadas->where('tm', 'O')->count();
            
            $totalRequerido = $totalNormales + 3;
            if ($totalRequerido > 0) {
                $progreso = min(100, round((($aprobadasNormales + min(3, $aprobadasOptativas)) / $totalRequerido) * 100));
            }

            // 3. Cursando subjects loaded with groups & teachers
            $cursandoMaterias = $user->materias()
                ->wherePivot('estado', 'cursando')
                ->with(['gruposMateriaDocente.docente'])
                ->get();

            // Load active group IDs and subject IDs
            $userMateriaGroups = [];
            foreach ($cursandoMaterias as $materia) {
                $groupId = $materia->pivot->grupo_materia_docente_id;
                if ($groupId) {
                    $userMateriaGroups[$materia->id] = $groupId;
                }
            }

            $subjectIds = $cursandoMaterias->pluck('id')->toArray();
            $groupIds = array_values($userMateriaGroups);

            // Fetch latest 5 publications for enrolled subjects and groups
            $ultimasPublicaciones = \App\Models\Consejo::with(['user.perfilEstudiante', 'materia', 'grupoMateriaDocente.docente'])
                ->whereIn('materia_id', $subjectIds)
                ->whereIn('grupo_materia_docente_id', $groupIds)
                ->latest()
                ->take(5)
                ->get();

            // Fetch unique teachers dictionary
            $teachers = [];
            foreach ($cursandoMaterias as $materia) {
                $groupId = $materia->pivot->grupo_materia_docente_id;
                $group = $materia->gruposMateriaDocente->firstWhere('id', $groupId);
                if ($group && $group->docente) {
                    $docente = $group->docente;
                    // Tag subject info
                    $docente->materia_nombre = $materia->nombre;
                    $docente->materia_codigo = $materia->codigo;
                    $teachers[$docente->id] = $docente;
                }
            }
            $misDocentes = collect(array_values($teachers));
        }

        return view('dashboard', compact('progreso', 'cursandoMaterias', 'carrera', 'misDocentes', 'ultimasPublicaciones'));
    }
}
