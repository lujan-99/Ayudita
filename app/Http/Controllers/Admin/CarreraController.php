<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarreraController extends Controller
{
    public function index(): View
    {
        $carreras = Carrera::all();
        return view('admin.carreras.index', compact('carreras'));
    }

    public function create(): View
    {
        return view('admin.carreras.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:carreras,nombre'],
        ]);

        Carrera::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.carreras.index')->with('success', 'Carrera creada exitosamente.');
    }

    public function edit(Carrera $carrera): View
    {
        return view('admin.carreras.edit', compact('carrera'));
    }

    public function update(Request $request, Carrera $carrera): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:carreras,nombre,' . $carrera->id],
        ]);

        $carrera->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.carreras.index')->with('success', 'Carrera actualizada exitosamente.');
    }

    public function destroy(Carrera $carrera): RedirectResponse
    {
        try {
            $carrera->delete();
            return redirect()->route('admin.carreras.index')->with('success', 'Carrera eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.carreras.index')->with('error', 'No se puede eliminar la carrera porque tiene materias o perfiles asociados.');
        }
    }

    public function showImport(Carrera $carrera): View
    {
        return view('admin.carreras.import', compact('carrera'));
    }

    public function importPlan(Request $request, Carrera $carrera): RedirectResponse
    {
        $json = '';
        if ($request->hasFile('json_file')) {
            $json = file_get_contents($request->file('json_file')->getRealPath());
        } elseif ($request->filled('json_text')) {
            $json = $request->input('json_text');
        } else {
            return back()->withInput()->with('error', 'Debes subir un archivo JSON o pegar el contenido del JSON en el campo de texto.');
        }

        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return back()->withInput()->with('error', 'El formato del JSON es inválido: ' . json_last_error_msg());
        }

        $materiasCreated = 0;
        $materiasUpdated = 0;

        // Fase 1: Crear o actualizar materias
        foreach ($data as $item) {
            if (empty($item['sigla']) || empty($item['nombre']) || empty($item['curso'])) {
                continue;
            }

            $codigo = trim($item['sigla']);
            $nombre = trim($item['nombre']);
            
            $semestre = 1;
            if (preg_match('/(\d+)/', $item['curso'], $matches)) {
                $semestre = (int)$matches[1];
            }

            $tm = !empty($item['tm']) ? trim($item['tm']) : 'N';

            $materia = \App\Models\Materia::updateOrCreate([
                'carrera_id' => $carrera->id,
                'codigo' => $codigo,
            ], [
                'nombre' => $nombre,
                'semestre' => $semestre,
                'tm' => $tm,
            ]);

            if ($materia->wasRecentlyCreated) {
                $materiasCreated++;
            } else {
                $materiasUpdated++;
            }
        }

        // Fase 2: Vincular prerrequisitos
        $requisitosCount = 0;
        foreach ($data as $item) {
            if (empty($item['sigla']) || !isset($item['requisitos']) || !is_array($item['requisitos'])) {
                continue;
            }

            $materia = \App\Models\Materia::where('carrera_id', $carrera->id)
                ->where('codigo', trim($item['sigla']))
                ->first();

            if (!$materia) {
                continue;
            }

            $requisitoIds = [];
            foreach ($item['requisitos'] as $reqSigla) {
                $reqMateria = \App\Models\Materia::where('carrera_id', $carrera->id)
                    ->where('codigo', trim($reqSigla))
                    ->first();

                if ($reqMateria) {
                    $requisitoIds[] = $reqMateria->id;
                }
            }

            $syncResult = $materia->prerequisitos()->sync($requisitoIds);
            $requisitosCount += count($syncResult['attached']) + count($syncResult['updated']) + count($syncResult['detached']);
        }

        return redirect()->route('admin.carreras.index')->with('success', "Plan de estudios importado. Materias creadas: {$materiasCreated}, actualizadas: {$materiasUpdated}, relaciones de prerrequisito actualizadas/sincronizadas: {$requisitosCount}.");
    }
}
