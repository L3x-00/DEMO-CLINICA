@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    {{-- CABECERA DEL PANEL --}}
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold text-dark">🏠 Panel de Inicio</h2>
            <p class="text-muted">Resumen de actividad y agenda para los próximos 7 días.</p>
        </div>
    </div>

    {{-- TARJETAS DE ESTADÍSTICAS RÁPIDAS --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body d-flex align-items-center py-4">
                    <div class="me-3">
                        <i class="bi bi-calendar-check-fill fs-1"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 opacity-75">Citas para Hoy</h6>
                        <h2 class="fw-bold mb-0">{{ $citasHoyCount }}</h2>
                    </div>
                </div>
            </div>
        </div>
        {{-- Puedes añadir más tarjetas aquí (ej: Total pacientes, Citas pendientes) --}}
    </div>

    {{-- SECCIÓN DE AGENDA --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-list-stars me-2 text-primary"></i>Agenda Próxima (7 días)
            </h5>
            <span class="badge bg-light text-primary border">Total: {{ $proximasCitas->count() }}</span>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-top">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-3">Fecha</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th class="text-center">Estado de Atención</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proximasCitas as $cita)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <i class="bi bi-clock me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                            </td>
                            <td>
                                <div class="fw-bold">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</div>
                                <small class="text-muted">DNI: {{ $cita->paciente->dni }}</small>
                            </td>
                            <td class="text-center">
                                {{-- DROPDOWN DE ESTADO (Corregido y Limpio) --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle shadow-sm w-100" type="button" data-bs-toggle="dropdown">
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
                                        
                                        {{-- Opción: Concluido --}}
                                        <li>
                                            <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="estado" value="Concluido">
                                                <button type="submit" class="dropdown-item rounded">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Concluido
                                                </button>
                                            </form>
                                        </li>

                                        {{-- Opción: No presentado --}}
                                        <li>
                                            <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="estado" value="No presentado">
                                                <button type="submit" class="dropdown-item rounded">
                                                    <i class="bi bi-person-x-fill text-danger me-2"></i> No presentado
                                                </button>
                                            </form>
                                        </li>

                                        {{-- Opción: Reprogramado --}}
                                        <li>
                                            <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="estado" value="Reprogramado">
                                                <button type="submit" class="dropdown-item rounded">
                                                    <i class="bi bi-calendar-event text-primary me-2"></i> Reprogramar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                No hay citas programadas para los próximos 7 días.
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