<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'foto',
        'detalles_basicos',
        'calificacion',
    ];

    public function gruposMateriaDocente(): HasMany
    {
        return $this->hasMany(GrupoMateriaDocente::class);
    }
}