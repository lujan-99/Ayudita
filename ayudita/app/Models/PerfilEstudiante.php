<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfilEstudiante extends Model
{
    use HasFactory;

    protected $table = 'perfiles_estudiantes';

    protected $fillable = [
        'user_id',
        'carrera_id',
        'semestre_actual',
        'formulario_completo',
        'tour_visto',
    ];

    protected function casts(): array
    {
        return [
            'semestre_actual' => 'integer',
            'formulario_completo' => 'boolean',
            'tour_visto' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }
}