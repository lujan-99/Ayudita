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
        'carnet_identidad',
        'carnet_universitario',
        'formulario_completo',
        'tour_visto',
        'nickname',
        'puntos',
    ];

    protected function casts(): array
    {
        return [
            'semestre_actual' => 'integer',
            'formulario_completo' => 'boolean',
            'tour_visto' => 'boolean',
            'puntos' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $perfil): void {
            if (empty($perfil->nickname)) {
                $perfil->nickname = self::generateUniqueNickname();
            }
        });
    }

    public static function generateUniqueNickname(): string
    {
        $animals = ['Perro', 'Gato', 'Zorro', 'Leon', 'Oso', 'Lobo', 'Aguila', 'Halcon', 'Tigre', 'Delfin', 'Tiburon', 'Puma', 'Buho', 'Condor', 'Jaguar', 'Conejo', 'Tortuga', 'Koala', 'Panda', 'Canguro'];
        $adjectives = ['Loco', 'Feliz', 'Rapido', 'Valiente', 'Sabio', 'Astuto', 'Silencioso', 'Feroz', 'Fiel', 'Agil', 'Atento', 'Noble', 'Fuerte', 'Sereno', 'Activo', 'Curioso', 'Divertido', 'Pensativo', 'Aventurero', 'Paciente'];

        $attempts = 0;
        do {
            $animal = $animals[array_rand($animals)];
            $adjective = $adjectives[array_rand($adjectives)];
            $nickname = "El " . $animal . " " . $adjective;
            
            if ($attempts > 5) {
                $nickname .= " " . rand(100, 999);
            }
            
            $exists = self::where('nickname', $nickname)->exists();
            $attempts++;
        } while ($exists);

        return $nickname;
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