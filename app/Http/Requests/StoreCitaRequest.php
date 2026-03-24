<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora'        => 'required',
            'motivo'      => 'nullable|string|max:500',
        ];
    }
}