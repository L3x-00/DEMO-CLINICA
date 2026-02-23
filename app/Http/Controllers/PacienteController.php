<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Mostrar la lista de pacientes con opción de búsqueda y ordenados por recientes.
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        $pacientes = Paciente::when($buscar, function ($query, $buscar) {
            return $query->where('dni', 'LIKE', "%$buscar%")
                         ->orWhere('apellido', 'LIKE', "%$buscar%")
                         ->orWhere('nombre', 'LIKE', "%$buscar%");
        })
        ->latest() 
        ->paginate(10); 

        return view('pacientes.index', compact('pacientes', 'buscar'));
    }

    /**
     * Mostrar el formulario para crear un nuevo paciente.
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Guardar el paciente con TODOS los nuevos campos médicos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|min:8|max:20|unique:pacientes,dni', 
            'sexo' => 'required',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        Paciente::create($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
    }

    /**
     * Mostrar el detalle completo del paciente (Botón del Ojo).
     */
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Muestra el formulario para editar.
     */
    public function edit(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Actualiza los datos del paciente.
     */
    public function update(Request $request, string $id)
    {
        // CORRECCIÓN AQUÍ: Se añadió la coma y el nombre de la columna para la validación unique
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|min:8|max:20|unique:pacientes,dni,' . $id,
            'sexo' => 'required',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Expediente actualizado correctamente.');
    }

    /**
     * Eliminar un paciente.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado del sistema.');
    }
}