<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    /**
     * Muestra la lista de pacientes.
     */
    public function index(Request $request)
    {
        $fechaBusqueda = $request->get('fecha', Carbon::now()->format('Y-m-d'));
        $query = Paciente::query();
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%$buscar%")
                  ->orWhere('apellido', 'LIKE', "%$buscar%")
                  ->orWhere('dni', 'LIKE', "%$buscar%");
            });
            
        }else {
                // 2. Si NO está buscando nada, aplicamos el filtro de fecha por defecto
                $query->whereDate('created_at', $fechaBusqueda);
            }

        $pacientes = $query->orderBy('created_at', 'desc')->get();
        return view('pacientes.index', compact('pacientes', 'fechaBusqueda')); 
    }
    /**
     * Muestra el formulario para registrar un nuevo paciente.
     */
    public function create()
    {
        return view('pacientes.create');
    }
    /**
     * Almacena un nuevo paciente en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|min:8|max:20|unique:pacientes,dni', 
            'sexo' => 'required',
            'fecha_nacimiento' => 'nullable|date',
            'evidencia' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', 
        ]);
        // 2. Capturamos todos los datos en una variable
        $data = $request->all();

        // 3. Procesamos la imagen si existe
        if ($request->hasFile('evidencia')) {
            $path = $request->file('evidencia')->store('evidencias', 'public');
            $data['evidencia'] = $path; // Actualizamos el valor en nuestro array $data
        
            } 
        // 4. ERROR CORREGIDO: Usamos $data en lugar de $request->all()
        Paciente::create($data);
        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }
    /**
     * Muestra la ficha completa.
     */
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Actualiza los datos en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni'      => 'required|min:8|max:20|unique:pacientes,dni,' . $id,
            'sexo'     => 'required',
            'evidencia' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2096',
        ]);

        $paciente = Paciente::findOrFail($id);
        $data = $request->all();

        // Lógica para actualizar imagen
        if ($request->hasFile('evidencia')) {
            // Eliminar imagen vieja si existe para ahorrar espacio
            if ($paciente->evidencia) {
                Storage::disk('public')->delete($paciente->evidencia);
            }
            $path = $request->file('evidencia')->store('evidencias', 'public');
            $data['evidencia'] = $path;
        }

        // Usamos $data para incluir la nueva ruta de la imagen
        $paciente->update($data);

        return redirect()->route('pacientes.index')
            ->with('success', 'Expediente actualizado correctamente.');
    }

    /**
     * Elimina el registro de un paciente.
     */
    public function destroy(Paciente $paciente)
    {
        // Opcional: Eliminar la imagen del disco al borrar al paciente
        if ($paciente->evidencia) {
            Storage::disk('public')->delete($paciente->evidencia);
        }
        
        $paciente->delete();
        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado del sistema.');
    }
}