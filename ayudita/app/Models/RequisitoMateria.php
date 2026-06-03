<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitoMateria extends Model
{
    use HasFactory;

    protected $table = 'requisitos_materias';

    protected $fillable = [
        'materia_id',
        'requisito_id',
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function requisito(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'requisito_id');
    }
}