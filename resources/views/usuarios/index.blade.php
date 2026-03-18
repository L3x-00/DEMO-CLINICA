@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--bs-body-color);">Gestión de Personal</h2>
            <p class="text-muted">Administra los accesos de tus asistentes y doctores.</p>
        </div>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="bi bi-person-plus-fill me-2"></i> Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0" style="background-color: var(--card-bg); border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="color: var(--bs-body-color);">
                <thead style="background-color: var(--nav-active-bg);">
                    <tr>
                        <th class="ps-4 py-3 border-0">Usuario</th>
                        <th class="py-3 border-0">Correo</th>
                        <th class="py-3 border-0 text-center">Rol</th>
                        <th class="py-3 border-0 text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                    <i class="bi bi-person-circle fs-5"></i>
                                </div>
                                <span class="fw-600">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td>{{ $u->email }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ $u->role === 'doctor' ? 'bg-danger' : 'bg-info' }} bg-opacity-10 text-{{ $u->role === 'doctor' ? 'danger' : 'info' }} px-3">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('usuarios.show', $u->id) }}" class="btn btn-sm  border" title="Ver detalles">
                                <i class="bi bi-eye text-primary"></i>
                            </a>
                            <a href="{{ route('usuarios.edit', $u->id) }}" class="btn btn-sm  border mx-1" title="Editar">
                                <i class="bi bi-pencil-square text-success"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection