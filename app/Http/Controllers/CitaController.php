<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Cita;

class CitaController extends Controller
{
    /**
     * Muestra la lista de todas las citas programadas.
     */
    public function index()
    {
        // Cargamos la relación 'paciente' (Eager Loading) para evitar múltiples consultas a la BD
        $citas = Cita::with('paciente')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();
        
        return view('citas.index', compact('citas'));
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     * Soporta pre-selección de paciente vía URL (?paciente_id=X).
     */
    public function create(Request $request)
    {
        $pacientePreseleccionado = null;
        
        // Si recibimos un ID por la URL, buscamos al paciente para mostrar sus datos en la vista
        if ($request->has('paciente_id')) {
            $pacientePreseleccionado = Paciente::find($request->paciente_id);
        }

        return view('citas.create', compact('pacientePreseleccionado'));
    }

    /**
     * Guarda la nueva cita en la base de datos.
     */
    public function store(Request $request)
    {
        // Validamos los datos 🛡️
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora'        => 'required',
            'motivo'      => 'nullable|string|max:500',
        ]);

        // Creamos el registro
        Cita::create([
            'paciente_id' => $request->paciente_id,
            'fecha'       => $request->fecha,
            'hora'        => $request->hora,
            'motivo'      => $request->motivo,
            'estado'      => 'Pendiente', 
        ]);

        return redirect()->route('citas.index')->with('success', '¡Cita programada con éxito! 😊');
    }

    /**
     * Actualiza el estado de una cita (Pendiente, Concluido, etc.).
     */
    public function cambiarEstado(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        
        // Validamos que el estado enviado sea uno de los permitidos en tu ENUM de la BD
        $request->validate([
            'estado' => 'required|in:Pendiente,Concluido,No presentado,Reprogramado'
        ]);

        $cita->estado = $request->estado;
        $cita->save();

        return back()->with('success', 'Estado de la cita actualizado correctamente.');
    }

    /**
     * Motor de búsqueda AJAX para TomSelect.
     */
    public function buscarPaciente(Request $request)
    {
        $term = $request->get('q'); 

        if (!$term) {
            return response()->json([]);
        }

        // Buscamos por nombre, apellido o DNI
        $pacientes = Paciente::where('nombre', 'LIKE', "%$term%")
            ->orWhere('apellido', 'LIKE', "%$term%")
            ->orWhere('dni', 'LIKE', "%$term%")
            ->limit(10) // Limitamos a 10 resultados para mayor velocidad
            ->get(['id', 'nombre', 'apellido', 'dni']); 

        return response()->json($pacientes);
    }
}