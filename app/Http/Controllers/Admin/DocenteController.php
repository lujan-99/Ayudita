<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocenteController extends Controller
{
    public function index(): View
    {
        $docentes = Docente::all();
        return view('admin.docentes.index', compact('docentes'));
    }

    public function create(): View
    {
        return view('admin.docentes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'detalles_basicos' => ['nullable', 'string'],
            'calificacion' => ['required', 'numeric', 'min:0', 'max:5'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_file')) {
            $destinationPath = public_path('uploads/docentes');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('foto_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $fotoPath = 'uploads/docentes/' . $fileName;
        }

        Docente::create([
            'nombre_completo' => $request->nombre_completo,
            'foto' => $fotoPath,
            'detalles_basicos' => $request->detalles_basicos,
            'calificacion' => $request->calificacion,
        ]);

        return redirect()->route('admin.docentes.index')->with('success', 'Docente registrado exitosamente.');
    }

    public function edit(Docente $docente): View
    {
        return view('admin.docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'detalles_basicos' => ['nullable', 'string'],
            'calificacion' => ['required', 'numeric', 'min:0', 'max:5'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $fotoPath = $docente->foto;
        if ($request->hasFile('foto_file')) {
            // Delete old photo if it exists
            if ($docente->foto && file_exists(public_path($docente->foto))) {
                @unlink(public_path($docente->foto));
            }

            $destinationPath = public_path('uploads/docentes');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('foto_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $fotoPath = 'uploads/docentes/' . $fileName;
        }

        $docente->update([
            'nombre_completo' => $request->nombre_completo,
            'foto' => $fotoPath,
            'detalles_basicos' => $request->detalles_basicos,
            'calificacion' => $request->calificacion,
        ]);

        return redirect()->route('admin.docentes.index')->with('success', 'Docente actualizado exitosamente.');
    }

    public function destroy(Docente $docente): RedirectResponse
    {
        try {
            // Delete photo if exists
            if ($docente->foto && file_exists(public_path($docente->foto))) {
                @unlink(public_path($docente->foto));
            }
            
            $docente->delete();
            return redirect()->route('admin.docentes.index')->with('success', 'Docente eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.docentes.index')->with('error', 'No se puede eliminar el docente porque tiene materias o grupos asociados.');
        }
    }
}
