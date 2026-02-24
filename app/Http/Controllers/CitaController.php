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
        $citas = Cita::with('paciente')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();
        
        return view('citas.index', compact('citas'));
    }

    /**
     * Muestra el detalle de una cita específica (BOTÓN OJO).
     */
    public function show($id)
    {
        $cita = Cita::with('paciente')->findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create(Request $request)
    {
        $pacientePreseleccionado = null;
        if ($request->has('paciente_id')) {
            $pacientePreseleccionado = Paciente::find($request->paciente_id);
        }

        return view('citas.create', compact('pacientePreseleccionado'));
    }

    /**
     * Guarda la nueva cita.
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora'        => 'required',
            'motivo'      => 'nullable|string|max:500',
        ]);

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
     * Muestra el formulario de edición (BOTÓN LÁPIZ).
     */
    public function edit($id)
    {
        $cita = Cita::with('paciente')->findOrFail($id);
        return view('citas.edit', compact('cita'));
    }

    /**
     * Procesa la actualización de la cita (Formulario de Editar).
     */
    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $request->validate([
            'fecha'  => 'required|date',
            'hora'   => 'required',
            'estado' => 'required|in:Pendiente,Concluido,No presentado,Reprogramado',
            'motivo' => 'nullable|string|max:500',
        ]);

        $cita->update($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    /**
     * Elimina la cita de la base de datos (BOTÓN BASURA).
     */
    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'La cita ha sido eliminada.');
    }

    /**
     * Actualiza solo el estado (Usado en el Home y Dropdowns).
     */
    public function cambiarEstado(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        
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

        $pacientes = Paciente::where('nombre', 'LIKE', "%$term%")
            ->orWhere('apellido', 'LIKE', "%$term%")
            ->orWhere('dni', 'LIKE', "%$term%")
            ->limit(10)
            ->get(['id', 'nombre', 'apellido', 'dni']); 

        return response()->json($pacientes);
    }
}