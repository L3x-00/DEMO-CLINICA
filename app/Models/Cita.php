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
    /**
     * Obtener la clase de CSS de Bootstrap según el estado de la cita.
     */
    public function getEstadoColorAttribute(): string
    {
        return [
            'Pendiente'     => 'text-warning',
            'Concluido'     => 'text-success',
            'No presentado' => 'text-danger',
        ][$this->estado] ?? 'text-info';
    }

    /**
     * Retorna el texto con emoji según el estado
     */
    public function getEstadoTextoAttribute(): string
    {
        return [
            'Pendiente'     => '⏳ Pendiente',
            'Concluido'     => '✅ Concluido',
            'No presentado' => '❌ No asistió',
        ][$this->estado] ?? $this->estado;
    }
}
