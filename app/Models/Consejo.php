<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consejo extends Model
{
    use HasFactory;

    protected $table = 'consejos';

    protected $fillable = [
        'materia_id',
        'grupo_materia_docente_id',
        'user_id',
        'contenido',
        'tipo',
        'archivo_path',
        'archivo_nombre',
        'likes_count',
        'dislikes_count',
        'validado',
    ];

    protected function casts(): array
    {
        return [
            'validado' => 'boolean',
            'likes_count' => 'integer',
            'dislikes_count' => 'integer',
        ];
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function grupoMateriaDocente(): BelongsTo
    {
        return $this->belongsTo(GrupoMateriaDocente::class, 'grupo_materia_docente_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
