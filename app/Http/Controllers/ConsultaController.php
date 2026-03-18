<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Atencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function create($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        $user = Auth::user();
        
        // Obtener el último número de consulta y sumar 1
        $ultimoNumero = Consulta::max('numero_consulta') ?? 0;
        $nuevoNumero = $ultimoNumero + 1;

        return view('consulta.create', compact('paciente', 'user', 'nuevoNumero'));
    }

    public function store(Request $request)
    {
        // 1. Validación de campos obligatorios en el formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'motivo_consulta' => 'required|string',
            'diagnostico' => 'required|string',
        ]);

        // 2. Obtener datos del paciente para autocompletar
        $paciente = Paciente::findOrFail($request->paciente_id);
        $user = Auth::user();

        // 3. Preparar todos los datos para la inserción
        $data = $request->except('_token');

        // 4. Forzar datos obligatorios de la DB (Autocompletado)
        $data['fecha_registro'] = now()->format('Y-m-d');
        $data['hora_registro']  = now()->format('H:i:s');
        $data['numero_consulta'] = $request->numero_consulta ?? ((Consulta::max('numero_consulta') ?? 0) + 1);
        
        // Edad al momento de la consulta (Importante para el histórico)
        $data['edad_momento'] = $paciente->edad . " años"; 

        // Datos del Doctor (Aseguramos que no viajen vacíos)
        $data['atendido_por']    = $user->name;
        $data['doctor_nombres']  = $user->name; 
        $data['doctor_apellidos'] = $user->last_name ?? 'Médico'; 

        // 5. Crear la consulta
        Consulta::create($data);

        // 6. Actualizar el estado en la tabla de Atenciones/Derivaciones
        Atencion::where('paciente_id', $paciente->id)
            ->where('estado', 'En Espera')
            ->update(['estado' => 'Atendido']);

        return redirect()->route('pacientes.index')
            ->with('success', 'Consulta de ' . $paciente->nombre . ' registrada y atención finalizada con éxito.');
    }
    public function edit($id)
    {
        $consulta = Consulta::with('paciente')->findOrFail($id);
        return view('consulta.edit', compact('consulta'));
    }
    public function show($id)
    {
        $consulta = Consulta::with('paciente')->findOrFail($id);
        return view('consulta.show', compact('consulta'));
    }

    public function update(Request $request, $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update($request->all());

        return redirect()->route('consulta.show', $id)
            ->with('success', 'La consulta ha sido actualizada correctamente.');
    }

    public function historial($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        $consultas = Consulta::where('paciente_id', $paciente_id)
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('consulta.index', compact('paciente', 'consultas'));
    }
}