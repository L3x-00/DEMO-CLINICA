<?php
namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
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
        // 1. Validamos los datos (opcional pero recomendado)
        $request->validate([
            'paciente_id' => 'required',
            'motivo_consulta' => 'required'
        ]);

        // 2. Usamos $request->except('_token') para quitar el campo que causa el error
        $data = $request->except('_token');
        
        // 3. Creamos la consulta
        $consulta = new Consulta($data);
        
        // 4. Asignamos manualmente los datos del doctor autenticado
        $consulta->atendido_por = Auth::user()->name;
        $consulta->doctor_nombres = Auth::user()->first_name ?? Auth::user()->name;
        $consulta->doctor_apellidos = Auth::user()->last_name ?? '';
        
        $consulta->save();

        return redirect()->route('pacientes.index')->with('success', 'Consulta médica registrada con éxito');
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
    // Obtenemos las consultas ordenadas por la más reciente
    $consultas = Consulta::where('paciente_id', $paciente_id)
                         ->orderBy('created_at', 'desc')
                         ->get();

    return view('consulta.index', compact('paciente', 'consultas'));
}
}