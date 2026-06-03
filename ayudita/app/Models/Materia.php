<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrera_id',
        'codigo',
        'nombre',
        'semestre',
    ];

    protected function casts(): array
    {
        return [
            'semestre' => 'integer',
        ];
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function requisitosComoObjetivo(): HasMany
    {
        return $this->hasMany(RequisitoMateria::class, 'materia_id');
    }

    public function esRequisitoDe(): HasMany
    {
        return $this->hasMany(RequisitoMateria::class, 'requisito_id');
    }

    public function prerequisitos(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'requisitos_materias', 'materia_id', 'requisito_id');
    }

    public function materiasQueLaRequieren(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'requisitos_materias', 'requisito_id', 'materia_id');
    }

    public function gruposMateriaDocente(): HasMany
    {
        return $this->hasMany(GrupoMateriaDocente::class);
    }
}