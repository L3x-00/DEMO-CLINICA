@extends('layouts.app') {{-- Asumiendo que usas un layout principal --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Mensajes de Éxito o Error --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card shadow border-0 overflow-hidden" style="background-color: var(--card-bg); color: var(--bs-body-color); border-radius: 15px;">
                {{-- Encabezado con color de acento --}}
                <div class="card-header border-0 py-4" style="background-color: var(--nav-active-bg); border-bottom: 1px solid var(--bs-border-color);">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-person-badge-fill fs-3 text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold" style="color: var(--accent-main);">Gestión de Usuarios</h4>
                            <p class="mb-0 small opacity-75 text-dark">Registre las credenciales para su personal asistente.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            {{-- Sección de Datos Personales --}}
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Nombres</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--bs-border-color);"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control border-start-0" placeholder="Ej. Juan" required 
                                           style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" placeholder="Ej. Pérez" required 
                                       style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-600 small">Correo Electrónico Laboral</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--bs-border-color);"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" placeholder="asistente@clinica.com" required 
                                           style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                                </div>
                            </div>

                            <hr class="my-4 opacity-25">

                            {{-- Sección de Seguridad --}}
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Contraseña de Acceso</label>
                                <input type="password" name="password" class="form-control" required 
                                       style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control" required 
                                       style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill">
                                <i class="bi bi-shield-lock me-2"></i> Crear Credenciales
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i> 
                    Los usuarios creados tendrán el rol de <strong>Asistente</strong> por defecto.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection