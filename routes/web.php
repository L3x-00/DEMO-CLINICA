<?php
use App\Http\Controllers\AtencionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteMedicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CajaController; 
use App\Http\Controllers\ConsultaController;

// 🏠 Rutas Públicas
Route::get('/', function () {
    return view('welcome');
});

// 🔑 Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 NIVEL 1: Rutas Protegidas (Solo requiere estar logueado)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Gestión General
    Route::resource('pacientes', PacienteController::class);
    Route::resource('citas', CitaController::class);
    
    // Operaciones Médicas y Caja
    Route::patch('/citas/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('citas.estado');
    Route::patch('/citas/{id}/reprogramar', [CitaController::class, 'reprogramar'])->name('citas.reprogramar');
    Route::get('/buscar-pacientes', [CitaController::class, 'buscarPaciente'])->name('pacientes.buscar');
    Route::get('/diagnostico', [CajaController::class, 'diagnosticoIndex'])->name('diagnostico.index');
    Route::get('/caja', [CajaController::class, 'index'])->name('caja.index');
    Route::post('/caja/guardar', [CajaController::class, 'store'])->name('caja.store');
    Route::get('/buscar-pacientes-json', [CajaController::class, 'buscarPacientes'])->name('pacientes.buscar.json');

    // Consultas Médicas (Eliminado el middleware auth redundante)
    Route::get('/consulta/nueva/{paciente_id}', [ConsultaController::class, 'create'])->name('consulta.create');
    Route::post('/consulta/guardar', [ConsultaController::class, 'store'])->name('consulta.store');
    Route::get('/consulta/ver/{id}', [ConsultaController::class, 'show'])->name('consulta.show');
    Route::put('/consulta/actualizar/{id}', [ConsultaController::class, 'update'])->name('consulta.update');
    Route::get('/consulta/editar/{id}', [ConsultaController::class, 'edit'])->name('consulta.edit');
    Route::get('/paciente/{paciente_id}/historial', [ConsultaController::class, 'historial'])->name('consulta.historial');

    // Atenciones
    Route::post('/atenciones/derivar', [AtencionController::class, 'derivar'])->name('atenciones.derivar');
    Route::patch('/atenciones/{id}/completar', [AtencionController::class, 'completar'])->name('atenciones.completar');

    // 🔐 NIVEL 2: Acceso por Rol (Solo Asistente/Admin)
    Route::middleware(['role:asistente'])->group(function () {
        Route::resource('reportes', ReporteMedicoController::class);
        Route::resource('usuarios', UsuarioController::class);
    });
});