<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    // Permitimos que estos campos se llenen masivamente desde el formulario
    protected $fillable = ['nombre', 'apellido', 'dni', 'telefono', 'historial_medico'];
}