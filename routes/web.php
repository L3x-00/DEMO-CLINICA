<?php
use App\Http\Controllers\AtencionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteMedicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CajaController; // ✅ Importación correcta
use App\Http\Controllers\ConsultaController;
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
    Route::middleware(['auth'])->group(function () {
        Route::get('/consulta/nueva/{paciente_id}', [ConsultaController::class, 'create'])->name('consulta.create');
        Route::post('/consulta/guardar', [ConsultaController::class, 'store'])->name('consulta.store');
        Route::get('/consulta/ver/{id}', [ConsultaController::class, 'show'])->name('consulta.show');
        Route::put('/consulta/actualizar/{id}', [ConsultaController::class, 'update'])->name('consulta.update');
        Route::get('/consulta/editar/{id}', [ConsultaController::class, 'edit'])->name('consulta.edit');
        Route::get('/paciente/{paciente_id}/historial', [ConsultaController::class, 'historial'])->name('consulta.historial');
    });
    Route::post('/atenciones/derivar', [AtencionController::class, 'derivar'])->name('atenciones.derivar');
    Route::patch('/atenciones/{id}/completar', [App\Http\Controllers\AtencionController::class, 'completar'])->name('atenciones.completar');
});