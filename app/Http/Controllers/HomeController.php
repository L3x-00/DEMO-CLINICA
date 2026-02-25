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
    $hoy = date('Y-m-d');
    $ayer = date('Y-m-d', strtotime("-1 days"));

    // 1. Estadísticas para los gráficos
    $citasHoyCount = \App\Models\Cita::whereDate('fecha', $hoy)->count();
    $citasAyerCount = \App\Models\Cita::whereDate('fecha', $ayer)->count();
    
    // Citas atendidas (Concluidas) de hoy vs ayer
    $atendidosHoy = \App\Models\Cita::whereDate('fecha', $hoy)->where('estado', 'Concluido')->count();
    $atendidosAyer = \App\Models\Cita::whereDate('fecha', $ayer)->where('estado', 'Concluido')->count();

    // 2. Agenda de los próximos 7 días (tu lógica anterior)
    $proximasCitas = \App\Models\Cita::with('paciente')
        ->where('fecha', '>=', $hoy)
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->take(10)
        ->get();

    return view('home', compact(
        'citasHoyCount', 
        'atendidosHoy', 
        'atendidosAyer', 
        'citasAyerCount',
        'proximasCitas'
    ));
}
}