<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
{
    // 1. IMPORTANTE: Cambiar a true para permitir que se use
    public function authorize(): bool
    {
        return true; 
    }

    // 2. Aquí mueves todas las reglas que tenías en el Controller
    public function rules(): array
    {
        return [
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni'      => 'required|string|unique:pacientes,dni,' . ($this->paciente ?? ''),
            'telefono' => 'nullable|string|max:20',
            'email'    => 'nullable|email',
            'fecha_nacimiento' => 'required|date',
        ];
    }

    // 3. OPCIONAL: Personaliza los mensajes de error
    public function messages(): array
    {
        return [
            'dni.unique' => 'Este número de DNI ya está registrado en el sistema.',
            'nombre.required' => 'El nombre del paciente es obligatorio.',
        ];
    }
}