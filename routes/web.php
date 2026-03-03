<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteMedicoController;

// 🏠 Ruta de Bienvenida (Página de inicio pública)
Route::get('/', function () {
    return view('welcome');
});
// --------------------------------------------------------------------------
// Rutas de Autenticación (Públicas)
// --------------------------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// --------------------------------------------------------------------------
// Rutas Protegidas (Requieren Login) 🔐
// --------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    // 1. Acceso Común (Doctor y Asistente)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('pacientes', PacienteController::class);
    // Gestión de Citas (CRUD completo para ambos)
    Route::resource('citas', CitaController::class);
    Route::patch('/citas/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('citas.estado');
    Route::patch('/citas/{id}/reprogramar', [CitaController::class, 'reprogramar'])->name('citas.reprogramar');
    Route::get('/buscar-pacientes', [CitaController::class, 'buscarPaciente'])->name('pacientes.buscar');
    // 2. Acceso Exclusivo (Solo Doctor) 🩺
    Route::middleware(['role:doctor'])->group(function () {
        // El asistente podrá ver la lista si quieres, pero no crear. 
        // Si quieres bloquear TODO el módulo de reportes, se queda aquí adentro:
        Route::resource('reportes', ReporteMedicoController::class);
        // Aquí puedes agregar rutas de estadísticas o borrado masivo en el futuro
    });

});