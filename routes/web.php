<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Landing Page / Bienvenida
Route::get('/', function () {
    return view('welcome');
});

// 2. Dashboard Principal (Protegido por Autenticación)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Ruta de la Pasarela de Pago (Paywall)
// Accesible directamente cuando se presiona el botón "Mejorar a Pro"
Route::get('/premium-paywall', function () {
    // Si un usuario ya es Pro por alguna razón, lo redirigimos al dashboard
    if (Auth::user()->role_id !== 1) {
        return redirect()->route('dashboard');
    }
    return view('auth.premium-paywall');
})->middleware(['auth'])->name('paywall');

// 4. Ruta real de contenido protegido (Materias/Recursos Avanzados)
Route::get('/materias/{id}', function ($id) {
    $user = Auth::user();

    // Aquí defines qué IDs de materias van a requerir cuenta PRO (2, 3, 4, 5 y 6)
    $materiasPremium = [2, 3, 4, 5, 6];

    // Si la materia es Premium y el usuario es Free (role_id == 1), bloqueamos el acceso directo
    if (in_array($id, $materiasPremium) && $user->role_id == 1) {
        return view('auth.premium-paywall', [
            'title' => 'Contenido Bloqueado 🔒',
            'heading' => 'Esta asignatura requiere nivel PRO',
        ]);
    }

    // ¡AQUÍ ESTÁ EL CAMBIO! Cargamos la vista real pasándole el ID de la materia
    // Como tu archivo está en 'resources/views/layouts/materias.blade.php', lo llamamos como 'layouts.materias'
    return view('layouts.materias', [
        'materia_id' => $id
    ]);
})->middleware(['auth'])->name('materias.show');

// 5. Grupo de Rutas del Perfil de Usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';