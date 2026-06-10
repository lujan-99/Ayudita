<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocenteComentario extends Model
{
    protected $fillable = [
        'user_id',
        'docente_id',
        'comentario',
        'calificacion',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function docente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }
}
