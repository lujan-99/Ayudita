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
            'etiqueta' => ['required_with:archivo', 'nullable', 'string', 'in:Primer Parcial,Segundo Parcial,Examen Final,Laboratorio,Práctica,Otro / Apuntes'],
        ]);

        // 3. Handle File Upload (directly to public directory and database base64)
        $filePath = null;
        $fileOriginalName = null;
        $fileBase64 = null;
        $fileMime = null;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileOriginalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Encode file as base64 for database storage persistence
            $fileBase64 = base64_encode(file_get_contents($file->getRealPath()));
            $fileMime = $file->getMimeType();

            // Ensure directory exists for local fallback/testing
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
            'archivo_base64' => $fileBase64,
            'archivo_mime' => $fileMime,
            'likes_count' => 0,
            'dislikes_count' => 0,
            'validado' => false,
            'etiqueta' => $filePath ? $request->etiqueta : null,
        ]);

        // 5. Award Points (Dynamic depending on file and category)
        $puntos = 5;
        if ($filePath) {
            $puntos = match ($request->etiqueta) {
                'Examen Final', 'Segundo Parcial' => 25,
                'Primer Parcial' => 20,
                'Laboratorio', 'Práctica' => 15,
                default => 10,
            };
        }

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

    /**
     * Securely stream file preview inline.
     */
    public function showArchivo(Consejo $consejo)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $user = auth()->user();
        if (!$user->isPremium() && $user->id !== $consejo->user_id) {
            abort(403, 'Debes ser Premium para ver este archivo.');
        }

        // Serve from database base64 if available
        if ($consejo->archivo_base64) {
            $fileData = base64_decode($consejo->archivo_base64);
            $mimeType = $consejo->archivo_mime ?? 'application/octet-stream';

            return response($fileData)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $consejo->archivo_nombre . '"');
        }

        // Fallback to disk if base64 is not populated
        if ($consejo->archivo_path && file_exists(public_path($consejo->archivo_path))) {
            $mimeType = mime_content_type(public_path($consejo->archivo_path)) ?: 'application/octet-stream';
            return response()->file(public_path($consejo->archivo_path), [
                'Content-Type' => $mimeType,
            ]);
        }

        abort(404, 'El archivo no existe.');
    }

    /**
     * Securely download file as attachment.
     */
    public function download(Consejo $consejo)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $user = auth()->user();
        if (!$user->isPremium() && $user->id !== $consejo->user_id) {
            abort(403, 'Debes ser Premium para descargar este archivo.');
        }

        // Serve from database base64 if available
        if ($consejo->archivo_base64) {
            $fileData = base64_decode($consejo->archivo_base64);
            $mimeType = $consejo->archivo_mime ?? 'application/octet-stream';
            $fileName = $consejo->archivo_nombre ?? 'archivo';

            return response($fileData)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        }

        // Fallback to disk if base64 is not populated
        if ($consejo->archivo_path && file_exists(public_path($consejo->archivo_path))) {
            return response()->download(public_path($consejo->archivo_path), $consejo->archivo_nombre);
        }

        abort(404, 'El archivo no existe.');
    }
}
