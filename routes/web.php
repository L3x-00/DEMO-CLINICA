<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController; // 👈 ¡Esta es la clave!
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteMedicoController;
// 🏠 Ruta de Bienvenida (Página de inicio pública)
Route::get('/', function () {
    return view('welcome'); // Así se llamará nuestro nuevo archivo
});
// Rutas de Autenticación (Públicas)

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rutas Protegidas (Solo usuarios logueados) 🔐
Route::middleware(['auth'])->group(function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('reportes', ReporteMedicoController::class);   
Route::resource('pacientes', PacienteController::class);
    
    // Rutas de Citas
Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
Route::patch('/citas/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('citas.estado');
Route::patch('/citas/{id}/reprogramar', [App\Http\Controllers\CitaController::class, 'reprogramar'])->name('citas.reprogramar');
    
    // Esta es la ruta que llama el JavaScript de TomSelect 🔍
Route::get('/buscar-pacientes', [CitaController::class, 'buscarPaciente'])->name('pacientes.buscar');
Route::middleware(['auth'])->group(function () {
    // Esta línea crea automáticamente las 7 rutas del CRUD (incluyendo show, edit y destroy)
    Route::resource('citas', CitaController::class);

    // Mantenemos tu ruta personalizada para cambiar el estado desde el Home
    Route::patch('/citas/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('citas.estado');
    
    // Ruta para el buscador AJAX
    Route::get('/buscar-pacientes', [CitaController::class, 'buscarPaciente'])->name('pacientes.buscar');
});
});