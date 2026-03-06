<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Paciente;
use App\Models\User;

class ServicioRealizado extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, si sigue la convención de Laravel)
    protected $table = 'servicios_realizados';

    // Campos que se pueden llenar masivamente 📝
    protected $fillable = [
        'paciente_id', 
        'servicio', 
        'observacion', 
        'costo', 
        'comision', 
        'jaladora', 
        'asistente_id'
    ];

    /**
     * Relaciones de Eloquent 🔗
     */

    // Un servicio realizado pertenece a un paciente 👤
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Un servicio fue registrado por un asistente (modelo User) 👩‍⚕️
    public function asistente()
    {
        // Especificamos 'asistente_id' porque no sigue el nombre estándar 'user_id'
        return $this->belongsTo(User::class, 'asistente_id');
    }
}