@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--bs-body-color);">Gestión de Personal</h2>
            <p class="text-muted">Administra los accesos de tus asistentes y doctores.</p>
        </div>
        <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUsuarioCreate">
            <i class="bi bi-person-plus me-1"></i> Nuevo Asistente
        </button>
    </div>

    {{-- Alertas de éxito --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de Usuarios --}}
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
                    @forelse($usuarios as $u)
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
                            <span class="badge rounded-pill {{ $u->role === 'doctor' ? 'bg-danger' : 'bg-info' }} bg-opacity-10 text-{{ $u->role === 'doctor' ? 'danger' : 'info' }} px-3 text-uppercase">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            {{-- Botón Ver Detalles --}}
                            <button type="button" class="btn btn-sm border" 
                                    onclick="abrirModalUsuarioShow('{{ addslashes($u->name) }}', '{{ $u->role }}', '{{ $u->email }}', '{{ $u->created_at }}')" 
                                    title="Ver detalles">
                                <i class="bi bi-eye text-primary"></i>
                            </button>

                            {{-- Botón Editar --}}
                            <button type="button" class="btn btn-sm btn-light-primary rounded-circle mx-1" 
                                    onclick="abrirModalUsuarioEdit('{{ $u->id }}', '{{ addslashes($u->name) }}', '{{ $u->email }}')"
                                    title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            {{-- Botón Eliminar --}}
                            <form action="{{ route('usuarios.destroy', $u->id) }}" method="POST" class="d-inline form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light-danger rounded-circle text-danger" 
                                        title="Eliminar" onclick="confirmarEliminacion(this)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                            No hay personal registrado todavía.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('usuarios.partials.modales')

@push('scripts')
    @vite(['resources/js/pages/usuarios.js'])
@endpush
@endsection