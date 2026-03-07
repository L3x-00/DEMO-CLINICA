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
                        @method('PUT') 
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold opacity-75 text-uppercase">Nombre Completo</label>
                            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="form-control form-control-lg" required 
                                style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color); border-radius: 12px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold opacity-75 text-uppercase">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control form-control-lg" required
                                style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color); border-radius: 12px;">
                        </div>

                        <div class="alert alert-warning border-0 small mt-4 rounded-3 d-flex align-items-center">
                            <i class="bi bi-shield-lock fs-4 me-3"></i>
                            <div>
                                <strong>Seguridad:</strong> Deja los campos de clave en blanco si no deseas cambiar la contraseña actual.
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold opacity-75 text-uppercase">Nueva Clave</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••"
                                    style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color); border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold opacity-75 text-uppercase">Confirmar Nueva Clave</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••"
                                    style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color); border-radius: 10px;">
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between align-items-center border-top pt-4">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                                <i class="bi bi-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success px-5 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i> Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection