<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCitaRequest;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Cita;
use Carbon\Carbon;

class CitaController extends Controller
{
    /**
     * Muestra la lista de todas las citas programadas con buscador global.
     */
    public function index(Request $request)
    {
        $fechaBusqueda = $request->get('fecha', Carbon::now()->format('Y-m-d'));
        
        // Seleccionamos solo las columnas necesarias del paciente para ahorrar memoria
        $query = Cita::with(['paciente:id,nombre,apellido,dni']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('paciente', function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%$buscar%")
                  ->orWhere('apellido', 'LIKE', "%$buscar%")
                  ->orWhere('dni', 'LIKE', "%$buscar%");
            });
        } else {
            $query->whereDate('fecha', $fechaBusqueda);
        }

        // Ordenamos y ejecutamos
        $citas = $query->orderBy('fecha', 'asc')
                       ->orderBy('hora', 'asc')
                       ->get();
        
        return view('citas.index', compact('citas', 'fechaBusqueda'));
    }

    /**
     * Muestra el detalle de una cita específica (BOTÓN OJO).
     */
    public function show($id)
    {
        // Cargamos la relación completa aquí porque en el show sí solemos ver todo el perfil
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
    public function store(StoreCitaRequest $request) // <-- Usas tu nueva clase aquí
    {
        // Si el código llega aquí, los datos YA SON VÁLIDOS.
        // Si fallan, Laravel redirige atrás automáticamente con los errores.
        
        Cita::create($request->validated()); // Solo usa los datos que pasaron la regla

        return redirect()->route('citas.index')
            ->with('success', '¡Cita programada con éxito! 😊');
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
     * Procesa la actualización de la cita.
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
     * Actualiza solo el estado.
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

    public function reprogramar(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
        ]);

        $cita = Cita::findOrFail($id);
        
        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'Reprogramado',
            'observaciones' => $cita->observaciones . "\n-- Motivo Reprogramación: " . $request->motivo
        ]);

        return redirect()->back()->with('success', 'La cita ha sido reprogramada con éxito.');
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