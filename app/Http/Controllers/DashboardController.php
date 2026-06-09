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
        }

        return view('dashboard', compact('progreso', 'cursandoMaterias', 'carrera'));
    }
}
