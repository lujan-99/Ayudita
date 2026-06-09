<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MateriaController extends Controller
{
    public function index(): View
    {
        $materias = Materia::with('carrera')->get();
        return view('admin.materias.index', compact('materias'));
    }

    public function create(): View
    {
        $carreras = Carrera::all();
        return view('admin.materias.create', compact('carreras'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'carrera_id' => ['required', 'exists:carreras,id'],
            'codigo' => ['required', 'string', 'max:50'],
            'nombre' => ['required', 'string', 'max:255'],
            'semestre' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $existsCodigo = Materia::where('carrera_id', $request->carrera_id)->where('codigo', $request->codigo)->exists();
        if ($existsCodigo) {
            return back()->withInput()->withErrors(['codigo' => 'Ya existe una materia con ese código en esta carrera.']);
        }

        $existsNombre = Materia::where('carrera_id', $request->carrera_id)->where('nombre', $request->nombre)->exists();
        if ($existsNombre) {
            return back()->withInput()->withErrors(['nombre' => 'Ya existe una materia con ese nombre en esta carrera.']);
        }

        Materia::create([
            'carrera_id' => $request->carrera_id,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'semestre' => $request->semestre,
        ]);

        return redirect()->route('admin.materias.index')->with('success', 'Materia creada exitosamente.');
    }

    public function edit(Materia $materia): View
    {
        $carreras = Carrera::all();
        return view('admin.materias.edit', compact('materia', 'carreras'));
    }

    public function update(Request $request, Materia $materia): RedirectResponse
    {
        $request->validate([
            'carrera_id' => ['required', 'exists:carreras,id'],
            'codigo' => ['required', 'string', 'max:50'],
            'nombre' => ['required', 'string', 'max:255'],
            'semestre' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $existsCodigo = Materia::where('carrera_id', $request->carrera_id)
            ->where('codigo', $request->codigo)
            ->where('id', '!=', $materia->id)
            ->exists();
        if ($existsCodigo) {
            return back()->withInput()->withErrors(['codigo' => 'Ya existe otra materia con ese código en esta carrera.']);
        }

        $existsNombre = Materia::where('carrera_id', $request->carrera_id)
            ->where('nombre', $request->nombre)
            ->where('id', '!=', $materia->id)
            ->exists();
        if ($existsNombre) {
            return back()->withInput()->withErrors(['nombre' => 'Ya existe otra materia con ese nombre en esta carrera.']);
        }

        $materia->update([
            'carrera_id' => $request->carrera_id,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'semestre' => $request->semestre,
        ]);

        return redirect()->route('admin.materias.index')->with('success', 'Materia actualizada exitosamente.');
    }

    public function destroy(Materia $materia): RedirectResponse
    {
        try {
            $materia->delete();
            return redirect()->route('admin.materias.index')->with('success', 'Materia eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.materias.index')->with('error', 'No se puede eliminar la materia porque tiene prerrequisitos o grupos asociados.');
        }
    }
}
