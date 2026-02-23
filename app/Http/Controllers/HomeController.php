<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita; 
use Carbon\Carbon;   

class HomeController extends Controller
{
    // Borramos el constructor para evitar el error del middleware

    public function index()
    {
        $hoy = Carbon::today();
        $dentroDeSieteDias = Carbon::today()->addDays(7);

        // Contamos cuántas citas hay hoy
        $citasHoyCount = Cita::whereDate('fecha', $hoy)->count();

        // Solo traer citas que NO estén concluidas ni canceladas para el Dashboard
        $proximasCitas = Cita::with('paciente')
            ->whereBetween('fecha', [$hoy, $dentroDeSieteDias])
            ->whereIn('estado', ['Pendiente', 'Reprogramado']) // 👈 Filtro inteligente
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();

        return view('home', compact('citasHoyCount', 'proximasCitas'));
    }
}