<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

// 1. Landing Page / Bienvenida
Route::get('/', function () {
    $instagramId = config('services.instagram.business_id');
    $pageId = config('services.instagram.page_id');
    $accessToken = config('services.instagram.access_token');
    
    $cacheKey = 'social_latest_posts_' . md5($accessToken . '_' . $instagramId . '_' . $pageId);

    $posts = [];
    try {
        $posts = Cache::remember($cacheKey, 1800, function () use ($instagramId, $pageId, $accessToken) {
            if (!$accessToken) {
                return [];
            }

            $allPosts = [];

            // 1. Fetch Instagram Posts
            if ($instagramId) {
                try {
                    $response = Http::timeout(5)->get("https://graph.facebook.com/v20.0/{$instagramId}/media", [
                        'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
                        'limit' => 3,
                        'access_token' => $accessToken,
                    ]);
                    
                    if ($response->successful()) {
                        $igData = $response->json()['data'] ?? [];
                        foreach ($igData as $post) {
                            $mediaUrl = $post['media_url'] ?? '';
                            if (($post['media_type'] ?? '') === 'VIDEO' && isset($post['thumbnail_url'])) {
                                $mediaUrl = $post['thumbnail_url'];
                            }
                            $allPosts[] = [
                                'source' => 'instagram',
                                'id' => $post['id'],
                                'text' => $post['caption'] ?? '',
                                'image' => $mediaUrl,
                                'link' => $post['permalink'] ?? 'https://www.instagram.com/ayuditausfx/',
                                'timestamp' => strtotime($post['timestamp'] ?? 'now'),
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error('Error fetching Instagram media: ' . $e->getMessage());
                }
            }

            // 2. Fetch Facebook Page Posts
            if ($pageId) {
                try {
                    $response = Http::timeout(5)->get("https://graph.facebook.com/v20.0/{$pageId}/feed", [
                        'fields' => 'id,message,created_time,full_picture,permalink_url',
                        'limit' => 3,
                        'access_token' => $accessToken,
                    ]);
                    
                    if ($response->successful()) {
                        $fbData = $response->json()['data'] ?? [];
                        foreach ($fbData as $post) {
                            if (isset($post['message']) || isset($post['full_picture'])) {
                                $allPosts[] = [
                                    'source' => 'facebook',
                                    'id' => $post['id'],
                                    'text' => $post['message'] ?? '',
                                    'image' => $post['full_picture'] ?? '',
                                    'link' => $post['permalink_url'] ?? "https://www.facebook.com/{$pageId}",
                                    'timestamp' => strtotime($post['created_time'] ?? 'now'),
                                ];
                            }
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error('Error fetching Facebook feed: ' . $e->getMessage());
                }
            }

            // Sort combined posts by timestamp descending
            usort($allPosts, function ($a, $b) {
                return $b['timestamp'] <=> $a['timestamp'];
            });

            return $allPosts;
        });
    } catch (\Exception $e) {
        logger()->error('Cache error on landing page: ' . $e->getMessage());
        $posts = [];
    }

    return view('welcome', compact('posts'));
});

// Rutas de Términos y Privacidad
Route::get('/terminos-condiciones', function () {
    return view('terminos');
})->name('terminos');

Route::get('/politica-privacidad', function () {
    return view('privacidad');
})->name('privacidad');

use App\Http\Controllers\PlanEstudiosController;
use App\Http\Controllers\DocenteController as StudentDocenteController;
use App\Http\Controllers\DashboardController;

// 2. Dashboard Principal (Protegido por Autenticación)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Ruta del Plan de Estudios Interactivo (Grafo)
Route::get('/plan-estudios', [PlanEstudiosController::class, 'show'])->middleware(['auth'])->name('plan-estudios');

// Ruta del Listado de Docentes para estudiantes
Route::get('/docentes', [StudentDocenteController::class, 'index'])->middleware(['auth'])->name('docentes.index');
Route::get('/docentes/{id}', [StudentDocenteController::class, 'show'])->middleware(['auth'])->name('docentes.show');
Route::post('/docentes/{id}/comentarios', [StudentDocenteController::class, 'storeComentario'])->middleware(['auth'])->name('docentes.comentarios.store');

// Ruta API para obtener materias de una carrera (usada en registro)
Route::get('/api/carreras/{carrera}/materias', [PlanEstudiosController::class, 'getMateriasJson'])->name('api.carreras.materias');
// 3. Ruta de la Pasarela de Pago (Paywall)
Route::get('/premium-paywall', function () {
    if (Auth::user()->isPremium()) {
        return redirect()->route('dashboard');
    }
    return view('auth.premium-paywall');
})->middleware(['auth'])->name('paywall');

Route::post('/paypal/checkout/completed', [App\Http\Controllers\PayPalController::class, 'completed'])
    ->middleware(['auth'])
    ->name('paypal.completed');

Route::post('/premium/redeem-points', [App\Http\Controllers\PayPalController::class, 'redeemPoints'])
    ->middleware(['auth'])
    ->name('premium.redeem_points');

// 4. Ruta real de contenido (Materias/Recursos) - Desbloqueado para todos
Route::get('/materias', [App\Http\Controllers\MateriaController::class, 'index'])->middleware(['auth'])->name('materias.index');

Route::get('/materias/{id}', function ($id) {
    $user = auth()->user();

    // 1. Verify student is taking this subject
    $userMateria = $user->materias()
        ->where('materia_id', $id)
        ->wherePivot('estado', 'cursando')
        ->first();

    if (!$userMateria) {
        abort(403, 'No estás cursando esta asignatura.');
    }

    $userGroupId = $userMateria->pivot->grupo_materia_docente_id;
    if (!$userGroupId) {
        abort(403, 'No tienes un grupo asignado para esta materia.');
    }

    // 2. Load subject and filter groups and teacher card info
    $materia = \App\Models\Materia::with(['carrera', 'gruposMateriaDocente.docente'])->findOrFail($id);
    
    // Get only the group the student belongs to
    $selectedGroup = $materia->gruposMateriaDocente->firstWhere('id', $userGroupId);

    // Get only the consejos belonging to this subject and this student's group
    $consejos = \App\Models\Consejo::with(['user.perfilEstudiante', 'grupoMateriaDocente.docente'])
        ->where('materia_id', $id)
        ->where('grupo_materia_docente_id', $userGroupId)
        ->latest()
        ->get();

    return view('materias.show', [
        'materia' => $materia,
        'materia_id' => $id,
        'selectedGroup' => $selectedGroup,
        'consejos' => $consejos,
        'userGroupId' => $userGroupId,
    ]);
})->middleware(['auth'])->name('materias.show');

// Rutas de Consejos y Recursos
Route::middleware(['auth'])->group(function () {
    Route::post('/materias/{materia}/consejos', [App\Http\Controllers\ConsejoController::class, 'store'])->name('consejos.store');
    Route::post('/consejos/{consejo}/like', [App\Http\Controllers\ConsejoController::class, 'like'])->name('consejos.like');
    Route::post('/consejos/{consejo}/dislike', [App\Http\Controllers\ConsejoController::class, 'dislike'])->name('consejos.dislike');
});

// 5. Grupo de Rutas del Perfil de Usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CarreraController;
use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GrupoController;

// 6. Grupo de Rutas de Administración
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('carreras/{carrera}/import', [CarreraController::class, 'showImport'])->name('carreras.import');
    Route::post('carreras/{carrera}/import', [CarreraController::class, 'importPlan'])->name('carreras.import.post');
    Route::resource('carreras', CarreraController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
});

require __DIR__.'/auth.php';