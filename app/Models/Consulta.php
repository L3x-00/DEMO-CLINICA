<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'numero_consulta',
        'fecha_registro',
        'hora_registro',
        'edad_momento',
        'motivo_consulta',
        'tiempo_enfermedad',
        'apetito',
        'sed',
        'sueno',
        'estado_animo',
        'orina',
        'deposiciones',
        'examen_fisico',
        'temperatura',
        'presion_arterial',
        'frecuencia_respiratoria',
        'frecuencia_cardiaca',
        'peso',
        'talla',
        'diagnostico',
        'tratamiento',
        'examenes_auxiliares',
        'referencia_lugar_motivo',
        'proxima_cita',
        'atendido_por',
        'doctor_nombres',
        'doctor_apellidos',
        'observacion'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}