<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'premium_until',
        'paypal_subscription_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium_until' => 'datetime',
        ];
    }

    /**
     * Assign the default freemium role when one exists.
     */
    protected static function booted(): void
    {
        static::creating(function (self $user): void {
            if ($user->role_id !== null) {
                return;
            }

            $freeRoleId = Role::query()
                ->where('nombre', 'free')
                ->value('id');

            if ($freeRoleId !== null) {
                $user->role_id = $freeRoleId;
            }
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function perfilEstudiante(): HasOne
    {
        return $this->hasOne(PerfilEstudiante::class);
    }

    public function materias(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'materia_user')
                    ->withPivot('estado', 'grupo_materia_docente_id')
                    ->withTimestamps();
    }

    public function isPremium(): bool
    {
        if ($this->role && $this->role->nombre === 'admin') {
            return true;
        }

        if ($this->role && $this->role->nombre === 'premium') {
            if ($this->premium_until && now()->gt($this->premium_until)) {
                $freeRoleId = Role::query()->where('nombre', 'free')->value('id');
                if ($freeRoleId) {
                    $this->role_id = $freeRoleId;
                    $this->save();
                }
                return false;
            }
            return true;
        }

        return false;
    }
}
