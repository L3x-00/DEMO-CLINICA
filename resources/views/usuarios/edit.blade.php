@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow border-0" style="background-color: var(--card-bg); color: var(--bs-body-color); border-radius: 15px;">
                <div class="card-header border-0 py-4 text-center" style="background-color: var(--nav-active-bg);">
                    <h4 class="mb-0 fw-bold">Actualizar Credenciales</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Importante para actualizaciones --}}
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nombre Completo</label>
                            <input type="text" name="name" value="{{ $usuario->name }}" class="form-control" required 
                                   style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ $usuario->email }}" class="form-control" required
                                   style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                        </div>

                        <div class="alert alert-info border-0 small mt-4">
                            <i class="bi bi-info-circle me-1"></i> Deja la clave en blanco si no deseas cambiarla.
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nueva Clave</label>
                                <input type="password" name="password" class="form-control"
                                       style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirmar Nueva Clave</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-link text-muted">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection