@extends('layouts.app')

{{-- Usamos stack para no ensuciar el layout si no es necesario --}}
@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
<div class="container mt-4 mb-5">
    
    {{-- Info del Doctor (Opcional si ya lo tienes en el layout nuevo) --}}
    <div class="d-flex justify-content-end mb-4">
        <div class="card shadow-sm border-primary bg-white" style="width: 280px;">
            <div class="card-body py-2 px-3 text-end">
                <h6 class="mb-0 text-primary">👨‍⚕️ {{ auth()->user()->name }}</h6>
                <small class="text-muted d-block">Doctor Conectado</small>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="col-lg-12">
        {{-- Buscador y Título --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 fw-bold text-secondary">Pacientes Registrados</h4>
            
            <form action="{{ route('pacientes.index') }}" method="GET" class="d-flex gap-2" style="width: 400px;">
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-end-0">🔎</span>
                    <input type="text" name="buscar" class="form-control border-start-0" placeholder="DNI, Nombre o Apellido..." value="{{ $buscar ?? '' }}">
                    <button type="submit" class="btn btn-primary px-3">Buscar</button>
                </div>
                @if(request('buscar'))
                    <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm d-flex align-items-center">✕</a>
                @endif
            </form>
        </div>

        {{-- Tabla --}}
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i> Base de Datos Médica</h5>
                <a href="{{ route('pacientes.create') }}" class="btn btn-light fw-bold text-primary shadow-sm btn-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-white">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Documento</th>
                            <th>Paciente</th>
                            <th>Contacto</th>
                            <th>Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientes as $paciente)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border">{{ $paciente->tipo_documento ?? 'DNI' }}</span>
                                    <span class="fw-bold">{{ $paciente->dni }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $paciente->apellido }}, {{ $paciente->nombre }}</div>
                                    <small class="text-muted">{{ $paciente->sexo }} | {{ $paciente->edad }} años</small>
                                </td>
                                <td>
                                    <div><i class="bi bi-telephone small me-1"></i> {{ $paciente->telefono ?? '---' }}</div>
                                    <small class="text-muted"><i class="bi bi-envelope small me-1"></i> {{ $paciente->email ?? '---' }}</small>
                                </td>
                                <td>
                                    <small>{{ $paciente->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm shadow-sm" role="group">
                                        <a href="{{ route('pacientes.show', $paciente->id) }}" class="btn btn-outline-info" title="Ver Ficha Completa">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-outline-warning" title="Editar Datos">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro permanentemente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-search d-block fs-1 mb-2"></i>
                                    No se encontraron pacientes registrados con ese criterio.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pacientes->hasPages())
            <div class="card-footer bg-white">
                {{ $pacientes->appends(['buscar' => $buscar])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection