<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // Mostrar la lista de pacientes
    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    // Mostrar el formulario para crear
    public function create()
    {
        return view('pacientes.create');
    }

    // Guardar el paciente en la BD
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|digits:8|unique:pacientes',
        ]);

        Paciente::create($request->all());
        return redirect()->route('pacientes.index')->with('success', 'Paciente creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un paciente específico.
     */
    public function edit(string $id)
    {
        // Usamos findOrFail para que si el ID no existe, mande un error 404
        $paciente = Paciente::findOrFail($id);
        
        // Retornamos la vista 'edit' enviando los datos del paciente
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Actualiza los datos del paciente en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        // Validamos: El DNI debe ser único pero ignorando el ID del paciente actual
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|digits:8|unique:pacientes,dni,' . $id,
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Datos del paciente actualizados correctamente.');
    }

    // Eliminar un paciente
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado.');
    }
}