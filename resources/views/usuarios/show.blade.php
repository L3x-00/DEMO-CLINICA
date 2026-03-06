@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="background-color: var(--card-bg); color: var(--bs-body-color); border-radius: 15px;">
                <div class="card-body text-center p-5">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-block p-4 mb-4">
                        <i class="bi bi-person-vcard fs-1"></i>
                    </div>
                    
                    <h3 class="fw-bold mb-1">{{ $usuario->name }}</h3>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-4 mb-4">
                        {{ ucfirst($usuario->role) }}
                    </span>

                    <div class="text-start mt-4 p-4 rounded" style="background-color: var(--bs-body-bg);">
                        <div class="mb-3">
                            <small class="text-muted d-block">Correo Electrónico</small>
                            <span class="fw-bold">{{ $usuario->email }}</span>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted d-block">Fecha de Registro</small>
                            <span class="fw-bold">{{ $usuario->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Volver</a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary rounded-pill px-4">Editar Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection