<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\GrupoMateriaDocente;
use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GrupoController extends Controller
{
    public function index(): View
    {
        $grupos = GrupoMateriaDocente::with(['materia', 'docente'])->get();
        return view('admin.grupos.index', compact('grupos'));
    }

    public function create(): View
    {
        $materias = Materia::orderBy('nombre')->get();
        $docentes = Docente::orderBy('nombre_completo')->get();
        return view('admin.grupos.create', compact('materias', 'docentes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'materia_id' => ['required', 'exists:materias,id'],
            'docente_id' => ['required', 'exists:docentes,id'],
            'grupo_codigo' => ['required', 'string', 'max:50'],
            'calificacion' => ['required', 'numeric', 'min:0', 'max:5'],
        ]);

        // Check if group configuration already exists
        $exists = GrupoMateriaDocente::where('materia_id', $request->materia_id)
            ->where('docente_id', $request->docente_id)
            ->where('grupo_codigo', $request->grupo_codigo)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['grupo_codigo' => 'Este grupo ya se encuentra registrado para esta materia y este docente.']);
        }

        GrupoMateriaDocente::create([
            'materia_id' => $request->materia_id,
            'docente_id' => $request->docente_id,
            'grupo_codigo' => $request->grupo_codigo,
            'calificacion' => $request->calificacion,
        ]);

        return redirect()->route('admin.grupos.index')->with('success', 'Grupo académico creado exitosamente.');
    }

    public function edit(GrupoMateriaDocente $grupo): View
    {
        $materias = Materia::orderBy('nombre')->get();
        $docentes = Docente::orderBy('nombre_completo')->get();
        return view('admin.grupos.edit', compact('grupo', 'materias', 'docentes'));
    }

    public function update(Request $request, GrupoMateriaDocente $grupo): RedirectResponse
    {
        $request->validate([
            'materia_id' => ['required', 'exists:materias,id'],
            'docente_id' => ['required', 'exists:docentes,id'],
            'grupo_codigo' => ['required', 'string', 'max:50'],
            'calificacion' => ['required', 'numeric', 'min:0', 'max:5'],
        ]);

        // Check unique constraint excluding current record
        $exists = GrupoMateriaDocente::where('materia_id', $request->materia_id)
            ->where('docente_id', $request->docente_id)
            ->where('grupo_codigo', $request->grupo_codigo)
            ->where('id', '!=', $grupo->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['grupo_codigo' => 'Otro grupo ya se encuentra registrado para esta materia, docente y código.']);
        }

        $grupo->update([
            'materia_id' => $request->materia_id,
            'docente_id' => $request->docente_id,
            'grupo_codigo' => $request->grupo_codigo,
            'calificacion' => $request->calificacion,
        ]);

        return redirect()->route('admin.grupos.index')->with('success', 'Grupo académico actualizado exitosamente.');
    }

    public function destroy(GrupoMateriaDocente $grupo): RedirectResponse
    {
        $grupo->delete();
        return redirect()->route('admin.grupos.index')->with('success', 'Grupo académico eliminado exitosamente.');
    }
}
