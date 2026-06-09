<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        return view('docentes.index', compact('docentes'));
    }
}
