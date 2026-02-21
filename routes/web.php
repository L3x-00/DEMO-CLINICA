<?php

use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;

// Redirigir la raíz al listado de pacientes
Route::get('/', function () {
    return redirect()->route('pacientes.index');
});

// Ruta de recurso que conecta con todos los métodos del controlador
Route::resource('pacientes', PacienteController::class);