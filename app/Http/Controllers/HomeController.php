<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atencion; 
use Carbon\Carbon;
use App\Models\Cita;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();
        $mesActual = Carbon::now()->month;
        $servicioDoctor = 'Consulta Médica';

        // 1. Ingresos totales del mes actual
        $ingresosMes = Atencion::whereMonth('created_at', $mesActual)
            ->where('servicio', $servicioDoctor)
            ->where('estado', 'Atendido')
            ->sum('total_pagado');

        // 2. Cantidad de pacientes atendidos hoy
        $pacientesAtendidosHoy = Atencion::whereDate('created_at', $hoy)
            ->where('servicio', $servicioDoctor)
            ->where('estado', 'Atendido')
            ->count();

        // 3. Datos para el Gráfico
        $reporteSemanal = Atencion::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total_pagado) as total')
            )
            ->where('servicio', $servicioDoctor)
            ->where('estado', 'Atendido')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('fecha')
            ->orderBy('fecha', 'ASC')
            ->get();

        // --- ESTA ES LA PARTE QUE FALTABA ---
        // 4. Pacientes en espera para el Dashboard del Doctor
        $pacientesEnEspera = Atencion::with('paciente')
            ->where('servicio', $servicioDoctor)
            ->where('estado', 'En Espera') // Solo los que la asistente envió pero no han sido atendidos
            ->orderBy('created_at', 'asc')
            ->get();
        // -------------------------------------

        // 5. Mantenemos la agenda de próximas citas
        $proximasCitas = Cita::with('paciente')
            ->where('fecha', '>=', $hoy->format('Y-m-d'))
            ->where('estado', 'Pendiente')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(5)
            ->get();

        return view('home', compact(
            'ingresosMes', 
            'pacientesAtendidosHoy', 
            'reporteSemanal',
            'pacientesEnEspera', // Ahora sí existe
            'proximasCitas'
        ));
    }
}