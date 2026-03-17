<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    // Esto le dice a Laravel: "Confío en el desarrollador, deja guardar todos los campos"
    protected $guarded = [];

    // Relación con el paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}