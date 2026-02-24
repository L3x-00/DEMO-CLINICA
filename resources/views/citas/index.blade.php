@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">Agenda de Citas 🦴</h2>
            <p class="text-muted small">Control total de turnos y consultas médicas</p>
        </div>
        <a href="{{ route('citas.create') }}" class="btn btn-primary shadow-sm fw-bold">
            <i class="bi bi-calendar-plus me-1"></i> Nueva Cita
        </a>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- TABLA DE CITAS --}}
    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-0"> {{-- P-0 para que la tabla toque los bordes de la card --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3">Fecha y Hora ⏰</th>
                            <th>Paciente 👤</th>
                            <th>Motivo</th>
                            <th>Estado 🚦</th>
                            <th class="text-center pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td class="ps-4">
                                <span class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</span>
                                <small class="text-muted"><i class="bi bi-clock small"></i> {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</small>
                            </td>
                            <td>
                                @if($cita->paciente)
                                    <div class="fw-bold">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</div>
                                    <small class="badge bg-light text-dark border fw-normal">ID: {{ $cita->paciente->dni }}</small>
                                @else
                                    <span class="text-danger small fw-bold">Paciente no encontrado ❌</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small" title="{{ $cita->motivo }}">
                                    {{ Str::limit($cita->motivo ?? 'Sin motivo especificado', 35) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $color = [
                                        'Pendiente' => 'bg-warning text-dark',
                                        'Concluido' => 'bg-success',
                                        'No presentado' => 'bg-danger',
                                        'Reprogramado' => 'bg-info text-dark'
                                    ][$cita->estado] ?? 'bg-secondary';
                                @endphp
                                <span class="badge rounded-pill {{ $color }}">
                                    {{ $cita->estado }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                {{-- GRUPO DE ACCIONES --}}
                                <div class="btn-group btn-group-sm shadow-sm" role="group">
                                    <a href="{{ route('citas.show', $cita->id) }}" class="btn btn-outline-info" title="Ver detalle">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-outline-warning" title="Editar o Reprogramar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    {{-- FORMULARIO PARA ELIMINAR --}}
                                    <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta cita permanentemente?')">
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
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x d-block fs-1 mb-2 opacity-25"></i>
                                <p class="mb-0">No hay citas programadas en la agenda actualmente.</p>
                                <a href="{{ route('citas.create') }}" class="btn btn-sm btn-link mt-2">Crear primera cita</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection