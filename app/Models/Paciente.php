<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    // Agregamos los campos que el formulario puede llenar ✍️
protected $fillable = [
    'tipo_documento', 
    'dni', 
    'nombre', 
    'apellido', 
    'sexo', 
    'fecha_nacimiento', 
    'edad', 
    'lugar_nacimiento', 
    'email', 
    'telefono', 
    'direccion', 
    'provincia', 
    'nacionalidad', 
    'distrito', 
    'profesion', 
    'lugar_laboral', 
    'ocupacion', 
    'estado_civil', 
    'alergias',
    'evidencia'

];

    // Tu relación con citas...
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
    
}

