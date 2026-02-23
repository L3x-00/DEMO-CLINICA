@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">🏠 Panel de Inicio</h2>
            <p class="text-muted">Resumen de actividad para los próximos 7 días.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow border-0 bg-primary text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-calendar-check-fill fs-1"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Citas para Hoy</h6>
                        <h2 class="fw-bold mb-0">{{ $citasHoyCount }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-list-stars me-2 text-primary"></i>Agenda Próxima (7 días)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proximasCitas as $cita)
                        <tr>
                            <td><strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</td>
                            <td>{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</td>
                            <td>
                                <td class="text-center">
    <div class="dropdown">
        <button class="btn btn-sm btn-light border dropdown-toggle shadow-sm w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if($cita->estado == 'Pendiente')
                <span class="badge rounded-pill bg-warning text-dark">⏳ Pendiente</span>
            @elseif($cita->estado == 'Concluido')
                <span class="badge rounded-pill bg-success">✅ Concluido</span>
            @elseif($cita->estado == 'No presentado')
                <span class="badge rounded-pill bg-danger">❌ No vino</span>
            @else
                <span class="badge rounded-pill bg-info">{{ $cita->estado }}</span>
            @endif
        </button>

        <ul class="dropdown-menu shadow border-0 p-2">
            <li><h6 class="dropdown-header">Cambiar estado a:</h6></li>
            
            <li>
                <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                    @csrf 
                    @method('PATCH')
                    <input type="hidden" name="estado" value="Concluido">
                    <button type="submit" class="dropdown-item rounded py-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i> Concluido
                    </button>
                </form>
            </li>

            <li>
                <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                    @csrf 
                    @method('PATCH')
                    <input type="hidden" name="estado" value="No presentado">
                    <button type="submit" class="dropdown-item rounded py-2">
                        <i class="bi bi-person-x-fill text-danger me-2"></i> No presentado
                    </button>
                </form>
            </li>

            <li>
                <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                    @csrf 
                    @method('PATCH')
                    <input type="hidden" name="estado" value="Reprogramado">
                    <button type="submit" class="dropdown-item rounded py-2">
                        <i class="bi bi-calendar-event text-primary me-2"></i> Reprogramar
                    </button>
                </form>
            </li>
        </ul>
    </div>
</td>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No hay citas programadas para esta semana.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection