<?php

namespace App\Http\Controllers;

use App\Models\ReporteMedico;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReporteMedicoController extends Controller
{
    /**
     * Listado general de reportes.
     */
    public function index()
    {
        // Cargamos la relación paciente para mostrar nombres en la tabla
        $reportes = ReporteMedico::with('paciente')->orderBy('fecha', 'desc')->get();
        return view('reportes.index', compact('reportes'));
    }

    /**
     * Formulario de creación de informe.
     */
    public function create(Request $request)
    {
        $paciente = null;
        
        // Si venimos desde el perfil del paciente, cargamos sus datos (incluyendo alergias)
        if ($request->has('paciente_id')) {
            $paciente = Paciente::findOrFail($request->paciente_id);
        }
        
        // Obtenemos todos los pacientes por si se genera el reporte desde el menú general
        $pacientes = Paciente::orderBy('apellido', 'asc')->get(); 
        
        return view('reportes.create', compact('paciente', 'pacientes'));
    }

    /**
     * Guarda el nuevo informe médico.
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'diagnostico' => 'required|string|max:1000',
            'cie_10'      => 'nullable|string|max:20',
        ]);

        // El campo "resumen_historia" (alergias) se extrae del modelo Paciente 
        // para asegurar que siempre esté actualizado al momento de guardar.
        ReporteMedico::create([
            'paciente_id'                => $request->paciente_id,
            'examen_fisico_preferencial' => $request->examen_fisico_preferencial,
            'examen_auxiliar'            => $request->examen_auxiliar,
            'diagnostico'                => $request->diagnostico,
            'cie_10'                     => $request->cie_10,
            'tratamiento'                => $request->tratamiento,
            'evolucion'                  => $request->evolucion,
            'recomendaciones'            => $request->recomendaciones,
            'fecha'                      => Carbon::now()->format('Y-m-d'),
            'doctor'                     => Auth::user()->name,
        ]);

        return redirect()->route('reportes.index')->with('success', '¡Informe médico generado y guardado con éxito! 📄');
    }

    /**
     * Muestra el informe médico para ver e imprimir.
     */
    public function show($id)
    {
        // Usamos eager loading para traer los datos del paciente y sus alergias
        $reporte = ReporteMedico::with('paciente')->findOrFail($id);
        
        return view('reportes.show', compact('reporte'));
    }

    /**
     * Elimina un informe médico.
     */
    public function destroy($id)
    {
        $reporte = ReporteMedico::findOrFail($id);
        $reporte->delete();

        return redirect()->route('reportes.index')->with('success', 'El informe médico ha sido eliminado.');
    }
}