<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atencion;

class AtencionController extends Controller
{
   public function derivar(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio' => 'required',
            'total_pagado' => 'required|numeric',
        ]);

        Atencion::create([
            'paciente_id' => $request->paciente_id,
            'servicio' => $request->servicio,
            'costo_servicio' => $request->servicio == 'Consulta Médica' ? 100 : $request->total_pagado,
            'total_pagado' => $request->total_pagado,
            // CAMBIO AQUÍ: Debe iniciar "En Espera" para que aparezca en el Dashboard
            'estado' => 'En Espera', 
            'doctor_id' => auth()->id(), 
        ]);

        return back()->with('success', 'Paciente derivado correctamente. Aparecerá en la lista de espera del doctor.');
    }
    public function completar($id)
    {
        $atencion = Atencion::findOrFail($id);
        $atencion->update(['estado' => 'Atendido']);

        return back()->with('success', 'Consulta finalizada. Los ingresos han sido actualizados.');
    }
}