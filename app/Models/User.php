<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // <--- AGREGAR ESTO

class User extends Authenticatable implements JWTSubject // <--- AGREGAR "implements JWTSubject"
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        ];
    }

    /**
     * MÉTODOS OBLIGATORIOS PARA JWT
     */

    public function getJWTIdentifier()
    {
        // Devuelve el ID del usuario
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Puedes añadir datos extra al token aquí si quieres (ej. 'role' => 'admin')
        return [];
    }
}