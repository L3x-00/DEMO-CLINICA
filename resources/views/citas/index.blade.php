@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Agenda de Citas 🦴</h2>
        <a href="{{ route('citas.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Nueva Cita
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha y Hora ⏰</th>
                            <th>Paciente 👤</th>
                            <th>DNI 🆔</th>
                            <th>Motivo</th>
                            <th>Estado 🚦</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td>
                                {{-- Formateamos la fecha a día/mes/año y la hora a formato 12h --}}
                                <span class="d-block fw-bold">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</span>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</small>
                            </td>
                            <td>
                                @if($cita->paciente)
                                    <span class="fw-bold">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</span>
                                @else
                                    <span class="text-danger small">Paciente no encontrado ❌</span>
                                @endif
                            </td>
                            <td>{{ $cita->paciente?->dni ?? 'N/A' }}</td>
                            <td>
                                {{-- Limitamos el texto para que no se desborde la tabla --}}
                                {{ Str::limit($cita->motivo ?? 'Sin motivo especificado', 40) }}
                            </td>
                            <td>
                                <span class="badge rounded-pill {{ $cita->estado == 'Pendiente' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ $cita->estado }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x d-block fs-1 mb-2"></i>
                                No hay citas programadas actualmente.
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