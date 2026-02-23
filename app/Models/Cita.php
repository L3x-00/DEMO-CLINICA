<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cita extends Model
{
    // Definimos qué campos se pueden llenar masivamente
    protected $fillable = [
        'paciente_id', 
        'fecha', 
        'hora', 
        'motivo', 
        'observaciones', 
        'recetario', 
        'estado'
    ];

    /**
     * Una cita pertenece a un paciente. 👤
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }
}