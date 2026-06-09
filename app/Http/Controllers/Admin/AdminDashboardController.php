<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $carrerasCount = Carrera::count();
        $docentesCount = Docente::count();
        $materiasCount = Materia::count();
        $usersCount = User::count();
        $gruposCount = \App\Models\GrupoMateriaDocente::count();

        return view('admin.dashboard', compact('carrerasCount', 'docentesCount', 'materiasCount', 'usersCount', 'gruposCount'));
    }
}
