<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrupoMateriaDocente extends Model
{
    use HasFactory;

    protected $table = 'grupo_materia_docente';

    protected $fillable = [
        'materia_id',
        'docente_id',
        'grupo_codigo',
        'calificacion',
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function consejos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Consejo::class, 'grupo_materia_docente_id');
    }
}