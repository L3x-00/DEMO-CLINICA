<?php

namespace App\Http\Controllers;

use App\Models\ServicioRealizado;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CajaController extends Controller
{
    /**
     * Ventana 1: Diagnóstico (Registro Clínico) 🩺
     * Muestra solo lo ocurrido el día de hoy para seguimiento rápido.
     */
    public function diagnosticoIndex(Request $request)
    {
        $servicios = ServicioRealizado::whereDate('created_at', Carbon::today())
            ->with('paciente')
            ->latest()
            ->get();

        return view('diagnostico.index', compact('servicios'));
    }

    /**
     * Ventana 2: Caja (Dashboard Financiero) 💰
     * Muestra el reporte de ingresos y egresos con filtros.
     */
    public function index(Request $request)
    {
        // 1. Capturamos el filtro de periodo (por defecto: hoy)
        $filtro = $request->get('periodo', 'hoy');
        $query = ServicioRealizado::query();

        // 2. Aplicamos la lógica de tiempo según la selección 🕒
        switch ($filtro) {
            case 'semana':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(), 
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'mes':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'hoy':
            default:
                $query->whereDate('created_at', Carbon::today());
                break;
        }

        // 3. Obtenemos los datos con Eager Loading
        $servicios = $query->with(['paciente', 'asistente'])->latest()->get();

        // 4. Calculamos los totales para las tarjetas de la vista Caja
        $ingresoBruto = $servicios->sum('costo');
        $totalComisiones = $servicios->sum('comision');
        $utilidadNeta = $ingresoBruto - $totalComisiones;

        return view('caja.index', compact(
            'servicios', 
            'ingresoBruto', 
            'totalComisiones', 
            'utilidadNeta', 
            'filtro'
        ));
    }

    /**
     * Guarda un nuevo registro (desde el modal de Diagnóstico o Caja) 📥
     */
    public function store(Request $request)
    {
        // Validación: Hacemos costo y comision opcionales para que el registro clínico pase sin problemas
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio'    => 'required|string|max:255',
            'costo'       => 'nullable|numeric|min:0',
            'comision'    => 'nullable|numeric|min:0',
            'jaladora'    => 'nullable|string|max:255',
            'observacion' => 'nullable|string',
        ]);

        // Creación del registro
        ServicioRealizado::create([
            'paciente_id'  => $validated['paciente_id'],
            'servicio'     => $validated['servicio'],
            'observacion'  => $validated['observacion'] ?? null,
            'costo'        => $validated['costo'] ?? 0, // Por defecto 0 si viene de Diagnóstico
            'comision'     => $validated['comision'] ?? 0, // Por defecto 0 si viene de Diagnóstico
            'jaladora'     => $validated['jaladora'] ?? 'Ninguna',
            'asistente_id' => auth()->id(), 
        ]);

        // Redirección inteligente: vuelve a la página desde donde se envió el formulario
        return redirect()->back()
            ->with('success', '¡Registro completado con éxito!');
    }

    /**
     * Endpoint para el buscador en tiempo real (JSON) 🔎
     */
    public function buscarPacientes(Request $request)
    {
        $term = $request->get('q');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $pacientes = Paciente::where('nombre', 'LIKE', "%{$term}%")
            ->orWhere('dni', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get(['id', 'nombre', 'dni']);

        return response()->json($pacientes);
    }
}