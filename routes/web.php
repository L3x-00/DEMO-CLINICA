<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteMedicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CajaController; // ✅ Importación correcta
// 🏠 Ruta de Bienvenida (Pública)
Route::get('/', function () {
    return view('welcome');
});
// 🔑 Rutas de Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// 🔐 Rutas Protegidas (Requieren Login)
Route::middleware(['auth'])->group(function () {
    // 1. Acceso Común (Doctor y Asistente) 📋
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Gestión de Pacientes y Citas
    Route::resource('pacientes', PacienteController::class);
    Route::resource('citas', CitaController::class);
    // Rutas específicas de Citas
    Route::patch('/citas/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('citas.estado');
    Route::patch('/citas/{id}/reprogramar', [CitaController::class, 'reprogramar'])->name('citas.reprogramar');
    Route::get('/buscar-pacientes', [CitaController::class, 'buscarPaciente'])->name('pacientes.buscar');
    // --- 🟢 Módulo de Caja y Diagnóstico (Separados) ---
    // Ventana de Diagnóstico (Registro Clínico)
    Route::get('/diagnostico', [CajaController::class, 'diagnosticoIndex'])->name('diagnostico.index');
    // Ventana de Caja (Dashboard Financiero)
    Route::get('/caja', [CajaController::class, 'index'])->name('caja.index');
    // Acciones Comunes
    Route::post('/caja/guardar', [CajaController::class, 'store'])->name('caja.store');
    Route::get('/buscar-pacientes-json', [CajaController::class, 'buscarPacientes'])->name('pacientes.buscar.json');
    // --------------------------------------------------
    // 2. Acceso Exclusivo (Solo Doctor) 🩺
    Route::middleware(['role:asistente'])->group(function () {
        Route::resource('reportes', ReporteMedicoController::class);
        Route::resource('usuarios', UsuarioController::class);
    });

});