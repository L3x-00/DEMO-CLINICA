<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PacienteController extends Controller
{
    /**
     * Muestra la lista de pacientes.
     * Implementa un filtro obligatorio por fecha (hoy por defecto)
     * e integra una barra de búsqueda sobre esos resultados.
     */
    public function index(Request $request)
    {
        // 1. Capturamos la fecha del filtro. Si no existe, usamos la fecha actual del sistema.
        $fechaBusqueda = $request->get('fecha', Carbon::now()->format('Y-m-d'));

        // 2. Iniciamos la consulta base (Query Builder)
        $query = Paciente::query();

        /**
         * FILTRO POR FECHA:
         * Compara solo la parte de la fecha (Y-m-d) de la columna 'created_at'.
         * Esto permite que el panel se mantenga "limpio" cada día nuevo.
         */
        $query->whereDate('created_at', $fechaBusqueda);

        /**
         * BARRA DE BÚSQUEDA:
         * Si el usuario escribe en el buscador, filtramos dentro de los resultados del día.
         * Buscamos coincidencias en Nombre, Apellido o DNI.
         */
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%$buscar%")
                  ->orWhere('apellido', 'LIKE', "%$buscar%")
                  ->orWhere('dni', 'LIKE', "%$buscar%");
            });
        }

        // 3. Ejecutamos la consulta ordenando por los más recientes primero
        $pacientes = $query->orderBy('created_at', 'desc')->get();

        // 4. Retornamos la vista pasando la colección y la fecha de búsqueda para el input date
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
     * Usa $request->all() asumiendo que el $fillable en el Modelo está correcto.
     */
    public function store(Request $request)
    {
        // Validación de datos obligatorios
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|min:8|max:20|unique:pacientes,dni', 
            'sexo' => 'required',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        // Creación masiva
        Paciente::create($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    /**
     * Muestra la ficha completa (Historia Clínica) de un paciente específico.
     */
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Muestra el formulario para editar los datos de un paciente existente.
     */
    public function edit(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Actualiza los datos en la base de datos.
     * El DNI ignora al paciente actual en la validación 'unique' para evitar errores al guardar.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni'      => 'required|min:8|max:20|unique:pacientes,dni,' . $id,
            'sexo'     => 'required',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Expediente actualizado correctamente.');
    }

    /**
     * Elimina el registro de un paciente (Borrado físico).
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado del sistema.');
    }
}