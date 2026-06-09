<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Consejo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ConsejoController extends Controller
{
    /**
     * Store a newly created advice/resource in storage.
     */
    public function store(Request $request, Materia $materia)
    {
        $user = auth()->user();

        // 1. Verify student is taking this subject
        $userMateria = $user->materias()
            ->where('materia_id', $materia->id)
            ->wherePivot('estado', 'cursando')
            ->first();

        if (!$userMateria) {
            abort(403, 'No estás cursando esta asignatura.');
        }

        $userGroupId = $userMateria->pivot->grupo_materia_docente_id;
        if (!$userGroupId) {
            abort(403, 'No tienes un grupo asignado para esta materia.');
        }

        // 2. Validate input
        $request->validate([
            'contenido' => ['required', 'string', 'max:2000'],
            'tipo' => ['required', 'string', 'in:consejo,examen,apunte,otro'],
            'archivo' => ['nullable', 'file', 'max:10240', 'mimes:pdf,png,jpg,jpeg,gif'],
        ]);

        // 3. Handle File Upload (directly to public directory)
        $filePath = null;
        $fileOriginalName = null;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileOriginalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            $destinationPath = public_path('uploads/consejos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $fileName);
            $filePath = 'uploads/consejos/' . $fileName;
        }

        // 4. Create Consejo
        $consejo = Consejo::create([
            'materia_id' => $materia->id,
            'grupo_materia_docente_id' => $userGroupId,
            'user_id' => $user->id,
            'contenido' => $request->contenido,
            'tipo' => $request->tipo,
            'archivo_path' => $filePath,
            'archivo_nombre' => $fileOriginalName,
            'likes_count' => 0,
            'dislikes_count' => 0,
            'validado' => false,
        ]);

        // 5. Award Points (5 for text, 15 for files)
        $puntos = $filePath ? 15 : 5;
        if ($user->perfilEstudiante) {
            $user->perfilEstudiante->increment('puntos', $puntos);
        }

        return back()->with('success', '¡Aporte publicado con éxito! Has ganado ' . $puntos . ' puntos.');
    }

    /**
     * Increment the likes count and award 1 point to the author.
     */
    public function like(Consejo $consejo): JsonResponse
    {
        $consejo->increment('likes_count');

        $author = $consejo->user;
        if ($author && $author->perfilEstudiante) {
            $author->perfilEstudiante->increment('puntos', 1);
        }

        return response()->json([
            'success' => true,
            'likes_count' => $consejo->likes_count,
            'author_nickname' => $author?->perfilEstudiante?->nickname,
            'author_puntos' => $author?->perfilEstudiante?->puntos ?? 0,
        ]);
    }

    /**
     * Increment the dislikes count.
     */
    public function dislike(Consejo $consejo): JsonResponse
    {
        $consejo->increment('dislikes_count');

        return response()->json([
            'success' => true,
            'dislikes_count' => $consejo->dislikes_count,
        ]);
    }
}
