<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MateriaController extends Controller
{
    /**
     * Display a listing of the student's active subjects.
     */
    public function index(): View
    {
        $user = auth()->user();
        $carrera = $user->perfilEstudiante?->carrera;

        // Retrieve only the subjects the user is currently taking ('cursando')
        $materias = $user->materias()
            ->wherePivot('estado', 'cursando')
            ->with(['gruposMateriaDocente.docente'])
            ->get();

        return view('materias.index', compact('materias', 'carrera'));
    }
}
